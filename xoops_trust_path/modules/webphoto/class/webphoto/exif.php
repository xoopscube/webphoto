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


class webphoto_exif {
	public $_exif_class;
	public $_utility_class;
	public $_mysql_utility_class;

	function __construct() {
		$this->_exif_class          =& webphoto_lib_exif::getInstance();
		$this->_utility_class       =& webphoto_lib_utility::getInstance();
		$this->_mysql_utility_class =& webphoto_lib_mysql_utility::getInstance();

	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_exif();
		}

		return $instance;
	}


// exif

	function get_exif( $file ) {
		$info = $this->_exif_class->read_file( $file );
		if ( ! is_array( $info ) ) {
			return null; // no action
		}

		$info['datetime_mysql'] = $this->exif_to_mysql_datetime( $info );

		return $info;
	}

	function exif_to_mysql_datetime( $exif ) {
		$datetime     = $exif['datetime'];
		$datetime_gnu = $exif['datetime_gnu'];

		if ( $datetime_gnu ) {
			return $datetime_gnu;
		}

		$time = $this->str_to_time( $datetime );
		if ( $time <= 0 ) {
			return false;
		}

		return $this->time_to_mysql_datetime( $time );
	}


// utility class

	function str_to_time( $str ) {
		return $this->_utility_class->str_to_time( $str );
	}

	function time_to_mysql_datetime( $time ) {
		return $this->_mysql_utility_class->time_to_mysql_datetime( $time );
	}

// --- class end ---
}

?>
