<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_d3_preload {
	public $_dh;
	public $_opened_path = null;

	public $_errors = array();

	public $_TRUST_DIRNAME;
	public $_TRUST_DIR;
	public $_DIRNAME;
	public $_MODULE_DIR;
	public $_MODULE_URL;

	public $_DEBUG = false;

	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_d3_preload();
		}

		return $instance;
	}

	public function init( $dirname, $trust_dirname ) {
		$this->init_trust( $trust_dirname );

		$this->_DIRNAME    = $dirname;
		$this->_MODULE_DIR = XOOPS_ROOT_PATH . '/modules/' . $dirname;
		$this->_MODULE_URL = XOOPS_URL . '/modules/' . $dirname;
	}

	public function init_trust( $trust_dirname ) {
		$this->_TRUST_DIRNAME = $trust_dirname;
		$this->_TRUST_DIR     = XOOPS_TRUST_PATH . '/modules/' . $trust_dirname;
	}


// public
	public function include_once_preload_trust_files() {
		$path = $this->_TRUST_DIR . '/preload';
		$ext  = 'php';

		return $this->include_once_files_in_dir( $path, $ext );
	}

	public function include_once_preload_files() {
		$path = $this->_MODULE_DIR . '/preload';
		$ext  = 'php';

		return $this->include_once_files_in_dir( $path, $ext );
	}

	public function &get_class_instance( $name ) {
		$name_extend = $this->build_class_name( $name );
		$name_basic  = strtolower( $this->_TRUST_DIRNAME . '_' . $name );
		if ( class_exists( $name_extend ) ) {
			$ret = new $name_extend( $this->_DIRNAME, $this->_TRUST_DIRNAME );

			return $ret;

		} elseif ( class_exists( $name_basic ) ) {
			$ret = new $name_basic( $this->_DIRNAME, $this->_TRUST_DIRNAME );

			return $ret;
		}

		$false = false;

		return $false;
	}

	public function exists_class( $name ) {
		if ( class_exists( $this->build_class_name( $name ) ) ) {
			return true;
		}

		return false;
	}

	public function exists_function( $name ) {
		if ( function_exists( $this->build_function_name( $name ) ) ) {
			return true;
		}

		return false;
	}

	public function exec_class_method( $name, $method, $options = null ) {
		$class_name = $this->build_class_name( $name );
		if ( class_exists( $class_name ) ) {
			$class = new $class_name( $this->_DIRNAME, $this->_TRUST_DIRNAME );

			if ( method_exists( $class, $method ) ) {
				return $class->$method( $options );
			}
		}

		return false;
	}

	public function exec_function( $name, $options = null ) {
		$func = $this->build_function_name( $name );
		if ( function_exists( $func ) ) {
			return $func( $options );
		}

		return false;
	}

	public function build_class_name( $name ) {
		return $this->build_name( $name );
	}

	public function build_function_name( $name ) {
		return $this->build_name( $name );
	}

	public function build_name( $name ) {
		return strtolower( $this->_TRUST_DIRNAME . '_' . $this->_DIRNAME . '_' . $name );
	}


// preload contstant
	public function get_preload_const_array() {
		$arr = [];

		$needle       = strtoupper( '_P_' . $this->_DIRNAME . '_' );
		$constant_arr = get_defined_constants();

		foreach ( $constant_arr as $k => $v ) {
			if ( strpos( $k, $needle ) !== 0 ) {
				continue;
			}

			$key         = strtolower( str_replace( $needle, '', $k ) );
			$arr[ $key ] = $v;
		}

		return $arr;
	}


// dir handler
	public function include_once_files_in_dir( $path, $ext ) {
		$files = $this->get_files_in_dir( $path, $ext );
		if ( ! is_array( $files ) || ! count( $files ) ) {
			return false;
		}

		foreach ( $files as $file ) {
// omit _xxx
			if ( preg_match( "/^_/", $file ) ) {
				continue;
			}

			$path_file = $path . '/' . $file;
			include_once $path_file;
			if ( $this->_DEBUG ) {
				echo "include_once $path_file <br>\n";
			}
		}

		return true;
	}

	public function get_files_in_dir( $path, $ext = null, $flag_dir = false, $flag_sort = false, $id_as_key = false ) {
		$arr   = [];
		$false = false;

		$path = $this->strip_slash_from_tail( $path );

		$ret = $this->opendir( $path );
		if ( ! $ret ) {
			return $false;
		}

		$pattern = "/\." . preg_quote( $ext ) . "$/";

		foreach ( $this->readdir_array() as $file ) {
			$path_file = $path . '/' . $file;

			if ( is_dir( $path_file ) || ! is_file( $path_file ) ) {
				continue;
			}

			if ( $ext && ! preg_match( $pattern, $file ) ) {
				continue;
			}

			$file_out = $file;
			if ( $flag_dir ) {
				$file_out = $dirname . '/' . $file;
			}
			if ( $id_as_key ) {
				$arr[ $file ] = $file_out;
			} else {
				$arr[] = $file_out;
			}
		}

		$this->closedir();

		if ( $flag_sort ) {
			asort( $arr );
			reset( $arr );
		}

		return $arr;
	}


// basic function
	public function opendir( $path = null ) {
		$this->_dh = null;

		if ( empty( $path ) ) {
			$path = $this->_opened_path;
		}

		if ( ! is_dir( $path ) ) {
			$this->set_error( "not directory: " . $path );

			return false;
		}

		$dh = opendir( $path );
		if ( ! $dh ) {
			$this->set_error( "cannot open directory: " . $path );

			return false;
		}

		$this->_dh          =& $dh;
		$this->_opened_path = $path;

		return true;
	}

	public function closedir() {
		if ( $this->_dh ) {
			$ret = closedir( $this->_dh );
			if ( ! $ret ) {
				$this->set_error( "cannot close directory: " . $this->_opened_path );

				return false;    // NG
			}
		}

		return true;
	}

	public function &readdir_array() {
		$arr = array();
		while ( false !== ( $file = readdir( $this->_dh ) ) ) {
			$arr[] = $file;
		}

		return $arr;
	}


// utlity
	public function check_dirname( $dirname ) {
// check directory travers
		if ( preg_match( "|\.\./|", $dirname ) ) {
			$this->set_error( "illegal directory name: " . $dirname );

			return false;
		}

		return true;
	}

	public function add_slash_to_tail( $dir ) {
		if ( substr( $dir, - 1, 1 ) != '/' ) {
			$dir .= '/';
		}

		return $dir;
	}

	public function strip_slash_from_tail( $dir ) {
		if ( substr( $dir, - 1, 1 ) == '/' ) {
			$dir = substr( $dir, 0, - 1 );
		}

		return $dir;
	}


// error
	public function get_errors() {
		return $this->_errors;
	}

	public function set_error( $msg ) {
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

}
