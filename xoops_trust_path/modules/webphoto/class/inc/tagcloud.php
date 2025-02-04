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


class webphoto_inc_tagcloud extends webphoto_inc_base_ini {
	public $_uri_class;

	public $_item_table;
	public $_cat_table;
	public $_tag_table;
	public $_p2t_table;

	public $_cfg_perm_cat_read = 0;
	public $_cfg_perm_item_read = 0;

	public $_PERM_ALLOW_ALL = _C_WEBPHOTO_PERM_ALLOW_ALL;
	public $_PERM_DENOY_ALL = _C_WEBPHOTO_PERM_DENOY_ALL;
	public $_PERM_SEPARATOR = _C_WEBPHOTO_PERM_SEPARATOR;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct();

		$this->init_base_ini( $dirname, $trust_dirname );
		$this->init_handler( $dirname );

		$this->_init_config( $dirname );

		$this->_uri_class =& webphoto_inc_uri::getSingleton( $dirname );

		$this->_item_table = $this->prefix_dirname( 'item' );
		$this->_cat_table  = $this->prefix_dirname( 'cat' );
		$this->_tag_table  = $this->prefix_dirname( 'tag' );
		$this->_p2t_table  = $this->prefix_dirname( 'p2t' );
	}

	public static function &getSingleton( $dirname, $trust_dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] = new webphoto_inc_tagcloud( $dirname, $trust_dirname );
		}

		return $singletons[ $dirname ];
	}


// tagcloud

	public function build_tagcloud( $limit ) {
		$rows = $this->get_tag_rows( $limit );
		if ( ! is_array( $rows ) || ! count( $rows ) ) {
			return array();
		}

		return $this->build_tagcloud_by_rows( $rows );
	}

	public function build_tagcloud_by_rows( $rows ) {
// Assigning the return value of new by reference is deprecated
		$cloud_class = new webphoto_lib_cloud();

		ksort( $rows );

		foreach ( array_keys( $rows ) as $i ) {
			$name  = $rows[ $i ]['tag_name'];
			$count = $rows[ $i ]['photo_count'];
			$link  = $this->_uri_class->build_tag( $name );
			$cloud_class->addElement( $name, $link, $count );
		}

		return $cloud_class->build();
	}


// get tag rows

	public function get_tag_rows( $limit = 0, $offset = 0 ) {
		if ( ( $this->_cfg_perm_cat_read == _C_WEBPHOTO_OPT_PERM_READ_ALL ) &&
		     ( $this->_cfg_perm_item_read == _C_WEBPHOTO_OPT_PERM_READ_ALL ) ) {

			return $this->_get_tag_rows_with_count(
				'tag_id', $limit, $offset );

		} else {
			return $this->_get_tag_rows_with_count_cat(
				'tag_id', $limit, $offset );
		}
	}


// get item count

	public function get_item_count_by_tag( $tag ) {
		if ( $this->_cfg_perm_cat_read == _C_WEBPHOTO_OPT_PERM_READ_ALL ) {
			return $this->_get_item_count_by_tag( $tag );

		} else {
			return $this->_get_item_count_by_tag_for_cat( $tag );
		}
	}


// get item rows

	public function get_item_id_array_by_tag( $tag, $orderby, $limit = 0, $offset = 0 ) {
		$orderby = $this->convert_item_field( $orderby );

		if ( $this->_cfg_perm_cat_read == _C_WEBPHOTO_OPT_PERM_READ_ALL ) {
			return $this->_get_item_id_array_by_tag(
				$tag, $orderby, $limit, $offset );

		} else {
			return $this->_get_item_id_array_by_tag_for_cat(
				$tag, $orderby, $limit, $offset );
		}
	}


// where

	public function _build_where_by_tag_for_cat( $tag ) {
		$where = $this->_build_where_by_tag( $tag );
		$where .= ' AND ';
		$where .= $this->build_where_cat_perm_read();

		return $where;
	}

	public function _build_where_by_tag( $tag ) {
		$where = $this->convert_item_field(
			$this->build_where_public_with_item() );
		$where .= ' AND t.tag_name=' . $this->quote( $tag );

		return $where;
	}


// sql

	public function _get_item_count_by_tag_for_cat( $tag ) {
		$sql = 'SELECT COUNT(DISTINCT i.item_id) ';
		$sql .= ' FROM ' . $this->_p2t_table . ' p2t ';
		$sql .= ' INNER JOIN ' . $this->_item_table . ' i ';
		$sql .= ' ON i.item_id = p2t.p2t_photo_id ';
		$sql .= ' INNER JOIN ' . $this->_tag_table . ' t ';
		$sql .= ' ON t.tag_id = p2t.p2t_tag_id ';
		$sql .= ' INNER JOIN ' . $this->_cat_table . ' c ';
		$sql .= ' ON i.item_cat_id = c.cat_id ';
		$sql .= ' WHERE ' . $this->_build_where_by_tag_for_cat( $tag );

		return $this->get_count_by_sql( $sql );
	}

	public function _get_item_count_by_tag( $tag ) {
		$sql = 'SELECT COUNT(DISTINCT i.item_id) ';
		$sql .= ' FROM ' . $this->_p2t_table . ' p2t ';
		$sql .= ' INNER JOIN ' . $this->_item_table . ' i ';
		$sql .= ' ON i.item_id = p2t.p2t_photo_id ';
		$sql .= ' INNER JOIN ' . $this->_tag_table . ' t ';
		$sql .= ' ON t.tag_id = p2t.p2t_tag_id ';
		$sql .= ' WHERE ' . $this->_build_where_by_tag( $tag );

		return $this->get_count_by_sql( $sql );
	}

	public function _get_item_id_array_by_tag_for_cat( $tag, $orderby, $limit = 0, $offset = 0 ) {
		$sql = 'SELECT DISTINCT i.item_id ';
		$sql .= ' FROM ' . $this->_p2t_table . ' p2t ';
		$sql .= ' INNER JOIN ' . $this->_item_table . ' i ';
		$sql .= ' ON i.item_id = p2t.p2t_photo_id ';
		$sql .= ' INNER JOIN ' . $this->_tag_table . ' t ';
		$sql .= ' ON t.tag_id = p2t.p2t_tag_id ';
		$sql .= ' INNER JOIN ' . $this->_cat_table . ' c ';
		$sql .= ' ON i.item_cat_id = c.cat_id ';
		$sql .= ' WHERE ' . $this->_build_where_by_tag_for_cat( $tag );
		$sql .= ' ORDER BY ' . $orderby;

		return $this->get_first_rows_by_sql( $sql, $limit, $offset );
	}

	public function _get_item_id_array_by_tag( $tag, $orderby, $limit = 0, $offset = 0 ) {
		$sql = 'SELECT DISTINCT i.item_id ';
		$sql .= ' FROM ' . $this->_p2t_table . ' p2t ';
		$sql .= ' INNER JOIN ' . $this->_item_table . ' i ';
		$sql .= ' ON i.item_id = p2t.p2t_photo_id ';
		$sql .= ' INNER JOIN ' . $this->_tag_table . ' t ';
		$sql .= ' ON t.tag_id = p2t.p2t_tag_id ';
		$sql .= ' WHERE ' . $this->_build_where_by_tag( $tag );
		$sql .= ' ORDER BY ' . $orderby;

		return $this->get_first_rows_by_sql( $sql, $limit, $offset );
	}

	public function _get_tag_rows_with_count_cat( $key, $limit = 0, $offset = 0 ) {
		$sql = 'SELECT t.*, COUNT(*) AS photo_count ';
		$sql .= ' FROM ' . $this->_tag_table . ' t ';
		$sql .= ' INNER JOIN ' . $this->_p2t_table . ' p2t ';
		$sql .= ' ON t.tag_id = p2t.p2t_tag_id ';
		$sql .= ' INNER JOIN ' . $this->_item_table . ' i ';
		$sql .= ' ON i.item_id = p2t.p2t_photo_id ';
		$sql .= ' INNER JOIN ' . $this->_cat_table . ' c ';
		$sql .= ' ON i.item_cat_id = c.cat_id ';
		$sql .= ' WHERE ' . $this->build_where_public_with_item_cat();
		$sql .= ' GROUP BY t.tag_id ';
		$sql .= ' ORDER BY photo_count DESC';

		return $this->get_rows_by_sql( $sql, $limit, $offset, $key );
	}

	public function _get_tag_rows_with_count( $key, $limit = 0, $offset = 0 ) {
		$sql = 'SELECT t.*, COUNT(*) AS photo_count ';
		$sql .= ' FROM ' . $this->_tag_table . ' t ';
		$sql .= ' INNER JOIN ' . $this->_p2t_table . ' p2t ';
		$sql .= ' ON t.tag_id = p2t.p2t_tag_id ';
		$sql .= ' GROUP BY t.tag_id ';
		$sql .= ' ORDER BY photo_count DESC';

		return $this->get_rows_by_sql( $sql, $limit, $offset, $key );
	}


// config

	public function _init_config( $dirname ) {
		$config_handler =& webphoto_inc_config::getSingleton( $dirname );

		$this->_cfg_perm_cat_read  = $config_handler->get_by_name( 'perm_cat_read' );
		$this->_cfg_perm_item_read = $config_handler->get_by_name( 'perm_item_read' );
	}

}
