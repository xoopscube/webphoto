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


class webphoto_admin_update_check extends webphoto_base_ini {

	public $_item_handler;
	public $_file_handler;
	public $_player_handler;
	public $_photo_handler;

	public $_item_count_all;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_item_handler   =& webphoto_item_handler::getInstance(
			$dirname, $trust_dirname );
		$this->_file_handler   =& webphoto_file_handler::getInstance(
			$dirname, $trust_dirname );
		$this->_player_handler =& webphoto_player_handler::getInstance(
			$dirname, $trust_dirname );
		$this->_photo_handler  =& webphoto_photo_handler::getInstance( $dirname );

		$this->_item_count_all = $this->_item_handler->get_count_all();

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {

		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_update_check( $dirname, $trust_dirname );
		}

		return $instance;
	}


// check

	public function build_msg( $msg, $flag_highlight = false, $flag_br = false ) {
		$str = null;

		if ( $this->check_040() ) {
			$msg = '<a href="' . $this->get_url( '040' ) . '">';
			$msg .= _AM_WEBPHOTO_MUST_UPDATE;
			$msg .= '</a>';
			$str = $this->build_error_msg( $msg, '', false );

		} elseif ( $this->check_050() ) {
			$msg = '<a href="' . $this->get_url( '050' ) . '">';
			$msg .= _AM_WEBPHOTO_MUST_UPDATE;
			$msg .= '</a>';
			$str = $this->build_error_msg( $msg, '', false );

		} elseif ( $this->check_130() ) {
			$msg = '<a href="' . $this->get_url( '130' ) . '">';
			$msg .= _AM_WEBPHOTO_MUST_UPDATE;
			$msg .= '</a>';
			$str = $this->build_error_msg( $msg, '', false );

		} elseif ( $this->check_210() ) {
			$msg = '<a href="' . $this->get_url( '210' ) . '">';
			$msg .= _AM_WEBPHOTO_MUST_UPDATE;
			$msg .= '</a>';
			$str = $this->build_error_msg( $msg, '', false );
		}

		return $str;
	}

	public function check_040() {
		if ( $this->_item_count_all > 0 ) {
			return false;
		}
		if ( $this->_photo_handler->get_count_all() > 0 ) {
			return true;
		}

		return false;
	}

	public function check_050() {
		return $this->_player_handler->get_count_all() == 0;
	}

	public function check_130() {
		if ( $this->_item_count_all == 0 ) {
			return false;
		}
		if ( $this->_file_handler->get_count_by_kind( _C_WEBPHOTO_FILE_KIND_SMALL ) == 0 ) {
			return true;
		}

		return false;
	}

	public function check_210() {
		if ( $this->_item_count_all == 0 ) {
			return false;
		}
		if ( $this->_item_handler->get_count_photo() == 0 ) {
			return false;
		}
		if ( $this->_item_handler->get_count_photo_detail_onclick() == 0 ) {
			return true;
		}

		return false;
	}

	public function get_url( $ver ) {
		$url = $this->_MODULE_URL . '/admin/index.php?fct=update_' . $ver;

		return $url;
	}
}


