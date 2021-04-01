<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

webphoto_include_once( 'admin/header.php' );
webphoto_include_once( 'class/inc/gperm_def.php' );
webphoto_include_once( 'class/lib/groupperm.php' );
webphoto_include_once( 'class/lib/groupperm_form.php' );
webphoto_include_once( 'class/admin/groupperm_form.php' );
webphoto_include_once( 'class/admin/groupperm.php' );

$manager =& webphoto_admin_groupperm::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$manager->main();
exit();
