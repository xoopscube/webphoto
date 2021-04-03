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

// webphoto files
if ( ! defined( "WEBPHOTO_DIRNAME" ) ) {
	define( "WEBPHOTO_DIRNAME", $MY_DIRNAME );
}
if ( ! defined( "WEBPHOTO_ROOT_PATH" ) ) {
	define( "WEBPHOTO_ROOT_PATH", XOOPS_ROOT_PATH . '/modules/' . WEBPHOTO_DIRNAME );
}

if ( ! defined( "WEBPHOTO_COMMOND_MODE" ) ) {
	define( "WEBPHOTO_COMMOND_MODE", 1 );
}

include_once WEBPHOTO_TRUST_PATH . '/class/d3/optional.php';
include_once WEBPHOTO_TRUST_PATH . '/include/optional.php';

webphoto_include_once( 'preload/debug.php' );

webphoto_include_once( 'class/lib/error.php' );
webphoto_include_once( 'class/lib/handler.php' );

webphoto_include_once( 'class/bin/xoops_database.php' );
webphoto_include_once( 'class/bin/xoops_mysql_database.php' );
webphoto_include_once( 'class/bin/xoops_base.php' );
webphoto_include_once( 'class/bin/permission.php' );
webphoto_include_once( 'class/bin/base.php' );
webphoto_include_once( 'class/bin/config.php' );

webphoto_include_once( 'main/include_submit_base.php' );
webphoto_include_once( 'main/include_mail_recv.php' );

webphoto_include_once( 'class/inc/ini.php' );

webphoto_include_once( 'class/lib/utility.php' );
webphoto_include_once( 'class/lib/tree_handler.php' );

webphoto_include_once( 'class/bin/retrieve.php' );

webphoto_include_once_preload();

$manage =& webphoto_bin_retrieve::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$manage->main();
