<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * caller main/mail_retrieve.php i_post.php
 * admin/maillog_manager.php
 * bin/retrieve.php
 */

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

// PEAR
if ( ! defined( '_WEBPHOTO_PEAR_LOADED' ) ) {
	define( '_WEBPHOTO_PEAR_LOADED', '1' );

	$config_class =& webphoto_config::getInstance( WEBPHOTO_DIRNAME );
	$pear_path    = $config_class->get_by_name( 'pear_path' );

	if ( empty( $pear_path ) || ! is_dir( $pear_path ) ) {
		$pear_path = WEBPHOTO_TRUST_PATH . '/PEAR';
	}

	set_include_path( get_include_path() . PATH_SEPARATOR . $pear_path );
}

require_once 'Net/POP3.php';
require_once 'Mail/mimeDecode.php';

webphoto_include_once( 'class/pear/mail_pop3.php' );
webphoto_include_once( 'class/pear/mail_decode.php' );
webphoto_include_once( 'class/pear/mail_parse.php' );

webphoto_include_once( 'class/lib/mail.php' );

webphoto_include_once( 'class/edit/mail_check.php' );
webphoto_include_once( 'class/edit/mail_photo.php' );
webphoto_include_once( 'class/edit/mail_unlink.php' );
webphoto_include_once( 'class/edit/mail_retrieve.php' );
