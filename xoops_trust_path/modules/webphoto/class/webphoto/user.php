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


class webphoto_user extends webphoto_base_this {
	public $_public_class;

	public $_PHOTO_LIST_USER_ORDER = 'item_uid ASC, item_id DESC';
	public $_PHOTO_LIST_USER_GROUP = 'item_uid';


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_public_class
			=& webphoto_photo_public::getInstance( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_user( $dirname, $trust_dirname );
		}

		return $instance;
	}


// main

	public function page_sel( $param ) {
		return ( $param != _C_WEBPHOTO_UID_DEFAULT ) &&
		       ( $param >= 0 );
	}


// list

	public function build_rows_for_list() {
		$list_rows = $this->_item_handler->get_rows_by_groupby_orderby(
			$this->_PHOTO_LIST_USER_GROUP, $this->_PHOTO_LIST_USER_ORDER );
		if ( ! is_array( $list_rows ) || ! count( $list_rows ) ) {
			return false;
		}

		$arr = array();
		foreach ( $list_rows as $row ) {
			$uid = (int) $row['item_uid'];

			$photo_row = null;

			$title = $this->build_show_uname( $uid );
			$link  = 'index.php/user/' . $uid . '/';

			$total      = $this->_public_class->get_count_by_uid( $uid );
			$photo_rows = $this->_public_class->get_rows_by_uid_orderby(
				$uid, $this->_PHOTO_LIST_UPDATE_ORDER, $this->_PHOTO_LIST_LIMIT );

			if ( isset( $photo_rows[0] ) ) {
				$photo_row = $photo_rows[0];
			}

			$arr[] = array( $title, $uid, $total, $photo_row );
		}

		return $arr;
	}


// detail

	public function build_total_for_detail( $uid ) {
		$title = $this->build_show_info_morephotos( $uid );
		$total = $this->_public_class->get_count_by_uid( $uid );

		return array( $title, $total );
	}

	public function build_rows_for_detail( $uid, $orderby, $limit = 0, $start = 0 ) {
		return $this->_public_class->get_rows_by_uid_orderby(
			$uid, $orderby, $limit, $start );
	}


// rss

	public function build_rows_for_rss( $uid, $orderby, $limit = 0, $start = 0 ) {
		return $this->build_rows_for_detail(
			$uid, $orderby, $limit, $start );
	}

}
