<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

webphoto_include_once( 'admin/header.php' );
webphoto_include_once( 'class/admin/text.php' );

$webphoto_manage =& webphoto_admin_text::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$webphoto_manage->main();
exit();
