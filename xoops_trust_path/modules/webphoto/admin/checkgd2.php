<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

webphoto_include_once( 'class/admin/checkgd2.php' );

webphoto_include_language( 'admin.php' );

// main
$manager =& webphoto_admin_checkgd2::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$manager->main();
exit();
