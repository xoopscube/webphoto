<?php
/**
 * WebPhoto module for XCL
 * @package XCL
 * @subpackage Webphoto
 * @version 2.3
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief $MY_DIRNAME WEBPHOTO_TRUST_PATH are set by calle
 */

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) die( 'not permit' ) ;

// webphoto
if( !defined("WEBPHOTO_DIRNAME") ) {
	  define("WEBPHOTO_DIRNAME", $MY_DIRNAME );
}
if( !defined("WEBPHOTO_ROOT_PATH") ) {
	  define("WEBPHOTO_ROOT_PATH", XOOPS_ROOT_PATH.'/modules/'.WEBPHOTO_DIRNAME );
}

include_once WEBPHOTO_TRUST_PATH.'/class/d3/optional.php';
include_once WEBPHOTO_TRUST_PATH.'/include/optional.php';
webphoto_include_once( 'preload/debug.php' );

// fork each pages
$FCT_UNUSE = array('category','date','myphoto','place','search','tag','user');
$fct = webphoto_fct() ;
if ( in_array( $fct, $FCT_UNUSE ) ) {
	$fct = '';
}

$WEBPHOTO_FCT     = $fct;
$file_trust_fct   = WEBPHOTO_TRUST_PATH .'/main/'. $WEBPHOTO_FCT .'.php' ;
$file_root_fct    = WEBPHOTO_ROOT_PATH  .'/main/'. $WEBPHOTO_FCT .'.php' ;
$file_trust_index = WEBPHOTO_TRUST_PATH .'/main/index.php' ;
$file_root_index  = WEBPHOTO_ROOT_PATH  .'/main/index.php' ;

if ( file_exists( $file_root_fct ) ) {
	webphoto_debug_msg( $file_root_fct );
	include_once $file_root_fct;

} elseif ( file_exists( $file_trust_fct ) ) {
	webphoto_debug_msg( $file_trust_fct );
	include_once $file_trust_fct;

} elseif ( file_exists( $file_root_index ) ) {
	webphoto_debug_msg( $file_root_index );
	include_once $file_root_index;

} elseif ( file_exists( $file_trust_index ) ) {
	webphoto_debug_msg( $file_trust_index );
	include_once $file_trust_index;

} else {
	die( 'wrong request' ) ;
}
