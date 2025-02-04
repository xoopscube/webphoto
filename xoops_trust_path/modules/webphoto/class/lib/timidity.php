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


class webphoto_lib_timidity {
	public $_cmd_timidity = 'timidity';

	public $_cmd_path = null;
	public $_msg_array = array();
	public $_DEBUG = false;


	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_timidity();
		}

		return $instance;
	}


	public function set_cmd_path( $val ) {
		$this->_cmd_path     = $val;
		$this->_cmd_timidity = $this->_cmd_path . 'timidity';

		if ( $this->is_win_os() ) {
			$this->_cmd_timidity = $this->conv_win_cmd( $this->_cmd_timidity );
		}
	}

	public function set_debug( $val ) {
		$this->_DEBUG = (bool) $val;
	}

	public function mid_to_wav( $mid, $wav, $option = '' ) {
		$cmd_option = ' -Ow -o ' . $wav . ' ' . $option;

		return $this->timidity( $mid, $cmd_option );
	}

	public function timidity( $mid, $option = '' ) {
		$cmd = $this->_cmd_timidity . ' ' . $option . ' ' . $mid;
		exec( "$cmd 2>&1", $ret_array, $ret_code );
		if ( $this->_DEBUG ) {
			echo $cmd . "<br>\n";
		}
		$this->set_msg( $cmd );
		$this->set_msg( $ret_array );

		return $ret_code;
	}


// version

	public function version( $path ) {
// TiMidity++ version 2.13.1

		$timidity = $path . 'timidity';
		if ( $this->is_win_os() ) {
			$timidity = $this->conv_win_cmd( $timidity );
		}

		$cmd = $timidity . ' -v 2>&1';
		exec( $cmd, $ret_array );
		if ( count( $ret_array ) > 0 ) {
			$ret = true;
			$msg = $ret_array[0];

		} else {
			$ret = false;
			$msg = "Error: " . $timidity . " can't be executed";
		}

		return array( $ret, $msg );
	}


// utility

	public function is_win_os() {
		if ( strpos( PHP_OS, "WIN" ) === 0 ) {
			return true;
		}

		return false;
	}

	public function conv_win_cmd( $cmd ) {
		$str = '"' . $cmd . '.exe"';

		return $str;
	}


// msg

	function clear_msg_array() {
		$this->_msg_array = array();
	}

	function get_msg_array() {
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
