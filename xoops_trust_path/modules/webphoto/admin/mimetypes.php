<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

webphoto_include_once( 'admin/header.php' );
webphoto_include_once( 'class/lib/pagenavi.php' );
webphoto_include_once( 'class/handler/mime_handler.php' );
webphoto_include_once( 'class/admin/mime_form.php' );
webphoto_include_once( 'class/admin/mimetypes.php' );

$manager =& webphoto_admin_mimetypes::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$manager->main();
exit();
