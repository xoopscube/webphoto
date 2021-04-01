<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

webphoto_include_once( 'admin/header_rss.php' );
webphoto_include_once( 'class/admin/rss_form.php' );
webphoto_include_once( 'class/admin/rss_manager.php' );

$manager =& webphoto_admin_rss_manager::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$manager->main();
exit();
