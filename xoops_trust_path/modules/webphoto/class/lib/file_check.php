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


class webphoto_lib_file_check {
	public $_dir_class;

	public $_ini_safe_mode;

	public $_DIRNAME;
	public $_TRUST_DIRNAME;
	public $_MODULE_DIR;
	public $_TRUST_DIR;

	public $_CHMOD_MODE = 0777;


	public function __construct( $dirname, $trust_dirname ) {

		$this->_DIRNAME       = $dirname;
		$this->_MODULE_DIR    = XOOPS_ROOT_PATH . '/modules/' . $dirname;
		$this->_TRUST_DIRNAME = $trust_dirname;
		$this->_TRUST_DIR     = XOOPS_TRUST_PATH . '/modules/' . $trust_dirname;

		$this->_dir_class =& webphoto_lib_dir::getInstance();

		$this->_ini_safe_mode = ini_get( 'safe_mode' );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_file_check( $dirname, $trust_dirname );
		}

		return $instance;
	}

	public function create_list( $name ) {
		$data = '';
		$dir  = $this->build_dir( $name );

		$files = $this->_dir_class->get_files_in_deep_dir( $dir );
		foreach ( $files as $file ) {
			$file_full = $dir . $file;
			if ( is_dir( $file_full ) || ! is_file( $file_full ) ) {
				continue;
			}
//		$md5  = md5_file( $file_full ) ;
			$size = filesize( $file_full );
			$line = count( file( $file_full ) );
			$str  = $file . ' : ' . $size . ' : ' . $line . "\n";
			$data .= $str;
		}

		$this->write_file( $name, $data );

		return $data;
	}

	public function check_list( $name ) {
		$msg     = '';
		$dir     = $this->build_dir( $name );
		$data    = $this->read_file( $name );
		$resFile = XOOPS_TRUST_PATH . '/cache/webphoto_check_' . $name . '.txt';
		$res     = '';

		$lines = $this->str_to_array( $data, "\n" );
		foreach ( $lines as $line ) {
			list( $file, $size_comp, $line_comp ) = $this->str_to_array( $line, ":" );
			$file_full = $dir . trim( $file );
			if ( ! file_exists( $file_full ) ) {
				$msg .= 'not exist : ' . $file_full . "<br>\n";
				continue;
			}
//		$md5  = md5_file( $file_full ) ;
			$size = filesize( $file_full );
			$line = count( file( $file_full ) );
			$res  .= $file . ' : ' . $size . ' : ' . $line . "\n";
//		if ( $md5 != trim($md5) ) ) {
//			$msg .= 'unmatch md5 : '.$file_full."<br>\n";
//		}
			if ( $size == trim( $size_comp ) ) {
				continue;
			}
			if ( $line == trim( $line_comp ) ) {
				continue;
			}
			$msg .= 'unmatch : ' . $file_full . "<br>\n";
		}
		file_put_contents( $resFile, $res );

		return $msg;
	}

	public function build_dir( $name ) {
		switch ( $name ) {
			case 'trust':
				$dir = $this->_TRUST_DIR;
				break;

			case 'root':
				$dir = $this->_MODULE_DIR;
				break;
		}

		return $dir;
	}

	public function write_file( $name, $data, $mode = 'w', $flag_chmod = true ) {
		$file = XOOPS_TRUST_PATH . '/tmp/' . $this->build_filename( $name );
		$fp   = fopen( $file, $mode );
		if ( ! $fp ) {
			return false;
		}

		$byte = fwrite( $fp, $data );
		fclose( $fp );

// the user can delete this file which apache made.
		if ( ( $byte > 0 ) && $flag_chmod ) {
			$this->chmod_file( $file, $this->_CHMOD_MODE );
		}

		return $byte;
	}

	public function chmod_file( $file, $mode ) {
		if ( ! $this->_ini_safe_mode ) {
			chmod( $file, $mode );
		}
	}

	public function read_file( $name ) {
		$file = $this->_TRUST_DIR . '/include/' . $this->build_filename( $name );

		return file_get_contents( $file );
	}

	public function build_filename( $name ) {
		$file = $this->_TRUST_DIRNAME . '_check_' . $name . '.txt';

		return $file;
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
