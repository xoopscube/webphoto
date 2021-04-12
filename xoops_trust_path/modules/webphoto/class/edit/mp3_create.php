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


class webphoto_edit_mp3_create extends webphoto_edit_base_create {
	public $_lame_class;

	public $_param_ext = 'mp3';
	public $_param_dir = 'mp3s';
	public $_param_mime = 'audio/mpeg';
	public $_param_medium = 'audio';
	public $_param_kind = _C_WEBPHOTO_FILE_KIND_MP3;
	public $_msg_created = 'create mp3';
	public $_msg_failed = 'fail to create mp3';


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_lame_class =& webphoto_lame::getInstance( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_mp3_create( $dirname, $trust_dirname );
		}

		return $instance;
	}


// create mp3

	public function create_param( $param ) {
		$this->clear_msg_array();

		$item_id  = $param['item_id'];
		$src_file = $param['src_file'];
		$src_ext  = $param['src_ext'];
		$src_kind = $param['src_kind'];

// return input file is not wav 
		if ( ! $this->is_wav_ext( $src_ext ) ) {
			return null;
		}

		$mp3_param = $this->create_mp3( $item_id, $src_file, $src_ext );
		if ( ! is_array( $mp3_param ) ) {
			return null;
		}

		return $mp3_param;
	}

	public function create_mp3( $item_id, $src_file, $src_ext ) {
		$name_param = $this->build_name_param( $item_id );
		$file       = $name_param['file'];

		$ret = $this->_lame_class->create_mp3( $src_file, $file );

		return $this->build_result( $ret, $name_param );
	}

}
