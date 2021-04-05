<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * $MY_DIRNAME WEBPHOTO_TRUST_PATH are set by caller
 */

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

include_once WEBPHOTO_TRUST_PATH . '/include/header.php';

webphoto_include_once( 'class/inc/waiting.php', $MY_DIRNAME );

// --- eval begin ---
eval( 'function b_waiting_' . $MY_DIRNAME . '(){
	return webphoto_waiting_base( "' . $MY_DIRNAME . '" ) ;
}' );
// --- eval end ---

// === function begin ===
if ( ! function_exists( 'webphoto_waiting_base' ) ) {

	function webphoto_waiting_base( $dirname ) {
		$inc_class =& webphoto_inc_waiting::getSingleton(
			$dirname, WEBPHOTO_TRUST_DIRNAME );

		return $inc_class->waiting();
	}

}
