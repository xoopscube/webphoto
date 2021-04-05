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

include_once WEBPHOTO_TRUST_PATH . '/class/d3/optional.php';
include_once WEBPHOTO_TRUST_PATH . '/include/optional.php';

webphoto_include_once( 'preload/debug.php', $MY_DIRNAME );
webphoto_include_once( 'include/constants.php', $MY_DIRNAME );
webphoto_include_once( 'include/version.php', $MY_DIRNAME );
webphoto_include_once( 'class/lib/multibyte.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/ini.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/handler.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/base_ini.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/xoops_config.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/config.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/group_permission.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/workdir.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/catlist.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/xoops_version.php', $MY_DIRNAME );
webphoto_include_language( 'modinfo.php', $MY_DIRNAME );

$webphoto_inc_xoops_version =& webphoto_inc_xoops_version::getSingleton(
	$MY_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$modversion                 = $webphoto_inc_xoops_version->build_modversion();

