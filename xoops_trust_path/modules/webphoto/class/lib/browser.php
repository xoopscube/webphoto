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


class webphoto_lib_browser {

	public $_http_user_agent = null;
	public $_os = null;
	public $_browser = null;

	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_browser();
		}

		return $instance;
	}


// presume os and browser by agent

	public function presume_agent() {
		$agent = $_SERVER["HTTP_USER_AGENT"];

		if ( empty( $agent ) ) {
			return;
		}    // undefined

// presume OS
		$os = 'unknown';
		if ( false !== stripos( $agent, "Win" ) ) {
			$os = 'win';
		} elseif ( false !== stripos( $agent, "Mac" ) ) {
			$os = 'mac';
		} elseif ( false !== stripos( $agent, "Linux" ) ) {
			$os = 'linux';
		} elseif ( false !== stripos( $agent, "BSD" ) ) {
			$os = 'bsd';
		} elseif ( false !== stripos( $agent, "IRIX" ) ) {
			$os = 'irix';
		} elseif ( false !== stripos( $agent, "Sun" ) ) {
			$os = 'sun';
		} elseif ( false !== stripos( $agent, "HP-UX" ) ) {
			$os = 'hpux';
		} elseif ( false !== stripos( $agent, "AIX" ) ) {
			$os = 'aix';
		} elseif ( false !== stripos( $agent, "X11" ) ) {
			$os = 'x11';
		}

// presume Browser
		$brawser = 'unknown';
		if ( false !== stripos( $agent, "Opera" ) ) {
			$browser = 'opera';
		} elseif ( false !== stripos( $agent, "MSIE" ) ) {
			$browser = 'msie';
		} elseif ( false !== stripos( $agent, "Firefox" ) ) {
			$browser = 'firefox';
		} elseif ( false !== stripos( $agent, "Chrome" ) ) {
			$browser = 'chrome';
		} elseif ( false !== stripos( $agent, "Safari" ) ) {
			$browser = 'safari';
		}

		$this->_http_user_agent = $agent;
		$this->_os              = $os;
		$this->_browser         = $browser;
	}


// get param

	public function get_os() {
		return $this->_os;
	}

	public function get_browser() {
		return $this->_browser;
	}

}
