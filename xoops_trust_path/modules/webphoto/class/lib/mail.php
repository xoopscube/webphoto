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


class webphoto_lib_mail {

	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_mail();
		}

		return $instance;
	}


// utility

	function get_valid_addr( $str ) {
		list( $name, $addr ) = $this->parse_name_addr( $str );

		if ( $this->check_valid_addr( $addr ) ) {
			return $addr;
		}

		return null;
	}

	function check_valid_addr( $addr ) {
// same as class/xoopsmailer.php
		$PATTERN = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i";

		if ( preg_match( $PATTERN, $addr ) ) {
			return true;
		}

		return false;
	}

	function parse_name_addr( $str ) {
		$name = '';

// taro <taro@example.com>
		$PATTERN = '/(.*)<(.*)>/i';

		if ( preg_match( $PATTERN, $str, $matches ) ) {
			$name = trim( $matches[1] );
			$addr = trim( $matches[2] );
		} else {
			$addr = trim( $str );
		}

		return array( $name, $addr );
	}

}
