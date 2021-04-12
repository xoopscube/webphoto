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

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

// topnews
function b_webphoto_topnews_show( $options ) {
	$inc_class =& webphoto_inc_blocks::getSingleton(
		b_webphoto_dirname( $options ), WEBPHOTO_TRUST_DIRNAME );

	return $inc_class->topnews_show( $options );
}

function b_webphoto_topnews_p_show( $options ) {
	$inc_class =& webphoto_inc_blocks::getSingleton(
		b_webphoto_dirname( $options ), WEBPHOTO_TRUST_DIRNAME );

	return $inc_class->topnews_p_show( $options );
}

function b_webphoto_topnews_edit( $options ) {
	$inc_class =& webphoto_inc_blocks::getSingleton(
		b_webphoto_dirname( $options ), WEBPHOTO_TRUST_DIRNAME );

	return $inc_class->topnews_edit( $options );
}

function b_webphoto_topnews_p_edit( $options ) {
	$inc_class =& webphoto_inc_blocks::getSingleton(
		b_webphoto_dirname( $options ), WEBPHOTO_TRUST_DIRNAME );

	return $inc_class->topnews_p_edit( $options );
}

function b_webphoto_tophits_show( $options ) {
	$inc_class =& webphoto_inc_blocks::getSingleton(
		b_webphoto_dirname( $options ), WEBPHOTO_TRUST_DIRNAME );

	return $inc_class->tophits_show( $options );
}

function b_webphoto_tophits_p_show( $options ) {
	$inc_class =& webphoto_inc_blocks::getSingleton(
		b_webphoto_dirname( $options ), WEBPHOTO_TRUST_DIRNAME );

	return $inc_class->tophits_p_show( $options );
}

function b_webphoto_tophits_edit( $options ) {
	$inc_class =& webphoto_inc_blocks::getSingleton(
		b_webphoto_dirname( $options ), WEBPHOTO_TRUST_DIRNAME );

	return $inc_class->tophits_edit( $options );
}

function b_webphoto_tophits_p_edit( $options ) {
	$inc_class =& webphoto_inc_blocks::getSingleton(
		b_webphoto_dirname( $options ), WEBPHOTO_TRUST_DIRNAME );

	return $inc_class->tophits_p_edit( $options );
}

function b_webphoto_rphoto_show( $options ) {
	$inc_class =& webphoto_inc_blocks::getSingleton(
		b_webphoto_dirname( $options ), WEBPHOTO_TRUST_DIRNAME );

	return $inc_class->rphoto_show( $options );
}

function b_webphoto_rphoto_edit( $options ) {
	$inc_class =& webphoto_inc_blocks::getSingleton(
		b_webphoto_dirname( $options ), WEBPHOTO_TRUST_DIRNAME );

	return $inc_class->rphoto_edit( $options );
}

function b_webphoto_catlist_show( $options ) {
	$inc_class =& webphoto_inc_blocks::getSingleton(
		b_webphoto_dirname( $options ), WEBPHOTO_TRUST_DIRNAME );

	return $inc_class->catlist_show( $options );
}

function b_webphoto_catlist_edit( $options ) {
	$inc_class =& webphoto_inc_blocks::getSingleton(
		b_webphoto_dirname( $options ), WEBPHOTO_TRUST_DIRNAME );

	return $inc_class->catlist_edit( $options );
}

function b_webphoto_tagcloud_show( $options ) {
	$inc_class =& webphoto_inc_blocks::getSingleton(
		b_webphoto_dirname( $options ), WEBPHOTO_TRUST_DIRNAME );

	return $inc_class->tagcloud_show( $options );
}

function b_webphoto_tagcloud_edit( $options ) {
	$inc_class =& webphoto_inc_blocks::getSingleton(
		b_webphoto_dirname( $options ), WEBPHOTO_TRUST_DIRNAME );

	return $inc_class->tagcloud_edit( $options );
}

function b_webphoto_timeline_show( $options ) {
	$inc_class =& webphoto_inc_blocks::getSingleton(
		b_webphoto_dirname( $options ), WEBPHOTO_TRUST_DIRNAME );

	return $inc_class->timeline_show( $options );
}

function b_webphoto_timeline_edit( $options ) {
	$inc_class =& webphoto_inc_blocks::getSingleton(
		b_webphoto_dirname( $options ), WEBPHOTO_TRUST_DIRNAME );

	return $inc_class->timeline_edit( $options );
}

function b_webphoto_dirname( $options ) {
	return $options[0] ?? 'webphoto';
}
