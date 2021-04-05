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


class webphoto_lib_file_log {

	public $_file = '';

	public function __construct() {
		$file = XOOPS_TRUST_PATH . '/log/webphoto_log.txt';
		$this->set_file( $file );
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_file_log();
		}

		return $instance;
	}

	public function set_file( $file ) {
		$this->_file = $file;
	}

	public function backtrace() {
		ob_start();
		debug_print_backtrace();
		$this->write( ob_get_contents() );
		ob_end_clean();
	}

	public function printr( $val ) {
		ob_start();
		print_r( $val );
		$this->write( ob_get_contents() );
		ob_end_clean();
	}

	public function time() {
		$this->write( date( "Y-m-d H:i:s" ) );
	}

	public function url() {
		$protocol = ( isset( $_SERVER['HTTPS'] ) && ( $_SERVER['HTTPS'] == 'on' ) ) ? 'https' : 'http';
		$url      = $protocol . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$this->write( "URL: " . $url );
	}

	public function request_uri() {
		$this->write( "REQUEST_URI: " . $_SERVER["REQUEST_URI"] );
	}

	public function request_method() {
		$this->write( "REQUEST_METHOD: " . $_SERVER["REQUEST_METHOD"] );
	}

	public function write( $data ) {
		file_put_contents( $this->_file, $data . "\n", FILE_APPEND );
	}

}
