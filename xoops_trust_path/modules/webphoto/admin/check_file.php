<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

webphoto_include_once( 'admin/header.php' );
webphoto_include_once( 'class/lib/dir.php' );
webphoto_include_once( 'class/lib/file_check.php' );
webphoto_include_once( 'class/admin/check_file.php' );

$manager =& webphoto_admin_check_file::getInstance(
	WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$manager->main();
exit();

