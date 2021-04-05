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
 * class webphoto_embed_ameba
 * http://vision.ameba.jp/watch.do?movie=1726761;
 * <script language="JavaScript" type="text/JavaScript"
 * src="http://visionmovie.ameba.jp/mcj.php?id=XXX&width=320&height=240&skin=gray"></script>
 * <meta name="keywords" content="ピグ,裏技,透明人間,動画" />
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_embed_ameba extends webphoto_embed_base {

// this word is written by UTF-8
	public $_TAGS_REMOVE = array( '動画' );

	public function __construct() {
		parent::__construct( 'ameba' );
		//$this->webphoto_embed_base( 'ameba' );
		$this->set_url( 'http://vision.ameba.jp/watch.do?movie=' );
		$this->set_sample( '1726761' );
	}

	public function embed( $src, $width, $height, $extra = null ) {
		$item = $this->get_xml_item( $src );
		if ( ! is_object( $item ) ) {
			return false;
		}

		$url = $this->get_xml_script_src( $item );
		if ( empty( $url ) ) {
			return false;
		}

		return $this->build_embed_script( $url, $width, $height );
	}

	public function link( $src ) {
		return $this->build_link( $src );
	}

	public function width() {
		return 320;
	}

	public function height() {
		return 240;
	}

	public function desc() {
		return $this->build_desc();
	}

// xml
	public function support_params() {
		return $this->build_support_params();
	}

	public function get_xml_params( $src ) {
		$item = $this->get_xml_item( $src );
		if ( ! is_object( $item ) ) {
			return false;
		}

		return array(
			'title'       => $this->get_xml_title( $item ),
			'description' => $this->get_xml_description( $item ),
			'url'         => $this->get_xml_url( $item ),
			'thumb'       => $this->get_xml_thumb( $item ),
			'duration'    => $this->get_xml_duration( $item ),
			'tags'        => $this->get_xml_tags( $src ),
			'script'      => $this->get_xml_script( $item ),
		);
	}

	public function get_xml_item( $src ) {
		$url  = 'http://vision.ameba.jp/api/get/detailMovie.do?movie=' . $src;
		$cont = $this->get_remote_file( $url );
		if ( empty( $cont ) ) {
			return false;
		}

		$xml   = $this->get_simplexml( $cont );
		$error = trim( $this->get_obj_property( $xml, 'error' ) );
		if ( $error ) {
			return false;
		}

		$item = $this->get_obj_property( $xml, 'item' );

		return $item;
	}

	public function get_xml_title( $item ) {
		$str = $this->get_obj_property( $item, 'title' );
		$str = $this->convert_from_utf8( (string) $str );

		return $str;
	}

	public function get_xml_description( $item ) {
		$str = $this->get_obj_property( $item, 'description' );
		$str = $this->convert_from_utf8( (string) $str );

		return $str;
	}

	public function get_xml_url( $item ) {
		$str = $this->get_obj_property( $item, 'link' );
		$str = (string) $str;

		return $str;
	}

	public function get_xml_thumb( $item ) {
		$str = $this->get_obj_property( $item, 'imageUrlLarge' );
		$str = (string) $str;

		return $str;
	}

	public function get_xml_duration( $item ) {
		$str = $this->get_obj_property( $item, 'playTimeSecond' );
		$arr = explode( ':', $str );
		if ( ! isset( $arr[1] ) ) {
			return false;
		}

		return ( $arr[0] * 60 ) + $arr[1];
	}

	public function get_xml_tags( $src ) {
		$url  = $this->build_link( $src );
		$tags = $this->get_remote_meta_tags( $url );
		if ( ! isset( $tags['keywords'] ) ) {
			return false;
		}

		$str = $tags['keywords'];
		$arr = $this->str_to_array( $str, ',' );
		$arr = $this->array_remove( $arr, $this->_TAGS_REMOVE );
		$arr = $this->convert_array_from_utf8( $arr );

		return $arr;
	}

	public function get_xml_script( $item ) {
		$url = $this->get_xml_script_src( $item );
		if ( empty( $url ) ) {
			return false;
		}

		return $this->build_embed_script_with_repalce( $url );
	}

	public function get_xml_script_src( $item ) {
		$player = $this->get_obj_property( $item, 'player' );
		$script = $this->get_obj_property( $player, 'script' );
		$str    = $this->get_obj_attributes( $script, 'src' );
		$str    = (string) $str;

		return $str;
	}

	public function build_embed_script( $src, $width, $height ) {
		$url = $src . '&width=' . $width . '&height=' . $height . '&skin=gray';
		$str = $this->build_script( $url );

		return $str;
	}

}
