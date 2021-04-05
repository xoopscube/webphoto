<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @deprecated UPDATE PLUGIN / API / JSON
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

//=========================================================
// class webphoto_embed_nicovideo
//
// http://www.nicovideo.jp/watch/sm7389627
//
// <script type="text/javascript" src="http://ext.nicovideo.jp/thumb_watch/sm7389627">
//
// <iframe width="312" height="176" src="http://ext.nicovideo.jp/thumb/sm7389627" scrolling="no" style="border:solid 1px #CCC;" frameborder="0">
// <a href="http://www.nicovideo.jp/watch/sm7389627">
//=========================================================

class webphoto_embed_nicovideo extends webphoto_embed_base {

// this word is written by UTF-8
	public $_DESCRIPTION_REMOVE = '前→.*';

	public function __construct() {
		parent::__construct( 'nicovideo' );
		$this->set_url( 'http://www.nicovideo.jp/watch/' );
		$this->set_sample( 'sm7389627' );
	}

	public function embed( $src, $width, $height, $extra = null ) {
		$str = $this->build_embed_script( $src, $width, $height );

		return $str;
	}

	public function link( $src ) {
		return $this->build_link( $src );
	}

	public function width() {
		return 312;
	}

	public function height() {
		return 176;
	}

	public function desc() {
		return $this->build_desc();
	}

// xml
	public function support_params() {
		return $this->build_support_params();
	}

	public function get_xml_params( $src ) {
		$url  = 'http://www.nicovideo.jp/api/getthumbinfo/' . $src;
		$cont = $this->get_remote_file( $url );
		if ( empty( $cont ) ) {
			return false;
		}

		$xml    = $this->get_simplexml( $cont );
		$status = $this->get_obj_attributes( $xml, 'status' );
		if ( $status != 'ok' ) {
			return false;
		}

		$thumb = $this->get_obj_property( $xml, 'thumb' );
		if ( ! is_object( $thumb ) ) {
			return false;
		}

		return array(
			'title'       => $this->get_xml_title( $thumb ),
			'description' => $this->get_xml_description( $thumb ),
			'url'         => $this->get_xml_url( $thumb ),
			'thumb'       => $this->get_xml_thumb( $thumb ),
			'duration'    => $this->get_xml_duration( $thumb ),
			'tags'        => $this->get_xml_tags( $thumb ),
			'script'      => $this->build_xml_script( $src ),
		);
	}

	public function get_xml_title( $thumb ) {
		$str = $this->get_obj_property( $thumb, 'title' );
		$str = $this->convert_from_utf8( (string) $str );

		return $str;
	}

	public function get_xml_description( $thumb ) {
		$str = $this->get_obj_property( $thumb, 'description' );
		$str = preg_replace( '/' . $this->_DESCRIPTION_REMOVE . '/', '', $str );
		$str = $this->convert_from_utf8( (string) $str );

		return $str;
	}

	public function get_xml_url( $thumb ) {
		$str = $this->get_obj_property( $thumb, 'watch_url' );
		$str = (string) $str;

		return $str;
	}

	public function get_xml_thumb( $thumb ) {
		$str = $this->get_obj_property( $thumb, 'thumbnail_url' );
		$str = (string) $str;

		return $str;
	}

	public function get_xml_duration( $thumb ) {
		$str = $this->get_obj_property( $thumb, 'length' );
		$arr = explode( ':', $str );

		return ( $arr[0] * 60 ) + $arr[1];
	}

	public function get_xml_tags( $thumb ) {
		$tags = $this->get_obj_property( $thumb, 'tags' );
		$arr  = $this->get_obj_property( $tags, 'tag' );
		$arr  = $this->obj_array_to_str_array( $arr );
		$arr  = $this->convert_array_from_utf8( $arr );

		return $arr;
	}

	public function build_xml_script( $src ) {
		return $this->build_embed_script_with_repalce( $src );
	}

	public function build_embed_script( $src, $width, $height ) {
		$url = 'http://ext.nicovideo.jp/thumb_watch/' . $src . '?w=' . $width . '&h=' . $height;
		$str = $this->build_script_begin( $url );
		$str .= '<!--so.addParam("wmode", "transparent");-->';
		$str .= $this->build_script_end();

		return $str;
	}
}
