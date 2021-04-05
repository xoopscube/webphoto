<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * $MY_DIRNAME WEBPHOTO_TRUST_PATH are set by caller
 */

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

// xoops system files
include_once XOOPS_ROOT_PATH . '/class/template.php';
include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';

// webphoto files
include_once WEBPHOTO_TRUST_PATH . '/class/d3/optional.php';
include_once WEBPHOTO_TRUST_PATH . '/include/optional.php';

webphoto_include_once( 'preload/debug.php', $MY_DIRNAME );
webphoto_include_once( 'class/d3/preload.php', $MY_DIRNAME );
webphoto_include_once( 'include/constants.php', $MY_DIRNAME );
webphoto_include_once( 'include/gmap_api.php', $MY_DIRNAME );
webphoto_include_once( 'class/xoops/base.php', $MY_DIRNAME );
webphoto_include_once( 'class/lib/multibyte.php', $MY_DIRNAME );
webphoto_include_once( 'class/lib/cloud.php', $MY_DIRNAME );
webphoto_include_once( 'class/lib/utility.php', $MY_DIRNAME );
webphoto_include_once( 'class/lib/mysql_utility.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/ini.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/xoops_header.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/handler.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/xoops_config.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/config.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/base_ini.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/group_permission.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/catlist.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/tagcloud.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/public.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/auto_publish.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/uri.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/gmap_block.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/gmap_info.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/timeline.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/blocks.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/weblinks.php', $MY_DIRNAME );

webphoto_include_language( 'blocks.php', $MY_DIRNAME );

webphoto_include_once_preload_trust();
