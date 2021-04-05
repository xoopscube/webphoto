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


class webphoto_lib_imagemagick {
	public $_cmd_convert = 'convert';
	public $_cmd_composite = 'composite';

	public $_cmd_path = null;
	public $_flag_chmod = false;
	public $_msg_array = array();

	public $_CHMOD_MODE = 0777;
	public $_DEBUG = false;


	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_imagemagick();
		}

		return $instance;
	}


// main

	public function set_cmd_path( $val ) {
		$this->_cmd_path      = $val;
		$this->_cmd_convert   = $this->_cmd_path . 'convert';
		$this->_cmd_composite = $this->_cmd_path . 'composite';

		if ( $this->is_win_os() ) {
			$this->_cmd_convert   = $this->conv_win_cmd( $this->_cmd_convert );
			$this->_cmd_composite = $this->conv_win_cmd( $this->_cmd_composite );
		}

	}

	public function set_flag_chmod( $val ) {
		$this->_flag_chmod = (bool) $val;
	}

	public function set_debug( $val ) {
		$this->_DEBUG = (bool) $val;
	}

	public function resize_rotate( $src, $dst, $max_width = 0, $max_height = 0, $rorate = 0 ) {
		$option = '';

		if ( ( $max_width > 0 ) && ( $max_height > 0 ) ) {
			$option .= ' -geometry ' . $max_width . 'x' . $max_height;
		}

		if ( $rorate > 0 ) {
			$option .= ' -rotate ' . $rorate;
		}

		$this->convert( $src, $dst, $option );

		return true;
	}

	public function add_watermark( $src, $dst, $mark ) {
		$option = '-compose plus ';
		$this->composite( $src, $dst, $mark, $option );
	}

	public function add_icon( $src, $dst, $icon ) {
		$option = ' -gravity southeast ';
		$this->composite( $src, $dst, $icon, $option );
	}

	public function convert( $src, $dst, $option = '' ) {
		$cmd       = $this->_cmd_convert . ' ' . $option . ' ' . $src . ' ' . $dst;
		$ret_array = null;
		exec( "$cmd 2>&1", $ret_array );
		if ( $this->_DEBUG ) {
			echo $cmd . "<br>\n";
			print_r( $ret_array );
		}

		$this->set_msg( $cmd );
		$this->set_msg( $ret_array );

		if ( is_file( $dst ) && filesize( $dst ) ) {
			if ( $this->_flag_chmod ) {
				$this->chmod_file( $dst, $this->_CHMOD_MODE );
			}

			return true;
		}

		return false;
	}

	public function composite( $src, $dst, $change, $option = '' ) {
		$cmd = $this->_cmd_composite . ' ' . $option . ' ' . $change . ' ' . $src . ' ' . $dst;

		$ret_array = null;
		exec( "$cmd 2>&1", $ret_array );
		if ( $this->_DEBUG ) {
			echo $cmd . "<br>\n";
			print_r( $ret_array );
		}

		$this->set_msg( $cmd );
		$this->set_msg( $ret_array );

		if ( is_file( $dst ) && filesize( $dst ) ) {
			if ( $this->_flag_chmod ) {
				$this->chmod_file( $dst, $this->_CHMOD_MODE );
			}

			return true;
		}

		return false;
	}

	public function chmod_file( $file, $mode ) {
		if ( ! $this->_ini_safe_mode ) {
			chmod( $file, $mode );
		}
	}


// version

	public function version( $path ) {
		$convert = $path . 'convert';
		if ( $this->is_win_os() ) {
			$convert = $this->conv_win_cmd( $convert );
		}

		$cmd = $convert . ' --help';
		exec( $cmd, $ret_array );
		if ( count( $ret_array ) > 0 ) {
			$ret = true;
			$str = $ret_array[0] . "<br>\n";

		} else {
			$ret = false;
			$str = "Error: " . $convert . " can't be executed";
		}

		return array( $ret, $str );
	}


// utility

	public function is_win_os() {
		return strpos( PHP_OS, "WIN" ) === 0;
	}

	public function conv_win_cmd( $cmd ) {
		$str = '"' . $cmd . '.exe"';

		return $str;
	}


// msg

	public function clear_msg_array() {
		$this->_msg_array = array();
	}

// BUG: Fatal error: Call to undefined method webphoto_lib_imagemagick::get_msg_array()
	public function get_msg_array() {
		return $this->_msg_array;
	}

	function set_msg( $ret_array ) {
		if ( is_array( $ret_array ) ) {
			foreach ( $ret_array as $line ) {
				$this->_msg_array[] = $line;
			}
		} else {
			$this->_msg_array[] = $ret_array;
		}
	}

}
