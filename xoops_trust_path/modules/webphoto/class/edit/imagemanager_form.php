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


class webphoto_edit_imagemanager_form extends webphoto_edit_form {

	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->init_preload();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_imagemanager_form( $dirname, $trust_dirname );
		}

		return $instance;
	}


// imagemanager

	public function build_form_imagemanager( $row, $param ) {
		return array_merge(
			$this->build_form_base_param(),
			$this->build_form_submit_imagemanager( $row, $param )
		);
	}

	public function build_form_submit_imagemanager( $row, $param ) {
		$has_resize   = $param['has_resize'];
		$allowed_exts = $param['allowed_exts'];

		$this->set_row( $row );

		return array(
			'max_file_size'        => $this->_cfg_fsize,
			'ele_maxpixel'         => $this->ele_maxpixel( $has_resize ),
			'ele_maxsize'          => $this->ele_maxsize(),
			'ele_allowed_exts'     => $this->ele_allowed_exts( $allowed_exts ),
			'ele_item_description' => $this->item_description_dhtml(),
			'item_cat_id_options'  => $this->item_cat_id_options(),
		);
	}

}

