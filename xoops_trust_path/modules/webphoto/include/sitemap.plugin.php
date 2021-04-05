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

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

include_once WEBPHOTO_TRUST_PATH . '/include/header.php';

webphoto_include_once( 'class/inc/uri.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/sitemap.php', $MY_DIRNAME );

// --- eval begin ---
eval( 'function b_sitemap_' . $MY_DIRNAME . '(){return webphoto_sitemap_base( "' . $MY_DIRNAME . '" ) ;}' );
// --- eval end ---

if ( ! function_exists( 'webphoto_sitemap_base' ) ) {

	function webphoto_sitemap_base( $dirname ) {
		$inc_class =& webphoto_inc_sitemap::getSingleton(
			$dirname, WEBPHOTO_TRUST_DIRNAME );

		return $inc_class->sitemap();
	}

}
