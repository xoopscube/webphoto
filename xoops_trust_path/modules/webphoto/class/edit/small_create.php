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


class webphoto_edit_small_create extends webphoto_edit_middle_thumb_create {
	public $_remote_class;

	public $_tmp_file = null;

	public $_FOPEN_MODE = 'wb';
	public $_FLAG_CHMOD = true;
	public $_FLAG_CREATE_FROM_ICON = false;

	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_remote_class =& webphoto_lib_remote_file::getInstance();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_small_create( $dirname, $trust_dirname );
		}

		return $instance;
	}


// create small image

// factory_create
	public function create_small_param_from_external_icon( $row ) {
		$param = $this->build_small_param_from_external_icon( $row );
		if ( ! is_array( $param ) ) {
			return false;
		}

		$small_param = $this->create_small_param( $param );

// remove tmp file
		if ( $this->_tmp_file ) {
			unlink( $this->_tmp_file );
		}

		return $small_param;
	}

// update_130
	public function build_small_param_from_external_icon( $row ) {
		$external_url   = $row['item_external_url'];
		$external_thumb = $row['item_external_thumb'];
		$icon_name      = $row['item_icon_name'];

		if ( $this->is_image_url( $external_url ) ) {
			return $this->build_small_param_external( $row, $external_url );
		}
		if ( $this->is_image_url( $external_thumb ) ) {
			return $this->build_small_param_external( $row, $external_thumb );
		}
		if ( $this->_FLAG_CREATE_FROM_ICON && $icon_name ) {
			return $this->build_small_param_icon( $icon_name );
		}

		return null;
	}

	public function build_small_param_external( $row, $url ) {
		$this->_tmp_file = null;

		$src_ext  = $this->parse_ext( $url );
		$src_file = $this->build_tmp_file( $src_ext );

		$data = $this->get_remote_file( $url );
		if ( empty( $data ) ) {
			return false;
		}

		$this->write_file( $src_file, $data );
		if ( ! file_exists( $src_file ) ) {
			return false;
		}

		$this->_tmp_file = $src_file;

		$param = array(
			'item_id'  => $row['item_id'],
			'src_ext'  => $src_ext,
			'src_file' => $src_file,
		);

		return $param;
	}

	public function build_small_param_icon( $icon_name ) {
		$src_file = $this->build_icon_file( $icon_name, false );
		if ( ! file_exists( $src_file ) ) {
			return false;
		}

		$param = [
			'item_id'  => $row['item_id'],
			'src_ext'  => $this->parse_ext( $icon_name ),
			'src_file' => $src_file,
		];

		return $param;
	}

	public function is_image_url( $url ) {
		if ( empty( $url ) ) {
			return false;
		}
		$ext = $this->parse_ext( $url );
		if ( empty( $ext ) ) {
			return false;
		}

		return $this->is_image_ext( $ext );
	}


// remote class

	public function get_remote_file( $url ) {
		return $this->_remote_class->read_file( $url );
	}


// utility class

	public function write_file( $file, $data ) {
		return $this->_utility_class->write_file( $file, $data, $this->_FOPEN_MODE, $this->_FLAG_CHMOD );
	}
}
