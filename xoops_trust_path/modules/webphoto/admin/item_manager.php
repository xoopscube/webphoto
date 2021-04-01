<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

webphoto_include_once( 'admin/header_edit.php' );
webphoto_include_once( 'class/edit/photo_form.php' );
webphoto_include_once( 'class/edit/misc_form.php' );
webphoto_include_once( 'class/edit/flashvar_edit.php' );
webphoto_include_once( 'class/edit/flashvar_form.php' );
webphoto_include_once( 'class/admin/item_form.php' );
webphoto_include_once( 'class/admin/item_manager.php' );

$manage =& webphoto_admin_item_manager::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$manage->main();
exit();
