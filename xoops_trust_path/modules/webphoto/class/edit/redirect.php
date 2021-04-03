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


class webphoto_edit_redirect extends webphoto_edit_base {
	public $_redirect_time = 0;
	public $_redirect_url = null;
	public $_redirect_msg = null;

	public $_TIME_SUCCESS = 1;
	public $_TIME_PENDING = 3;
	public $_TIME_FAILED = 5;
	public $_URL_SUCCESS = null;
	public $_URL_PENDING = null;
	public $_URL_FAILED = null;
	public $_MSG_SUCCESS = 'success';
	public $_MSG_PENDING = 'pending';
	public $_MSG_FAILED = 'failed';

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->preload_init();
		$this->preload_constant();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_redirect( $dirname, $trust_dirname );
		}

		return $instance;
	}


// build failed msg

	public function build_failed_msg( $ret ) {
		switch ( $ret ) {
			case _C_WEBPHOTO_ERR_DB:
				$this->set_error_in_head_with_admin_info( 'DB Error' );

				return false;

			case _C_WEBPHOTO_ERR_UPLOAD;
				$this->set_error_in_head( 'File Upload Error' );

				return false;

			case _C_WEBPHOTO_ERR_NO_SPECIFIED:
				$this->set_error( 'UPLOAD error: file name not specified' );

				return false;

			case _C_WEBPHOTO_ERR_EXT:
				$this->set_error_by_const_name( 'UPLOADER_ERR_NOT_ALLOWED_EXT' );

				return false;

			case _C_WEBPHOTO_ERR_FILE_SIZE:
				$this->set_error_by_const_name( 'UPLOADER_ERR_LARGE_FILE_SIZE' );

				return false;

			case _C_WEBPHOTO_ERR_NO_PERM:
				$this->set_error( _NOPERM );

				return false;

			case _C_WEBPHOTO_ERR_NO_RECORD:
				$this->set_error_by_const_name( 'NOMATCH_PHOTO' );

				return false;

			case _C_WEBPHOTO_ERR_EMPTY_CAT:
				$this->set_error_by_const_name( 'ERR_EMPTY_CAT' );

				return false;

			case _C_WEBPHOTO_ERR_INVALID_CAT:
				$this->set_error_by_const_name( 'ERR_INVALID_CAT' );

				return false;

			case _C_WEBPHOTO_ERR_EMPTY_FILE:
				$this->set_error_by_const_name( 'ERR_EMPTY_FILE' );

				return false;

			case _C_WEBPHOTO_ERR_FILE:
				$this->set_error_by_const_name( 'ERR_FILE' );

				return false;

			case _C_WEBPHOTO_ERR_NO_IMAGE;
				$this->set_error_by_const_name( 'ERR_NOIMAGESPECIFIED' );

				return false;

			case _C_WEBPHOTO_ERR_FILEREAD:
				$this->set_error_by_const_name( 'ERR_FILEREAD' );

				return false;

			case _C_WEBPHOTO_ERR_NO_TITLE:
				$this->set_error_by_const_name( 'ERR_TITLE' );

				return false;

			case _C_WEBPHOTO_ERR_EMBED:
				$this->set_error_by_const_name( 'ERR_EMBED' );

				return false;

			case _C_WEBPHOTO_ERR_PLAYLIST:
				$this->set_error_by_const_name( 'ERR_PLAYLIST' );

				return false;

			case _C_WEBPHOTO_ERR_CREATE_PHOTO:
				$this->set_error_by_const_name( 'ERR_CREATE_PHOTO' );

				return false;

			case 0:
			default:
				break;
		}

		return true;
	}


// redirect

	public function build_redirect( $param ) {
		$is_failed  = isset( $param['is_failed'] ) ? (bool) $param['is_failed'] : false;
		$is_pending = isset( $param['is_pending'] ) ? (bool) $param['is_pending'] : false;

		$has_extra_msg = isset( $param['has_extra_msg'] ) ?
			(bool) $param['has_extra_msg'] : $this->has_msg_array();

		$url_success = $param['url_success'] ?? $this->_URL_SUCCESS;

		$url_pending = $param['url_pending'] ?? $this->_URL_PENDING;

		$url_failed = $param['url_failed'] ?? $this->_URL_FAILED;

		$time_success = isset( $param['time_success'] ) ?
			(int) $param['time_success'] : $this->_TIME_SUCCESS;

		$time_pending = isset( $param['time_pending'] ) ?
			(int) $param['time_pending'] : $this->_TIME_PENDING;

		$time_failed = isset( $param['time_failed'] ) ?
			(int) $param['time_failed'] : $this->_TIME_FAILED;

		$msg_success = $param['msg_success'] ?? $this->_MSG_SUCCESS;

		$msg_pending = $param['msg_pending'] ?? $this->_MSG_PENDING;

		$msg_failed = $param['msg_failed'] ?? $this->get_format_error();

		if ( empty( $msg_failed ) ) {
			$msg_failed = $this->_MSG_FAILED;
		}

		$msg_extra = $param['msg_extra'] ?? ( $this->get_format_msg_array() . '<br>' . $msg_success );

// pending
		if ( $is_failed ) {
			$url  = $url_failed;
			$time = $time_failed;
			$msg  = $msg_failed;

// pending
		} elseif ( $is_pending ) {
			$url  = $url_pending;
			$time = $time_pending;
			$msg  = $msg_pending;

// has msg
		} elseif ( $has_extra_msg ) {
			$url  = $url_success;
			$time = $time_pending;
			$msg  = $msg_extra;

// success
		} else {
			$url  = $url_success;
			$time = $time_success;
			$msg  = $msg_success;
		}

		$this->_redirect_url  = $url;
		$this->_redirect_time = $time;
		$this->_redirect_msg  = $msg;

		return array( $url, $time, $msg );
	}


// set & get param

	public function get_redirect_url() {
		return $this->_redirect_url;
	}

	public function get_redirect_time() {
		return $this->_redirect_time;
	}

	public function get_redirect_msg() {
		return $this->_redirect_msg;
	}

	public function get_time_success() {
		return $this->_TIME_SUCCESS;
	}

	public function get_time_pending() {
		return $this->_TIME_PENDING;
	}

	public function get_time_failed() {
		return $this->_TIME_FAILED;
	}

	public function set_error_by_const_name( $name ) {
		$this->set_error( $this->get_constant( $name ) );
	}

}
