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


class webphoto_main_download extends webphoto_file_read {
	public $_readfile_class;
	public $_browser_class;

	public $_TIME_FAIL = 5;

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_readfile_class =& webphoto_lib_readfile::getInstance();
		$this->_browser_class  =& webphoto_lib_browser::getInstance();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_main_download( $dirname, $trust_dirname );
		}

		return $instance;
	}


// main

	public function main() {
		$item_id   = $this->_post_class->get_post_get_int( 'item_id' );
		$file_kind = $this->_post_class->get_post_get_int( 'file_kind' );

		$item_row = $this->get_item_row( $item_id );
		if ( ! is_array( $item_row ) ) {
			redirect_header( $this->_MODULE_URL, $this->_TIME_FAIL, $this->_error );
			exit();
		}

// check perm down
		if ( ! $this->check_item_perm( $item_row['item_perm_down'] ) ) {
			redirect_header( $this->_MODULE_URL, $this->_TIME_FAIL, _NOPERM );
			exit();
		}

		$file_row = $this->get_file_row( $item_row, $file_kind );
		if ( ! is_array( $file_row ) ) {
			redirect_header( $this->_MODULE_URL, $this->_TIME_FAIL, $this->_error );
			exit();
		}

		$mime      = $file_row['file_mime'];
		$file_name = $file_row['file_name'];

// Notice [PHP]: Undefined index: file_full
		$file = $file_row['full_path'];

		list( $name, $name_alt ) =
			$this->build_filename_by_row( $item_row, $file_row );

		list( $name, $is_rfc2231 ) =
			$this->build_filename_encode( $name, $name_alt );

		$this->_readfile_class->readfile_down( $file, $mime, $name, $is_rfc2231 );

		exit();
	}

	public function build_filename_by_row( $item_row, $file_row ) {
		$item_title = $item_row['item_title'];
		$file_name  = $file_row['file_name'];
		$file_ext   = $file_row['file_ext'];
		$file_kind  = $file_row['file_kind'];

		$aux = $this->_file_handler->get_download_image_aux( $file_kind );

		if ( $item_title ) {
			if ( $aux && $file_ext ) {
				$name = $item_title . '_' . $aux . '.' . $file_ext;
			} elseif ( $file_ext ) {
				$name = $item_title . '.' . $file_ext;
			} elseif ( $aux ) {
				$name = $item_title . '_' . $aux;
			} else {
				$name = $item_title;
			}
		} else {
			$name = $file_name;
		}

// substitute the characters that cannot be used as the file name to underbar. 
// \ / : * ? " < > | sapce
		$name = $this->_utility_class->substitute_filename_to_underbar( $name );
		$name = $this->_multibyte_class->convert_space_zen_to_han( $name );
		$name = str_replace( ' ', '_', $name );

		return array( $name, $file_name );
	}

	public function build_filename_encode( $name, $name_alt ) {
		$is_rfc2231 = false;

		if ( ! $this->get_ini( 'download_filename_encode' ) ) {
			return array( $name_alt, $is_rfc2231 );
		}

		$browser = $this->get_convert_kind( $name );
		switch ( $browser ) {
// ASCII
			case 'ascii':
				$name = rawurlencode( $name );
				break;

// SJIS
			case 'msie_ja':
				$name = $this->_multibyte_class->convert_encoding(
					$name, "SJIS", _CHARSET );
				break;

// RFC2231
			case 'firefox':
			case 'chrome':
			case 'opera':
				$name       = $this->_multibyte_class->convert_to_utf8( $name );
				$name       = $this->_utility_class->build_filename_rfc2231( $name, 'utf-8', _LANGCODE );
				$is_rfc2231 = true;
				break;

// UTF-8
			case 'safari_utf8':
				$name = $this->_multibyte_class->convert_to_utf8( $name );
				break;

			default:
				$name = rawurlencode( $name_alt );
				break;
		}

		return array( $name, $is_rfc2231 );
	}

	public function get_convert_kind( $name ) {
		$is_japanese = $this->_xoops_class->is_japanese( _C_WEBPHOTO_JPAPANESE );

		$this->_browser_class->presume_agent();
		$browser = $this->_browser_class->get_browser();

		$ascii = $this->_multibyte_class->convert_encoding(
			$name, "US-ASCII", _CHARSET );
		if ( $ascii == $name ) {
			$browser = 'ascii';
		}

		if ( ( $browser == 'msie' ) && $is_japanese ) {
			$browser = 'msie_ja';
		}

		if ( ( $browser == 'safari' ) && ( _CHARSET == 'UTF-8' ) ) {
			$browser = 'safari_utf8';
		}

		return $browser;
	}

// --- class end ---
}

?>
