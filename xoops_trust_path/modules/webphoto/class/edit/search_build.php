<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_edit_search_build {
	public $_item_handler;
	public $_file_handler;
	public $_cat_handler;
	public $_syno_handler;
	public $_tag_build_class;

	public $_DIRNAME;
	public $_MODULE_URL;
	public $_MODULE_DIR;

	public $_SPACE = ' ';

	public function __construct( $dirname, $trust_dirname ) {
		$this->_DIRNAME    = $dirname;
		$this->_MODULE_URL = XOOPS_URL . '/modules/' . $dirname;
		$this->_MODULE_DIR = XOOPS_ROOT_PATH . '/modules/' . $dirname;

		$this->_item_handler
			=& webphoto_item_handler::getInstance( $dirname, $trust_dirname );
		$this->_cat_handler
			=& webphoto_cat_handler::getInstance( $dirname, $trust_dirname );
		$this->_file_handler
			=& webphoto_file_handler::getInstance( $dirname, $trust_dirname );
		$this->_syno_handler
			=& webphoto_syno_handler::getInstance( $dirname, $trust_dirname );
		$this->_tag_build_class
			=& webphoto_tag_build::getInstance( $dirname, $trust_dirname );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_search_build( $dirname, $trust_dirname );
		}

		return $instance;
	}


// insert

	public function build_with_tag( $row ) {
		$tag_array = $this->_tag_build_class->get_tag_name_array_by_photoid( $row['item_id'] );

		return $this->build_search( $row, $tag_array );
	}

	public function build_row( $row, $tag_name_array = null ) {
		$row['item_search'] = $this->build_search( $row, $tag_name_array );

		return $row;
	}

	public function build_search( $row, $tag_name_array = null ) {
		$str = $this->_item_handler->build_search( $row );
		$str .= $this->get_category( $row );
		$str .= $this->get_tag( $tag_name_array );
		$str .= $this->get_synonym();

		return $str;
	}

	public function get_category( $row ) {
		$str      = $this->_SPACE;
		$cat_rows = $this->_cat_handler->get_parent_path_array( $row['item_cat_id'] );
		foreach ( $cat_rows as $cat_row ) {
			$str .= $cat_row['cat_title'] . $this->_SPACE;
		}

		return $str;
	}

	public function get_tag( $tag_name_array ) {
		if ( ! is_array( $tag_name_array ) || ! count( $tag_name_array ) ) {
			return '';
		}

		$str = $this->_SPACE;
		foreach ( $tag_name_array as $tag_name ) {
			$str .= $tag_name . $this->_SPACE;
		}

		return $str;
	}

	public function get_synonym() {
		$syno_rows = $this->_syno_handler->get_rows_orderby_weight_asc();
		if ( ! is_array( $syno_rows ) || ! count( $syno_rows ) ) {
			return '';
		}

		$str = $this->_SPACE;
		foreach ( $syno_rows as $syno_row ) {
			$key = $syno_row['syno_key'];
			$val = $syno_row['syno_value'];
			if ( ( strpos( $str, $key ) > 0 ) && ( strpos( $str, $val ) === false ) ) {
				$str .= $val . $this->_SPACE;
			}
		}

		return $str;
	}
}
