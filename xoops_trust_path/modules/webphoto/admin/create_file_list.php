<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

webphoto_include_once( 'admin/header.php' );
webphoto_include_once( 'class/lib/dir.php' );
webphoto_include_once( 'class/lib/file_check.php' );
webphoto_include_once( 'class/admin/create_file_list.php' );

$manager =& webphoto_admin_create_file_list::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$manager->main();
exit();
