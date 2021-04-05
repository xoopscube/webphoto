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


class webphoto_lib_pathinfo {
	public $_get_param = null;
	public $_pathinfo_array = null;

	public $_PAGE_DEFAULT = 1;


	public function __construct() {
		$this->_init();
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_pathinfo();
		}

		return $instance;
	}

	public function _init() {
		$get = $_GET;

		$path_info = $this->get_server_path_info();

		if ( $path_info ) {
			$this->_pathinfo_array = $this->str_to_array( $path_info, '/' );
			foreach ( $this->_pathinfo_array as $path ) {
				$qs = $this->str_to_array( $path, '=' );
				if ( isset( $qs[0], $qs[1] ) ) {
					$get[ $qs[0] ] = $qs[1];
				}
			}
		}

		$this->_get_param = $get;
	}

	public function get_fct_op_0() {
		$fct = $this->get( 'fct' );
		if ( $fct ) {
			return $fct;
		}

		$op = $this->get( 'op' );
		if ( $op ) {
			return $op;
		}

		return $this->get_path( 0 );
	}

	public function get_op_or_0() {
		$op = $this->get( 'op' );
		if ( $op ) {
			return $op;
		}

		return $this->get_path( 0 );
	}

	public function get_page() {
		$page = $this->get_int( 'page' );
		if ( $page < $this->_PAGE_DEFAULT ) {
			$page = $this->_PAGE_DEFAULT;
		}

		return $page;
	}

	public function isset_param( $key ) {
		return isset( $this->_get_param[ $key ] );
	}

	public function get( $key, $default = null ) {
		return $this->_get_param[ $key ] ?? $default;
	}

	public function get_text( $key, $default = null ) {
		return $this->strip_slashes_gpc( $this->get( $key, $default ) );
	}

	public function get_int( $key, $default = 0 ) {
		return (int) $this->get( $key, $default );
	}

	public function get_float( $key, $default = 0 ) {
		return (float) $this->get( $key, $default );
	}

	public function get_server_path_info() {
		$str = isset( $_SERVER["PATH_INFO"] ) ? $_SERVER["PATH_INFO"] : null;

		return $str;
	}

	public function get_param() {
		return $this->_get_param;
	}

	public function get_path( $num ) {
		return $this->_pathinfo_array[ $num ] ?? false;
	}


// utlity

	public function strip_slashes_gpc( $str ) {
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

	public function str_to_array( $str, $pattern ) {
		$arr1 = explode( $pattern, $str );
		$arr2 = array();
		foreach ( $arr1 as $v ) {
			$v = trim( $v );
			if ( $v == '' ) {
				continue;
			}
			$arr2[] = $v;
		}

		return $arr2;
	}

}
