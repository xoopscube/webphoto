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
include_once XOOPS_ROOT_PATH . '/class/snoopy.php';

define( "QRCODE_DATA_PATH", WEBPHOTO_TRUST_PATH . '/class/qrcode/qrcode_data' );

webphoto_include_once( 'main/header_item_handler.php' );
webphoto_include_once( 'include/gmap_api.php' );

webphoto_include_once( 'class/qrcode/qrcode_img.php' );
webphoto_include_once( 'class/xoops/base.php' );
webphoto_include_once( 'class/xoops/groupperm.php' );

webphoto_include_once( 'class/inc/handler.php' );
webphoto_include_once( 'class/inc/base_ini.php' );
webphoto_include_once( 'class/inc/group_permission.php' );
webphoto_include_once( 'class/inc/xoops_header.php' );
webphoto_include_once( 'class/inc/catlist.php' );
webphoto_include_once( 'class/inc/tagcloud.php' );
webphoto_include_once( 'class/inc/auto_publish.php' );
webphoto_include_once( 'class/inc/uri.php' );
webphoto_include_once( 'class/inc/gmap_info.php' );
webphoto_include_once( 'class/inc/timeline.php' );

webphoto_include_once( 'class/d3/language.php' );
webphoto_include_once( 'class/d3/notification_select.php' );
webphoto_include_once( 'class/d3/comment_view.php' );
webphoto_include_once( 'class/d3/preload.php' );

webphoto_include_once( 'class/lib/msg.php' );
webphoto_include_once( 'class/lib/post.php' );
webphoto_include_once( 'class/lib/pathinfo.php' );
webphoto_include_once( 'class/lib/highlight.php' );
webphoto_include_once( 'class/lib/pagenavi.php' );
webphoto_include_once( 'class/lib/remote_file.php' );
webphoto_include_once( 'class/lib/base.php' );
webphoto_include_once( 'class/lib/cloud.php' );
webphoto_include_once( 'class/lib/multibyte.php' );
webphoto_include_once( 'class/lib/xml.php' );
webphoto_include_once( 'class/lib/plugin.php' );
webphoto_include_once( 'class/lib/gtickets.php' );
webphoto_include_once( 'class/lib/search.php' );
webphoto_include_once( 'class/lib/mysql_utility.php' );

webphoto_include_once( 'class/handler/file_handler.php' );
webphoto_include_once( 'class/handler/cat_handler.php' );
webphoto_include_once( 'class/handler/tag_handler.php' );
webphoto_include_once( 'class/handler/p2t_handler.php' );
webphoto_include_once( 'class/handler/photo_tag_handler.php' );
webphoto_include_once( 'class/handler/gicon_handler.php' );
webphoto_include_once( 'class/handler/user_handler.php' );
webphoto_include_once( 'class/handler/player_handler.php' );
webphoto_include_once( 'class/handler/flashvar_handler.php' );
webphoto_include_once( 'class/handler/vote_handler.php' );
webphoto_include_once( 'class/handler/item_cat_handler.php' );

webphoto_include_once( 'class/webphoto/config.php' );
webphoto_include_once( 'class/webphoto/permission.php' );
webphoto_include_once( 'class/webphoto/uri.php' );
webphoto_include_once( 'class/webphoto/uri_parse.php' );
webphoto_include_once( 'class/webphoto/kind.php' );
webphoto_include_once( 'class/webphoto/multibyte.php' );
webphoto_include_once( 'class/webphoto/base_ini.php' );
webphoto_include_once( 'class/webphoto/base_this.php' );
webphoto_include_once( 'class/webphoto/xoops_header.php' );
webphoto_include_once( 'class/webphoto/tag_build.php' );
webphoto_include_once( 'class/webphoto/gmap.php' );
webphoto_include_once( 'class/webphoto/photo_sort.php' );
webphoto_include_once( 'class/webphoto/photo_public.php' );
webphoto_include_once( 'class/webphoto/playlist.php' );
webphoto_include_once( 'class/webphoto/flash_player.php' );
webphoto_include_once( 'class/webphoto/embed_base.php' );
webphoto_include_once( 'class/webphoto/embed.php' );
webphoto_include_once( 'class/webphoto/rate_check.php' );
webphoto_include_once( 'class/webphoto/page.php' );
webphoto_include_once( 'class/webphoto/item_public.php' );
webphoto_include_once( 'class/webphoto/photo_navi.php' );
webphoto_include_once( 'class/webphoto/show_image.php' );
webphoto_include_once( 'class/webphoto/show_photo.php' );
webphoto_include_once( 'class/webphoto/timeline_init.php' );
webphoto_include_once( 'class/webphoto/timeline.php' );
webphoto_include_once( 'class/webphoto/qr.php' );
webphoto_include_once( 'class/webphoto/pagenavi.php' );
webphoto_include_once( 'class/webphoto/notification_select.php' );
webphoto_include_once( 'class/webphoto/main.php' );
webphoto_include_once( 'class/webphoto/category.php' );
webphoto_include_once( 'class/webphoto/date.php' );
webphoto_include_once( 'class/webphoto/photo.php' );
webphoto_include_once( 'class/webphoto/place.php' );
webphoto_include_once( 'class/webphoto/search.php' );
webphoto_include_once( 'class/webphoto/tag.php' );
webphoto_include_once( 'class/webphoto/user.php' );
webphoto_include_once( 'class/webphoto/factory.php' );

webphoto_include_language( 'modinfo.php' );
webphoto_include_language( 'main.php' );

webphoto_include_once_preload_trust();
webphoto_include_once_preload();
