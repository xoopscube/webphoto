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


class webphoto_photo_build extends webphoto_lib_error {
	public $_item_handler;
	public $_cat_handler;
	public $_syno_handler;

	public $_DIRNAME;
	public $_MODULE_URL;
	public $_MODULE_DIR;


	public function __construct( $dirname ) {
		parent::__construct();

		$this->_DIRNAME    = $dirname;
		$this->_MODULE_URL = XOOPS_URL . '/modules/' . $dirname;
		$this->_MODULE_DIR = XOOPS_ROOT_PATH . '/modules/' . $dirname;

		$this->_item_handler =& webphoto_item_handler::getInstance( $dirname );
		$this->_cat_handler  =& webphoto_cat_handler::getInstance( $dirname );
		$this->_syno_handler =& webphoto_syno_handler::getInstance( $dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_photo_build( $dirname );
		}

		return $instance;
	}


// insert

	public function build_search_with_tag( $row ) {
		$tag_class =& webphoto_tag::getInstance( $this->_DIRNAME );

		return $this->build_search(
			$row,
			$tag_class->get_tag_name_array_by_photoid( $row['item_id'] ) );
	}

	public function build_search( $row, $tag_name_array = null ) {
		$str = $this->_item_handler->build_search( $row );
		$str .= ' ';

// add category
		$cat_rows = $this->_cat_handler->get_parent_path_array( $row['item_cat_id'] );
		foreach ( $cat_rows as $cat_row ) {
			$str .= $cat_row['cat_title'] . ' ';
		}

// add tag
		if ( is_array( $tag_name_array ) && count( $tag_name_array ) ) {
			foreach ( $tag_name_array as $tag_name ) {
				$str .= $tag_name . ' ';
			}
		}

// add synonym
		$syno_rows = $this->_syno_handler->get_rows_orderby_weight_asc();
		if ( is_array( $syno_rows ) && count( $syno_rows ) ) {
			foreach ( $syno_rows as $syno_row ) {
				$key = $syno_row['syno_key'];
				$val = $syno_row['syno_value'];
				if ( ( strpos( $str, $key ) > 0 ) && ( strpos( $str, $val ) === false ) ) {
					$str .= $val . ' ';
				}
			}
		}

		return $str;
	}

}
