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


class webphoto_lib_download_filename {

	public $_CHARSET_LOCAL = 'utf-8';
	public $_LANGCODE = 'en';
	public $_is_japanese = false;

	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_download_filename();
		}

		return $instance;
	}

	public function set_charset_local( $val ) {
		$this->_CHARSET_LOCAL = strtolowr( $val );
	}

	public function set_langcode( $val ) {
		$this->_LANGCODE = strtolowr( $val );
	}

	public function set_is_japanese( $val ) {
		$this->_is_japanese = (bool) $val;
	}

	public function build_encode( $name, $name_alt, $browser ) {
		$is_rfc2231 = false;

		$name = $this->substitute_filename( $name );
		$kind = $this->get_kind( $name, $browser );

		switch ( $kind ) {
// ASCII
			case 'ascii':
				$name = rawurlencode( $name );
				break;

// SJIS
			case 'msie_ja':
				$name = $this->convert_encoding( $name, 'sjis-win', $this->_CHARSET_LOCAL );
				break;

// RFC2231
			case 'firefox':
			case 'chrome':
			case 'opera':
				$name       = $this->convert_to_utf8( $name );
				$name       = $this->build_filename_rfc2231( $name, 'utf-8', $this->_LANGCODE );
				$is_rfc2231 = true;
				break;

// UTF-8
			case 'safari_utf8':
				$name = $this->convert_to_utf8( $name );
				break;

			default:
				$name = rawurlencode( $name_alt );
				break;
		}

		return array( $name, $is_rfc2231 );
	}

	public function get_kind( $name, $browser ) {
		$ascii = $this->convert_encoding(
			$name, 'us-ascii', $this->_CHARSET_LOCAL );
		if ( $ascii == $name ) {
			$browser = 'ascii';
		}

		if ( ( $browser == 'msie' ) && $this->_is_japanese ) {
			$browser = 'msie_ja';
		}

		if ( ( $browser == 'safari' ) && ( $this->_CHARSET_LOCAL == 'utf-8' ) ) {
			$browser = 'safari_utf8';
		}

		return $browser;
	}

	public function build_filename_rfc2231( $name, $charset, $langcode ) {
		$str = strtolower( $charset . "'" . $langcode . "'" );
		$str .= rawurlencode( $name );

		return $str;
	}

	public function substitute_filename( $str ) {
		$str = $this->convert_space_zen_to_han( $str );
		$str = $this->substitute_filename_to_underbar( $str );

		return $str;
	}

	public function substitute_filename_to_underbar( $name ) {
// substitute the characters that cannot be used as the file name to underbar. 
// \ / : * ? " < > | sapce
		$search  = array( '\\', '/', ':', '*', '?', '"', '<', '>', '|', ' ' );
		$replace = array( '_', '_', '_', '_', '_', '_', '_', '_', '_', '_' );

		$str = str_replace( $search, $replace, $name );

		return $str;
	}


// multibyte

	public function convert_to_utf8( $str ) {
		return $this->convert_encoding( $str, 'utf-8', $this->_CHARSET_LOCAL );
	}

	public function convert_encoding( $str, $charset_to, $charset_from ) {

// no action when same charset
		if ( $charset_from == $charset_to ) {
			return $str;
		}

		if ( function_exists( 'mb_convert_encoding' ) ) {
			return mb_convert_encoding( $str, $charset, $charset_from );
		}
		if ( function_exists( 'iconv' ) ) {
			return iconv( $charset_from, $charset . '//TRANSLIT', $str );
		}

		return $str;
	}

	public function convert_space_zen_to_han( $str ) {
		if ( function_exists( 'mb_convert_kana' ) ) {
			return mb_convert_kana( $str, 's' );
		}

		return $str;
	}

}
