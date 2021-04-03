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


class webphoto_imagemagick extends webphoto_cmd_base {
	public $_imagemagick_class;
	public $_cfg_imagingpipe;

	public $_PIPEID_IMAGICK = _C_WEBPHOTO_PIPEID_IMAGICK;

	public $_CMD_CONVERT = 'convert';
	public $_CMYK_OPTION = '-colorspace RGB';


// constructor

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
		//$this->webphoto_cmd_base( $dirname, $trust_dirname );

		$this->_imagemagick_class =& webphoto_lib_imagemagick::getInstance();

		$this->_cfg_imagingpipe = $this->get_config_by_name( 'imagingpipe' );

		$this->_imagemagick_class->set_cmd_path(
			$this->get_config_dir_by_name( 'imagickpath' ) );

		$this->set_debug_by_ini_name( $this->_imagemagick_class );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_imagemagick( $dirname, $trust_dirname );
		}

		return $instance;
	}


// create jpeg

	public function create_jpeg_from_cmyk( $src_file, $dst_file, $rotate = 0, $option = null ) {
		$new_option = $this->_CMYK_OPTION;

		if ( $rotate > 0 ) {
			$new_option .= ' -rotate ' . $rotate;
		}

		$new_option .= ' ' . $option;

		return $this->create_jpeg( $src_file, $dst_file, $new_option );
	}

	public function create_jpeg( $src_file, $dst_file, $option = null ) {
		if ( $this->_cfg_imagingpipe != $this->_PIPEID_IMAGICK ) {
			return 0;    // no action
		}

		if ( empty( $option ) ) {
			$option = $this->get_cmd_option( $src_file, $this->_CMD_CONVERT );
		}

		$this->_imagemagick_class->convert( $src_file, $dst_file, $option );
		if ( is_file( $dst_file ) ) {
			$this->chmod_file( $dst_file );

			return 1;    // suceess
		}

		$this->set_error( $this->_imagemagick_class->get_msg_array() );

		return - 1;    // fail
	}

// --- class end ---
}

?>
