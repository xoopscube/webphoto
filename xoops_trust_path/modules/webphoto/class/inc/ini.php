<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_inc_ini {

	public $_DIRNAME;
	public $_TRUST_DIRNAME;
	public $_MODULE_DIR;
	public $_TRUST_DIR;

	public $_array_ini = null;

	public $_DEBUG_READ = false;

	public function __construct( $dirname, $trust_dirname ) {

		$this->_DIRNAME       = $dirname;
		$this->_MODULE_DIR    = XOOPS_ROOT_PATH . '/modules/' . $dirname;
		$this->_TRUST_DIRNAME = $trust_dirname;
		$this->_TRUST_DIR     = XOOPS_TRUST_PATH . '/modules/' . $trust_dirname;

		$constpref = strtoupper( '_P_' . $dirname . '_' );
		$this->set_debug_read_by_const_name( $constpref . 'DEBUG_READ' );
	}

	public static function &getSingleton( $dirname, $trust_dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] = new webphoto_inc_ini( $dirname, $trust_dirname );
		}

		return $singletons[ $dirname ];
	}


// public
// Get Initial settings from include/main.ini
	public function read_main_ini( $debug = false ) {
		$this->read_ini( 'main.ini', $debug );
	}

	function read_ini( $file, $debug = false ) {
		$file_trust_include = $this->_TRUST_DIR . '/include/' . $file;
		$file_trust_preload = $this->_TRUST_DIR . '/preload/' . $file;
		$file_root_include  = $this->_MODULE_DIR . '/include/' . $file;
		$file_root_preload  = $this->_MODULE_DIR . '/preload/' . $file;

		$arr = array();

// root: high priority
		if ( file_exists( $file_root_include ) ) {
			$this->debug_msg_read_file( $file_root_include, $debug );
			$arr_ini = parse_ini_file( $file_root_include );
			if ( is_array( $arr_ini ) ) {
				$arr = array_merge( $arr, $arr_ini );
			}

// trust: low priority
		} elseif ( file_exists( $file_trust_include ) ) {
			$this->debug_msg_read_file( $file_trust_include, $debug );
			$arr_ini = parse_ini_file( $file_trust_include );
			if ( is_array( $arr_ini ) ) {
				$arr = array_merge( $arr, $arr_ini );
			}

// read if trust
			if ( file_exists( $file_trust_preload ) ) {
				$this->debug_msg_read_file( $file_trust_preload, $debug );
				$arr_ini = parse_ini_file( $file_trust_preload );
				if ( is_array( $arr_ini ) ) {
					$arr = array_merge( $arr, $arr_ini );
				}
			}
		}

// read preload
		if ( file_exists( $file_root_preload ) ) {
			$this->debug_msg_read_file( $file_root_preload, $debug );
			$arr_ini = parse_ini_file( $file_root_preload );
			if ( is_array( $arr_ini ) ) {
				$arr = array_merge( $arr, $arr_ini );
			}
		}

		$this->_array_ini = $arr;

		return true;
	}

	public function isset_ini( $name ) {
		if ( isset( $this->_array_ini[ $name ] ) ) {
			return true;
		}

		return false;
	}

	public function get_ini( $name ) {
		return $this->_array_ini[ $name ] ?? null;
	}

	public function explode_ini( $name, $grue = '|', $prefix = null ) {
		return $this->str_to_array(
			$this->get_ini( $name ), $grue, $prefix );
	}

	public function hash_ini( $name, $grue1 = '|', $grue2 = ':' ) {
		$arr = $this->str_to_array(
			$this->get_ini( $name ), $grue1, null );
		if ( ! is_array( $arr ) ) {
			return false;
		}

		$ret = array();
		foreach ( $arr as $a ) {
			$t = $this->str_to_array( $a, $grue2, null );
			if ( isset( $t[0] ) && isset( $t[1] ) ) {
				$ret[ $t[0] ] = $t[1];
			}
		}

		return $ret;
	}

	public function str_to_array( $str, $grue, $prefix ) {
		$arr = explode( $grue, $str );
		$ret = array();
		foreach ( $arr as $a ) {
			$a = trim( $a );
			if ( $a == '' ) {
				continue;
			}
			$ret[] = $prefix . $a;
		}

		return $ret;
	}


// debug

	public function debug_msg_read_file( $file, $debug = true ) {
		$file_win = str_replace( '/', '\\', $file );

		if ( $this->_DEBUG_READ && $debug ) {
			echo 'read ' . $file . "<br>\n";
		}
	}

	public function set_debug_read( $val ) {
		$this->_DEBUG_READ = (bool) $val;
	}

	public function set_debug_read_by_const_name( $name ) {
		$name = strtoupper( $name );
		if ( defined( $name ) ) {
			$this->set_debug_read( constant( $name ) );
		}
	}

}
