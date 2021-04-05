<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *  N903i 240�~270
 * http://code.google.com/intl/en/apis/maps/documentation/staticmaps/
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_lib_staticmap {
// map param
	public $_key = null;
	public $_width = 220;
	public $_height = 220;
	public $_maptype = 'mobile';
	public $_sanitize = true;


	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_staticmap();
		}

		return $instance;
	}


// build url

	public function build_url( $param ) {
		$latitude  = $param['latitude'];
		$longitude = $param['longitude'];
		$zoom      = $param['zoom'];

		$key      = $param['key'] ?? $this->_key;
		$maptype  = $param['maptype'] ?? $this->_maptype;
		$markers  = $param['markers'] ?? null;
		$width    = isset( $param['width'] ) ? (int) $param['width'] : $this->_width;
		$height   = isset( $param['height'] ) ? (int) $param['height'] : $this->_height;
		$sanitize = isset( $param['sanitize'] ) ? (bool) $param['sanitize'] : $this->_sanitize;

		$static_markers = $this->build_markers( $markers );

		$str = 'http://maps.google.com/staticmap?';
		$str .= 'key=' . $key;
		$str .= '&center=' . $latitude . ',' . $longitude;
		$str .= '&zoom=' . $zoom;
		$str .= '&size=' . $width . 'x' . $height;
		$str .= '&maptype=' . $maptype;

		if ( $static_markers ) {
			$str .= '&markers=' . $static_markers;
		}

		if ( $sanitize ) {
			$str = $this->sanitize_url( $str );
		}

		return $str;
	}

	public function build_markers( $markers ) {
		if ( ! is_array( $markers ) || ! count( $markers ) ) {
			return null;
		}

		$arr = array();
		foreach ( $markers as $marker ) {
			$latitude  = $marker['latitude'];
			$longitude = $marker['longitude'];
			$color     = $marker['color'] ?? null;
			$alpha     = $marker['alpha'] ?? null;

			$str = $latitude . ',' . $longitude;
			if ( $color ) {
				$str .= ',' . $color;
				if ( $alpha ) {
					$str .= $alpha;
				}
			}

			$arr[] = $str;
		}

		return implode( '|', $arr );
	}

	public function sanitize_url( $str ) {
		$str = str_replace( '|', '%7C', $str );

		return htmlspecialchars( $str, ENT_QUOTES );
	}


// set param

	public function set_key( $val ) {
		$this->_key = $val;
	}

	public function set_maptype( $val ) {
		$this->_maptype = $val;
	}

	public function set_width( $val ) {
		$this->_width = (int) $val;
	}

	public function set_height( $val ) {
		$this->_height = (int) $val;
	}

	public function set_sanitize( $val ) {
		$this->_sanitize = (bool) $val;
	}

}
