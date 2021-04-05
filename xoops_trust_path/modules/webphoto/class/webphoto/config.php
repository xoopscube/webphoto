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


class webphoto_config {
	public $_utility_class;


	public function __construct( $dirname ) {
		$this->_init( $dirname );

		$this->_utility_class =& webphoto_lib_utility::getInstance();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_config( $dirname );
		}

		return $instance;
	}


	public function _init( $dirname ) {
		$xoops_class         =& webphoto_xoops_base::getInstance();
		$this->_config_array = $xoops_class->get_module_config_by_dirname( $dirname );
	}


// get

	public function get_config_array() {
		return $this->_config_array;
	}

	public function get_by_name( $name ) {
		if ( isset( $this->_config_array[ $name ] ) ) {
			return $this->_config_array[ $name ];
		}

		return null;
	}

	public function get_array_by_name( $name ) {
		$str = $this->get_by_name( $name );
		if ( $str ) {
			$arr = explode( '|', $str );
		} else {
			$arr = array();
		}

		return $arr;
	}

	public function get_dir_by_name( $name ) {
		$str = $this->get_by_name( $name );

		return $this->add_separator_to_tail( $str );
	}

	public function get_work_dir( $sub_dir = null ) {
		$dir = $this->get_by_name( 'workdir' );
		if ( $sub_dir ) {
			$dir .= '/' . $sub_dir;
		}

		return $dir;
	}

	public function get_uploads_path( $sub_dir = null ) {
		$path = $this->_get_path_by_name( 'uploadspath' );
		if ( $sub_dir ) {
			$path .= '/' . $sub_dir;
		}

		return $path;
	}

	public function get_medias_path() {
		return $this->_get_path_by_name( 'mediaspath' );
	}

	public function get_large_wh() {
		return $this->get_wh_common( 'width', 'height' );
	}

	public function get_middle_wh() {
		return $this->get_wh_common( 'middle_width', 'middle_height' );
	}

	public function get_small_wh() {
		return $this->get_wh_common( 'small_width', 'small_height' );
	}

	public function get_thumb_wh() {
		return $this->get_wh_common( 'thumb_width', 'thumb_height' );
	}

	public function get_wh_common( $name_width, $name_height ) {
		$width  = $this->get_by_name( $name_width );
		$height = $this->get_by_name( $name_height );

		if ( $width && empty( $height ) ) {
			$height = $width;
		} elseif ( empty( $width ) && $height ) {
			$width = $height;
		}

		return array( $width, $height );
	}

	public function _get_path_by_name( $name ) {
		$path = $this->get_by_name( $name );
		if ( $path ) {
			return $this->add_slash_to_head( $path );
		}

		return null;
	}

	public function is_set_mail() {
		$host = $this->get_by_name( 'mail_host' );
		$user = $this->get_by_name( 'mail_user' );
		$pass = $this->get_by_name( 'mail_pass' );

		if ( $host && $user && $pass ) {
			return true;
		}

		return false;
	}


// utlity class

	public function add_slash_to_head( $str ) {
		return $this->_utility_class->add_slash_to_head( $str );
	}

	public function add_separator_to_tail( $str ) {
		return $this->_utility_class->add_separator_to_tail( $str );
	}

}
