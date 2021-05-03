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


class webphoto_edit_base extends webphoto_base_this {
	public $_item_create_class;
	public $_mime_class;
	public $_icon_build_class;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_item_create_class =& webphoto_edit_item_create::getInstance( $dirname, $trust_dirname );
		$this->_mime_class		  =& webphoto_mime::getInstance( $dirname, $trust_dirname );
		$this->_icon_build_class  =& webphoto_edit_icon_build::getInstance( $dirname );
	}


// check dir
// BUG : wrong judgment in check_dir
	public function check_dir( $dir ) {
		if ( $dir && is_dir( $dir ) && is_writable( $dir ) && is_readable( $dir ) ) {
			return 0;
		}
		$this->set_error( 'dir error : ' . $dir );

		return _C_WEBPHOTO_ERR_CHECK_DIR;
	}


// post class

	public function get_post_text( $key, $default = null ) {
		return $this->_post_class->get_post_text( $key, $default );
	}

	public function get_post_int( $key, $default = 0 ) {
		return $this->_post_class->get_post_int( $key, $default );
	}

	public function get_post_float( $key, $default = 0 ) {
		return $this->_post_class->get_post_float( $key, $default );
	}

	public function get_post( $key, $default = null ) {
		return $this->_post_class->get_post( $key, $default );
	}


// item create class

	public function format_and_insert_item( $row, $flag_force = false ) {
		$newid = $this->_item_create_class->format_and_insert(
			$row, $flag_force );
		if ( ! $newid ) {
			$this->set_error( $this->_item_create_class->get_errors() );

			return false;
		}

		return $newid;
	}

	public function format_and_update_item( $row, $flag_force = false ) {
		$ret = $this->_item_create_class->format_and_update(
			$row, $flag_force );
		if ( ! $ret ) {
			$this->set_error( $this->_item_create_class->get_errors() );

			return false;
		}

		return true;
	}


// mime class

	public function ext_to_kind( $ext ) {
		return $this->_mime_class->ext_to_kind( $ext );
	}

	public function get_my_allowed_mimes() {
		return $this->_mime_class->get_my_allowed_mimes();
	}

	public function is_my_allow_ext( $ext ) {
		return $this->_mime_class->is_my_allow_ext( $ext );
	}


// icon

	public function build_item_row_icon_if_empty( $row, $ext = null ) {
		return $this->_icon_build_class->build_row_icon_if_empty( $row, $ext );
	}

	public function build_icon_image( $ext ) {
		return $this->_icon_build_class->build_icon_image( $ext );
	}


// timestamp

	public function get_server_time_by_post( $key, $default = 0 ) {
		$time = $this->_post_class->get_post_time( $key, $default );
		if ( $time > 0 ) {
			return $this->user_to_server_time( $time );
		} else {
			return $default;
		}
	}


// tmp dir

	public function build_tmp_dir_file( $name ) {
		return $this->_TMP_DIR . '/' . $name;
	}

	public function unlink_tmp_dir_file( $name ) {
		if ( $name ) {
			$this->unlink_file( $this->build_tmp_dir_file( $name ) );
		}
	}

	public function build_file_dir_file( $name ) {
		return $this->_FILE_DIR . '/' . $name;
	}


// msg

	public function check_msg_level_admin() {
		return $this->check_msg_level( _C_WEBPHOTO_MSG_LEVEL_ADMIN );
	}

	public function check_msg_level_user() {
		return $this->check_msg_level( _C_WEBPHOTO_MSG_LEVEL_USER );
	}

	public function set_msg_level_admin( $msg, $flag_highlight = false, $flag_br = false ) {
		if ( ! $this->check_msg_level_admin() ) {
			return;    // no action
		}
		$str = $this->build_msg( $msg, $flag_highlight, $flag_br );
		if ( $str ) {
			$this->set_msg( $str );
		}
	}

	public function set_msg_level_user( $msg, $flag_highlight = false, $flag_br = false ) {
		if ( ! $this->check_msg_level_user() ) {
			return;    // no action
		}
		$str = $this->build_msg( $msg, $flag_highlight, $flag_br );
		if ( $str ) {
			$this->set_msg( $str );
		}
	}

}
