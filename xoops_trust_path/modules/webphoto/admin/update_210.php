<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

webphoto_include_once( 'admin/header_edit.php' );
webphoto_include_once( 'class/admin/update_210.php' );

$manager =& webphoto_admin_update_210::getInstance(
	WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$manager->main();
exit();
