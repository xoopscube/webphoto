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
// class webphoto_embed_dailymotion
//
// http://www.dailymotion.com/cluster/tech/video/x3y6yk_no-more-keyboardsmicrosoft_tech
//
// <object width="420" height="253">
// <param name="movie" value="http://www.dailymotion.com/swf/x3y6yk"></param>
// <param name="allowFullScreen" value="true"></param>
// <param name="allowScriptAccess" value="always"></param>
// <embed src="http://www.dailymotion.com/swf/x3y6yk" type="application/x-shockwave-flash" width="420" height="253" allowFullScreen="true" allowScriptAccess="always"></embed>
// </object>
//=========================================================
class webphoto_embed_dailymotion extends webphoto_embed_base {

	public function __construct() {
		parent::__construct( 'dailymotion' );
		$this->set_url( 'http://www.dailymotion.com/cluster/tech/video/' );
	}

	public function embed( $src, $width, $height, $extra = null ) {
		$movie = 'http://www.dailymotion.com/swf/' . $src;
		$extra = 'allowFullScreen="true" allowScriptAccess="always"';

		$str = $this->build_object_begin( $width, $height );
		$str .= $this->build_param( 'movie', $movie );
		$str .= $this->build_param( 'allowFullScreen', 'true' );
		$str .= $this->build_param( 'allowScriptAccess', 'always' );
		$str .= $this->build_embed_flash( $movie, $width, $height, $extra );
		$str .= $this->build_object_end();

		return $str;
	}

	public function link( $src ) {
		return $this->build_link( $src );
	}

	public function desc() {
		return $this->build_desc_span( $this->_url_head, 'x3y6yk', '_no-more-keyboardsmicrosoft_tech' );
	}

// xml
	public function support_params() {
		return $this->build_support_params();
	}

	public function get_xml_params( $src ) {
		//!FIX test
		//$url  = 'http://www.dailymotion.com/rss/video/'.$src;
		$url  = 'https://www.dailymotion.com/video/' . $src;
		$cont = $this->get_remote_file( $url );
		if ( empty( $cont ) ) {
			return false;
		}

		$xml     = $this->get_simplexml( $cont );
		$channel = $this->get_obj_property( $xml, 'channel' );
		$item    = $this->get_obj_property( $channel, 'item' );
		if ( ! is_object( $item ) ) {
			return false;
		}

		return array(
			'title'       => $this->get_xml_title( $item ),
			'description' => $this->get_xml_description( $item ),
			'url'         => $this->get_xml_url( $item ),
			'thumb'       => $this->get_xml_thumb( $item ),
			'duration'    => $this->get_xml_duration( $item ),
			'tags'        => $this->get_xml_tags( $item ),
			'script'      => $this->get_xml_script( $item ),
		);
	}

	public function get_xml_title( $item ) {
		$str = $this->get_obj_property( $item, 'title' );
		$str = $this->convert_from_utf8( (string) $str );

		return $str;
	}

	public function get_xml_description( $item ) {
		$xpath = $this->get_xpath( $item, '//itunes:summary' );
		$str   = (string) $xpath;
		$str   = $this->convert_from_utf8( $str );

		return $str;
	}

	public function get_xml_url( $item ) {
		$str = $this->get_obj_property( $item, 'link' );
		$str = (string) $str;

		return $str;
	}

	public function get_xml_thumb( $item ) {
		$xpath = $this->get_xpath( $item, '//media:thumbnail_medium_url' );
		$attr  = $this->get_obj_method( $xpath, 'attributes' );
		$str   = $this->get_obj_property( $attr, 'url' );
		$str   = (string) $str;

		return $str;
	}

	public function get_xml_duration( $item ) {
		$xpath = $this->get_xpath( $item, '//media:content' );
		$attr  = $this->get_obj_method( $xpath, 'attributes' );
		$str   = $this->get_obj_property( $attr, 'duration' );
		$str   = (string) $str;

		return $str;
	}

	public function get_xml_tags( $item ) {
		$str = $this->get_xpath( $item, '//itunes:keywords' );
		$arr = $this->str_to_array( $str, ',' );
		$arr = $this->convert_array_from_utf8( $arr );

		return $arr;
	}

	public function get_xml_script( $item ) {
		$str = $this->get_xpath( $item, '//media:player' );
		$str = $this->replace_width_height( $str );

		return $str;
	}
}
