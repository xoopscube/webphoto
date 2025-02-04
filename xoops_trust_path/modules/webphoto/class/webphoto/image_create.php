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


class webphoto_image_create {
	public $_image_cmd_class;
	public $_config_class;
	public $_kind_class;

	public $_has_resize = false;
	public $_has_rotate = false;
	public $_flag_chmod = true;


	public function __construct( $dirname ) {
		$this->_kind_class   =& webphoto_kind::getInstance();
		$this->_config_class =& webphoto_config::getInstance( $dirname );

		$this->_init_image_cmd();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_image_create( $dirname );
		}

		return $instance;
	}


	function _init_image_cmd() {
		$this->_image_cmd_class =& webphoto_lib_image_cmd::getInstance();

		$this->_image_cmd_class->set_imagingpipe( $this->get_config_by_name( 'imagingpipe' ) );
		$this->_image_cmd_class->set_forcegd2( $this->get_config_by_name( 'forcegd2' ) );
		$this->_image_cmd_class->set_imagickpath( $this->get_config_by_name( 'imagickpath' ) );
		$this->_image_cmd_class->set_netpbmpath( $this->get_config_by_name( 'netpbmpath' ) );
		$this->_image_cmd_class->set_jpeg_quality( $this->get_config_by_name( 'jpeg_quality' ) );

		$this->_image_cmd_class->set_normal_exts( $this->get_image_exts() );
		$this->_image_cmd_class->set_flag_chmod( $this->_flag_chmod );

		$this->_has_resize = $this->_image_cmd_class->has_resize();
		$this->_has_rotate = $this->_image_cmd_class->has_rotate();
	}

	function has_resize() {
		return $this->_has_resize;
	}

	function has_rotate() {
		return $this->_has_rotate;
	}


// config class

	function get_config_by_name( $name ) {
		return $this->_config_class->get_by_name( $name );
	}


// kind class

	function get_image_exts() {
		return $this->_kind_class->get_image_exts();
	}


// image cmd class

	function cmd_resize_rotate( $src_file, $dst_file, $max_width, $max_height, $rotate = 0 ) {
		return $this->_image_cmd_class->resize_rotate(
			$src_file, $dst_file, $max_width, $max_height, $rotate );
	}

	function cmd_rotate( $src_file, $dst_file, $rotate = 0 ) {
		$ret = $this->_image_cmd_class->resize_rotate(
			$src_file, $dst_file, 0, 0, $rotate );
		if ( $ret < 0 ) {
			return - 1;
		}

		return 1;
	}

	function cmd_resize( $src_file, $dst_file, $max_width, $max_height ) {
		return $this->_image_cmd_class->resize_rotate(
			$src_file, $dst_file, $max_width, $max_height, 0 );
	}

	function cmd_add_icon( $src_file, $dst_file, $icon_file ) {
		return $this->_image_cmd_class->add_icon(
			$src_file, $dst_file, $icon_file );
	}

	function cmd_convert( $src_file, $dst_file, $option = null ) {
		return $this->_image_cmd_class->convert(
			$src_file, $dst_file, $option );
	}

}
