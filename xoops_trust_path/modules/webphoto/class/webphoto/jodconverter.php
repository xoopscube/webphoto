<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_jodconverter extends webphoto_cmd_base {
	public $_config_class;
	public $_jod_class;
	public $_multibyte_class;
	public $_utility_class;

	public $_use_jod = false;
	public $_java_path = '';
	public $_junk_words = null;

	public $_TMP_DIR;
	public $_TEXT_EXT = 'txt';
	public $_HTML_EXT = 'html';

	public $_JUNK_WORDS_ENG = array(
		'Slide',
		'First page',
		'Last page',
		'Back',
		'Continue',
		'Graphics',
		'Text',
		'Overview',
		'Sheet'
	);


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_config_class    =& webphoto_config::getInstance( $dirname );
		$this->_jod_class       =& webphoto_lib_jodconverter::getInstance();
		$this->_multibyte_class =& webphoto_multibyte::getInstance();
		$this->_utility_class   =& webphoto_lib_utility::getInstance();

		$this->_TMP_DIR = $this->_config_class->get_work_dir( 'tmp' );

// set param
		if ( defined( "_C_WEBPHOTO_JAVA_PATH" ) ) {
			$this->_java_path = _C_WEBPHOTO_JAVA_PATH;
			$this->_jod_class->set_cmd_path_java( _C_WEBPHOTO_JAVA_PATH );
		}
		if ( defined( "_C_WEBPHOTO_JODCONVERTER_JAR" ) ) {
			$this->_jod_class->set_jodconverter_jar( _C_WEBPHOTO_JODCONVERTER_JAR );
			$this->_use_jod = true;
		}

// junk words
		$arr = $this->str_to_array( _WEBPHOTO_JODCONVERTER_JUNK_WORDS, '|' );
		if ( is_array( $arr ) ) {
			$this->_junk_words = array_merge( $this->_JUNK_WORDS_ENG, $arr );
		} else {
			$this->_junk_words = $this->_JUNK_WORDS_ENG;
		}

		$this->set_debug_by_const_name( $this->_jod_class, 'DEBUG_JODCONVERTER' );
		$this->set_debug_by_ini_name( $this->_jod_class );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_jodconverter( $dirname, $trust_dirname );
		}

		return $instance;
	}


// create pdf

	public function create_pdf( $src_file, $dst_file ) {
		return $this->convert_single( $src_file, $dst_file );
	}


// create swf

	public function create_swf( $src_file, $dst_file ) {
		return $this->convert_single( $src_file, $dst_file );
	}


// text content

	public function get_text_content_for_doc( $src_file ) {
		if ( empty( $src_file ) ) {
			return null;    // no action
		}
		if ( ! is_file( $src_file ) ) {
			return null;    // no action
		}
		if ( ! $this->_use_jod ) {
			return null;    // no action
		}

		$txt_file = $this->_TMP_DIR . '/' . uniqid( 'tmp_' ) . '.' . $this->_TEXT_EXT;
		$ret      = $this->convert_single( $src_file, $txt_file );
		if ( ! $ret ) {
			$arr = array(
				'flag'   => false,
				'errors' => $this->get_errors(),
			);

			return $arr;
		}

		$text = file_get_contents( $txt_file );
		$text = $this->_multibyte_class->convert_from_utf8( $text );
		$text = $this->_multibyte_class->build_plane_text( $text );

		unlink( $txt_file );

		$arr = array(
			'flag'    => true,
			'content' => $text,
		);

		return $arr;
	}

	public function get_text_content_for_xls_ppt( $src_file ) {
		if ( empty( $src_file ) ) {
			return null;    // no action
		}
		if ( ! is_file( $src_file ) ) {
			return null;    // no action
		}
		if ( ! $this->_use_jod ) {
			return null;    // no action
		}

		$flag_dir = false;
		$dir_new  = null;

		$node    = uniqid( 'n' );
		$dir     = $this->_TMP_DIR;
		$dir_new = $this->_TMP_DIR . '/' . uniqid( 'd' );

// make tmp dir, if not safe_mode
		if ( ! $this->_ini_safe_mode ) {
			mkdir( $dir_new );
			if ( is_dir( $dir_new ) ) {
				chmod( $dir_new, $this->_CHMOD_MODE );
				$dir      = $dir_new;
				$flag_dir = true;
			}
		}

		$html_file = $dir . '/' . $node . '.' . $this->_HTML_EXT;
		$this->_jod_class->convert( $src_file, $html_file );

		$file_arr = $this->get_files_in_dir( $dir, $this->_HTML_EXT, false, true );
		if ( ! is_array( $file_arr ) ) {
			$arr = array(
				'flag'   => false,
				'errors' => $this->_jod_class->get_msg_array(),
			);

			return $arr;
		}

		$flag_match = false;
		$text       = '';

		foreach ( $file_arr as $file ) {
			$flag_file = false;
			if ( strpos( $file, $node ) === 0 ) {
				$flag_file = true;
			}
			if ( $flag_dir && ( strpos( $file, 'text' ) === 0 ) ) {
				$flag_file = true;
			}
			if ( ! $flag_file ) {
				continue;
			}

			$flag_match = true;
			$file_full  = $dir . '/' . $file;
			$text       .= file_get_contents( $file_full );

// remove tmp file
			unlink( $file_full );
		}

// remove tmp dir
		if ( $flag_dir ) {
			$file_arr = $this->get_files_in_dir( $dir );
			if ( is_array( $file_arr ) ) {
				foreach ( $file_arr as $file ) {
					$file_full = $dir . '/' . $file;
					unlink( $file_full );
				}
			}
			rmdir( $dir_new );
		}

// no match file
		if ( ! $flag_match ) {
			$arr = array(
				'flag'   => false,
				'errors' => array( 'no match file' ),
			);

			return $arr;
		}

		$text = $this->_multibyte_class->convert_from_utf8( $text );
		$text = $this->remove_junk( $text );
		$text = $this->_multibyte_class->build_plane_text( $text );

		$arr = array(
			'flag'    => true,
			'content' => $text,
		);

		return $arr;
	}

	public function remove_junk( $text ) {
		foreach ( $this->_junk_words as $word ) {
			$text = str_replace( '>' . $word . '<', '> <', $text );
			$text = str_replace( '>' . $word . ' ', '>  ', $text );
			$text = str_replace( ' ' . $word . '<', '  <', $text );
			$text = str_replace( ' ' . $word . ' ', '   ', $text );
			$text = preg_replace( "/[\n|\r]" . preg_quote( $word ) . " /i", ' ', $text );
		}

		return $text;
	}


// convert

	public function convert_single( $src_file, $dst_file ) {
		if ( ! $this->_use_jod ) {
			return 0;    // no action
		}

		$ret = $this->_jod_class->convert( $src_file, $dst_file );
		if ( is_file( $dst_file ) ) {
			$this->chmod_file( $dst_file );

			return 1;    // suceess
		}

		$this->set_error( $this->_jod_class->get_msg_array() );

		return - 1;    // fail
	}


// version

	public function use_jod() {
		return $this->_use_jod;
	}

	public function java_path() {
		return $this->_java_path;
	}

	public function version() {
		return $this->_jod_class->version();
	}
}
