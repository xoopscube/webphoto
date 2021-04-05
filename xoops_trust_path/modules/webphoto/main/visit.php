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

webphoto_include_once( 'main/header_item_handler.php' );

webphoto_include_once( 'class/xoops/base.php' );
webphoto_include_once( 'class/d3/language.php' );
webphoto_include_once( 'class/lib/post.php' );
webphoto_include_once( 'class/lib/base.php' );
webphoto_include_once( 'class/lib/msg.php' );
webphoto_include_once( 'class/handler/cat_handler.php' );
webphoto_include_once( 'class/webphoto/base_ini.php' );
webphoto_include_once( 'class/webphoto/config.php' );
webphoto_include_once( 'class/webphoto/item_public.php' );
webphoto_include_once( 'class/main/visit.php' );

$webphoto_manage =& webphoto_main_visit::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$webphoto_manage->main();
exit();
