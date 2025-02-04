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
// class webphoto_embed_youtube
//
// http://www.youtube.com/watch?v=xFnwzdKNtpI
//
// <object width="425" height="373">
// <param name="movie" value="http://www.youtube.com/v/xFnwzdKNtpI&rel=0&border=1"></param>
// <param name="wmode" value="transparent"></param>
// <embed src="http://www.youtube.com/v/lGVwm326rnk&rel=0&border=1" type="application/x-shockwave-flash" wmode="transparent" width="425" height="373"></embed>
// </object>
//=========================================================
class webphoto_embed_youtube extends webphoto_embed_base {
	public $_URL_REMOVE = '&feature=.*';

	public function __construct() {
		parent::__construct( 'youtube' );
		$this->set_url( 'https://www.youtube.com/watch?v=' );
		$this->set_sample( 'xFnwzdKNtpI' );
	}

	public function embed( $src, $width, $height, $extra = null ) {
		$str = $this->build_embed_script( $src, $width, $height );

		return $str;
	}

	public function link( $src ) {
		return $this->build_link( $src );
	}

	public function thumb( $src ) {
		$str = 'https://img.youtube.com/vi/' . $src . '/mqdefault.jpg';

		return $str;
	}

	public function width() {
		return 640;
	}

	public function height() {
		return 360;
	}

	public function desc() {
		return $this->build_desc();
	}


	// xml
	public function support_params() {
		return $this->build_support_params();
	}

	public function get_xml_params( $src ) {
		if ( 0 === strpos( $src, "-" ) ) {
			$d = substr( $src, 1 );
		} else {
			$id = $src;
		}

		$url  = 'https://gdata.youtube.com/feeds/api/videos?vq=' . $id;
		$cont = $this->get_remote_file( $url );
		if ( empty( $cont ) ) {
			return false;
		}

		$xml   = $this->get_simplexml( $cont );
		$total = $this->get_xpath( $xml, '//openSearch:totalResults' );
		if ( $total != 1 ) {
			return false;
		}

		$entry = $this->get_obj_property( $xml, 'entry' );
		if ( ! is_object( $entry ) ) {
			return false;
		}

		return array(
			'title'       => $this->get_xml_title( $entry ),
			'description' => $this->get_xml_description( $entry ),
			'url'         => $this->get_xml_url( $entry ),
			'thumb'       => $this->get_xml_thumb( $entry ),
			'duration'    => $this->get_xml_duration( $entry ),
			'tags'        => $this->get_xml_tags( $entry ),
			'script'      => $this->build_xml_script( $src ),
		);
	}

	public function get_xml_title( $entry ) {
		$str = $this->get_xpath( $entry, '//media:title' );
		$str = $this->convert_from_utf8( (string) $str );

		return $str;
	}

	public function get_xml_description( $entry ) {
		$str = $this->get_xpath( $entry, '//media:description' );
		$str = $this->convert_from_utf8( (string) $str );

		return $str;
	}

	public function get_xml_url( $entry ) {
		$xpath = $this->get_xpath( $entry, '//media:player' );
		$str   = $this->get_obj_attributes( $xpath, 'url' );
		$str   = preg_replace( '/' . $this->_URL_REMOVE . '/', '', $str );

		return $str;
	}

	public function get_xml_thumb( $entry ) {
		$xpath = $this->get_xpath( $entry, '//media:thumbnail' );
		$str   = $this->get_obj_attributes( $xpath, 'url' );
		$str   = (string) $str;

		return $str;
	}

	public function get_xml_duration( $entry ) {
		$xpath = $this->get_xpath( $entry, '//yt:duration' );
		$str   = $this->get_obj_attributes( $xpath, 'seconds' );
		$str   = (string) $str;

		return $str;
	}

	public function get_xml_tags( $entry ) {
		$str = $this->get_xpath( $entry, '//media:keywords' );
		$arr = $this->str_to_array( $str, ',' );
		$arr = $this->convert_array_from_utf8( $arr );

		return $arr;
	}

	public function build_xml_script( $src ) {
		$str = $this->build_embed_script_with_repalce( $src );

		return $str;
	}

	public function build_embed_script( $src, $width, $height ) {
		$movie = 'https://www.youtube.com/v/' . $src . '&amp;rel=0&amp;border=0';
		$wmode = 'transparent';
		$extra = 'wmode="' . $wmode . '"';

		$str = $this->build_object_begin( $width, $height );
		$str .= $this->build_param( 'movie', $movie );
		$str .= $this->build_param( 'wmode', $wmode );
		$str .= $this->build_embed_flash( $movie, $width, $height, $extra );
		$str .= $this->build_object_end();

		return $str;
	}

}
