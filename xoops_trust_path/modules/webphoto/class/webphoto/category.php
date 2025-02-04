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


class webphoto_category extends webphoto_show_photo {
	public $_public_class;
	public $_catlist_class;

	public $_saved_sum_mode = 0;
	public $_saved_total = 0;

	public $_cfg_cat_child = null;
	public $_cfg_perm_cat_read = null;
	public $_cfg_cat_main_width = null;
	public $_cfg_cat_sub_width = null;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_public_class
			=& webphoto_photo_public::getInstance( $dirname, $trust_dirname );
		$this->_catlist_class
			=& webphoto_inc_catlist::getSingleton( $dirname, $trust_dirname );

		$this->_cfg_cat_child      = $this->_config_class->get_by_name( 'cat_child' );
		$this->_cfg_perm_cat_read  = $this->_config_class->get_by_name( 'perm_cat_read' );
		$this->_cfg_cat_main_width = $this->_config_class->get_by_name( 'cat_main_width' );
		$this->_cfg_cat_sub_width  = $this->_config_class->get_by_name( 'cat_sub_width' );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_category( $dirname, $trust_dirname );
		}

		return $instance;
	}


// list

	public function build_photo_list_for_list() {
		$cat_rows = $this->_catlist_class->get_cat_all_tree_array();
		if ( ! is_array( $cat_rows ) || ! count( $cat_rows ) ) {
			return false;
		}

		$photo_list = array();
		foreach ( $cat_rows as $cat_row ) {
			$cat_id = $cat_row['cat_id'];

			$show_catpath = false;
			$photo        = null;

			$catpath = $this->build_catpath( $cat_id );
			if ( is_array( $catpath ) && count( $catpath ) ) {
				$show_catpath = true;
			}

			list( $photo_row, $total, $this_sum ) = $this->get_photo_for_list( $cat_id );

			if ( is_array( $photo_row ) && count( $photo_row ) ) {
				$photo                               = $this->build_photo_show( $photo_row );
				$photo_rows[ $photo_row['item_id'] ] = $photo_row;
			}

			$cat_desc_disp = $this->_cat_handler->build_show_desc_disp( $cat_row );

			$photo_list[] = array(
				'title'            => '',
				'title_s'          => '',
				'link'             => '',
				'link_s'           => '',
				'total'            => $total,
				'photo'            => $photo,
				'sum'              => $this_sum,
				'show_catpath'     => $show_catpath,
				'catpath'          => $catpath,
				'cat_desc_disp'    => $cat_desc_disp,
				'cat_summary_disp' => $this->build_cat_summary_disp( $cat_desc_disp )
			);
		}

		return array( $photo_list, $photo_rows );
	}

	public function get_photo_for_list( $cat_id ) {
		$photo_row = null;
		$rows      = null;

		list( $sum_mode, $total, $total_sum, $small_sum ) =
			$this->get_total_by_catid( _C_WEBPHOTO_CAT_CHILD_EMPTY, $cat_id );


		if ( $total > 0 ) {
			$rows = $this->get_rows_by_catid(
				$sum_mode, $cat_id, $this->_PHOTO_LIST_UPDATE_ORDER, $this->_PHOTO_LIST_LIMIT );
		}

		if ( is_array( $rows ) && count( $rows ) ) {
			$photo_row = $rows[0];
		}

		return array( $photo_row, $total, $small_sum );
	}

	public function build_cat_summary_disp( $desc ) {
		return $this->_multibyte_class->build_summary( $desc, $this->_cfg_cat_summary );
	}


// detail

	public function build_total_for_detail( $cat_id ) {
		$row = $this->_catlist_class->get_cat_row_by_catid_perm( $cat_id );

		if ( ! is_array( $row ) ) {
			return array(
				'cat_title'       => '',
				'photo_total'     => 0,
				'photo_total_sum' => 0,
				'photo_small_sum' => 0,
				'sum_mode'        => 0,
			);
		}

		$cat_title = $row['cat_title'];

		list( $sum_mode, $total, $total_sum, $small_sum ) =
			$this->get_total_by_catid( $this->_cfg_cat_child, $cat_id );

		return array(
			'cat_title'       => $cat_title,
			'photo_total'     => $total,
			'photo_total_sum' => $total_sum,
			'photo_small_sum' => $small_sum,
			'sum_mode'        => $sum_mode,
		);

	}

	public function build_rows_for_detail( $sum_mode, $cat_id, $orderby, $limit, $start ) {
		return $this->get_rows_by_catid( $sum_mode, $cat_id, $orderby, $limit, $start );
	}

	public function get_total_by_catid( $sel_mode, $cat_id ) {
		$name      = 'catid_array';
		$sum_mode  = 0;    // small_sum
		$total     = 0;
		$small_sum = 0;
		$total_sum = 0;

		if ( ! $this->check_cat_perm_read_by_catid( $cat_id ) ) {
			return array( $mode, $total, $total_sum, $small_sum );
		}

		$array_cat_id = array( $cat_id );
		$catid_array  = $this->_catlist_class->get_cat_parent_all_child_id_by_id( $cat_id );

// BUG: total is wrong
		$small_sum = $this->_public_class->get_count_by_name_param( $name, $array_cat_id );
		$total_sum = $this->_public_class->get_count_by_name_param( $name, $catid_array );

		switch ( $sel_mode ) {
			case _C_WEBPHOTO_CAT_CHILD_EMPTY :
				if ( $small_sum > 0 ) {
					$total = $small_sum;
				} else {
					$sum_mode = 1;    // total_sum
					$total    = $total_sum;
				}
				break;

			case _C_WEBPHOTO_CAT_CHILD_ALWAYS :
				$sum_mode = 1;    // total_sum
				$total    = $total_sum;
				break;

			case _C_WEBPHOTO_CAT_CHILD_NON :
			default:
				$total = $small_sum;
				break;
		}

		return array( $sum_mode, $total, $total_sum, $small_sum );
	}

	public function get_rows_by_catid( $sum_mode, $cat_id, $orderby, $limit = 0, $offset = 0 ) {
		$name = 'catid_array';

		switch ( $sum_mode ) {
			case 1:
				$param = $this->_catlist_class->get_cat_parent_all_child_id_by_id( $cat_id );
				break;

			case 0:
			default:
				$param = array( $cat_id );
				break;
		}

		$rows = $this->_public_class->get_rows_by_name_param_orderby(
			$name, $param, $orderby, $limit, $offset );

		return $rows;
	}

	public function check_cat_perm_read_by_catid( $cat_id ) {
		if ( $this->_cfg_perm_cat_read == _C_WEBPHOTO_OPT_PERM_READ_ALL ) {
			return true;
		}
		if ( $this->_catlist_class->check_cat_perm_by_catid( $cat_id ) ) {
			return true;
		}

		return false;
	}


// rss

	public function build_rows_for_rss( $cat_id, $orderby, $limit = 0, $start = 0 ) {
		$rows = null;

		$cat_param = $this->build_total_for_detail( $cat_id );
		$total     = $cat_param['photo_total'];
		$sum_mode  = $cat_param['sum_mode'];

		if ( $total > 0 ) {
			$rows = $this->build_rows_for_detail(
				$sum_mode, $cat_id, $orderby, $limit, $start );
		}

		return $rows;
	}


// catpath

	public function build_catpath( $cat_id ) {
		$rows = $this->_cat_handler->get_parent_path_array( $cat_id );
		if ( ! is_array( $rows ) || ! count( $rows ) ) {
			return false;
		}

		$arr   = array();
		$count = count( $rows );
		$last  = $count - 1;

		for ( $i = $last; $i >= 0; $i -- ) {
			$arr[] = $this->_catlist_class->build_cat_show( $rows[ $i ] );
		}

		$ret          = array();
		$ret['list']  = $arr;
		$ret['first'] = $arr[0];
		$ret['last']  = $arr[ $last ];

		return $ret;
	}


// catlist

	public function build_catlist( $cat_id, $cols_in, $delmita ) {
		$show_sub      = $this->get_ini( 'category_show_sub' );
		$show_main_img = $this->get_ini( 'category_show_main_img' );
		$show_sub_img  = $this->get_ini( 'category_show_sub_img' );

		$show = false;

		$cats = $this->_catlist_class->build_catlist( $cat_id, $show_sub );
		list( $cols, $width ) =
			$this->_catlist_class->calc_width( $cols_in );

		if ( is_array( $cats ) && count( $cats ) ) {
			$show = true;
		}

		$catlist = array(
			'cats'          => $cats,
			'cols'          => $cols,
			'width'         => $width,
			'delmita'       => $delmita,
			'show_sub'      => $show_sub,
			'show_main_img' => $show_main_img,
			'show_sub_img'  => $show_sub_img,
			'main_width'    => $this->_cfg_cat_main_width,
			'sub_width'     => $this->_cfg_cat_sub_width,
		);

		return array(
			'show_catlist' => $show,
			'catlist'      => $catlist,
		);
	}
}
