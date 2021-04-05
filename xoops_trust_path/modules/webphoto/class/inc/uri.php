<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * class webphoto_inc_uri
 * caller webphoto_uri webphoto_inc_tagcloud
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_inc_uri {
	public $_cfg_use_pathinfo = false;

	public $_DIRNAME;
	public $_MODULE_URL;
	public $_MODULE_DIR;

	public $_SEPARATOR = '&amp;';
	public $_MARK_SLASH = '/';
	public $_MARK_COLON = ':';
	public $_HTML_AMP = '&amp;';
	public $_HTML_SLASH = '&#047;';
	public $_HTML_COLON = '&#058;';


	public function __construct( $dirname ) {
		$this->_DIRNAME    = $dirname;
		$this->_MODULE_URL = XOOPS_URL . '/modules/' . $dirname;
		$this->_MODULE_DIR = XOOPS_ROOT_PATH . '/modules/' . $dirname;

		$this->_init_xoops_config( $dirname );

		if ( $this->_cfg_use_pathinfo ) {
			$this->_SEPARATOR = $this->_MARK_SLASH;
		} else {
			$this->_SEPARATOR = $this->_HTML_AMP;
		}
	}

	public static function &getSingleton( $dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] = new webphoto_inc_uri( $dirname );
		}

		return $singletons[ $dirname ];
	}


// public
	public function get_separator() {
		return $this->_SEPARATOR;
	}

	public function build_photo( $id, $flag_amp_sanitize = true ) {
		return $this->build_full_uri_mode_param( 'photo', $id, $flag_amp_sanitize );
	}

	public function build_category( $id, $flag_amp_sanitize = true ) {
		return $this->build_full_uri_mode_param( 'category', $id, $flag_amp_sanitize );
	}

	public function build_tag( $tag ) {
		return $this->build_full_uri_mode_param(
			'tag', $this->rawurlencode_encode_str( $tag ) );
	}

	function build_search_photo_keywords( $id, $keywords ) {
		$param = array(
			'keywords' => $keywords
		);

		$str = $this->build_relatevie_uri_mode( 'photo' );
		$str .= $this->build_part_uri_param( $id );
		$str .= $this->build_uri_extention( $param, true, false );

		return $str;
	}

	function build_sitemap_category() {
		$str = $this->build_relatevie_uri_mode( 'category' );
		$str .= $this->build_part_uri_param_name();

		return $str;
	}


// private

	function build_full_uri_mode_param( $mode, $param, $flag_amp_sanitize = true ) {
		$str = $this->_MODULE_URL . '/';
		$str .= $this->build_relatevie_uri_mode_param( $mode, $param, $flag_amp_sanitize );

		return $str;
	}

	function build_relatevie_uri_mode_param( $mode, $param, $flag_amp_sanitize = true ) {
		$str = $this->build_relatevie_uri_mode( $mode );
		$str .= $this->build_part_uri_param( $param, $flag_amp_sanitize );

		return $str;
	}

	function build_full_uri_mode( $mode ) {
		$str = $this->_MODULE_URL . '/';
		$str .= $this->build_relatevie_uri_mode( $mode );

		return $str;
	}

	function build_part_uri_param( $param, $flag_amp_sanitize = true ) {
		$str = $this->build_part_uri_param_name( $flag_amp_sanitize );

		if ( $this->_cfg_use_pathinfo ) {
			$str .= $param . '/';
		} else {
			$str .= $param;
		}

		return $str;
	}

	function build_part_uri_param_name( $flag_amp_sanitize = true ) {
		$amp = '&';
		if ( $flag_amp_sanitize ) {
			$amp = '&amp;';
		}

		if ( $this->_cfg_use_pathinfo ) {
			$str = '/';
		} else {
			$str = $amp . _C_WEBPHOTO_URI_PARAM_NAME . '=';
		}

		return $str;
	}

	function build_relatevie_uri_mode( $mode ) {
		$str = 'index.php';
		$str .= $this->build_part_uri_mode( $mode );

		return $str;
	}

	function build_part_uri_mode( $mode ) {
		if ( $this->_cfg_use_pathinfo ) {
			$str = '/' . $this->sanitize( $mode );
		} else {
			$str = '?fct=' . $this->sanitize( $mode );
		}

		return $str;
	}

	function build_uri_extention( $param, $flag_amp_sanitize = true, $flag_param_sanitize = true ) {
		if ( ! is_array( $param ) || ! count( $param ) ) {
			return null;
		}

		$amp = '&';
		if ( $flag_amp_sanitize ) {
			$amp = '&amp;';
		}

		$arr = array();
		if ( $flag_param_sanitize ) {
			foreach ( $param as $k => $v ) {
				$arr[] = $this->sanitize( $k ) . '=' . $this->sanitize( $v );
			}
		} else {
			foreach ( $param as $k => $v ) {
				$arr[] = $k . '=' . $v;
			}
		}

		if ( $this->_cfg_use_pathinfo ) {
			$str = implode( $arr, '/' ) . '/';
		} else {
			$str = $amp . implode( $arr, $amp );
		}

		return $str;
	}


// encode

	function rawurlencode_encode_str( $str ) {
		return rawurlencode( $this->encode_str( $str ) );
	}

	function encode_str( $str ) {
		$str = $this->encode_slash( $str );

		return $this->encode_colon( $str );
	}

	function decode_str( $str ) {
		$str = $this->decode_slash( $str );

		return $this->decode_colon( $str );
	}

	function encode_slash( $str ) {
		return str_replace( $this->_MARK_SLASH, $this->_HTML_SLASH, $str );
	}

	function encode_colon( $str ) {
		return str_replace( $this->_MARK_COLON, $this->_HTML_COLON, $str );
	}

	function decode_slash( $str ) {
		return str_replace( $this->_HTML_SLASH, $this->_MARK_SLASH, $str );
	}

	function decode_colon( $str ) {
		return str_replace( $this->_HTML_COLON, $this->_MARK_COLON, $str );
	}


// utility

	function sanitize( $str ) {
		return htmlspecialchars( $str, ENT_QUOTES );
	}


// xoops_config

	function _init_xoops_config( $dirname ) {
		$config_handler =& webphoto_inc_config::getSingleton( $dirname );

		$this->_cfg_use_pathinfo = $config_handler->get_by_name( 'use_pathinfo' );
	}

}
