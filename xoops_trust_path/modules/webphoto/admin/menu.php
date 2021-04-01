<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

include_once WEBPHOTO_TRUST_PATH . '/class/d3/optional.php';
include_once WEBPHOTO_TRUST_PATH . '/include/optional.php';

$MY_DIRNAME = $GLOBALS['MY_DIRNAME'];
webphoto_include_once( 'class/inc/ini.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/admin_menu.php', $MY_DIRNAME );
webphoto_include_language( 'modinfo.php', $MY_DIRNAME );

$manager   =& webphoto_inc_admin_menu::getSingleton(
	$MY_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$adminmenu = $manager->build_menu();
