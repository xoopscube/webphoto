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


class webphoto_lib_post {


// constructor

	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_post();
		}

		return $instance;
	}


// function

	function get_post( $key, $default = null ) {
		$str = $_POST[ $key ] ?? $default;

		return $str;
	}

	function get_post_text( $key, $default = null ) {
		return $this->_strip_slashes_gpc( $this->get_post( $key, $default ) );
	}

	function get_post_int( $key, $default = 0 ) {
		return (int) $this->get_post( $key, $default );
	}

	function get_post_float( $key, $default = 0 ) {
		return (float) $this->get_post( $key, $default );
	}

	function get_post_url( $key, $default = null ) {
		$str = $this->get_post_text( $key, $default );
		if ( $this->check_http_start( $str ) && $this->check_http_fill( $str ) ) {
			return $str;
		}

		return $default;
	}

	function get_post_time( $key, $default = null ) {
		return $this->str_to_time( $this->get_post_text( $key, $default ) );
	}

	function get_get( $key, $default = null ) {
		$str = $_GET[ $key ] ?? $default;

		return $str;
	}

	function get_get_text( $key, $default = null ) {
		return $this->_strip_slashes_gpc( $this->get_get( $key, $default ) );
	}

	function get_get_int( $key, $default = 0 ) {
		return (int) $this->get_get( $key, $default );
	}

	function get_post_get( $key, $default = null ) {
		$str = $default;
		if ( isset( $_POST[ $key ] ) ) {
			$str = $_POST[ $key ];
		} elseif ( isset( $_GET[ $key ] ) ) {
			$str = $_GET[ $key ];
		}

		return $str;
	}

	function get_post_get_text( $key, $default = null ) {
		return $this->_strip_slashes_gpc( $this->get_post_get( $key, $default ) );
	}

	function get_post_get_int( $key, $default = 0 ) {
		return (int) $this->get_post_get( $key, $default );
	}


// utlity

	function _strip_slashes_gpc( $str ) {
		if ( ! get_magic_quotes_gpc() ) {
			return $str;
		}

		if ( ! is_array( $str ) ) {
			return stripslashes( $str );
		}

		$arr = array();
		foreach ( $str as $k => $v ) {
			$arr[ $k ] = stripslashes( $v );
		}

		return $arr;
	}

	function check_http_start( $str ) {
		if ( preg_match( "|^https?://|", $str ) ) {
			return true;    // include HTTP
		}

		return false;
	}

	function check_http_fill( $str ) {
		if ( ( $str != '' ) && ( $str != 'http://' ) && ( $str != 'https://' ) ) {
			return true;
		}

		return false;
	}

	function str_to_time( $str ) {
		$str = trim( $str );
		if ( $str ) {
			$time = strtotime( $str );
			if ( $time > 0 ) {
				return $time;
			}

			return - 1;    // failed to convert
		}

		return 0;
	}

}

