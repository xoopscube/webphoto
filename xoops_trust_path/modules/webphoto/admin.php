<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

// check permission
global $xoopsUser;

// environment
require_once XOOPS_ROOT_PATH . '/class/template.php';

$module_handler    =& xoops_gethandler( 'module' );
$xoopsModule       =& $module_handler->getByDirname( $MY_DIRNAME );
$config_handler    =& xoops_gethandler( 'config' );
$xoopsModuleConfig =& $config_handler->getConfigsByCat( 0, $xoopsModule->getVar( 'mid' ) );

// check permission of 'module_admin' of this module
$moduleperm_handler =& xoops_gethandler( 'groupperm' );
if ( ! is_object( @$xoopsUser ) || ! $moduleperm_handler->checkRight( 'module_admin', $xoopsModule->getVar( 'mid' ), $xoopsUser->getGroups() ) ) {
	die( 'only admin can access this area' );
}

$xoopsOption['pagetype'] = 'admin';

require_once XOOPS_ROOT_PATH . '/include/cp_functions.php';

// altsys
$mytrustdirname = basename( __DIR__ );
$mytrustdirpath = XOOPS_TRUST_PATH . '/modules/' . $mytrustdirname;
$mydirname      = $MY_DIRNAME;
$mydirpath      = XOOPS_ROOT_PATH . '/modules/' . $MY_DIRNAME;

if ( ! empty( $_GET['lib'] ) ) {

// initialize language manager
	$langmanpath = XOOPS_TRUST_PATH . '/libs/altsys/class/D3LanguageManager.class.php';
	if ( ! file_exists( $langmanpath ) ) {
		die( 'install the latest altsys' );
	}

	require_once( $langmanpath );
	$langman = D3LanguageManager::getInstance();

	// common libs (eg. altsys)
	$lib  = preg_replace( '/[^a-zA-Z0-9_-]/', '', $_GET['lib'] );
	$page = preg_replace( '/[^a-zA-Z0-9_-]/', '', @$_GET['page'] );

	// check the page can be accessed (make controllers.php just under the lib)
	$controllers = array();
	if ( file_exists( XOOPS_TRUST_PATH . '/libs/' . $lib . '/controllers.php' ) ) {
		require XOOPS_TRUST_PATH . '/libs/' . $lib . '/controllers.php';
		if ( ! in_array( $page, $controllers ) ) {
			$page = $controllers[0];
		}
	}

	if ( file_exists( XOOPS_TRUST_PATH . '/libs/' . $lib . '/' . $page . '.php' ) ) {
		include XOOPS_TRUST_PATH . '/libs/' . $lib . '/' . $page . '.php';
	} else if ( file_exists( XOOPS_TRUST_PATH . '/libs/' . $lib . '/index.php' ) ) {
		include XOOPS_TRUST_PATH . '/libs/' . $lib . '/index.php';
	} else {
		die( 'wrong request' );
	}

	exit();
}

// load language files (main.php & admin.php)
if ( ! defined( "WEBPHOTO_DIRNAME" ) ) {
	define( "WEBPHOTO_DIRNAME", $MY_DIRNAME );
}
if ( ! defined( "WEBPHOTO_ROOT_PATH" ) ) {
	define( "WEBPHOTO_ROOT_PATH", XOOPS_ROOT_PATH . '/modules/' . WEBPHOTO_DIRNAME );
}

include_once WEBPHOTO_TRUST_PATH . '/class/d3/optional.php';
include_once WEBPHOTO_TRUST_PATH . '/include/optional.php';
webphoto_include_once( 'preload/debug.php' );

// fork each page
$get_fct  = $_GET['fct'] ?? null;
$post_fct = $_POST['fct'] ?? $get_fct;
$fct      = preg_replace( '/[^a-zA-Z0-9_-]/', '', $post_fct );

$file_trust_fct   = WEBPHOTO_TRUST_PATH . '/admin/' . $fct . '.php';
$file_root_fct    = WEBPHOTO_ROOT_PATH . '/admin/' . $fct . '.php';
$file_trust_index = WEBPHOTO_TRUST_PATH . '/admin/index.php';
$file_root_index  = WEBPHOTO_ROOT_PATH . '/admin/index.php';
$file_root_main   = WEBPHOTO_ROOT_PATH . '/admin/main.php';

if ( file_exists( $file_root_fct ) ) {
	webphoto_debug_msg( $file_root_fct );
	include_once $file_root_fct;

} elseif ( file_exists( $file_trust_fct ) ) {
	webphoto_debug_msg( $file_trust_fct );
	include_once $file_trust_fct;

} elseif ( file_exists( $file_root_main ) ) {
	webphoto_debug_msg( $file_root_main );
	include_once $file_root_main;

} elseif ( file_exists( $file_trust_index ) ) {
	webphoto_debug_msg( $file_trust_index );
	include_once $file_trust_index;

} else {
	die( 'wrong request' );
}
