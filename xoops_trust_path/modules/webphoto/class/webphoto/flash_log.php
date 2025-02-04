<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * class webphoto_flash_log
 * caller webphoto_main_callback webphoto_admin_item_manager
 */

// http://code.jeroenwijering.com/trac/wiki/Flashvars3
//
// Only for the mediaplayer. 
// Set this to a serverside script that can process statistics. 
// The player will send it a POST every time an item starts/stops. 
// To send callbacks automatically to Google Analytics, 
// set this to urchin (if you use the old urchinTracker code) 
// or analytics (if you use the new pageTracker code). 
//
// The player returns $id, $title, $file, $state, $duration in POST variable
// $state (start/stop)
// $duration is set at stop


if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

class webphoto_flash_log {
	public $_config_class;
	public $_utility_class;

	public $_WORK_DIR;
	public $_LOG_FILE;


	public function __construct( $dirname ) {
		$this->_utility_class =& webphoto_lib_utility::getInstance();
		$this->_post_class    =& webphoto_lib_post::getInstance();

		$this->_init_xoops_config( $dirname );

		$this->_LOG_FILE = $this->_WORK_DIR . '/log/flash.txt';
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_flash_log( $dirname );
		}

		return $instance;
	}


// callback

	function callback_log() {
		$id       = $this->_post_class->get_post_int( 'id' );
		$duration = $this->_post_class->get_post_int( 'duration' );
		$title    = $this->_post_class->get_post_text( 'title' );
		$file     = $this->_post_class->get_post_text( 'file' );
		$state    = $this->_post_class->get_post_text( 'state' );

		if ( $state != 'start' ) {
			return true;    // no action
		}

		$http_referer = null;
		$remote_addr  = null;

		if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
			$http_referer = $_SERVER['HTTP_REFERER'];
		}

		if ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
			$remote_addr = $_SERVER['REMOTE_ADDR'];
		}

		$data = formatTimestamp( time(), 'm' ) . ',';
		$data .= $http_referer . ',';
		$data .= $remote_addr . ',';
		$data .= $state . ',';
		$data .= $id . ',';
		$data .= $title . ',';
		$data .= $file . ',';
		$data .= $duration;
		$data .= "\r\n";

		return $this->append_log( $data );
	}


// write read

	function get_filename() {
		return $this->_LOG_FILE;
	}

	function append_log( $data ) {
		return $this->_utility_class->write_file( $this->_LOG_FILE, $data, 'a', true );
	}

	function read_log() {
		if ( ! file_exists( $this->_LOG_FILE ) ) {
			return false;    // no file
		}

		$lines = $this->_utility_class->read_file_cvs( $this->_LOG_FILE );

		if ( ! is_array( $lines ) ) {
			return false;
		}

		$count = count( $lines );

// empty file
		if ( $count == 0 ) {
			return array();    // no data
		}

// one line and empty line
		if ( ( $count == 1 ) && empty( $lines[0] ) ) {
			return array();    // no data
		}

// remove last line if empty
		if ( empty( $lines[ $count ][0] ) ) {
			array_pop( $lines );
		}

		return $lines;
	}

	function empty_log() {
		if ( ! file_exists( $this->_LOG_FILE ) ) {
			return false;
		}

		return $this->_utility_class->write_file( $this->_LOG_FILE, '', 'w', true );
	}


// xoops_config

	function _init_xoops_config( $dirname ) {
		$config_handler =& webphoto_inc_config::getSingleton( $dirname );

		$this->_WORK_DIR = $config_handler->get_by_name( 'workdir' );
	}

}
