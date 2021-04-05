<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * class webphoto_lib_jodconverter
 * http://www.artofsolving.com/opensource/jodconverter
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_lib_jodconverter {

	public $_cmd_java = 'java';

	public $_CMD_PATH_JAVA = '';
	public $_jodconverter_jar = '';
	public $_msg_array = array();
	public $_DEBUG = false;

	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_jodconverter();
		}

		return $instance;
	}


// set

	public function set_cmd_path_java( $val ) {
		$this->_CMD_PATH_JAVA = $val;
		$this->_cmd_java      = $this->_CMD_PATH_JAVA . 'java';

		if ( $this->is_win_os() ) {
			$this->_cmd_java = $this->conv_win_cmd( $this->_cmd_java );
		}
	}

	public function set_jodconverter_jar( $val ) {
		$this->_jodconverter_jar = $val;
	}

	public function set_debug( $val ) {
		$this->_DEBUG = (bool) $val;
	}


// main

	public function convert( $src_file, $dst_file ) {
		$this->clear_msg_array();

		$cmd = $this->_cmd_java . ' -jar ' . $this->_jodconverter_jar . ' ' . $src_file . ' ' . $dst_file;
		exec( "$cmd 2>&1", $ret_array, $ret_code );
		if ( $this->_DEBUG ) {
			echo $cmd . "<br>\n";
			print_r( $ret_array );
		}
		$this->set_msg( $cmd );
		$this->set_msg( $ret_array );

		return $ret_code;
	}


// version

	public function version() {
		$cmd = $this->_cmd_java . ' -version';
		exec( "$cmd 2>&1", $ret_array, $ret_code );
		if ( $this->_DEBUG ) {
			echo $cmd . "<br>\n";
		}

		$ret = false;
		if ( is_array( $ret_array ) && count( $ret_array ) ) {
			$msg = $ret_array[0] . "<br>\n";
			list ( $ret, $msg_jod ) = $this->get_version_jodconverter();
			$msg .= $msg_jod;

		} else {
			$msg = "Error: " . $this->_cmd_java . " cannot be executed";
		}

		return array( $ret, $msg );
	}

	public function get_version_jodconverter() {
		$ret = false;

		if ( file_exists( $this->_jodconverter_jar ) ) {
			$ret = true;
			$msg = " jodconverter version ";
			$msg .= $this->parse_version_jodconverter();

		} else {
			$msg = "Error: cannot find " . $this->_jodconverter_jar;
		}

		return array( $ret, $msg );
	}

	public function parse_version_jodconverter() {
		preg_match( '/jodconverter-cli-(.*)\.jar/i', $this->_jodconverter_jar, $matches );
		if ( isset( $matches[1] ) ) {
			return $matches[1];
		}

		return null;
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

	public function clear_msg_array() {
		$this->_msg_array = array();
	}

	public function get_msg_array() {
		return $this->_msg_array;
	}

	public function set_msg( $ret_array ) {
		if ( is_array( $ret_array ) ) {
			foreach ( $ret_array as $line ) {
				$this->_msg_array[] = $line;
			}
		} else {
			$this->_msg_array[] = $ret_array;
		}
	}

}
