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


class webphoto_lib_netpbm {

	public $_cmd_path = null;
	public $_DEBUG = false;

	public $_NETPBM_PIPES = array(
		"jpegtopnm",
		"giftopnm",
		"pngtopnm",
		"pnmtojpeg",
		"pnmtopng",
		"ppmquant",
		"ppmtogif",
		"pnmscale",
		"pnmflip"
	);


	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_netpbm();
		}

		return $instance;
	}


// main

	public function set_cmd_path( $val ) {
		$this->_cmd_path = $val;
	}

	public function resize_rotate( $src, $dst, $max_width = 0, $max_height = 0, $rotate = 0 ) {
		$image_size = getimagesize( $src );
		if ( ! is_array( $image_size ) ) {
			return false;
		}

		$src_type = $image_size[2];
		$dst_type = $this->file_to_type( $dst, $src_type );

		$cmd_in  = $this->build_cmd_in( $src_type );
		$cmd_out = $this->build_cmd_out( $dst_type );

		if ( empty( $cmd_in ) || empty( $cmd_out ) ) {
			return false;
		}

		$cmd_resize = null;
		$cmd_rotate = null;

		if ( ( $max_width > 0 ) && ( $max_height > 0 ) ) {
			$cmd_resize = $this->build_cmd_resize( $max_width, $max_height );
		}

		if ( $rotate > 0 ) {
			$cmd_rotate = $this->build_cmd_rotate( 360 - $rotate );
		}

		// Do Modify and check success
		if ( $cmd_resize && $cmd_rotate ) {
			$cmd_resize_rotate = $cmd_resize . ' | ' . $cmd_rotate;
		} elseif ( $cmd_resize ) {
			$cmd_resize_rotate = $cmd_resize;
		} elseif ( $cmd_rotate ) {
			$cmd_resize_rotate = $cmd_rotate;
		} else {
			return false;
		}

		$cmd = $cmd_in . ' < ' . $src . ' | ' . $cmd_resize_rotate . ' | ' . $cmd_out . ' > ' . $dst;
		exec( $cmd );
		if ( $this->_DEBUG ) {
			echo $cmd . "<br>\n";
		}

		return true;
	}

	public function build_cmd_in( $type ) {
		$cmd_in = null;

		switch ( $type ) {
			// GIF
			case 1 :
				$cmd_in = $this->_cmd_path . 'giftopnm';
				break;

			// JPEG
			case 2 :
				$cmd_in = $this->_cmd_path . 'jpegtopnm';
				break;

			// PNG
			case 3 :
				$cmd_in = $this->_cmd_path . 'pngtopnm';
				break;

			default :
				break;
		}

		return $cmd_in;
	}

	public function build_cmd_out( $type ) {
		$cmd_out = null;

		switch ( $type ) {
			// GIF
			case 1 :
				$cmd_out = $this->_cmd_path . 'ppmquant 256 | ';
				$cmd_out .= $this->_cmd_path . 'ppmtogif';
				break;

			// JPEG
			case 2 :
				$cmd_out = $this->_cmd_path . 'pnmtojpeg';
				break;

			// PNG
			case 3 :
				$cmd_out = $this->_cmd_path . 'pnmtopng';
				break;

			default :
				break;
		}

		return $cmd_out;
	}

	public function build_cmd_resize( $max_width, $max_height ) {
		$cmd = $this->_cmd_path . 'pnmscale -xysize ' . $max_width . ' ' . $max_height;

		return $cmd;
	}

	public function build_cmd_rotate( $angle ) {
		$cmd = $this->_cmd_path . 'pnmflip -r' . $angle . ' ';

		return $cmd;
	}

	public function file_to_type( $file, $type_default ) {
		$ext = $this->parse_ext( $file );

		switch ( $ext ) {
			case 'gif' :
				$type = 1;
				break;

			case 'jpg' :
				$type = 2;
				break;

			case 'png' :
				$type = 3;
				break;

			default :
				$type = $type_default;
				break;
		}

		return $type;
	}

	public function parse_ext( $file ) {
		return strtolower( substr( strrchr( $file, '.' ), 1 ) );
	}


// version

	public function version( $path ) {
		$arr = array();
		foreach ( $this->_NETPBM_PIPES as $pipe ) {
			$ret_array = array();
			exec( "{$path}$pipe --version 2>&1", $ret_array );
			if ( count( $ret_array ) > 0 ) {
				$ret = true;
				$str = $ret_array[0];

			} else {
				$ret = false;
				$str = "Error: {$path}$pipe can't be executed";
			}
			$arr[] = array( $ret, $str );
		}

		return $arr;
	}

}
