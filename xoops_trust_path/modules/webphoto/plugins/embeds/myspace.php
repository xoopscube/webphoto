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
// class webphoto_embed_myspace
//
// http://vids.myspace.com/index.cfm?fuseaction=vids.individual&videoid=2096626
//
// <object width="425px" height="360px" >
// <param name="allowFullScreen" value="true"/>
// <param name="movie" value="http://mediaservices.myspace.com/services/media/embed.aspx/m=2096626,t=1,mt=video,searchID=,primarycolor=,secondarycolor="/>
// <embed src="http://mediaservices.myspace.com/services/media/embed.aspx/m=2096626,t=1,mt=video,searchID=,primarycolor=,secondarycolor=" width="425" height="360" allowFullScreen="true" type="application/x-shockwave-flash" />
// </object>
//=========================================================

class webphoto_embed_myspace extends webphoto_embed_base {
	public $_TITLE_REMOVE = "\s+ - MySpace Video";
	public $_DESCRIPTION_REMOVE = "\r|\n";

// this word is written by UTF-8
	public $_TITLE_SPLIT = "さんが投稿した動画";

	public function __construct() {
		parent::__construct( 'myspace' );
		$this->set_url( 'http://vids.myspace.com/index.cfm?fuseaction=vids.individual&videoid=' );
		$this->set_sample( '57094809' );
	}

	public function embed( $src, $width, $height, $extra = null ) {
		$str = $this->build_embed_script( $src, $width, $height );

		return $str;
	}

	public function link( $src ) {
		return $this->build_link( $src );
	}

	public function desc() {
		return $this->build_desc();
	}

// xml
	public function build_support_params() {
		return array(
			'title'       => true,
			'description' => true,
			'url'         => true,
			'thumb'       => true,
//		'duration'    => false ,
			'tags'        => true,
			'script'      => true,
		);
	}

	public function get_xml_params( $src ) {
		$url  = 'http://vids.myspace.com/index.cfm?fuseaction=oembed&format=xml&';
		$url  .= 'url=http%3a%2f%2fvids.myspace.com%2findex.cfm%3ffuseaction%3dvids.individual%26videoid%3d' . $src;
		$cont = $this->get_remote_file( $url );
		if ( empty( $cont ) ) {
			return false;
		}

		$xml = $this->get_simplexml( $cont );
		if ( ! is_object( $xml ) ) {
			return false;
		}

		$meta_url  = $this->build_link( $src );
		$meta_tags = $this->get_remote_meta_tags( $meta_url );

		$title = $this->get_xml_title( $xml );

		return array(
			'title'       => $title,
			'description' => $this->get_xml_description( $meta_tags, $title ),
			'url'         => $this->build_link( $src ),
			'thumb'       => $this->get_xml_thumb( $xml ),
			'tags'        => $this->get_xml_tags( $meta_tags ),
//		'duration'    => 0 ,
			'script'      => $this->get_xml_script( $xml ),
		);
	}

	public function get_xml_title( $xml ) {
		$str1 = $this->get_obj_property( $xml, 'title' );
		$arr  = $this->str_to_array( $str1, $this->_TITLE_SPLIT );
		if ( ! isset( $arr[1] ) ) {
			return false;
		}

		$str2 = preg_replace( '/' . $this->_TITLE_REMOVE . '/', '', $arr[1] );
		$str2 = $this->convert_from_utf8( $str2 );

		return $str2;
	}

	public function get_xml_description( $tags, $title ) {
		if ( ! isset( $tags['description'] ) ) {
			return false;
		}

		$pat = '. ' . $title . ' by ';
		//!FIX THIS
		$str1 = ereg_replace( $this->_DESCRIPTION_REMOVE, '', $tags['description'] );
		$arr  = $this->str_to_array( $str1, $pat );
		if ( ! isset( $arr[0] ) ) {
			return false;
		}

		$str2 = $arr[0];
		$str2 = $this->convert_from_utf8( $str2 );

		return $str2;
	}

	public function get_xml_thumb( $xml ) {
		$str = $this->get_obj_property( $xml, 'thumbnail_url' );
		$str = (string) $str;

		return $str;
	}

	public function get_xml_tags( $tags ) {
		if ( ! isset( $tags['keywords'] ) ) {
			return false;
		}

		$arr = $this->str_to_array( $tags['keywords'], ',' );
		$arr = $this->convert_array_from_utf8( $arr );

		return $arr;
	}

	public function get_xml_script( $xml ) {
		$str = $this->get_obj_property( $xml, 'html' );
		$str = $this->replace_width_height( $str );

		return $str;
	}

	public function build_embed_script( $src, $width, $height ) {
		$movie = 'http://mediaservices.myspace.com/services/media/embed.aspx/m=' . $src;
		$extra = 'allowFullScreen="true" wmode="transparent"';

		$str = $this->build_object_begin( $width, $height );
		$str .= $this->build_param( 'movie', $movie );
		$str .= $this->build_param( 'allowFullScreen', 'true' );
		$str .= $this->build_param( 'wmode', "transparent" );
		$str .= $this->build_embed_flash( $movie, $width, $height, $extra );
		$str .= $this->build_object_end();

		return $str;
	}

}
