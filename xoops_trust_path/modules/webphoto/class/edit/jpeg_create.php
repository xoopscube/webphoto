<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_edit_jpeg_create extends webphoto_edit_base_create {
	public $_ext_class;
	public $_image_create_class;

	public $_is_cmyk = false;
	public $_rotate = 0;

	public $_param_ext = 'jpg';
	public $_param_dir = 'jpegs';
	var $_param_mime = 'image/jpeg';
	public $_param_medium = 'image';
	public $_param_kind = _C_WEBPHOTO_FILE_KIND_JPEG;
	public $_msg_created = 'create jpeg';
	public $_msg_failed = 'fail to create jpeg';

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_ext_class
			=& webphoto_ext::getInstance( $dirname, $trust_dirname );

		$this->_image_create_class =& webphoto_image_create::getInstance( $dirname );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_jpeg_create( $dirname, $trust_dirname );
		}

		return $instance;
	}


// create jpeg

	public function create_param( $param ) {
		$this->clear_msg_array();

		$item_id  = $param['item_id'];
		$src_file = $param['src_file'];
		$src_ext  = $param['src_ext'];
		$pdf_file = isset( $param['pdf_file'] ) ? $param['pdf_file'] : null;
		$rotate   = isset( $param['rotate_angle'] ) ? $param['rotate_angle'] : 0;

		$this->_is_cmyk = false;
		$this->_rotate  = 0;

// set flag if image, rotate
		if ( $this->is_image_ext( $src_ext ) ) {
			if ( $rotate ) {
				$this->_rotate = $rotate;
			}
		}

// set flag if jpeg, cmyk
		if ( $this->is_jpeg_ext( $src_ext ) ) {
			if ( $this->is_image_cmyk( $src_file ) ) {
				$this->_is_cmyk = true;
			}
		}

		$jpeg_param = $this->create_jpeg( $item_id, $src_file, $src_ext, $pdf_file );
		if ( ! is_array( $jpeg_param ) ) {
			return null;
		}

		return $jpeg_param;
	}

	public function create_jpeg( $item_id, $src_file, $src_ext, $pdf_file ) {
		$name_param = $this->build_name_param( $item_id );
		$name       = $name_param['name'];
		$path       = $name_param['path'];
		$file       = $name_param['file'];
		$url        = $name_param['url'];

		$param = array(
			'src_file'  => $src_file,
			'src_ext'   => $src_ext,
			'pdf_file'  => $pdf_file,
			'jpeg_file' => $file,
			'is_cmyk'   => $this->_is_cmyk,
			'rotate'    => $this->_rotate,
		);

		$ret = $this->_ext_class->execute( 'jpeg', $param );

		return $this->build_result( $ret, $name_param );
	}

	public function is_cmyk() {
		return $this->_is_cmyk;
	}


// create image param (for gif, png)

	public function create_image_param( $param ) {
		$item_id  = $param['item_id'];
		$src_file = $param['src_file'];

		$name_param = $this->build_name_param( $item_id );
		$jpeg_file  = $name_param['file'];

		$this->_image_create_class->cmd_rotate( $src_file, $jpeg_file, 0 );

		return $this->build_copy_result( $name_param );
	}

}
