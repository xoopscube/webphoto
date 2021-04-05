<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief optional functions - DO NOT replace this file
 * $MY_DIRNAME WEBPHOTO_TRUST_PATH are set by caller
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

function webphoto_fct() {
	$page_array = array(
		'photo_id' => 'photo',
		'cat_id'   => 'category',
	);

	$d3_class =& webphoto_d3_optional::getInstance();

	return $d3_class->get_fct( $page_array );
}

function webphoto_include_once_trust( $file, $debug = true ) {
	$d3_class =& webphoto_d3_optional::getInstance();
	$d3_class->init_trust( WEBPHOTO_TRUST_DIRNAME );

	return $d3_class->include_once_trust_file( $file, $debug );
}

function webphoto_include_once( $file, $dirname = null, $debug = true ) {
	$d3_class =& webphoto_d3_optional::getInstance();
	$d3_class->init( webphoto_get_dirname( $dirname ), WEBPHOTO_TRUST_DIRNAME );

	return $d3_class->include_once_file( $file, $debug );
}

function webphoto_include_once_language( $file, $dirname = null, $language = null ) {
	$d3_class =& webphoto_d3_optional::getInstance();
	$d3_class->init( webphoto_get_dirname( $dirname ), WEBPHOTO_TRUST_DIRNAME );
	$d3_class->set_language( webphoto_get_language( $language ) );

	return $d3_class->include_once_language( $file );
}

function webphoto_include_language( $file, $dirname = null, $language = null ) {
	$d3_class =& webphoto_d3_optional::getInstance();
	$d3_class->init( webphoto_get_dirname( $dirname ), WEBPHOTO_TRUST_DIRNAME );
	$d3_class->set_language( webphoto_get_language( $language ) );

	return $d3_class->include_language( $file );
}

function webphoto_debug_msg( $file, $dirname = null ) {
	$d3_class =& webphoto_d3_optional::getInstance();
	$d3_class->init( webphoto_get_dirname( $dirname ), WEBPHOTO_TRUST_DIRNAME );

	return $d3_class->debug_msg_include_file( $file );
}

function webphoto_include_once_preload( $dirname = null ) {
	$preload_class =& webphoto_d3_preload::getInstance();
	$preload_class->init( webphoto_get_dirname( $dirname ), WEBPHOTO_TRUST_DIRNAME );

	return $preload_class->include_once_preload_files();
}

function webphoto_include_once_preload_trust() {
	$preload_class =& webphoto_d3_preload::getInstance();
	$preload_class->init_trust( WEBPHOTO_TRUST_DIRNAME );

	return $preload_class->include_once_preload_trust_files();
}

function webphoto_get_dirname( $dirname ) {
	if ( ! defined( "WEBPHOTO_TRUST_DIRNAME" ) ) {
		die( 'not permit' );
	}

	if ( empty( $dirname ) ) {
		if ( defined( "WEBPHOTO_DIRNAME" ) ) {
			$dirname = WEBPHOTO_DIRNAME;
		} else {
			die( 'not permit' );
		}
	}

	return $dirname;
}

function webphoto_get_language( $language = null ) {
	if ( $language ) {
		return $language;
	}

	global $xoopsConfig;

	return $xoopsConfig['language'];
}
