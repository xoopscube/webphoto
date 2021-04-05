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


class webphoto_inc_weblinks extends webphoto_inc_public {

	public function __construct() {
		parent::__construct();
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_inc_weblinks();
		}

		return $instance;
	}


// public

	public function albums( $opts ) {
		$dirname = isset( $opts['dirname'] ) ? $opts['dirname'] : '';

		if ( empty( $dirname ) ) {
			return null;
		}

		$inc_class =& webphoto_inc_catlist::getSingleton( $dirname, WEBPHOTO_TRUST_DIRNAME );

		return $inc_class->get_cat_titles();
	}

	public function photos( $opts ) {
		$dirname     = isset( $opts['dirname'] ) ? $opts['dirname'] : '';
		$width       = isset( $opts['width'] ) ? (int) $opts['width'] : 140;
		$album_limit = isset( $opts['album_limit'] ) ? (int) $opts['album_limit'] : 1;
		$album_id    = isset( $opts['album_id'] ) ? (int) $opts['album_id'] : 0;
		$mode_sub    = isset( $opts['mode_sub'] ) ? (int) $opts['mode_sub'] : 1;
		$cycle       = isset( $opts['cycle'] ) ? (int) $opts['cycle'] : 60;
		$cols        = isset( $opts['cols'] ) ? (int) $opts['cols'] : 3;
		$title_max   = isset( $opts['title_max'] ) ? (int) $opts['title_max'] : 20;

		if ( empty( $dirname ) ) {
			return null;
		}

		$cache_time       = 0;
		$disable_renderer = true;

		$options = array(
			0                  => $dirname,        // dirname
			1                  => $album_limit,    // photos_num
			2                  => $album_id,        // cat_limitation
			3                  => $mode_sub,        // cat_limit_recursive
			4                  => $title_max,    // title_max_length
			5                  => $cols,            // cols
			6                  => $cache_time,    // cache_time
			'disable_renderer' => $disable_renderer,
		);

		$uri_class =& webphoto_inc_uri::getSingleton( $dirname );

// BUG: Fatal error: Call to undefined function: getinstance()
		$inc_class =& webphoto_inc_blocks::getSingleton( $dirname, WEBPHOTO_TRUST_DIRNAME );

		$block = $inc_class->rphoto_show( $options );

		if ( ! is_array( $block ) || ! count( $block ) ) {
			return null;
		}

		if ( ! is_array( $block['photo'] ) || ! count( $block['photo'] ) ) {
			return null;
		}

		$href_base = XOOPS_URL . '/modules/' . $dirname . '/';

		$ret = array();
		foreach ( $block['photo'] as $photo ) {
			$href = $href_base;
			$href .= $uri_class->build_relatevie_uri_mode_param( 'photo', $photo['item_id'] );

			$cat_href = $href_base;
			$cat_href .= $uri_class->build_relatevie_uri_mode_param( 'category', $photo['item_cat_id'] );

			if ( $photo['img_thumb_width'] && $photo['img_thumb_height'] ) {
				$img_attribs = 'width="' . $photo['img_thumb_width'] . '" height="' . $photo['img_thumb_height'] . '"';
			} else {
				$img_attribs = 'width="' . $block['cfg_thumb_width'] . '"';;
			}

			$ret[] = array(
				'href'        => $href,
				'cat_href'    => $cat_href,
				'img_attribs' => $img_attribs,
				'title'       => $photo['title_s'],
				'cat_title'   => $photo['cat_title_s'],
				'img_src'     => $photo['img_thumb_src_s'],
			);
		}

		return $ret;
	}
}
