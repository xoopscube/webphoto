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
// class webphoto_embed_ustream
//
// http://www.ustream.tv/recorded/6501293
//
// <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="320" height="260" id="utv605411" name="utv_n_329299">
// <param name="flashvars" value="autoplay=false" />
// <param name="allowfullscreen" value="true" />
// <param name="allowscriptaccess" value="always" />
// <param name="src" value="http://www.ustream.tv/flash/video/6501293" />
// <embed flashvars="autoplay=false" width="320" height="260" allowfullscreen="true" allowscriptaccess="always" id="utv605411" name="utv_n_329299" src="http://www.ustream.tv/flash/video/6501293" type="application/x-shockwave-flash" />
// </object>

//=========================================================
class webphoto_embed_ustream extends webphoto_embed_base {

	public function __construct() {
		parent::__construct( 'ustream' );
		$this->set_url( 'http://www.ustream.tv/recorded/' );
		$this->set_sample( '6996774' );
	}

	public function embed( $src, $width, $height, $extra = null ) {
		$movie = 'http://www.ustream.tv/flash/video/' . $src;

		$flashvars         = 'autoplay=false';
		$allowfullscreen   = 'true';
		$allowscriptaccess = 'always';

		$obj_extra = 'classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ';

		$embed_extra = 'flashvars="' . $flashvars . '" ';
		$embed_extra .= 'allowfullscreen="' . $allowfullscreen . '" ';
		$embed_extra .= 'allowscriptaccess="' . $allowscriptaccess . '" ';

		$str = $this->build_object_begin( $width, $height, $obj_extra );
		$str .= $this->build_param( 'flashvars', $flashvars );
		$str .= $this->build_param( 'allowfullscreen', $allowfullscreen );
		$str .= $this->build_param( 'allowscriptaccess', $allowscriptaccess );
		$str .= $this->build_embed_flash( $movie, $width, $height, $embed_extra );
		$str .= $this->build_object_end();

		return $str;
	}

	public function link( $src ) {
		return $this->build_link( $src );
	}

	public function width() {
		return 320;
	}

	public function height() {
		return 260;
	}

	public function desc() {
		return $this->build_desc();
	}

// xml
	public function support_params() {
		return $this->build_support_params();
	}

	public function get_xml_params( $src ) {
		$url  = 'http://api.ustream.tv/xml/video/' . $src . '/getinfo';
		$cont = $this->get_remote_file( $url );
		if ( empty( $cont ) ) {
			return false;
		}

		$xml   = $this->get_simplexml( $cont );
		$error = trim( $this->get_obj_property( $xml, 'error' ) );
		if ( $error ) {
			return false;
		}

		$results = $this->get_obj_property( $xml, 'results' );
		if ( ! is_object( $results ) ) {
			return false;
		}

		return array(
			'title'       => $this->get_xml_title( $results ),
			'description' => $this->get_xml_description( $results ),
			'url'         => $this->get_xml_url( $results ),
			'thumb'       => $this->get_xml_thumb( $results ),
			'duration'    => $this->get_xml_duration( $results ),
			'tags'        => $this->get_xml_tags( $results ),
			'script'      => $this->get_xml_script( $results ),

		);
	}

	public function get_xml_title( $results ) {
		$str = $this->get_obj_property( $results, 'title' );
		$str = $this->convert_from_utf8( (string) $str );

		return $str;
	}

	public function get_xml_description( $results ) {
		$str = $this->get_obj_property( $results, 'description' );
		$str = $this->convert_from_utf8( (string) $str );

		return $str;
	}

	public function get_xml_url( $results ) {
		$str = $this->get_obj_property( $results, 'url' );
		$str = (string) $str;

		return $str;
	}

	public function get_xml_thumb( $results ) {
		$url = $this->get_obj_property( $results, 'imageUrl' );
		$str = $this->get_obj_property( $url, 'small' );
		$str = (string) $str;

		return $str;
	}

	public function get_xml_duration( $results ) {
		$str = $this->get_obj_property( $results, 'lengthInSecond' );
		$str = floor( $str );

		return $str;
	}

	public function get_xml_tags( $results ) {
		$tags = $this->get_obj_property( $results, 'tags' );
		$arr  = $this->get_obj_property( $tags, 'array' );
		$arr  = $this->obj_array_to_str_array( $arr );
		$arr  = $this->convert_array_from_utf8( $arr );

		return $arr;
	}

	public function get_xml_script( $results ) {
		$str = $this->get_obj_property( $results, 'embedTag' );
		$str = $this->replace_width_height( $str );

		return $str;
	}

}
