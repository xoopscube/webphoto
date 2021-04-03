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


class webphoto_edit_flash_create extends webphoto_edit_base_create {
	public $_ext_class;

	public $_SUB_DIR_FLASHS = 'flashs';
	public $_FLASH_EXT = 'flv';
	public $_FLASH_MIME = 'video/x-flv';
	public $_FLASH_MEDIUM = 'video';


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_ext_class
			=& webphoto_ext::getInstance( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_flash_create( $dirname, $trust_dirname );
		}

		return $instance;
	}


// create flash

	function create( $param ) {
		$this->clear_msg_array();

		$item_id       = $param['item_id'];
		$item_width    = $param['item_width'];
		$item_height   = $param['item_height'];
		$item_duration = $param['item_duration'];
		$src_file      = $param['src_file'];
		$src_ext       = $param['src_ext'];
		$src_kind      = $param['src_kind'];

// return input file is flash 
		if ( $this->is_flash_ext( $src_ext ) ) {
			return null;
		}

		$arr = $this->create_flash( $item_id, $src_file, $src_ext );
		if ( ! is_array( $arr ) ) {
			return null;
		}

		$arr['width']    = $item_width;
		$arr['height']   = $item_height;
		$arr['duration'] = $item_duration;

		return $arr;

	}

	function create_flash( $item_id, $src_file, $src_ext ) {
		$this->_flag_created = false;
		$this->_flag_failed  = false;
		$this->_msg          = null;

		$flash_param = null;

		$name_param = $this->build_random_name_param(
			$item_id, $this->_FLASH_EXT, $this->_SUB_DIR_FLASHS );
		$name       = $name_param['name'];
		$path       = $name_param['path'];
		$file       = $name_param['file'];
		$url        = $name_param['url'];

		$param = array(
			'item_id'  => $item_id,
			'src_file' => $src_file,
			'src_ext'  => $src_ext,
			'flv_file' => $file,
		);

		$ret = $this->_ext_class->execute( 'flv', $param );

// created
		if ( $ret == 1 ) {
			$this->set_flag_created();
			$this->set_msg( 'create flash' );

			$flash_param = array(
				'url'    => $url,
				'path'   => $path,
				'name'   => $name,
				'ext'    => $this->_FLASH_EXT,
				'mime'   => $this->_FLASH_MIME,
				'medium' => $this->_FLASH_MEDIUM,
				'size'   => filesize( $file ),
				'kind'   => _C_WEBPHOTO_FILE_KIND_VIDEO_FLASH,
			);

// failed
		} elseif ( $ret == - 1 ) {
			$this->set_flag_failed();
			$this->set_msg( 'fail to create flash', true );
			$this->set_error( $this->_ext_class->get_errors() );
		}

		return $flash_param;
	}

}
