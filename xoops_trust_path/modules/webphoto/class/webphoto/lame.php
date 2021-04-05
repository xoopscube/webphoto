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


class webphoto_lame extends webphoto_cmd_base {
	public $_lame_class;
	public $_cfg_use_lame;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
		//$this->webphoto_cmd_base( $dirname, $trust_dirname );

		$this->_lame_class =& webphoto_lib_lame::getInstance();

		$this->_cfg_use_lame = $this->get_config_by_name( 'use_lame' );

		$this->_lame_class->set_cmd_path(
			$this->get_config_dir_by_name( 'lamepath' ) );

		$this->set_debug_by_ini_name( $this->_lame_class );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lame( $dirname, $trust_dirname );
		}

		return $instance;
	}


// create mp3

	function create_mp3( $src_file, $dst_file, $option = '' ) {
		if ( empty( $src_file ) ) {
			return 0;    // no action
		}
		if ( ! is_file( $src_file ) ) {
			return 0;    // no action
		}
		if ( ! $this->_cfg_use_lame ) {
			return 0;    // no action
		}

		$this->_lame_class->wav_to_mp3( $src_file, $dst_file, $option );

		if ( is_file( $dst_file ) ) {
			$this->chmod_file( $dst_file );

			return 1;    // suceess
		}

		$this->set_error( $this->_lame_class->get_msg_array() );

		return - 1;    // fail
	}

}
