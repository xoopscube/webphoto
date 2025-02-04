<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_edit_base_create extends webphoto_base_this {
	public $_msg_class;
	public $_mime_class;

	public $_result = null;
	public $_flag_created = false;
	public $_flag_failed = false;

	public $_IMAGE_MEDIUM = 'image';
	public $_EXT_PNG = 'png';

	public $_param_ext = null;
	public $_param_mime = null;
	public $_param_medium = null;
	public $_param_kind = null;
	public $_param_dir = null;
	public $_msg_created = null;
	public $_msg_failed = null;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_mime_class =& webphoto_mime::getInstance( $dirname, $trust_dirname );

// each msg box
		$this->_msg_class   = new webphoto_lib_msg();
		$this->_error_class = new webphoto_lib_error();
	}


// create copy param

	public function create_copy_param( $param ) {
		$item_id  = $param['item_id'];
		$src_file = $param['src_file'];

		$name_param = $this->build_name_param( $item_id );
		$file       = $name_param['file'];

		copy( $src_file, $file );

		return $this->build_copy_result( $name_param );
	}


// file

	public function build_name_param( $item_id ) {
		return $this->build_random_name_param(
			$item_id, $this->_param_ext, $this->_param_dir );
	}

	public function build_random_name_param( $item_id, $src_ext, $sub_dir ) {
		$name = $this->build_random_file_name( $item_id, $src_ext );
		$path = $this->_UPLOADS_PATH . '/' . $sub_dir . '/' . $name;
		$file = $this->build_file_full_path( $path );
		$url  = $this->build_file_full_url( $path );

		$arr = [
			'name' => $name,
			'path' => $path,
			'file' => $file,
			'url'  => $url,
		];

		return $arr;
	}

	public function build_image_file_param( $path, $name, $ext, $kind ) {
		$info = $this->build_image_info( $path, $ext );

		$arr = [
			'url'    => $this->build_file_full_url( $path ),
			'file'   => $this->build_file_full_path( $path ),
			'path'   => $path,
			'name'   => $name,
			'ext'    => $ext,
			'kind'   => $kind,
			'width'  => $info['width'],
			'height' => $info['height'],
			'size'   => $info['size'],
			'mime'   => $info['mime'],
			'medium' => $info['medium'],
		];

		return $arr;
	}

	public function build_image_info( $path, $ext ) {
		$size     = 0;
		$width    = 0;
		$height   = 0;
		$mime     = '';
		$medium   = '';
		$is_image = false;

		$file = $this->build_file_full_path( $path );

		if ( is_readable( $file ) ) {
			if ( $this->is_image_ext( $ext ) ) {
				$image_size = GetImageSize( $file );
				if ( is_array( $image_size ) ) {
					$width    = $image_size[0];
					$height   = $image_size[1];
					$mime     = $image_size['mime'];
					$medium   = $this->_IMAGE_MEDIUM;
					$is_image = true;
				}
			}
			$size = filesize( $file );
		}

		$arr = array(
			'path'     => $path,
			'ext'      => $ext,
			'size'     => $size,
			'width'    => $width,
			'height'   => $height,
			'mime'     => $mime,
			'medium'   => $medium,
			'is_image' => $is_image,
		);

		return $arr;
	}

	public function build_file_param_by_name_param( $name_param ) {
		$name = $name_param['name'];
		$path = $name_param['path'];
		$file = $name_param['file'];
		$url  = $name_param['url'];

		$info = $this->build_image_info( $path, $this->_param_ext );

		$param = [
			'url'    => $url,
			'file'   => $file,
			'path'   => $path,
			'name'   => $name,
			'width'  => $info['width'],
			'height' => $info['height'],
			'size'   => filesize( $file ),
			'ext'    => $this->_param_ext,
			'mime'   => $this->_param_mime,
			'medium' => $this->_param_medium,
			'kind'   => $this->_param_kind,
		];

		return $param;
	}

	public function build_result( $ret, $name_param ) {
		$file_param          = null;
		$this->_flag_created = false;
		$this->_flag_failed  = false;

// created
		if ( $ret == 1 ) {
			$this->set_flag_created();
			$this->set_msg( $this->_msg_created );
			$file_param = $this->build_file_param_by_name_param( $name_param );

// failed
		} elseif ( $ret == - 1 ) {
			$this->set_flag_failed();
			$this->set_msg( $this->_msg_failed, true );
		}

		return $file_param;
	}

	public function build_copy_result( $name_param ) {
		if ( file_exists( $name_param['file'] ) ) {
			$ret = 1;
		} else {
			$ret = - 1;
		}

		return $this->build_result( $ret, $name_param );
	}


// msg class

	public function clear_msg_array() {
		$this->_msg_class->clear_msg_array();
	}

	public function get_msg_array() {
		return $this->_msg_class->get_msg_array();
	}

	public function set_msg( $msg, $flag_highlight = false ) {
		return $this->_msg_class->set_msg( $msg, $flag_highlight );
	}


// error class

	public function clear_errors() {
		$this->_error_class->clear_errors();
	}

	public function get_errors() {
		return $this->_error_class->get_errors();
	}

	public function set_error( $msg ) {
		return $this->_error_class->set_error( $msg );
	}


// get param

	public function set_result( $v ) {
		$this->_result = $v;
	}

	public function set_flag_created() {
		$this->_flag_created = true;
	}

	public function set_flag_failed() {
		$this->_flag_failed = true;
	}

	public function clear_flags() {
		$this->_flag_created = false;
		$this->_flag_failed  = false;
	}

	public function get_result() {
		return $this->_result;
	}

	public function get_flag_created() {
		return $this->_flag_created;
	}

	public function get_flag_failed() {
		return $this->_flag_failed;
	}

}

