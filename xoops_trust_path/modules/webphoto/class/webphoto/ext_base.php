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


class webphoto_ext_base extends webphoto_base_ini {
	public $_utility_class;
	public $_mime_handler;
	public $_config_class;
	public $_multibyte_class;

	public $_cfg_work_dir;
	public $_cfg_makethumb;
	public $_constpref;

	public $_flag_chmod = false;
	public $_cached = array();
	public $_errors = array();
	public $_cached_mime_type_array = array();
	public $_cached_mime_kind_array = array();

	public $_TMP_DIR;

	public $_JPEG_EXT = 'jpg';
	public $_TEXT_EXT = 'txt';
	public $_ASX_EXT = 'asx';

	public $_FLAG_DEBUG = false;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_mime_handler =& webphoto_mime_handler::getInstance(
			$dirname, $trust_dirname );

		$this->_config_class    =& webphoto_config::getInstance( $dirname );
		$this->_multibyte_class =& webphoto_multibyte::getInstance();

		$this->_cfg_work_dir  = $this->_config_class->get_by_name( 'workdir' );
		$this->_cfg_makethumb = $this->_config_class->get_by_name( 'makethumb' );

		$this->_TMP_DIR = $this->_cfg_work_dir . '/tmp';

		$this->_constpref = strtoupper( '_P_' . $dirname . '_DEBUG_' );
	}


// check type

	function is_ext( $ext ) {
		return false;
	}

	function is_ext_in_array( $ext, $array ) {
		if ( in_array( strtolower( $ext ), $array ) ) {
			return true;
		}

		return false;
	}


// excute

	function execute( $method, $param ) {
		switch ( $method ) {
			case 'image':
				return $this->create_image( $param );
				break;

			case 'flv':
				return $this->create_flv( $param );
				break;

			case 'jpeg':
				return $this->create_jpeg( $param );
				break;

			case 'wav':
				return $this->create_wav( $param );
				break;

			case 'pdf':
				return $this->create_pdf( $param );
				break;

			case 'swf':
				return $this->create_swf( $param );
				break;

			case 'video_images':
				return $this->create_video_images( $param );
				break;

			case 'video_info':
				return $this->get_video_info( $param );
				break;

			case 'text_content':
				return $this->get_text_content( $param );
				break;

			case 'exif':
				return $this->get_exif( $param );
				break;
		}

		return null;
	}

	function create_image( $param ) {
		return null;
	}

	function create_video_images( $param ) {
		return null;
	}

	function create_flv( $param ) {
		return null;
	}

	function create_jpeg( $param ) {
		return null;
	}

	function create_wav( $param ) {
		return null;
	}

	function create_mp3( $param ) {
		return null;
	}

	function create_pdf( $param ) {
		return null;
	}

	function create_swf( $param ) {
		return null;
	}

	function get_video_info( $param ) {
		return null;
	}

	function get_text_content( $param ) {
		return null;
	}

	function get_exif( $param ) {
		return null;
	}


// error 

	function clear_error() {
		$this->_errors = array();
	}

	function set_error( $errors ) {
		if ( is_array( $errors ) ) {
			foreach ( $errors as $err ) {
				$this->_errors[] = $err;
			}
		} else {
			$this->_errors[] = $errors;
		}
	}

	function get_errors() {
		return $this->_errors;
	}


// mime handler

	function get_cached_mime_type_by_ext( $ext ) {
		if ( isset( $this->_cached_mime_type_array[ $ext ] ) ) {
			return $this->_cached_mime_type_array[ $ext ];
		}

		$row = $this->_mime_handler->get_cached_row_by_ext( $ext );
		if ( ! is_array( $row ) ) {
			return false;
		}

		$mime_arr = $this->str_to_array( $row['mime_type'], ' ' );
		if ( isset( $mime_arr[0] ) ) {
			$mime                                  = $mime_arr[0];
			$this->_cached_mime_type_array[ $ext ] = $mime;

			return $mime;
		}

		return false;
	}

	function get_cached_mime_kind_by_ext( $ext ) {
		if ( isset( $this->_cached_mime_kind_array[ $ext ] ) ) {
			return $this->_cached_mime_kind_array[ $ext ];
		}

		$row = $this->_mime_handler->get_cached_row_by_ext( $ext );
		if ( ! is_array( $row ) ) {
			return false;
		}

		$kind                                  = $row['mime_kind'];
		$this->_cached_mime_kind_array[ $ext ] = $kind;

		return $kind;
	}

	function match_ext_kind( $ext, $kind ) {
		if ( $this->get_cached_mime_kind_by_ext( $ext ) == $kind ) {
			return true;
		}

		return false;
	}


// debug

	function set_debug_by_name( $name ) {
		$const_name = strtoupper( $this->_constpref . $name );

		if ( defined( $const_name ) ) {
			$val = constant( $const_name );
			$this->set_flag_debug( $val );
		}
	}

	function set_flag_debug( $val ) {
		$this->_FLAG_DEBUG = (bool) $val;
	}


// set param 

	function set_flag_chmod( $val ) {
		$this->_flag_chmod = (bool) $val;
	}

}
