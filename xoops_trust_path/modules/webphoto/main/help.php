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

webphoto_include_once( 'main/header.php' );
webphoto_include_once( 'class/main/help.php' );

$manage =& webphoto_main_help::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );

$xoopsOption['template_main'] = WEBPHOTO_DIRNAME . '_main_help.html';
include XOOPS_ROOT_PATH . '/header.php';

$xoopsTpl->assign( $manage->main() );

include XOOPS_ROOT_PATH . '/footer.php';
exit();
