<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

webphoto_include_once( 'admin/header.php' );
webphoto_include_once( 'class/lib/dir.php' );
webphoto_include_once( 'class/lib/file_md5.php' );
webphoto_include_once( 'class/admin/create_md5.php' );

$manager =& webphoto_admin_create_md5::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$manager->main();
exit();
