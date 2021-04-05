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

include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
include_once XOOPS_ROOT_PATH . '/class/template.php';

include_once WEBPHOTO_TRUST_PATH . '/main/header_inc_handler.php';

webphoto_include_once( 'class/lib/multibyte.php' );
webphoto_include_once( 'class/xoops/base.php' );
webphoto_include_once( 'class/inc/group_permission.php' );
webphoto_include_once( 'class/inc/catlist.php' );
webphoto_include_once( 'class/inc/public.php' );
webphoto_include_once( 'class/main/imagemanager.php' );

webphoto_include_language( 'main.php' );

$manage =& webphoto_main_imagemanager::getSingleton( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );

// exit if error
$manage->check();

list( $param, $photos ) = $manage->main();

$xoopsTpl = new XoopsTpl();
$xoopsTpl->assign( $param );

if ( is_array( $photos ) && count( $photos ) ) {
	foreach ( $photos as $photo ) {
		$xoopsTpl->append( 'photos', $photo );
	}
}

$xoopsTpl->display( $manage->get_template() );
exit();
