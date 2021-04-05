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

if ( ! defined( 'XOOPS_ROOT_PATH' ) ) {
	die( 'not permit' );
}

if ( ! function_exists( 'happy_linux_build_once_gmap_api' ) ) {

	function happy_linux_build_once_gmap_api( $apikey, $langcode = null ) {
		if ( happy_linux_check_once_gmap_api() ) {
			return happy_linux_build_gmap_api( $apikey, $langcode );
		}

		return null;
	}

	function happy_linux_check_once_gmap_api() {
		$const_name = "_C_HAPPY_LINUX_LOADED_GMAP_APIKEY";
		if ( ! defined( $const_name ) ) {
			define( $const_name, 1 );

			return true;
		}

		return false;
	}

	function happy_linux_build_gmap_api( $apikey, $langcode = null ) {
		if ( empty( $langcode ) ) {
			$langcode = _LANGCODE;
		}

		$src = 'http://maps.google.com/maps?file=api&amp;hl=' . $langcode . '&amp;v=2&amp;key=' . $apikey;
		$str = '<script src="' . $src . '" type="text/javascript" charset="utf-8"></script>' . "\n";

		return $str;
	}

}
