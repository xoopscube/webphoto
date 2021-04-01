<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

webphoto_include_once( 'admin/header_edit.php' );
webphoto_include_once( 'class/admin/redo_form.php' );
webphoto_include_once( 'class/admin/redothumbs.php' );

$manager =& webphoto_admin_redothumbs::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$manager->main();
exit();
