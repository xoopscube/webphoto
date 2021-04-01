<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

webphoto_include_once( 'admin/header_edit.php' );
webphoto_include_once( 'class/edit/photo_form.php' );
webphoto_include_once( 'class/edit/misc_form.php' );
webphoto_include_once( 'class/admin/batch.php' );

$manager =& webphoto_admin_batch::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$manager->main();
exit();
