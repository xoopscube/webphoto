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


class webphoto_video extends webphoto_lib_error {
	public $_mime_handler;
	public $_config_class;
	public $_utility_class;
	public $_ffmpeg_class;

	public $_cfg_use_ffmpeg = false;

	public $_thumb_id = 0;
	public $_flash_info = null;

	public $_cached_extra_array = array();

	public $_FLASHS_PATH;
	public $_TMP_DIR;

	public $_PLURAL_MAX = _C_WEBPHOTO_VIDEO_THUMB_PLURAL_MAX;
	public $_PLURAL_SECOND = 0;
	public $_PLURAL_FIRST = 0;
	public $_PLURAL_OFFSET = 1;

	public $_SINGLE_MAX = 1;
	public $_SINGLE_SECOND = 1;
	public $_SINGLE_FIRST = 0;

	public $_THUMB_PREFIX = _C_WEBPHOTO_VIDEO_THUMB_PREFIX;    // tmp_video_
	public $_THUMB_EXT = 'jpg';
	public $_ICON_EXT = 'png';
	public $_FLASH_EXT = _C_WEBPHOTO_VIDEO_FLASH_EXT;    // flv
	public $_FLASH_MIME = 'video/x-flv';
	public $_FLASH_MEDIUM = 'video';

	public $_DEBUG = false;


	public function __construct( $dirname ) {
		parent::__construct();

		$this->_mime_handler  =& webphoto_mime_handler::getInstance( $dirname );
		$this->_config_class  =& webphoto_config::getInstance( $dirname );
		$this->_utility_class =& webphoto_lib_utility::getInstance();

		$uploads_path = $this->_config_class->get_uploads_path();
		$work_dir     = $this->_config_class->get_by_name( 'workdir' );

		$this->_TMP_DIR     = $work_dir . '/tmp';
		$this->_FLASHS_PATH = $uploads_path . '/flashs';

		$cfg_ffmpegpath        = $this->_config_class->get_dir_by_name( 'ffmpegpath' );
		$this->_cfg_use_ffmpeg = $this->_config_class->get_by_name( 'use_ffmpeg' );

		$this->_ffmpeg_class =& webphoto_lib_ffmpeg::getInstance();
		$this->_ffmpeg_class->set_tmp_path( $this->_TMP_DIR );
		$this->_ffmpeg_class->set_cmd_path( $cfg_ffmpegpath );
		$this->_ffmpeg_class->set_ext( $this->_THUMB_EXT );

		$constpref = strtoupper( '_P_' . $dirname . '_' );
		$this->set_debug_by_const_name( $constpref . 'DEBUG_VIDEO' );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_video( $dirname );
		}

		return $instance;
	}


// set param

	public function set_flag_chmod( $val ) {
		$this->_ffmpeg_class->set_flag_chmod( $val );
	}


// duration

	public function get_duration_size( $file ) {
		if ( ! $this->_cfg_use_ffmpeg ) {
			return null;
		}

		return $this->_ffmpeg_class->get_duration_size( $file );
	}


// thumb

	public function create_plural_thumbs( $id, $file ) {
		if ( ! $this->_cfg_use_ffmpeg ) {
			return false;
		}

		$this->_thumb_id = $id;

		$this->_ffmpeg_class->set_prefix( $this->build_ffmpeg_prefix( $id ) );
		$this->_ffmpeg_class->set_offset( $this->_PLURAL_OFFSET );

		return $this->_ffmpeg_class->create_thumbs(
			$file, $this->_PLURAL_MAX, $this->_PLURAL_SECOND );
	}

	public function create_single_thumb( $id, $file ) {
		$path = null;

		if ( ! $this->_cfg_use_ffmpeg ) {
			return $path;
		}

		$this->_ffmpeg_class->set_prefix( $this->build_ffmpeg_prefix( $id ) );

		$count = $this->_ffmpeg_class->create_thumbs(
			$file, $this->_SINGLE_MAX, $this->_SINGLE_SECOND );
		if ( $count ) {
			$path = $this->_TMP_DIR . '/' . $this->build_thumb_name( $id, $this->_SINGLE_FIRST, false );
		} else {
			$errors = $this->_ffmpeg_class->get_errors();
			$this->set_error( $errors );
			if ( $this->_DEBUG ) {
				print_r( $errors );
			}
		}

		return $path;
	}

	public function build_ffmpeg_prefix( $id ) {
// prefix_123_
		$str = $this->_THUMB_PREFIX . $id . '_';

		return $str;
	}

	public function build_thumb_name( $id, $num ) {
// prefix_123_456.jpg
		$str = $this->build_thumb_node( $id, $num ) . '.' . $this->_THUMB_EXT;

		return $str;
	}

	public function build_thumb_node( $id, $num ) {
// prefix_123_456
		$str = $this->build_ffmpeg_prefix( $id ) . $num;

		return $str;
	}

	public function get_first_thumb_node() {
		return $this->build_thumb_node( $this->_thumb_id, $this->_PLURAL_FIRST );
	}

	public function get_thumb_ext() {
		return $this->_THUMB_EXT;
	}


// flash

	public function create_flash( $file_in, $name_out ) {
		$this->_flash_param = null;

		$ext = $this->_utility_class->parse_ext( $file_in );

		if ( ! $this->_cfg_use_ffmpeg ) {
			return _C_WEBPHOTO_VIDEO_SKIPPED;
		}

// return input file is flash video
		if ( $ext == $this->_FLASH_EXT ) {
			return _C_WEBPHOTO_VIDEO_SKIPPED;
		}

		$path_out = $this->_FLASHS_PATH . '/' . $name_out;
		$file_out = XOOPS_ROOT_PATH . $path_out;
		$url_out  = XOOPS_URL . $path_out;
		$extra    = $this->get_cached_extra_by_ext( $ext );

		$ret = $this->_ffmpeg_class->create_flash( $file_in, $file_out, $extra );
		if ( ! $ret ) {
			$this->_utility_class->unlink_file( $file_out );
			$errors = $this->_ffmpeg_class->get_errors();
			$this->set_error( $errors );
			if ( $this->_DEBUG ) {
				print_r( $errors );
			}

			return _C_WEBPHOTO_VIDEO_FAILED;
		}

		$this->_flash_param = array(
			'url'    => $url_out,
			'path'   => $path_out,
			'name'   => $name_out,
			'ext'    => $this->_FLASH_EXT,
			'mime'   => $this->_FLASH_MIME,
			'medium' => $this->_FLASH_MEDIUM,
			'size'   => filesize( $file_out ),
		);

		return _C_WEBPHOTO_VIDEO_CREATED;
	}

	public function get_flash_param() {
		return $this->_flash_param;
	}

	public function get_flash_ext() {
		return $this->_FLASH_EXT;
	}


// mime

	public function get_cached_extra_by_ext( $ext ) {
		if ( isset( $this->_cached_extra_array[ $ext ] ) ) {
			return $this->_cached_extra_array[ $ext ];
		}

		$row = $this->_mime_handler->get_cached_row_by_ext( $ext );
		if ( ! is_array( $row ) ) {
			return false;
		}

		$extra                             = trim( $row['mime_ffmpeg'] );
		$this->_cached_extra_array[ $ext ] = $extra;

		return $extra;
	}


// debug

	public function set_debug_by_const_name( $name ) {
		if ( defined( $name ) ) {
			$val = constant( $name );
			$this->set_debug( $val );
			$this->_ffmpeg_class->set_debug( $val );
		}
	}

	public function set_debug( $val ) {
		$this->_DEBUG = (bool) $val;
	}

}
