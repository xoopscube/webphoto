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


class webphoto_photo_tag_handler extends webphoto_handler_base_ini {
	public $_item_table;
	public $_tag_table;
	public $_p2t_table;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_item_table = $this->prefix_dirname( 'item' );
		$this->_tag_table  = $this->prefix_dirname( 'tag' );
		$this->_p2t_table  = $this->prefix_dirname( 'p2t' );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_photo_tag_handler( $dirname, $trust_dirname );
		}

		return $instance;
	}


// count

	public function get_photo_count_public_by_tag( $tag_name, $limit = 0, $offset = 0 ) {
		$where = 'i.item_status > 0';
		$where .= ' AND t.tag_name=' . $this->quote( $tag_name );

		return $this->get_photo_count_by_where( $where );
	}

	public function get_photo_count_by_where( $where ) {
		$sql = 'SELECT COUNT(DISTINCT i.item_id) ';
		$sql .= ' FROM ' . $this->_p2t_table . ' p2t ';
		$sql .= ' INNER JOIN ' . $this->_item_table . ' i ';
		$sql .= ' ON i.item_id = p2t.p2t_photo_id ';
		$sql .= ' INNER JOIN ' . $this->_tag_table . ' t ';
		$sql .= ' ON t.tag_id = p2t.p2t_tag_id ';
		$sql .= ' WHERE ' . $where;

		return $this->get_count_by_sql( $sql );
	}


// rows

	function get_photo_rows_by_where_orderby( $where, $orderby, $limit = 0, $offset = 0 ) {
		$sql = 'SELECT DISTINCT i.item_id ';
		$sql .= ' FROM ' . $this->_p2t_table . ' p2t ';
		$sql .= ' INNER JOIN ' . $this->_item_table . ' i ';
		$sql .= ' ON i.item_id = p2t.p2t_photo_id ';
		$sql .= ' INNER JOIN ' . $this->_tag_table . ' t ';
		$sql .= ' ON t.tag_id = p2t.p2t_tag_id ';
		$sql .= ' WHERE ' . $where;
		$sql .= ' ORDER BY ' . $orderby;

		return $this->get_first_rows_by_sql( $sql, $limit, $offset );
	}

	function get_tag_rows_with_count( $key = 'tag_id', $limit = 0, $offset = 0 ) {
		$sql = 'SELECT t.*, COUNT(*) AS photo_count ';
		$sql .= ' FROM ' . $this->_tag_table . ' t, ';
		$sql .= $this->_p2t_table . ' p2t ';
		$sql .= ' WHERE t.tag_id = p2t.p2t_tag_id ';
		$sql .= ' GROUP BY tag_id ';
		$sql .= ' ORDER BY photo_count DESC';

		return $this->get_rows_by_sql( $sql, $limit, $offset, $key );
	}

//!FIX TODO THIS
	function __get_tag_rows_with_count( $key = 'tag_id', $limit = 0, $offset = 0 ) {
		$sql = 'SELECT t.*, COUNT(*) AS photo_count ';
		$sql .= ' FROM ' . $this->_tag_table . ' t ';
		$sql .= ' LEFT JOIN ' . $this->_p2t_table . ' p2t ';
		$sql .= ' ON t.tag_id = p2t.p2t_tag_id ';
		$sql .= ' GROUP BY tag_id ';
		$sql .= ' ORDER BY photo_count DESC';

		return $this->get_rows_by_sql( $sql, $limit, $offset, $key );
	}


// id array
	function get_photo_id_array_public_latest_by_tag( $tag_name, $limit = 0, $offset = 0 ) {
		$where   = 'i.item_status > 0';
		$where   .= ' AND t.tag_name=' . $this->quote( $tag_name );
		$orderby = 'i.item_time_update DESC, i.item_id DESC';

		return $this->get_photo_id_array_by_where_orderby( $where, $orderby, $limit, $offset );
	}

	function get_photo_id_array_public_latest_by_tag_orderby( $tag_name, $orderby, $limit = 0, $offset = 0 ) {
		$where = 'i.item_status > 0';
		$where .= ' AND t.tag_name=' . $this->quote( $tag_name );

		return $this->get_photo_id_array_by_where_orderby( $where, $orderby, $limit, $offset );
	}

	function get_photo_id_array_by_where_orderby( $where, $orderby, $limit = 0, $offset = 0 ) {
		$sql = 'SELECT DISTINCT i.item_id ';
		$sql .= ' FROM ' . $this->_p2t_table . ' p2t ';
		$sql .= ' INNER JOIN ' . $this->_item_table . ' i ';
		$sql .= ' ON i.item_id = p2t.p2t_photo_id ';
		$sql .= ' INNER JOIN ' . $this->_tag_table . ' t ';
		$sql .= ' ON t.tag_id = p2t.p2t_tag_id ';
		$sql .= ' WHERE ' . $where;
		$sql .= ' ORDER BY ' . $orderby;

		return $this->get_first_rows_by_sql( $sql, $limit, $offset );
	}

	function get_tag_id_array_by_where_orderby( $where, $orderby, $limit = 0, $offset = 0 ) {
		$sql = 'SELECT DISTINCT t.tag_id ';
		$sql .= ' FROM ' . $this->_p2t_table . ' p2t ';
		$sql .= ' INNER JOIN ' . $this->_item_table . ' i ';
		$sql .= ' ON i.item_id = p2t.p2t_photo_id ';
		$sql .= ' INNER JOIN ' . $this->_tag_table . ' t ';
		$sql .= ' ON t.tag_id = p2t.p2t_tag_id ';
		$sql .= ' WHERE ' . $where;
		$sql .= ' ORDER BY ' . $orderby;

		return $this->get_first_rows_by_sql( $sql, $limit, $offset );
	}

	function get_tag_id_array_null( $limit = 0, $offset = 0 ) {
		$sql = 'SELECT DISTINCT t.tag_id ';
		$sql .= ' FROM ' . $this->_tag_table . ' t ';
		$sql .= ' LEFT JOIN ' . $this->_p2t_table . ' p2t ';
		$sql .= ' ON t.tag_id = p2t.p2t_tag_id ';
		$sql .= ' WHERE p2t.pt2_tag_id IS NULL';
		$sql .= ' ORDER t.tag_id ASC';

		return $this->get_first_rows_by_sql( $sql, $limit, $offset );
	}

}
