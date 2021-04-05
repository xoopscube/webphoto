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

webphoto_include_once( 'class/inc/comment.php', $MY_DIRNAME );

eval( 'function ' . $MY_DIRNAME . '_comments_update( $id, $comments ){return webphoto_comments_update_base( "' . $MY_DIRNAME . '" , $id, $comments ) ;}
function ' . $MY_DIRNAME . '_comments_approve( &$comment ){return webphoto_comments_approve_base( "' . $MY_DIRNAME . '" , $comment ) ;}' );

// === com_update_base begin ===
if ( ! function_exists( 'webphoto_comments_update_base' ) ) {

	function webphoto_comments_update_base( $dirname, $id, $comments ) {
		$inc_handler =& webphoto_inc_comment::getSingleton(
			$dirname, WEBPHOTO_TRUST_DIRNAME );

		return $inc_handler->update_photo_comments( $id, $comments );
	}

	function webphoto_comments_approve_base( $dirname, &$comment ) {
		// notification mail here
	}

}
