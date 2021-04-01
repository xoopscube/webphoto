<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

webphoto_include_once( 'admin/header_edit.php' );
webphoto_include_once( 'class/lib/manage.php' );
webphoto_include_once( 'class/admin/item_table_manage.php' );

$manage =& webphoto_admin_item_table_manage::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$manage->main();
exit();
