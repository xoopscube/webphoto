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

$webphoto_item_handler
	=& webphoto_item_handler::getInstance( WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );

$com_replytitle = $webphoto_item_handler->get_replytitle();
if ( $com_replytitle ) {

// $com_replytitle is required
	include XOOPS_ROOT_PATH . '/include/comment_new.php';

} else {
	echo "No photo matches your request <br>\n";
}
exit();
