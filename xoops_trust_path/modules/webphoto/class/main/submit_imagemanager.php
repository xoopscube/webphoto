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


class webphoto_main_submit_imagemanager extends webphoto_edit_imagemanager_submit {
	public $_THIS_CLOSE_FCT = 'close';
	public $_THIS_CLOSE_URL;

	public $_TIME_SUCCESS = 3;
	public $_TIME_FAILED = 5;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_THIS_CLOSE_URL = $this->_MODULE_URL . '/index.php?fct=' . $this->_THIS_CLOSE_FCT;
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_main_submit_imagemanager( $dirname, $trust_dirname );
		}

		return $instance;
	}


// main

	public function main() {
		$ret = $this->submit_check();
		if ( ! $ret ) {
			redirect_header(
				$this->get_redirect_url(),
				$this->get_redirect_time(),
				$this->get_redirect_msg()
			);
			exit();
		}

		$op = $this->get_post_text( 'op' );
		switch ( $op ) {
			case 'submit':
				$this->_submit();
				break;
		}

		$this->_print_form_imagemanager();
	}


// create item row

	public function _create_item_row_default() {
		$row                = $this->_item_create_class->create( true );
		$row['item_cat_id'] = $this->get_post_cat_id();

		return $row;
	}

	public function _create_item_row_by_post() {
		$row                = $this->_item_create_class->create( true );
		$row['item_cat_id'] = $this->get_post_cat_id();
		$row['item_title']  = $this->get_post_text( 'item_title' );

		return $row;
	}


// submit

	public function _submit() {
		$is_failed = false;

// exit if error
		$this->check_token_and_redirect( $this->_THIS_CLOSE_URL, $this->_TIME_FAILED );

		$ret1 = $this->_submit_exec();
		$ret2 = $this->build_failed_msg( $ret1 );
		if ( ! $ret2 ) {
			$is_failed = true;
		}

		list( $url, $time, $msg ) = $this->build_redirect(
			$this->_build_redirect_param( $is_failed ) );

		redirect_header( $url, $time, $msg );
		exit();
	}

	public function _submit_exec() {
		$this->clear_msg_array();

		$item_row = $this->_create_item_row_by_post();

		$ret = $this->submit_exec_check( $item_row );
		if ( $ret < 0 ) {
			return $ret;
		}

		$ret = $this->_submit_exec_fetch( $item_row );
		if ( $ret < 0 ) {
			return $ret;
		}

		$item_row   = $this->_row_fetch;
		$photo_name = $this->_photo_tmp_name;

// --- insert item ---
		$item_row = $this->build_item_row_submit_insert( $item_row );
		$item_id  = $this->format_and_insert_item( $item_row );
		if ( ! $item_id ) {
			return _C_WEBPHOTO_ERR_DB;
		}

		$item_row['item_id'] = $item_id;
		$this->_row_create   = $item_row;

// --- insert files
		$ret = $this->_insert_media_files( $item_row, $photo_name );
		if ( $ret < 0 ) {
			return $ret;
		}

// --- update item ---
		$item_row = $this->build_item_row_submit_update( $item_row );
		$ret      = $this->format_and_update_item( $item_row );
		if ( ! $ret ) {
			return _C_WEBPHOTO_ERR_DB;
		}
		$this->_row_create = $item_row;

		$this->unlink_uploaded_files();
	}

	public function _submit_exec_fetch( $item_row ) {
		$this->_row_fetch = $item_row;

// Check if upload file name specified
		if ( ! $this->check_xoops_upload_file( $flag_thumb = false ) ) {
			return _C_WEBPHOTO_ERR_NO_SPECIFIED;
		}

		$ret = $this->submit_exec_fetch_photo( $item_row );
		if ( $ret < 0 ) {
			return $ret;    // failed
		}
		if ( empty( $this->_photo_tmp_name ) ) {
			return _C_WEBPHOTO_ERR_NO_IMAGE;
		}

		return 0;
	}

	public function _build_redirect_param( $is_failed ) {
		$param = array(
			'is_failed'   => $is_failed,
			'url_success' => $this->_THIS_CLOSE_URL,
			'url_failed'  => $this->_THIS_CLOSE_URL,
			'msg_success' => $this->get_constant( 'SUBMIT_RECEIVED' ),
		);

		return $param;
	}


// media files 

	public function _insert_media_files( $item_row ) {
		$ret = $this->_create_media_file_params( $item_row );
		if ( $ret < 0 ) {
			return $ret;
		}

// --- insert file ---
		$this->_file_id_array = $this->insert_media_files_from_params( $item_row );

		return 0;
	}

	public function _create_media_file_params( $item_row ) {
		$item_ext = $item_row['item_ext'];

		$this->init_photo_create();
		$photo_param = $this->build_photo_param( $item_row );

		list( $ret, $cont_param ) = $this->create_cont_param( $photo_param );
		if ( $ret < 0 ) {
			return $ret;
		}

		$file_params = array(
			'cont' => $cont_param,
		);

		if ( is_array( $cont_param ) ) {
			$image_params = $this->create_image_params_by_photo( $photo_param );
			if ( is_array( $image_params ) ) {
				$file_params = $file_params + $image_params;
			}
		}

		$this->_media_file_params = $file_params;

		return 0;
	}


// print form

	public function _print_form_imagemanager() {
		$form_class =& webphoto_edit_imagemanager_form::getInstance(
			$this->_DIRNAME, $this->_TRUST_DIRNAME );

		$template = 'db:' . $this->_DIRNAME . '_main_submit_imagemanager.html';

		$row = $this->_create_item_row_default();

		$param = array(
			'has_resize'   => $this->_has_image_resize,
			'allowed_exts' => $this->get_normal_exts(),
		);

		$arr                   = $form_class->build_form_imagemanager( $row, $param );
		$arr['xoops_themecss'] = $this->_xoops_class->get_xoops_themecss();

		$tpl = new XoopsTpl();
		$tpl->assign( $arr );
		$tpl->display( $template );
	}

}
