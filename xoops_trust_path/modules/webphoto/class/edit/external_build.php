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


class webphoto_edit_external_build {
	public $_item_row = null;

	public $_THUMB_EXT_DEFAULT = 'external';

	public function __construct( $dirname ) {
		$this->_utility_class    =& webphoto_lib_utility::getInstance();
		$this->_kind_class       =& webphoto_kind::getInstance();
		$this->_icon_build_class =& webphoto_edit_icon_build::getInstance( $dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_external_build( $dirname );
		}

		return $instance;
	}


	public function is_type( $row ) {
		if ( $row['item_external_url'] ) {
			return true;
		}

		return false;
	}

	public function build( $row ) {
		$this->_item_row = $row;

		$item_title          = $row['item_title'];
		$item_external_url   = $row['item_external_url'];
		$item_external_thumb = $row['item_external_thumb'];

		if ( ! $this->is_type( $row ) ) {
			return 1;    // no action
		}

		$item_ext        = $this->parse_ext( $item_external_url );
		$row['item_ext'] = $item_ext;

		if ( $this->is_image_ext( $item_ext ) ) {
			$row['item_kind'] = _C_WEBPHOTO_ITEM_KIND_EXTERNAL_IMAGE;

			if ( empty( $item_external_thumb ) ) {
				$row['item_external_thumb'] = $item_external_url;
			}

		} else {
			$row['item_kind'] = _C_WEBPHOTO_ITEM_KIND_EXTERNAL_GENERAL;
		}

		if ( empty( $item_title ) ) {
			$row['item_title'] = $this->build_title( $row );
		}

		$row = $this->build_row_icon_if_empty( $row, $this->_THUMB_EXT_DEFAULT );

		$this->_item_row = $row;

		return 0;    // OK
	}

	public function build_title( $row ) {
		$file  = $this->parse_url_to_filename( $row['item_external_url'] );
		$title = $this->strip_ext( $file );

		return $title;
	}

	public function get_item_row() {
		return $this->_item_row;
	}


// icon

	public function build_row_icon_if_empty( $row, $ext = null ) {
		return $this->_icon_build_class->build_row_icon_if_empty( $row, $ext );
	}


// kind class

	public function is_image_ext( $ext ) {
		return $this->_kind_class->is_image_ext( $ext );
	}


// utility

	public function parse_ext( $file ) {
		return $this->_utility_class->parse_ext( $file );
	}

	public function strip_ext( $file ) {
		return $this->_utility_class->strip_ext( $file );
	}

	public function parse_url_to_filename( $url ) {
		return $this->_utility_class->parse_url_to_filename( $url );
	}

}

