<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * class webphoto_lib_remote_file
 * use class snoopy
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

// define constant
define( '_C_WEBPHOTO_REMOTE_FILE_ERR_NOT_FETCH', - 1 );
define( '_C_WEBPHOTO_REMOTE_FILE_ERR_NO_RESULT', - 2 );


class webphoto_lib_remote_file extends webphoto_lib_error {

	public $_snoopy;


	public function __construct() {

		parent::__construct();

		$this->_snoopy = new Snoopy();
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_remote_file();
		}

		return $instance;
	}

	public function read_file( $url ) {
		return $this->snoppy_fetch( $url );
	}

	public function set_snoopy_proxy( $host, $port = '8080', $user = '', $pass = '' ) {
		$this->_snoopy->proxy_host = $host;
		$this->_snoopy->proxy_port = $port;

		if ( $user ) {
			$this->_snoopy->proxy_user = $user;
		}
		if ( $pass ) {
			$this->_snoopy->proxy_pass = $pass;
		}
	}

	public function set_snoopy_timeout_connect( $time ) {
		if ( (int) $time > 0 ) {
			$this->_snoopy->_fp_timeout = (float) $time;
		}
	}

	public function set_snoopy_timeout_read( $time ) {
		if ( (int) $time > 0 ) {
			$this->_snoopy->read_timeout = (float) $time;
		}
	}

	function snoppy_fetch( $url ) {
		$this->clear_error_code();
		$this->clear_errors();

		if ( empty( $url ) ) {
			return false;
		}

		if ( $this->_snoopy->fetch( $url ) ) {
			$res = $this->_snoopy->results;

			if ( $res ) {
				return $res;

			} else {
				$this->set_error_code( _C_WEBPHOTO_REMOTE_FILE_ERR_NO_RESULT );
				$this->set_error( "remote_file: remote data is empty:" );
				if ( $this->_snoopy->error ) {
					$this->set_error( "snoopy: " . $this->_snoopy->error );
				}

				return false;
			}

		} else {
			$this->set_error_code( _C_WEBPHOTO_REMOTE_FILE_ERR_NOT_FETCH );
			$this->set_error( "remote_file: cannot fetch remote data:" );
			if ( $this->_snoopy->error ) {
				$this->set_error( "snoopy: " . $this->_snoopy->error );
			}

			return false;
		}
	}
}
