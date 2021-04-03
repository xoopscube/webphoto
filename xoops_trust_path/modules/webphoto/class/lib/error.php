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


class webphoto_lib_error {
	public $_error_code = 0;
	public $_errors = array();

// color: red;
	public $_SPAN_STYLE_ERROR = 'color: #ff0000;';

// color: red;  background-color: lightyellow;  border: gray;
	public $_DIV_STYLE_ERROR = 'color: #ff0000; background-color: #ffffe0; border: #808080 1px dotted; padding: 3px 3px 3px 3px;';


// constructor

	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_error();
		}

		return $instance;
	}


// error code

	function clear_error_code() {
		$this->_error_code = 0;
	}

	function set_error_code( $code ) {
		$this->_error_code = intval( $code );
	}

	function get_error_code() {
		return $this->_error_code;
	}


// error

	function return_code() {
		if ( count( $this->_errors ) ) {
			return false;
		}

		return true;
	}

	function has_error() {
		if ( count( $this->_errors ) ) {
			return true;
		}

		return false;
	}

	function clear_errors() {
		$this->_errors = array();
	}

	function get_errors() {
		return $this->_errors;
	}

	function get_format_error( $flag_sanitize = true, $flag_highlight = true ) {
		$val = '';
		foreach ( $this->_errors as $msg ) {
			if ( $flag_sanitize ) {
				$msg = $this->sanitize( $msg );
			}
			$val .= $msg . "<br>\n";
		}

		if ( $flag_highlight ) {
			$val = $this->highlight( $val );
		}

		return $val;
	}

	function set_error( $msg ) {
// array type
		if ( is_array( $msg ) ) {
			foreach ( $msg as $m ) {
				$this->_errors[] = $m;
			}

// string type
		} else {
			$arr = explode( "\n", $msg );
			foreach ( $arr as $m ) {
				$this->_errors[] = $m;
			}
		}
	}

	function set_error_in_head( $msg ) {
		array_unshift( $this->_errors, $msg );
	}


// utility

	function sanitize( $str ) {
		return htmlspecialchars( $str, ENT_QUOTES );
	}

	function shorten_strings( $str, $length ) {
		if ( strlen( $str ) > $length ) {
			$str = webphoto_substr( $str, 0, $length ) . ' ...';
		}

		return $str;
	}

	function shorten_strings_with_nl2br( $str, $length ) {
		return nl2br( $this->sanitize( $this->shorten_strings( $str, $length ) ) );
	}

	function highlight( $msg ) {
		$str = '<span style="' . $this->_SPAN_STYLE_ERROR . '">';
		$str .= $msg;
		$str .= "</span>\n";

		return $str;
	}

	function error_in_box( $msg ) {
		$str = '<div style="' . $this->_DIV_STYLE_ERROR . '">';
		$str .= $msg;
		$str .= "</div>\n";

		return $str;
	}

}
