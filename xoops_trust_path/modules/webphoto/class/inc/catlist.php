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


class webphoto_inc_catlist extends webphoto_inc_base_ini {
	public $_xoops_tree_handler;
	public $_table_cat;
	public $_table_item;

	public $_myts;
	public $_multibyte_class;

	public $_cfg_uploadspath;
	public $_cfg_perm_cat_read;
	public $_cfg_perm_item_read;
	public $_cfg_cat_summary;

	public $_CATS_URL = null;

	public $_CAT_ORDER = 'cat_weight ASC, cat_title ASC, cat_id ASC';
	public $_PREFIX_NAME = 'prefix';
	public $_PREFIX_MARK = '.';
	public $_PREFIX_BAR = '--';

	public $_CAT_ID_NAME = 'cat_id';
	public $_SUMMARY_TAIL = '';


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct();

		$this->init_base_ini( $dirname, $trust_dirname );
		$this->init_handler( $dirname );
		$this->_init_xoops_config( $dirname );

		$this->_table_cat  = $this->prefix_dirname( 'cat' );
		$this->_table_item = $this->prefix_dirname( 'item' );

		$this->_xoops_tree_handler = new XoopsTree(
			$this->_table_cat, $this->_CAT_ID_NAME, 'cat_pid' );

		( method_exists( 'MyTextSanitizer', 'sGetInstance' ) and $this->_myts =& MyTextSanitizer::sGetInstance() ) || $this->_myts =& MyTextSanitizer::getInstance();

		$this->_multibyte_class =& webphoto_lib_multibyte::getInstance();

		$this->_CATS_URL = XOOPS_URL . $this->_cfg_uploadspath . '/categories';
	}

	public static function &getSingleton( $dirname, $trust_dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] = new webphoto_inc_catlist( $dirname, $trust_dirname );
		}

		return $singletons[ $dirname ];
	}


// top category
// webphoto_inc_xoops_version

	public function get_top_cat_rows( $limit = 0, $offset = 0 ) {
		$name_perm = $this->_get_name_perm();

		return $this->_get_cat_rows_by_pid_order_perm(
			0, $this->_CAT_ORDER, $name_perm, $limit, $offset );
	}

	public function _get_name_perm() {
		$str = '';
		if ( $this->_is_perm_cat_read_no_cat() ) {
			$str = 'cat_perm_read';
		}

		return $str;
	}

	public function _is_perm_cat_read_all() {
		if ( $this->_cfg_perm_cat_read == _C_WEBPHOTO_OPT_PERM_READ_ALL ) {
			return true;
		}

		return false;
	}

	public function _is_perm_cat_read_no_cat() {
		return $this->_cfg_perm_cat_read == _C_WEBPHOTO_OPT_PERM_READ_NO_CAT;
	}


// cat list
// webphoto_inc_blocks webphoto_category

	public function calc_width( $cols ) {
		if ( $cols <= 0 ) {
			$cols = 1;
		}

		$width = (int) ( 100 / $cols ) - 1;
		if ( $width <= 0 ) {
			$width = 1;
		}

		return array( $cols, $width );
	}

	public function build_catlist( $parent_id, $flag_sub ) {
		$catlist = array();

		$name_perm = $this->_get_name_perm();
		$rows      = $this->_get_cat_rows_by_pid_order_perm(
			$parent_id, $this->_CAT_ORDER, $name_perm );

		if ( ! is_array( $rows ) || ! count( $rows ) ) {
			return array();
		}

		foreach ( $rows as $row ) {
			$arr = $this->build_cat_show( $row );

			$arr['photo_small_sum']
				= $this->_get_photo_count_by_cat_row( $row );

			$arr['photo_total_sum']
				= $this->_get_photo_count_in_parent_all_children( $row );

			$arr['subcategories']
				= $this->_build_subcat( $row, $flag_sub );

			$catlist[] = $arr;
		}

		return $catlist;
	}

	public function _build_subcat( $cat_row, $flag_shub ) {
		$subcat = array();

		if ( ! $flag_shub ) {
			return array();
		}

		$rows = $this->_get_cat_first_child_rows_perm( $cat_row );
		if ( ! is_array( $rows ) || ! count( $rows ) ) {
			return array();
		}

		foreach ( $rows as $row ) {
			$arr = $this->build_cat_show( $row );

			$arr['photo_small_sum']
				= $this->_get_photo_count_by_cat_row( $row );

			$arr['photo_total_sum']
				= $this->_get_photo_count_in_parent_all_children( $row );

			$arr['number_of_subcat']
				= $this->_get_cat_count_first_child_perm( $row );

			$subcat[] = $arr;
		}

		return $subcat;
	}

// show main
	public function build_cat_show( $cat_row ) {
		$img_name = $cat_row['cat_img_name'];
		if ( $img_name ) {
			$url = $this->_CATS_URL . '/' . $img_name;
		} else {
			$url = $this->_build_cat_img_path( $cat_row );
		}

		$show                = $cat_row;
		$show['cat_title_s'] = $this->sanitize( $cat_row['cat_title'] );
		$show['imgurl']      = $url;
		$show['imgurl_s']    = $this->sanitize( $url );
		$show['summary']     = $this->_build_cat_summary( $cat_row['cat_description'] );

		return $show;
	}

	public function _build_cat_img_path( $cat_row ) {
		$img_path = $cat_row['cat_img_path'];
		if ( $this->check_http_null( $img_path ) ) {
			$url = '';
		} elseif ( $this->check_http_start( $img_path ) ) {
			$url = $img_path;
		} else {
			$url = XOOPS_URL . $this->add_slash_to_head( $img_path );
		}

		return $url;
	}

	public function _get_photo_count_in_parent_all_children( $cat_row ) {
		$id_arr = $this->get_cat_parent_all_child_id_by_row( $cat_row );

		return $this->_get_item_count_by_catid_array( $id_arr );
	}

	public function _get_photo_count_by_cat_row( $cat_row ) {
		if ( ! $this->_is_perm_cat_read_all() ) {
			if ( ! $this->_check_cat_perm_by_cat_row( $cat_row ) ) {
				return 0;
			}
		}

		return $this->_get_item_count_by_catid( $cat_row[ $this->_CAT_ID_NAME ] );
	}

	public function _build_cat_summary( $desc ) {
		return $this->_multibyte_class->build_summary(
			$this->_build_cat_desc_disp( $desc ), $this->_cfg_cat_summary, $this->_SUMMARY_TAIL );
	}

	public function _build_cat_desc_disp( $desc ) {
		return $this->_myts->displayTarea( $desc, 0, 1, 1, 1, 1, 1 );
	}


// cat tree
// webphoto_inc_weblinks

	public function get_cat_titles() {
		$rows = $this->get_cat_all_tree_array();
		if ( ! is_array( $rows ) || ! count( $rows ) ) {
			return null;
		}

		$arr = array();
		foreach ( $rows as $row ) {
			$arr[ $row['cat_id'] ] = $row['cat_title'];
		}

		return $arr;
	}

	public function get_cat_all_tree_array() {
		$name_perm = $this->_get_name_perm();

		return $this->get_cat_all_tree_array_perm(
			$this->_CAT_ORDER, $name_perm );
	}

	public function get_cat_parent_all_child_id_by_id( $cat_id ) {
		$cat_row = $this->_get_cat_row_by_id( $cat_id );
		if ( is_array( $cat_row ) ) {
			return $this->get_cat_parent_all_child_id_by_row( $cat_row );
		}

		return null;
	}

	public function get_cat_parent_all_child_id_by_row( $cat_row ) {
		if ( ! is_array( $cat_row ) ) {
			return null;
		}

		$cat_id    = $cat_row[ $this->_CAT_ID_NAME ];
		$name_perm = $this->_get_name_perm();
		$tree_arr  = $this->_get_cat_child_tree_array_recusible(
			$cat_id, $this->_CAT_ORDER, $name_perm );

		$tree_arr[] = $cat_row;

		$id_arr = array();

		if ( is_array( $tree_arr ) && count( $tree_arr ) ) {
			foreach ( $tree_arr as $row ) {
				if ( $this->_is_perm_cat_read_all() ||
				     ( $this->_check_cat_perm_by_cat_row( $row ) ) ) {

					$id_arr[] = $row[ $this->_CAT_ID_NAME ];
				}
			}
		}

		return $id_arr;
	}

	public function get_cat_all_child_tree_array( $cat_id = 0 ) {
		$name_perm = $this->_get_name_perm();

		return $this->_get_cat_child_tree_array_recusible(
			$cat_id, $this->_CAT_ORDER, $name_perm );
	}

// XoopsTree::makeMySelBox
	public function get_cat_all_tree_array_perm( $order, $name_perm = null ) {
		$pid_rows = $this->_get_cat_rows_by_pid_order_perm( 0, $order, $name_perm );
		if ( ! is_array( $pid_rows ) ) {
			return false;
		}

		$tree = array();
		foreach ( $pid_rows as $row ) {
			$catid                      = $row[ $this->_CAT_ID_NAME ];
			$row[ $this->_PREFIX_NAME ] = '';

			$tree[] = $row;

			$child_arr = $this->_get_cat_child_tree_array_recusible( $catid, $order, $name_perm );
			foreach ( $child_arr as $child ) {
				$tree[] = $child;
			}
		}

		return $tree;
	}


// cat handler

	public function get_cat_row_by_catid_perm( $cat_id ) {
		$cat_row = $this->_get_cat_row_by_id( $cat_id );
		if ( ! is_array( $cat_row ) ) {
			return false;
		}
		if ( ! $this->_check_cat_perm_by_cat_row( $cat_row ) ) {
			return false;
		}

		return $cat_row;
	}

	public function check_cat_perm_by_catid( $cat_id ) {
		$cat_row = $this->_get_cat_row_by_id( $cat_id );
		if ( is_array( $cat_row ) ) {
			return $this->_check_cat_perm_by_cat_row( $cat_row );
		}

		return false;
	}

	public function _check_cat_perm_by_cat_row( $cat_row, $name_perm = 'cat_perm_read' ) {
		return $this->check_perm_by_row_name_groups( $cat_row, $name_perm );

	}

// recursible function
// XoopsTree::getChildTreeArray
	public function _get_cat_child_tree_array_recusible(
		$sel_id, $order, $name_perm = null, $parray = array(), $r_prefix = ''
	) {
		$rows = $this->_get_cat_rows_by_pid_order_perm( $sel_id, $order, $name_perm );
		if ( ! is_array( $rows ) || ! count( $rows ) ) {
			return $parray;
		}

		foreach ( $rows as $row ) {
// add mark
			$new_r_prefix               = $r_prefix . $this->_PREFIX_MARK;
			$row[ $this->_PREFIX_NAME ] = $new_r_prefix;

			array_push( $parray, $row );

// recursible call
			$new_sel_id = $row[ $this->_CAT_ID_NAME ];
			$parray     = $this->_get_cat_child_tree_array_recusible(
				$new_sel_id, $order, $name_perm, $parray, $new_r_prefix );
		}

		return $parray;
	}

	function _get_cat_rows_by_pid_order_perm( $pid, $order, $name_perm = null, $limit = 0, $offset = 0 ) {
		$rows = $this->_get_cat_rows_by_pid_order( $pid, $order, $limit, $offset );
		if ( ! is_array( $rows ) || ! count( $rows ) ) {
			return false;
		}

		if ( $name_perm ) {
			$arr = array();
			foreach ( $rows as $row ) {
				if ( $this->_check_cat_perm_by_cat_row( $row, $name_perm ) ) {
					$arr[] = $row;
				}
			}

		} else {
			$arr = $rows;
		}

		return $arr;
	}

	function _get_cat_rows_by_pid_order( $pid, $order, $limit = 0, $offset = 0 ) {
		$sql = 'SELECT * FROM ' . $this->_table_cat;
		$sql .= ' WHERE cat_pid=' . (int) $pid;
		$sql .= ' ORDER BY ' . $order;

		return $this->get_rows_by_sql( $sql, $limit, $offset );
	}

	function _get_cat_first_child_rows_perm( $cat_row ) {
		$rows = $this->_xoops_tree_handler->getFirstChild(
			$cat_row[ $this->_CAT_ID_NAME ], $this->_CAT_ORDER );

		if ( ! is_array( $rows ) || ! count( $rows ) ) {
			return array();
		}

		if ( $this->_is_perm_cat_read_no_cat() ) {
			$arr = array();
			foreach ( $rows as $row ) {
				if ( $this->_check_cat_perm_by_cat_row( $row ) ) {
					$arr[] = $row;
				}
			}
		} else {
			$arr = $rows;
		}

		return $rows;
	}

	function _get_cat_count_first_child_perm( $cat_row ) {
		$rows = $this->_get_cat_first_child_rows_perm( $cat_row );
		if ( is_array( $rows ) ) {
			return count( $rows );
		} else {
			return 0;
		}
	}

	function _get_cat_row_by_id( $id ) {
		$sql = 'SELECT * FROM ' . $this->_table_cat;
		$sql .= ' WHERE cat_id=' . $id;

		return $this->get_row_by_sql( $sql );
	}


// item handler
	function _get_item_count_by_catid( $cat_id ) {
		$where = $this->build_where_public_with_item();
		$where .= ' AND item_cat_id=' . (int) $cat_id;

		return $this->get_item_count_by_where( $where );
	}

	function _get_item_count_by_catid_array( $catid_array ) {
		if ( ! is_array( $catid_array ) || ! count( $catid_array ) ) {
			return 0;
		}

		$where = $this->build_where_public_with_item();

		$where .= ' AND item_cat_id IN ( ';
		$where .= implode( ',', $catid_array );
		$where .= ' )';

		return $this->get_item_count_by_where( $where );
	}


// xoops_config

	function _init_xoops_config( $dirname ) {
		$config_handler =& webphoto_inc_config::getSingleton( $dirname );

		$this->_cfg_uploadspath    = $config_handler->get_path_by_name( 'uploadspath' );
		$this->_cfg_perm_cat_read  = $config_handler->get_by_name( 'perm_cat_read' );
		$this->_cfg_perm_item_read = $config_handler->get_by_name( 'perm_item_read' );
		$this->_cfg_cat_summary    = $config_handler->get_by_name( 'cat_summary' );
	}
}
