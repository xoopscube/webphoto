<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

include_once XOOPS_ROOT_PATH . '/class/template.php';
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

webphoto_include_once( 'main/include_submit_base.php' );
webphoto_include_once( 'main/include_submit.php' );

webphoto_include_once( 'class/xoops/base.php' );
webphoto_include_once( 'class/xoops/user.php' );

webphoto_include_once( 'class/inc/handler.php' );
webphoto_include_once( 'class/inc/base_ini.php' );
webphoto_include_once( 'class/inc/catlist.php' );
webphoto_include_once( 'class/inc/tagcloud.php' );
webphoto_include_once( 'class/inc/timeline.php' );
webphoto_include_once( 'class/inc/group_permission.php' );
webphoto_include_once( 'class/inc/xoops_header.php' );
webphoto_include_once( 'class/inc/ini.php' );
webphoto_include_once( 'class/inc/gmap_info.php' );
webphoto_include_once( 'class/inc/admin_menu.php' );

webphoto_include_once( 'class/lib/pagenavi.php' );
webphoto_include_once( 'class/lib/admin_menu.php' );

webphoto_include_once( 'class/webphoto/permission.php' );
webphoto_include_once( 'class/webphoto/photo_sort.php' );
webphoto_include_once( 'class/webphoto/flash_log.php' );
webphoto_include_once( 'class/webphoto/flash_player.php' );

webphoto_include_once( 'class/edit/action.php' );

webphoto_include_language( 'modinfo.php' );
webphoto_include_language( 'main.php' );
webphoto_include_language( 'admin.php' );

webphoto_include_once_preload_trust();
webphoto_include_once_preload();
