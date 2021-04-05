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

include_once XOOPS_ROOT_PATH . '/class/template.php';
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

webphoto_include_once( 'main/header_item_handler.php' );
webphoto_include_once( 'main/include_submit_base.php' );

webphoto_include_once( 'include/gmap_api.php' );

webphoto_include_once( 'class/xoops/base.php' );
webphoto_include_once( 'class/xoops/user.php' );

webphoto_include_once( 'class/inc/handler.php' );
webphoto_include_once( 'class/inc/base_ini.php' );
webphoto_include_once( 'class/inc/catlist.php' );
webphoto_include_once( 'class/inc/tagcloud.php' );
webphoto_include_once( 'class/inc/timeline.php' );
webphoto_include_once( 'class/inc/group_permission.php' );
webphoto_include_once( 'class/inc/xoops_header.php' );

webphoto_include_once( 'class/webphoto/permission.php' );

webphoto_include_language( 'modinfo.php' );
webphoto_include_language( 'main.php' );

webphoto_include_once_preload_trust();
webphoto_include_once_preload();
