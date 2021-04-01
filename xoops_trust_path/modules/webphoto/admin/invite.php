<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

webphoto_include_once( 'admin/header.php' );
webphoto_include_once( 'class/d3/mail_template.php' );
webphoto_include_once( 'class/lib/mail.php' );
webphoto_include_once( 'class/lib/mail_send.php' );
webphoto_include_once( 'class/admin/invite.php' );

$manager =& webphoto_admin_invite::getInstance(
	WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$manager->main();
exit();
