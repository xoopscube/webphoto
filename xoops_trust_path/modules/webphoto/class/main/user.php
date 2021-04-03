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


class webphoto_main_user extends webphoto_show_list {


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->set_mode( 'user' );
		$this->init_preload();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_main_user( $dirname, $trust_dirname );
		}

		return $instance;
	}


// main

// overwrite
	function list_sel() {
		if ( ( $this->_param != $this->_UID_DEFAULT ) &&
		     ( $this->_param >= 0 ) ) {
			return true;
		}

		return false;
	}


// list

// overwrite
	function list_get_photo_list() {
		$groupby   = 'item_uid';
		$orderby   = 'item_uid ASC, item_id DESC';
		$list_rows = $this->_item_handler->get_rows_by_groupby_orderby( $groupby, $orderby );
		if ( ! is_array( $list_rows ) || ! count( $list_rows ) ) {
			return false;
		}

		$arr = array();
		foreach ( $list_rows as $row ) {
			$uid = intval( $row['item_uid'] );

			$photo_row = null;

			$title = $this->build_show_uname( $uid );
			$link  = 'index.php/user/' . $uid . '/';

			$total      = $this->_public_class->get_count_by_uid( $uid );
			$photo_rows = $this->_public_class->get_rows_by_uid_orderby(
				$uid, $this->_PHOTO_LIST_ORDER, $this->_PHOTO_LIST_LIMIT );

			if ( isset( $photo_rows[0] ) ) {
				$photo_row = $photo_rows[0];
			}

			$arr[] = $this->list_build_photo_array(
				$title, $uid, $total, $photo_row );

		}

		return $arr;
	}


// detail list

// overwrite
	function list_build_detail( $uid ) {
		$rows    = null;
		$limit   = $this->_MAX_PHOTOS;
		$start   = $this->pagenavi_calc_start( $limit );
		$orderby = $this->get_orderby_by_post();

		$init_param = $this->list_build_init_param( true );

		$title = $this->build_show_info_morephotos( $uid );
		$total = $this->_public_class->get_count_by_uid( $uid );

		if ( $total > 0 ) {
			$rows = $this->_public_class->get_rows_by_uid_orderby(
				$uid, $orderby, $limit, $start );
		}

		$param      = $this->list_build_detail_common( $title, $total, $rows );
		$navi_param = $this->list_build_navi( $total, $limit );

		$this->list_assign_xoops_header();

		$ret = array_merge( $param, $init_param, $navi_param );

		return $this->add_show_js_windows( $ret );
	}

// --- class end ---
}

?>
