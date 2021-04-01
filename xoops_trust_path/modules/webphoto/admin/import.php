<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

webphoto_include_once( 'admin/header_edit.php' );
webphoto_include_once( 'class/xoops/groupperm.php' );
webphoto_include_once( 'class/xoops/module.php' );
webphoto_include_once( 'class/handler/xoops_comments_handler.php' );
webphoto_include_once( 'class/handler/xoops_image_handler.php' );
webphoto_include_once( 'class/handler/myalbum_handler.php' );
webphoto_include_once( 'class/webphoto/cat_selbox.php' );
webphoto_include_once( 'class/edit/import.php' );
webphoto_include_once( 'class/admin/import_form.php' );
webphoto_include_once( 'class/admin/import.php' );

$manager =& webphoto_admin_import::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$manager->main();
exit();
