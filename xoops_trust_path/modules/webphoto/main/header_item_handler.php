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

if ( ! defined( "WEBPHOTO_DIRNAME" ) ) {
	define( "WEBPHOTO_DIRNAME", $MY_DIRNAME );
}
if ( ! defined( "WEBPHOTO_ROOT_PATH" ) ) {
	define( "WEBPHOTO_ROOT_PATH", XOOPS_ROOT_PATH . '/modules/' . WEBPHOTO_DIRNAME );
}

include_once WEBPHOTO_TRUST_PATH . '/class/d3/optional.php';
include_once WEBPHOTO_TRUST_PATH . '/include/optional.php';

webphoto_include_once( 'include/constants.php' );
webphoto_include_once( 'class/lib/error.php' );
webphoto_include_once( 'class/lib/utility.php' );
webphoto_include_once( 'class/lib/mysql_utility.php' );
webphoto_include_once( 'class/lib/handler.php' );
webphoto_include_once( 'class/lib/tree_handler.php' );
webphoto_include_once( 'class/inc/ini.php' );
webphoto_include_once( 'class/inc/xoops_config.php' );
webphoto_include_once( 'class/inc/config.php' );
webphoto_include_once( 'class/handler/base_ini.php' );
webphoto_include_once( 'class/handler/item_handler.php' );
