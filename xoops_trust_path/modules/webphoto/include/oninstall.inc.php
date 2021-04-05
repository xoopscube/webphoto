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

// xoops system files
include_once XOOPS_ROOT_PATH . '/class/xoopsblock.php';
include_once XOOPS_ROOT_PATH . '/class/template.php';

// webphoto files
include_once WEBPHOTO_TRUST_PATH . '/include/header.php';

webphoto_include_once( 'class/lib/file_log.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/gperm_def.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/group.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/oninstall_item.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/oninstall_cat.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/oninstall_mime.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/oninstall_flashvar.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/oninstall.php', $MY_DIRNAME );

webphoto_include_once_trust( 'preload/constants.php' );

// onInstall function
// --- eval begin ---
eval( 'function xoops_module_install_' . $MY_DIRNAME . '( &$module ) {return webphoto_oninstall_base( $module ) ; } 
function xoops_module_update_' . $MY_DIRNAME . '( &$module ) {return webphoto_onupdate_base( $module ) ; } 
function xoops_module_uninstall_' . $MY_DIRNAME . '( &$module ) {return webphoto_onuninstall_base( $module ) ; } ' );
// --- eval end ---

if ( ! function_exists( 'webphoto_oninstall_base' ) ) {

	function webphoto_oninstall_base( &$module ) {
		$inc_class =& webphoto_inc_oninstall::getSingleton(
			webphoto_oninstall_dirname( $module ), WEBPHOTO_TRUST_DIRNAME );

		return $inc_class->install( $module );
	}

	function webphoto_onupdate_base( &$module ) {
		$inc_class =& webphoto_inc_oninstall::getSingleton(
			webphoto_oninstall_dirname( $module ), WEBPHOTO_TRUST_DIRNAME );

		return $inc_class->update( $module );
	}

	function webphoto_onuninstall_base( &$module ) {
		$inc_class =& webphoto_inc_oninstall::getSingleton(
			webphoto_oninstall_dirname( $module ), WEBPHOTO_TRUST_DIRNAME );

		return $inc_class->uninstall( $module );
	}

	function webphoto_oninstall_dirname( &$module ) {
		return $module->getVar( 'dirname', 'n' );
	}

	function webphoto_message_append_oninstall( &$module_obj, &$log ) {
		if ( is_array( @$GLOBALS['ret'] ) ) {
			foreach ( $GLOBALS['ret'] as $message ) {
				$log->add( strip_tags( $message ) );
			}
		}

		// use mLog->addWarning() or mLog->addError() if necessary
	}

	function webphoto_message_append_onupdate( &$module_obj, &$log ) {
		if ( is_array( @$GLOBALS['msgs'] ) ) {
			foreach ( $GLOBALS['msgs'] as $message ) {
				$log->add( strip_tags( $message ) );
			}
		}

		// use mLog->addWarning() or mLog->addError() if necessary
	}

	function webphoto_message_append_onuninstall( &$module_obj, &$log ) {
		if ( is_array( @$GLOBALS['ret'] ) ) {
			foreach ( $GLOBALS['ret'] as $message ) {
				$log->add( strip_tags( $message ) );
			}
		}

		// use mLog->addWarning() or mLog->addError() if necessary
	}

}
