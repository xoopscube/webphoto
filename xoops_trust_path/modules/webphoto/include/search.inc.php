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

webphoto_include_once( 'class/inc/public.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/auto_publish.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/uri.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/search.php', $MY_DIRNAME );

// --- eval begin ---
eval( 'function ' . $MY_DIRNAME . '_search( $query_array , $andor , $limit , $offset , $uid ){return webphoto_search_base( "' . $MY_DIRNAME . '" , $query_array , $andor , $limit , $offset , $uid ) ;}' );
// --- eval end ---

if ( ! function_exists( 'webphoto_search_base' ) ) {

	function webphoto_search_base( $dirname, $query_array, $andor, $limit, $offset, $uid ) {
		$inc_class =& webphoto_inc_search::getSingleton(
			$dirname, WEBPHOTO_TRUST_DIRNAME );

		return $inc_class->search( $query_array, $andor, $limit, $offset, $uid );
	}
}
