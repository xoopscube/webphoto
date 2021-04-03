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


class webphoto_ffmpeg extends webphoto_cmd_base {
	public $_ffmpeg_class;

	public $_cfg_use_ffmpeg = false;

	public $_thumb_id = 0;

	public $_PLURAL_MAX = _C_WEBPHOTO_VIDEO_THUMB_PLURAL_MAX;
	public $_PLURAL_SECOND = 0;
	public $_PLURAL_FIRST = 0;
	public $_PLURAL_OFFSET = 1;

	public $_SINGLE_SECOND = 1;

	public $_THUMB_PREFIX = _C_WEBPHOTO_VIDEO_THUMB_PREFIX;    // tmp_ffmpeg_

	public $_CMD_FFMPEG = 'ffmpeg';


// constructor

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
		//$this->webphoto_cmd_base( $dirname, $trust_dirname );

		$this->_cfg_use_ffmpeg = $this->_config_class->get_by_name( 'use_ffmpeg' );
		$cfg_ffmpegpath        = $this->_config_class->get_dir_by_name( 'ffmpegpath' );

		$this->_ffmpeg_class =& webphoto_lib_ffmpeg::getInstance();
		$this->_ffmpeg_class->set_tmp_path( $this->_TMP_DIR );
		$this->_ffmpeg_class->set_cmd_path( $cfg_ffmpegpath );
		$this->_ffmpeg_class->set_ext( $this->_JPEG_EXT );
		$this->_ffmpeg_class->set_flag_chmod( true );

		$this->set_debug_by_ini_name( $this->_ffmpeg_class );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_ffmpeg( $dirname, $trust_dirname );
		}

		return $instance;
	}


// duration

	function get_video_info( $file ) {
		if ( ! $this->_cfg_use_ffmpeg ) {
			return null;
		}

		return $this->_ffmpeg_class->get_video_info( $file );
	}


// create jpeg

	function create_jpeg( $src_file, $dst_file ) {
		if ( ! $this->_cfg_use_ffmpeg ) {
			return 0;
		}

		$this->_ffmpeg_class->create_single_thumb( $src_file, $dst_file, $this->_SINGLE_SECOND );
		if ( ! is_file( $dst_file ) ) {
			return - 1;
		}

		return 1;
	}


// plural images

	function create_plural_images( $id, $file ) {
		if ( ! $this->_cfg_use_ffmpeg ) {
			return false;
		}

		$this->_ffmpeg_class->set_prefix( $this->build_ffmpeg_prefix( $id ) );
		$this->_ffmpeg_class->set_offset( $this->_PLURAL_OFFSET );

		$count = $this->_ffmpeg_class->create_thumbs(
			$file, $this->_PLURAL_MAX, $this->_PLURAL_SECOND );

		if ( $count == 0 ) {
			$this->set_error( $this->_ffmpeg_class->get_msg_array() );

			return - 1;
		}

		return 1;
	}

	function build_ffmpeg_prefix( $id ) {
// prefix_123_
		$str = $this->_THUMB_PREFIX . $id . '_';

		return $str;
	}

// for misc_form
	function build_thumb_name( $id, $num ) {
// prefix_123_456.jpg
		$str = $this->build_thumb_node( $id, $num ) . '.' . $this->_JPEG_EXT;

		return $str;
	}

	function build_thumb_node( $id, $num ) {
// prefix_123_456
		$str = $this->build_ffmpeg_prefix( $id ) . $num;

		return $str;
	}


// flash

	function create_flash( $src_file, $dst_file, $option = null ) {
		if ( empty( $option ) ) {
			$option = $this->get_cmd_option( $src_file, $this->_CMD_FFMPEG );
		}

		$ret = $this->_ffmpeg_class->create_flash( $src_file, $dst_file, $option );
		if ( ! $ret ) {
			$this->set_error( $this->_ffmpeg_class->get_msg_array() );
		}

		return $ret;
	}


// mp3

	function create_mp3( $src_file, $dst_file, $option = null ) {
		if ( empty( $option ) ) {
			$option = $this->get_cmd_option( $src_file, $this->_CMD_FFMPEG );
		}

		$ret = $this->_ffmpeg_class->create_mp3( $src_file, $dst_file, $option );
		if ( ! $ret ) {
			$this->set_error( $this->_ffmpeg_class->get_msg_array() );
		}

		return $ret;
	}


// wav

	function create_wav( $src_file, $dst_file, $option = null ) {
		if ( empty( $option ) ) {
			$option = $this->get_cmd_option( $src_file, $this->_CMD_FFMPEG );
		}

		$ret = $this->_ffmpeg_class->create_wav( $src_file, $dst_file, $option );
		if ( ! $ret ) {
			$this->set_error( $this->_ffmpeg_class->get_msg_array() );
		}

		return $ret;
	}

// --- class end ---
}

?>
