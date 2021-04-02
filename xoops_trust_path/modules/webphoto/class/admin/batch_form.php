<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief $MY_DIRNAME WEBPHOTO_TRUST_PATH are set by calle
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_admin_batch_form extends webphoto_edit_form {


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_batch_form( $dirname, $trust_dirname );
		}

		return $instance;
	}

	public function print_form_batch( $cat_selbox ) {
		$post_catid = $this->_post_class->get_post_int( 'cat_id' );

		echo $this->build_form_begin();
		echo $this->build_input_hidden( 'fct', 'batch' );

		echo $this->build_table_begin();
		echo $this->build_line_title( _AM_WEBPHOTO_PHOTOBATCHUPLOAD );

		echo $this->build_line_ele( _WEBPHOTO_PHOTO_TITLE, $this->_build_ba_ele_title() );
		echo $this->build_line_ele( _WEBPHOTO_PHOTO_DESCRIPTION, $this->_build_ba_ele_desc() );
		echo $this->build_line_ele( _WEBPHOTO_CATEGORY, $cat_selbox );
		echo $this->build_line_ele( _AM_WEBPHOTO_TEXT_DIRECTORY, $this->_build_ba_ele_dir() );
		echo $this->build_line_ele( _WEBPHOTO_SUBMITTER, $this->_build_ba_ele_uid() );
		echo $this->build_line_ele( _WEBPHOTO_PHOTO_TIME_UPDATE, $this->_build_ba_ele_update() );
		echo $this->build_line_submit();

		echo $this->build_table_end();
		echo $this->build_form_end();

	}

	public function _build_ba_ele_title() {
		$post_title = $this->_post_class->get_post_text( 'title' );

		$ele = $this->build_input_text( 'title', $this->sanitize( $post_title ) );
		$ele .= "<br>\n";
		$ele .= _WEBPHOTO_DSC_TITLE_BLANK;

		return $ele;
	}

	public function _build_ba_ele_desc() {
		$post_desc = $this->_post_class->get_post_text( 'desc' );
		$ele       = $this->build_form_dhtml( 'desc', $this->sanitize( $post_desc ) );

		return $ele;
	}

	public function _build_ba_ele_dir() {
		$post_dir = $this->_post_class->get_post_text( 'dir' );

		$ele = _AM_WEBPHOTO_PHOTOPATH . ' ';
		$ele .= $this->build_input_text( 'dir', $this->sanitize( $post_dir ) );
		$ele .= "<br>\n";
		$ele .= _AM_WEBPHOTO_DESC_PHOTOPATH;

		return $ele;
	}

	public function _build_ba_ele_update() {
		return $this->build_input_text( 'update', formatTimestamp( time(), _WEBPHOTO_DTFMT_YMDHI ) );
	}

	public function _build_ba_ele_uid() {
		$post_uid = $this->_post_class->get_post_int( 'uid', $this->_xoops_uid );

		return $this->build_form_user_select( 'uid', $post_uid );
	}
}
