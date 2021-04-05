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

class webphoto_timidity extends webphoto_cmd_base {
	public $_timidity_class;
	public $_cfg_use_timidity;

	public $_WAV_EXT = 'wav';


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_timidity_class =& webphoto_lib_timidity::getInstance();

		$this->_cfg_use_timidity = $this->get_config_by_name( 'use_timidity' );

		$this->_timidity_class->set_cmd_path(
			$this->get_config_dir_by_name( 'timiditypath' ) );

		$this->set_debug_by_ini_name( $this->_timidity_class );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_timidity( $dirname, $trust_dirname );
		}

		return $instance;
	}


// create wav

	public function create_wav( $src_file, $dst_file, $option = '' ) {
		if ( empty( $src_file ) ) {
			return null;
		}
		if ( ! is_file( $src_file ) ) {
			return null;
		}
		if ( ! $this->_cfg_use_timidity ) {
			return null;
		}

		$this->_timidity_class->mid_to_wav( $src_file, $dst_file, $option );

		if ( is_file( $dst_file ) ) {
			$this->chmod_file( $dst_file );

			return 1;    // suceess
		}

		$this->set_error( $this->_timidity_class->get_msg_array() );

		return - 1;    // fail
	}


// create wav tmp

	public function create_wav_tmp( $item_id, $src_file, $option = '' ) {
		if ( empty( $src_file ) ) {
			return null;
		}
		if ( ! is_file( $src_file ) ) {
			return null;
		}
		if ( ! $this->_cfg_use_timidity ) {
			return null;
		}

		$dst_file = $this->build_wav_file( $item_id );

		$this->_timidity_class->mid_to_wav( $src_file, $dst_file, $option );

		if ( ! is_file( $dst_file ) ) {
			$arr = array(
				'flag'   => false,
				'errors' => $this->set_get_errors( $this->_timidity_class->get_msg_array() ),
			);

			return $arr;
		}

		$this->chmod_file( $dst_file );

		$arr = array(
			'flag'     => true,
			'item_id'  => $item_id,
			'src_file' => $dst_file,
			'src_ext'  => $this->_MP3_EXT,
		);

		return $arr;
	}

	public function build_wav_file( $item_id ) {
		return $this->build_file_by_prefix_ext(
			$this->build_prefix( $item_id ), $this->_WAV_EXT );
	}

}
