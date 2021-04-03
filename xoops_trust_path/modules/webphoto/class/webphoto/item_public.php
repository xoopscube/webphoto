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


class webphoto_item_public extends webphoto_base_ini {
	public $_config_class;
	public $_cat_handler;
	public $_item_handler;

	public $_cfg_perm_cat_read;
	public $_cfg_perm_item_read;

	public $_item_row = null;
	public $_error = null;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
		//$this->webphoto_base_ini( $dirname, $trust_dirname );

		$this->_config_class =& webphoto_config::getInstance( $dirname );
		$this->_cat_handler  =& webphoto_cat_handler::getInstance(
			$dirname, $trust_dirname );
		$this->_item_handler =& webphoto_item_handler::getInstance(
			$dirname, $trust_dirname );

		$this->_cfg_perm_cat_read  = $this->_config_class->get_by_name( 'perm_cat_read' );
		$this->_cfg_perm_item_read = $this->_config_class->get_by_name( 'perm_item_read' );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_item_public( $dirname, $trust_dirname );
		}

		return $instance;
	}


// main

	function get_item_row( $item_id ) {
		$row = $this->_item_handler->get_row_by_id( $item_id );
		if ( ! is_array( $row ) ) {
			$this->_error = $this->get_constant( 'NOMATCH_PHOTO' );

			return false;
		}

		$cat_id = $row['item_cat_id'];
		$status = $row['item_status'];

		if ( $status <= 0 ) {
			$this->_error = $this->get_constant( 'NOMATCH_PHOTO' );

			return false;
		}

		if ( $this->_cfg_perm_item_read != _C_WEBPHOTO_OPT_PERM_READ_ALL ) {
			if ( ! $this->_item_handler->check_perm_read_by_row( $row ) ) {

				$this->_error = $this->get_constant( 'NOMATCH_PHOTO' );

				return false;
			}
		}

		if ( $this->_cfg_perm_cat_read != _C_WEBPHOTO_OPT_PERM_READ_ALL ) {
			if ( ! $this->_cat_handler->check_perm_read_by_id( $cat_id ) ) {

				$this->_error = $this->get_constant( 'NOMATCH_PHOTO' );

				return false;
			}
		}

		$this->_item_row = $row;

		return $row;
	}

	function check_item_perm( $perm ) {
		return $this->_item_handler->check_perm_by_perm_groups( $perm );
	}

// --- class end ---
}

?>
