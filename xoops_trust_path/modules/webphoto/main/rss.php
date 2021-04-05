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

include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
include_once XOOPS_ROOT_PATH . '/class/template.php';

webphoto_include_once( 'main/header_item_handler.php' );

webphoto_include_once( 'class/xoops/base.php' );

webphoto_include_once( 'class/inc/handler.php' );
webphoto_include_once( 'class/inc/base_ini.php' );
webphoto_include_once( 'class/inc/group_permission.php' );
webphoto_include_once( 'class/inc/uri.php' );
webphoto_include_once( 'class/inc/catlist.php' );
webphoto_include_once( 'class/inc/tagcloud.php' );

webphoto_include_once( 'class/d3/language.php' );

webphoto_include_once( 'class/lib/multibyte.php' );
webphoto_include_once( 'class/lib/highlight.php' );
webphoto_include_once( 'class/lib/base.php' );
webphoto_include_once( 'class/lib/msg.php' );
webphoto_include_once( 'class/lib/post.php' );
webphoto_include_once( 'class/lib/pathinfo.php' );
webphoto_include_once( 'class/lib/search.php' );
webphoto_include_once( 'class/lib/xml.php' );
webphoto_include_once( 'class/lib/rss.php' );

webphoto_include_once( 'class/handler/file_handler.php' );
webphoto_include_once( 'class/handler/cat_handler.php' );
webphoto_include_once( 'class/handler/item_cat_handler.php' );
webphoto_include_once( 'class/handler/tag_handler.php' );
webphoto_include_once( 'class/handler/photo_tag_handler.php' );
webphoto_include_once( 'class/handler/p2t_handler.php' );

webphoto_include_once( 'class/webphoto/config.php' );
webphoto_include_once( 'class/webphoto/permission.php' );
webphoto_include_once( 'class/webphoto/base_ini.php' );
webphoto_include_once( 'class/webphoto/base_this.php' );
webphoto_include_once( 'class/webphoto/multibyte.php' );
webphoto_include_once( 'class/webphoto/kind.php' );
webphoto_include_once( 'class/webphoto/uri.php' );
webphoto_include_once( 'class/webphoto/photo_sort.php' );
webphoto_include_once( 'class/webphoto/photo_public.php' );
webphoto_include_once( 'class/webphoto/show_image.php' );
webphoto_include_once( 'class/webphoto/show_photo.php' );
webphoto_include_once( 'class/webphoto/tag_build.php' );
webphoto_include_once( 'class/webphoto/main.php' );
webphoto_include_once( 'class/webphoto/category.php' );
webphoto_include_once( 'class/webphoto/user.php' );
webphoto_include_once( 'class/webphoto/place.php' );
webphoto_include_once( 'class/webphoto/date.php' );
webphoto_include_once( 'class/webphoto/tag.php' );
webphoto_include_once( 'class/webphoto/search.php' );
webphoto_include_once( 'class/webphoto/rss.php' );
webphoto_include_once( 'class/main/rss.php' );

webphoto_include_language( 'main.php' );

$webphoto_manage =& webphoto_main_rss::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$webphoto_manage->main();
exit();
