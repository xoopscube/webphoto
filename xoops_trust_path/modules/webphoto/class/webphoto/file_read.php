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


class webphoto_file_read extends webphoto_item_public {
	public $_file_handler;
	public $_multibyte_class;
	public $_post_class;
	public $_utility_class;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
		//$this->webphoto_item_public( $dirname, $trust_dirname );

		$this->_file_handler    =& webphoto_file_handler::getInstance(
			$dirname, $trust_dirname );
		$this->_multibyte_class =& webphoto_multibyte::getInstance();
		$this->_post_class      =& webphoto_lib_post::getInstance();
		$this->_utility_class   =& webphoto_lib_utility::getInstance();

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_file_read( $dirname, $trust_dirname );
		}

		return $instance;
	}


// main

	public function get_file_row( $item_row, $kind ) {
		$file_id = $this->_item_handler->build_value_fileid_by_kind(
			$item_row, $kind );

		if ( $file_id == 0 ) {
			$this->_error = $this->get_constant( 'NO_FILE' );

			return false;
		}

		$file_row = $this->_file_handler->get_extend_row_by_id( $file_id );
		if ( ! is_array( $file_row ) ) {
			$this->_error = $this->get_constant( 'NO_FILE' );

			return false;
		}

		$exists = $file_row['full_path_exists'];

		if ( ! $exists ) {
			$this->_error = $this->get_constant( 'NO_FILE' );

			return false;
		}

		return $file_row;
	}

// --- class end ---
}

?>
