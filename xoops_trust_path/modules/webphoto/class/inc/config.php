<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * class webphoto_inc_config
 * caller inc_xoops_version inc_blocks
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_inc_config {
	public $_cached_config = array();
	public $_DIRNAME;

	public function __construct( $dirname ) {
		$this->_DIRNAME = $dirname;
		$this->_get_xoops_config( $dirname );
	}

	public static function &getSingleton( $dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] = new webphoto_inc_config( $dirname );
		}

		return $singletons[ $dirname ];
	}


// cache 

	function get_by_name( $name ) {
		return $this->_cached_config[ $name ] ?? false;
	}

	function get_path_by_name( $name ) {
		$path = $this->get_by_name( $name );
		if ( $path ) {
			return $this->_add_slash_to_head( $path );
		}

		return null;
	}

	function _add_slash_to_head( $str ) {
// ord : the ASCII value of the first character of string
// 0x2f slash

		if ( ord( $str ) != 0x2f ) {
			$str = "/" . $str;
		}

		return $str;
	}


// xoops class

	function _get_xoops_config( $dirname ) {
		if ( defined( "WEBPHOTO_COMMOND_MODE" ) && ( WEBPHOTO_COMMOND_MODE == 1 ) ) {
			$config =& webphoto_bin_config::getInstance();
		} else {
			$config =& webphoto_inc_xoops_config::getInstance();
		}

		$this->_cached_config = $config->get_config_by_dirname( $dirname );
	}

}
