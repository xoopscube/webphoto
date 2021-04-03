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


class webphoto_edit_wav_create extends webphoto_edit_base_create {
	public $_ext_class;

	public $_param_ext = 'wav';
	public $_param_dir = 'wavs';
	var $_param_mime = 'audio/wav';
	public $_param_medium = 'audio';
	public $_param_kind = _C_WEBPHOTO_FILE_KIND_WAV;
	public $_msg_created = 'create wav';
	public $_msg_failed = 'fail to create wav';


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_ext_class
			=& webphoto_ext::getInstance( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_wav_create( $dirname, $trust_dirname );
		}

		return $instance;
	}


// create wav
	public function create_param( $param ) {
		$this->clear_msg_array();

		$item_id  = $param['item_id'];
		$src_file = $param['src_file'];
		$src_ext  = $param['src_ext'];
		$src_kind = $param['src_kind'];

// return input file is wav 
		if ( $this->is_wav_ext( $src_ext ) ) {
			return null;
		}

		$wav_param = $this->create_wav( $item_id, $src_file, $src_ext );
		if ( ! is_array( $wav_param ) ) {
			return null;
		}

		return $wav_param;
	}

	public function create_wav( $item_id, $src_file, $src_ext ) {
		$name_param = $this->build_name_param( $item_id );
		$file       = $name_param['file'];

		$param = array(
			'item_id'  => $item_id,
			'src_file' => $src_file,
			'src_ext'  => $src_ext,
			'wav_file' => $file,
		);

		$ret = $this->_ext_class->execute( 'wav', $param );

		return $this->build_result( $ret, $name_param );
	}
}
