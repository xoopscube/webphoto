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


class webphoto_edit_icon_build {

	public $_DIRNAME;
	public $_MODULE_URL;
	public $_MODULE_DIR;
	public $_ROOT_EXTS_DIR;
	public $_ROOT_EXTS_URL;

	public $_EXT_PNG = 'png';
	public $_ICON_NAME_DEFAULT = 'default.png';

	public function __construct( $dirname ) {

		$this->_DIRNAME    = $dirname;
		$this->_MODULE_URL = XOOPS_URL . '/modules/' . $dirname;
		$this->_MODULE_DIR = XOOPS_ROOT_PATH . '/modules/' . $dirname;

		$this->_ROOT_EXTS_URL = $this->_MODULE_URL . '/images/exts';
		$this->_ROOT_EXTS_DIR = $this->_MODULE_DIR . '/images/exts';
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {

		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_icon_build( $dirname );
		}

		return $instance;
	}


// icon

	public function build_row_icon_if_empty( $row, $ext = null ) {

		if ( $row[ _C_WEBPHOTO_ITEM_FILE_THUMB ] ) {
			return $row;
		}
		if ( $row['item_external_thumb'] ) {
			return $row;
		}
		if ( $row['item_icon_name'] ) {
			return $row;
		}

		return $this->build_row_icon( $row, $ext );
	}

	public function build_row_icon( $row, $ext = null ) {
		if ( empty( $ext ) ) {
			$ext = $row['item_ext'];
		}
		if ( empty( $ext ) ) {
			return $row;
		}

		[ $name, $width, $height ] = $this->build_icon_image( $ext );
		$row['item_icon_name']   = $name;
		$row['item_icon_width']  = $width;
		$row['item_icon_height'] = $height;

		return $row;
	}

	public function build_icon_image( $ext ) {
		$name   = null;
		$width  = 0;
		$height = 0;

		if ( $ext ) {
			$name = $ext . '.' . $this->_EXT_PNG;
			$file = $this->_ROOT_EXTS_DIR . '/' . $name;
			if ( ! is_file( $file ) ) {
				$name = $this->_ICON_NAME_DEFAULT;
				$file = $this->_ROOT_EXTS_DIR . '/' . $name;
			}
			$size = getimagesize( $file );
			if ( is_array( $size ) ) {
				$width  = $size[0];
				$height = $size[1];
			}
		}

		return array( $name, $width, $height );
	}

}

