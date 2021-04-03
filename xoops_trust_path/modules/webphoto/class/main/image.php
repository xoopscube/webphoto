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


class webphoto_main_image extends webphoto_file_read {
	public $_readfile_class;
	public $_kind_class;

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_readfile_class =& webphoto_lib_readfile::getInstance();
		$this->_kind_class     =& webphoto_kind::getInstance();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_main_image( $dirname, $trust_dirname );
		}

		return $instance;
	}


// public

	public function main() {
		$item_id   = $this->_post_class->get_post_get_int( 'item_id' );
		$file_kind = $this->_post_class->get_post_get_int( 'file_kind' );

		$item_row = $this->get_item_row( $item_id );
		if ( ! is_array( $item_row ) ) {
			exit();
		}

		$file_row = $this->get_file_row( $item_row, $file_kind );
		if ( ! is_array( $file_row ) ) {
			exit();
		}

//print_r($file_row);

		$ext  = $file_row['file_ext'];
		$mime = $file_row['file_mime'];
		$size = $file_row['file_size'];

// Notice [PHP]: Undefined index: file_full
		$file = $file_row['full_path'];

		if ( ! $this->_kind_class->is_image_ext( $ext ) ) {
			exit();
		}

		$this->_readfile_class->readfile_view( $file, $mime );

		exit();
	}

// --- class end ---
}

?>
