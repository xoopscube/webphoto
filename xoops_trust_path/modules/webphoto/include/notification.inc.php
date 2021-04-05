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
webphoto_include_once( 'class/inc/notification.php', $MY_DIRNAME );

eval( 'function ' . $MY_DIRNAME . '_notify_iteminfo( $category, $item_id ){return webphoto_notify_iteminfo_base( "' . $MY_DIRNAME . '" , $category, $item_id ) ;}' );

if ( ! function_exists( 'webphoto_notify_iteminfo_base' ) ) {

	function webphoto_notify_iteminfo_base( $dirname, $category, $item_id ) {
		$inc_class =& webphoto_inc_notification::getSingleton(
			$dirname, WEBPHOTO_TRUST_DIRNAME );

		return $inc_class->notify( $category, $item_id );
	}

}
