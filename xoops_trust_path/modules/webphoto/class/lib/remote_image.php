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


// define constant
define( '_C_WEBPHOTO_REMOTE_IMAGE_ERR_WRITE', - 11 );


class webphoto_lib_remote_image extends webphoto_lib_remote_file {

	public $_dir_work = null;


	public function __construct() {

		parent::__construct();

		$this->_dir_work = XOOPS_TRUST_PATH . '/tmp';
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_remote_image();
		}

		return $instance;
	}

// public
// get_image_size
// return is same as getimagesize()
// array of width, height, type, attr

	public function get_image_size( $url ) {
		$this->clear_error_code();
		$this->clear_errors();

		if ( empty( $url ) || ( $url == 'http://' ) || ( $url == 'https://' ) ) {
			return false;
		}

		if ( ! is_writable( $this->_dir_work ) ) {
			return false;
		}

		$data = $this->read_file( $url );
		if ( ! $data ) {
			return false;
		}

		$file = tempnam( $this->_dir_work, "image" );

		if ( ! $this->write_file( $file, $data ) ) {
			$this->set_error_code( _C_WEBPHOTO_REMOTE_IMAGE_ERR_WRITE );
			$this->set_error( "remote_image: cannot write : " . $file );

			return false;
		}

		$size = getimagesize( $file );

		unlink( $file );

		return $size;
	}


// set and get property

	public function set_dir_work( $value ) {
		$this->_dir_work = $value;
	}

	public function get_dir_work() {
		return $this->_dir_work;
	}


// utility

	public function write_file( $file, $data, $mode = 'w', $flag_chmod = true ) {
		$fp = fopen( $file, $mode );
		if ( ! $fp ) {
			return false;
		}

		$byte = fwrite( $fp, $data );
		fclose( $fp );

// the user can delete this file which apache made.
		if ( ( $byte > 0 ) && $flag_chmod ) {
			chmod( $file, 0777 );
		}

		return $byte;
	}

}
