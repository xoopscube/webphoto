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

include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';


class webphoto_lib_tree_handler extends webphoto_lib_handler {

	public $_xoops_tree_handler;

	public $_cached_perm_in_parent_key_array = array();

	public $_ORDER_DEFAULT = null;

	public $_PATH_SEPARATOR = ' : ';

	public function __construct( $dirname ) {

		parent::__construct( $dirname );

		$this->set_use_prefix( true );
	}

	public function init_xoops_tree() {
		$this->set_order_default( $this->_id_name );
		$this->_xoops_tree_handler = new XoopsTree( $this->_table, $this->_id_name, $this->_pid_name );
	}

	public function set_order_default( $val ) {
		$this->_ORDER_DEFAULT = $val;
	}


// base on XoopsTree::getNicePathFromId 

	public function get_nice_path_from_id( $sel_id, $title_name, $func_url, $flag_short = false ) {
		$rows = $this->get_parent_path_array( $sel_id );
		if ( ! is_array( $rows ) || ! count( $rows ) ) {
			return '';
		}

		$path  = '';
		$start = count( $rows ) - 1;

		for ( $i = $start; $i >= 0; $i -- ) {
			$row   = $rows[ $i ];
			$id    = $row[ $this->_id_name ];
			$pid   = $row[ $this->_pid_name ];
			$title = $row[ $title_name ];

			if ( $flag_short ) {
				$url = $func_url . $id;
			} else {
				$url = $func_url . '&amp;' . $this->_id_name . '=' . $id;
			}

			$path .= '<a href="' . $url . '">';
			$path .= $this->sanitize( $title );
			$path .= '</a>';
			$path .= $this->_PATH_SEPARATOR;
		}

		return $path;
	}

// recursible function
	public function get_parent_path_array( $sel_id, $path_array = array() ) {
		$row = $this->get_cached_row_by_id( $sel_id );
		if ( ! is_array( $row ) ) {
			return $path_array;
		}

		$path_array[] = $row;
		$pid          = $row[ $this->_pid_name ];

// reached top 
		if ( $pid == 0 ) {
			return $path_array;
		}

// recursible call
		$path_array = $this->get_parent_path_array( $pid, $path_array );

		return $path_array;
	}

	public function set_path_separator( $val ) {
		$this->_PATH_SEPARATOR = $val;
	}


// base on XoopsTree::makeMySelBox 

	public function make_my_sel_box( $title_name, $order = '', $preset_id = 0, $none = 0, $sel_name = '', $onchange = '' ) {
		return $this->build_sel_box(
			$this->get_all_tree_array( $order ),
			$title_name, $preset_id, $none, $sel_name, $onchange );
	}

	public function build_sel_box( $tree, $title_name, $preset_id = 0, $none = 0, $sel_name = '', $onchange = '' ) {
		return $this->build_form_select_list( $tree, $title_name, $preset_id, $none, $sel_name, $onchange );
	}

	public function get_all_tree_array( $order = '', $name_perm = null ) {
		if ( empty( $order ) ) {
			$order = $this->_ORDER_DEFAULT;
		}

		$pid_rows = $this->get_rows_by_pid_order_with_perm( 0, $order, $name_perm );
		if ( ! is_array( $pid_rows ) ) {
			return false;
		}

		$tree = array();
		foreach ( $pid_rows as $row ) {
			$catid                      = $row[ $this->_id_name ];
			$row[ $this->_PREFIX_NAME ] = '';

			$tree[] = $row;

			$child_arr = $this->get_child_tree_array( $catid, $order, array(), '', $name_perm );
			foreach ( $child_arr as $child ) {
				$tree[] = $child;
			}
		}

		return $tree;
	}

	public function get_tree_name_list( $title_name, $none = false, $none_name = '---' ) {
		$rows = $this->get_all_tree_array();
		$arr  = array();
		if ( ! is_array( $rows ) || ! count( $rows ) ) {
			return $arr;
		}
		if ( $none ) {
			$arr[0] = $none_name;
		}
		foreach ( $rows as $row ) {
			$arr[ $row[ $this->_id_name ] ] = $row[ $title_name ];
		}

		return $arr;
	}


// base on XoopsTree::getChildTreeArray 

// recursible function
	public function get_child_tree_array( $sel_id = 0, $order = '', $parray = array(), $r_prefix = '', $name_perm = null ) {
		$rows = $this->get_rows_by_pid_order_with_perm( $sel_id, $order, $name_perm );
		if ( ! is_array( $rows ) || ! count( $rows ) ) {
			return $parray;
		}

		foreach ( $rows as $row ) {
// add mark
			$new_r_prefix               = $r_prefix . $this->_PREFIX_MARK;
			$row[ $this->_PREFIX_NAME ] = $r_prefix . $this->_PREFIX_MARK;

			array_push( $parray, $row );

// recursible call
			$new_sel_id = $row[ $this->_id_name ];
			$parray     = $this->get_child_tree_array( $new_sel_id, $order, $parray, $new_r_prefix, $name_perm );
		}

		return $parray;
	}

	public function get_rows_by_pid_order_with_perm( $pid, $order = '', $name_perm = null, $limit = 0, $offset = 0 ) {
		$rows = $this->get_rows_by_pid_order( $pid, $order, $limit, $offset );
		if ( ! is_array( $rows ) || ! count( $rows ) ) {
			return false;
		}

		if ( $name_perm ) {
			return $this->build_rows_with_perm( $rows, $name_perm );
		}

		return $rows;
	}

	public function get_rows_by_pid_order( $pid, $order = '', $limit = 0, $offset = 0 ) {
		$sql = 'SELECT * FROM ' . $this->_table;
		$sql .= ' WHERE ' . $this->_pid_name . '=' . $pid;
		if ( $order != '' ) {
			$sql .= ' ORDER BY ' . $order;
		}

		return $this->get_rows_by_sql( $sql, $limit, $offset );
	}


// tree handler

	public function getFirstChild( $sel_id, $order = "" ) {
		return $this->_xoops_tree_handler->getFirstChild( $sel_id, $order );
	}

	public function getFirstChildId( $sel_id ) {
		return $this->_xoops_tree_handler->getFirstChildId( $sel_id );
	}

	public function getAllChildId( $sel_id = 0, $order = "", $parray = array() ) {
		return $this->_xoops_tree_handler->getAllChildId( $sel_id, $order, $parray );
	}

	public function getAllParentId( $sel_id, $order = "", $idarray = array() ) {
		return $this->_xoops_tree_handler->getAllParentId( $sel_id, $order, $idarray );
	}

	public function getPathFromId( $sel_id, $title, $path = "" ) {
		return $this->_xoops_tree_handler->getPathFromId( $sel_id, $title, $path );
	}

	public function makeMySelBox( $title, $order = "", $preset_id = 0, $none = 0, $sel_name = "", $onchange = "" ) {
		return $this->_xoops_tree_handler->makeMySelBox( $title, $order, $preset_id, $none, $sel_name, $onchange );

	}

	public function getNicePathFromId( $sel_id, $title, $funcURL, $path = "" ) {
		return $this->_xoops_tree_handler->getNicePathFromId( $sel_id, $title, $funcURL, $path );
	}

	public function getIdPathFromId( $sel_id, $path = "" ) {
		return $this->_xoops_tree_handler->getIdPathFromId( $sel_id, $path );
	}

	public function getAllChild( $sel_id = 0, $order = "", $parray = array() ) {
		return $this->_xoops_tree_handler->getAllChild( $sel_id, $order, $parray );
	}

	public function getChildTreeArray( $sel_id = 0, $order = "", $parray = array(), $r_prefix = "" ) {
		return $this->_xoops_tree_handler->getChildTreeArray( $sel_id, $order, $parray, $r_prefix );
	}


// permission

	public function check_cached_perm_in_parents_by_id_name_groups_key( $id, $name, $groups = null, $key = '0' ) {
		if ( isset( $this->_cached_perm_in_parent_key_array[ $id ][ $key ] ) ) {
			return $this->_cached_perm_in_parent_key_array[ $id ][ $key ];
		}

		$ret                                                   = $this->check_perm_in_parents_by_id_name_groups_key( $id, $name, $groups, $key );
		$this->_cached_perm_in_parent_key_array[ $id ][ $key ] = $ret;

		return $ret;
	}

	public function check_perm_in_parents_by_id_name_groups_key( $id, $name, $groups = null, $key = '0' ) {
		$rows = $this->get_parent_path_array( $id );
		if ( ! is_array( $rows ) || ! count( $rows ) ) {
			return false;    // error
		}

		foreach ( $rows as $row ) {
			$ret = $this->check_cached_perm_by_row_name_groups_key( $row, $name, $groups, $key );
			if ( ! $ret ) {
				return false;
			}
		}

		return true;
	}

}

