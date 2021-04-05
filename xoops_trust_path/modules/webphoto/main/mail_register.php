<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

webphoto_include_once( 'main/header.php' );
webphoto_include_once( 'class/xoops/user.php' );
webphoto_include_once( 'class/lib/gtickets.php' );
webphoto_include_once( 'class/lib/element.php' );
webphoto_include_once( 'class/lib/form.php' );
webphoto_include_once( 'class/lib/mail.php' );
webphoto_include_once( 'class/handler/mime_handler.php' );
webphoto_include_once( 'class/handler/user_handler.php' );
webphoto_include_once( 'class/webphoto/mime.php' );
webphoto_include_once( 'class/edit/item_create.php' );
webphoto_include_once( 'class/edit/base.php' );
webphoto_include_once( 'class/edit/form.php' );
webphoto_include_once( 'class/edit/icon_build.php' );
webphoto_include_once( 'class/edit/mail_register_form.php' );
webphoto_include_once( 'class/main/mail_register.php' );

$manage =& webphoto_main_mail_register::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );

// exit if execute edit
$manage->check_action();

include( XOOPS_ROOT_PATH . '/header.php' );

$manage->print_form();

include( XOOPS_ROOT_PATH . '/footer.php' );
exit();
