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


class webphoto_embed_base {
	public $_snoopy_class;

	public $_param = null;
	public $_url_head = null;
	public $_url_tail = null;
	public $_sample = null;
	public $_tmp_dir = null;

	public $_TYPE = null;


	public function __construct( $type ) {
		$this->_TYPE = $type;

		$this->_snoopy_class = new Snoopy();
	}


// interface

	public function embed( $src, $width, $height, $extra = null ) {
		return null;
	}

	public function link( $src ) {
		return null;
	}

	public function thumb( $src ) {
		return null;
	}

	public function desc() {
		return null;
	}

	public function lang_desc() {
		return null;
	}

	public function width() {
		return 0;
	}

	public function height() {
		return 0;
	}

	public function support_params() {
		return null;
	}

	public function get_xml_params( $src ) {
		return null;
	}

	public function build_embed_script( $src, $width, $height ) {
		return null;
	}


// set param

	public function set_param( $val ) {
		$this->_param = $val;
	}

	public function get_param( $name ) {
		if ( isset( $this->_param[ $name ] ) ) {
			return $this->_param[ $name ];
		}

		return false;
	}

	public function set_url( $head, $tail = '' ) {
		$this->_url_head = $head;
		if ( $tail ) {
			$this->_url_tail = $tail;
		}
	}

	public function set_sample( $sample ) {
		$this->_sample = $sample;
	}

	public function set_tmp_dir( $val ) {
		$this->_tmp_dir = $val;
	}


// build

	public function build_object_begin( $width, $height, $extra = null ) {
// BUG: forget to close height
		$str = '<object width="' . $width . '" height="' . $height . '" ' . $extra . ' >' . "\n";

		return $str;
	}

	public function build_object_end() {
		$str = "</object>\n";

		return $str;
	}

	public function build_param( $name, $value ) {
		$str = '<param name="' . $name . '" value="' . $value . '" />' . "\n";

		return $str;
	}

	public function build_embed_flash( $src, $width, $height, $extra = null ) {
		$str = '<embed src="' . $src . '" width="' . $width . '" height="' . $height . '" ' . $extra . ' type="application/x-shockwave-flash" />' . "\n";

		return $str;
	}

	public function build_script( $src, $extra = null ) {
		$str = $this->build_script_begin( $src, $extra );
		$str .= $this->build_script_end();

		return $str;
	}

	public function build_script_begin( $src, $extra = null ) {
		$str = '<script language="JavaScript" type="text/JavaScript" src="' . $src . '" ' . $extra . ' >';

		return $str;
	}

	public function build_script_end() {
		$str = '</script>';

		return $str;
	}

	public function build_link( $src ) {
		$str = $this->_url_head . $src . $this->_url_tail;

		return $str;
	}

	public function build_desc() {
		return $this->build_desc_span( $this->_url_head, $this->_sample, $this->_url_tail );
	}

	public function build_desc_span( $head, $sample, $tail = null ) {
		$str = $head . '<span style="color: #FF0000;">' . $sample . '</span>' . $tail;

		return $str;
	}

	public function build_lang_desc( $str ) {
		$cont_name = strtoupper( '_WEBPHOTO_EXTERNEL_' . $this->_TYPE );
		if ( defined( $cont_name ) ) {
			$str = constant( $cont_name );
		}

		return $str;
	}

	public function replace_width_height( $str ) {
		$replacement_width  = 'width="' . _C_WEBPHOTO_EMBED_REPLACE_WIDTH . '"';
		$replacement_height = 'height="' . _C_WEBPHOTO_EMBED_REPLACE_HEIGHT . '"';

		$str = preg_replace( '/width="\d+"/', $replacement_width, $str );
		$str = preg_replace( '/height="\d+"/', $replacement_height, $str );

		return $str;
	}

	public function build_embed_script_with_replace( $src ) {
		$str = $this->build_embed_script(
			$src,
			_C_WEBPHOTO_EMBED_REPLACE_WIDTH,
			_C_WEBPHOTO_EMBED_REPLACE_HEIGHT );

		return $str;
	}

	public function build_support_params() {
		$arr = array(
			'title'       => true,
			'description' => true,
			'url'         => true,
			'thumb'       => true,
			'duration'    => true,
			'tags'        => true,
			'script'      => true,
		);

		return $arr;
	}


// Simple XML

	public function get_simplexml( $cont ) {
		if ( function_exists( 'simplexml_load_string' ) ) {
			return simplexml_load_string( $cont, 'SimpleXMLElement', LIBXML_NOCDATA );
		}

		return false;
	}

	public function get_xpath( $obj, $key ) {
		if ( is_object( $obj ) ) {
			$xpath = $obj->xpath( $key );
			if ( isset( $xpath[0] ) ) {
				return $xpath[0];
			}
		}

		return false;
	}

	public function get_obj_method( $obj, $key ) {
		if ( is_object( $obj ) && method_exists( $obj, $key ) ) {
			return $obj->$key();
		}

		return false;
	}

	public function get_obj_property( $obj, $key ) {
		if ( is_object( $obj ) && property_exists( $obj, $key ) ) {
			return $obj->$key;
		}

		return false;
	}

	public function get_obj_attributes( $obj, $key ) {
		$attr = $this->get_obj_method( $obj, 'attributes' );
		$str  = $this->get_obj_property( $attr, $key );

		return $str;
	}


// snoopy

	public function get_remote_file( $url ) {
		if ( $this->_snoopy_class->fetch( $url ) ) {
			return $this->_snoopy_class->results;
		}

		return false;
	}

	public function get_remote_meta_tags( $url ) {
		$cont = $this->get_remote_file( $url );
		if ( empty( $cont ) ) {
			return false;
		}

		$file = $this->build_tmp_file_name();
		$ret  = $this->write_file( $file, $cont );
		if ( ! $ret ) {
			return false;
		}

		$tags = get_meta_tags( $file );
		$this->unlink_file( $file );

		return $tags;
	}


// file

	public function build_tmp_file_name() {
		$str = $this->_tmp_dir . '/' . uniqid( 'embed' );

		return $str;
	}

	public function write_file( $file, $text ) {
		if ( function_exists( 'file_put_contents' ) ) {
			return file_put_contents( $file, $text );
		}

		return false;
	}

	public function unlink_file( $file ) {
		if ( file_exists( $file ) ) {
			return unlink( $file );
		}

		return false;
	}


// multibyte

	public function convert_from_utf8( $str ) {
		return $this->convert_encoding( $str, _CHARSET, 'UTF-8' );
	}

	public function convert_array_from_utf8( $arr ) {
		$ret = array();
		foreach ( $arr as $v ) {
			$ret[] = $this->convert_from_utf8( $v );
		}

		return $ret;
	}

	public function convert_encoding( $str, $to, $from ) {
		if ( strtolower( $to ) == strtolower( $from ) ) {
			return $str;
		}
		if ( function_exists( 'iconv' ) ) {
			return iconv( $from, $to . '//IGNORE', $str );
		}
		if ( function_exists( 'mb_convert_encoding' ) ) {
			return mb_convert_encoding( $str, $to, $from );
		}

		return $str;
	}


// utility

	public function str_to_array( $str, $pattern ) {
		$arr1 = explode( $pattern, $str );
		$arr2 = array();
		foreach ( $arr1 as $v ) {
			$v = trim( $v );
			if ( $v == '' ) {
				continue;
			}
			$arr2[] = $v;
		}

		return $arr2;
	}

	public function array_remove( $arr1, $arr2 ) {
		if ( ! is_array( $arr1 ) || ! count( $arr1 ) ) {
			return $arr1;
		}
		if ( ! is_array( $arr2 ) || ! count( $arr2 ) ) {
			return $arr1;
		}

		$ret = array();
		foreach ( $arr1 as $a ) {
			if ( ! in_array( $a, $arr2 ) ) {
				$ret[] = $a;
			}
		}

		return $ret;
	}

	public function obj_array_to_str_array( $arr ) {
		$ret = array();
		foreach ( $arr as $a ) {
			$ret[] = (string) $a;
		}

		return $ret;
	}

// --- class end ---
}
