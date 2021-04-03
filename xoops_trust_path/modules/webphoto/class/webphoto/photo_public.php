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


class webphoto_photo_public {
	public $_config_class;
	public $_item_cat_handler;

	public $_cfg_perm_cat_read;

	public $_ORDERBY_ASC = 'item_id ASC';
	public $_ORDERBY_LATEST = 'item_time_update DESC, item_id DESC';

// show
	public $_SHOW_CAT_SUB = true;
	public $_SHOW_CAT_MAIN_IMG = true;
	public $_SHOW_CAT_SUB_IMG = true;


// constructor

	public function __construct( $dirname, $trust_dirname ) {
		$this->_item_cat_handler
			=& webphoto_item_cat_handler::getInstance( $dirname, $trust_dirname );

		$this->_config_class =& webphoto_config::getInstance( $dirname );

		$this->_cfg_perm_cat_read = $this->_config_class->get_by_name( 'perm_cat_read' );
		$cfg_perm_item_read       = $this->_config_class->get_by_name( 'perm_item_read' );

		$this->_item_cat_handler->set_perm_item_read( $cfg_perm_item_read );
		$this->_item_cat_handler->set_perm_cat_read( $this->_cfg_perm_cat_read );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_photo_public( $dirname, $trust_dirname );
		}

		return $instance;
	}


// count

	function get_count() {
		return $this->get_count_by_name_param( 'public', null );
	}

	function get_count_imode() {
		return $this->get_count_by_name_param( 'imode', null );
	}

	function get_count_by_catid_array( $param ) {
		return $this->get_count_by_name_param( 'catid_array', $param );
	}

	function get_count_by_like_datetime( $param ) {
		return $this->get_count_by_name_param( 'like_datetime', $param );
	}

	function get_count_by_place( $param ) {
		return $this->get_count_by_name_param( 'place', $param );
	}

	function get_count_by_place_array( $param ) {
		return $this->get_count_by_name_param( 'place_array', $param );
	}

	function get_count_by_search( $param ) {
		return $this->get_count_by_name_param( 'search', $param );
	}

	function get_count_by_uid( $param ) {
		return $this->get_count_by_name_param( 'uid', $param );
	}

	function get_count_by_name_param( $name, $param ) {
		if ( $this->_cfg_perm_cat_read == _C_WEBPHOTO_OPT_PERM_READ_ALL ) {
			return $this->_item_cat_handler->get_count_item_by_name_param(
				$name, $param );

		} else {
			return $this->_item_cat_handler->get_count_item_cat_by_name_param(
				$name, $param );
		}
	}


// rows

	function get_rows_by_orderby( $orderby, $limit = 0, $offset = 0, $key = false ) {
		return $this->get_rows_by_name_param_orderby(
			'public', null, $orderby, $limit, $offset, $key );
	}

	function get_rows_imode_by_orderby( $orderby, $limit = 0, $offset = 0 ) {
		return $this->get_rows_by_name_param_orderby(
			'imode', null, $orderby, $limit, $offset );
	}

	function get_rows_photo_by_orderby( $orderby, $limit = 0, $offset = 0 ) {
		return $this->get_rows_by_name_param_orderby(
			'photo', null, $orderby, $limit, $offset );
	}

	function get_rows_photo_by_catid_orderby( $param, $orderby, $limit = 0, $offset = 0 ) {
		return $this->get_rows_by_name_param_orderby(
			'photo_catid', $param, $orderby, $limit, $offset );
	}

	function get_rows_by_catid_array_orderby( $param, $orderby, $limit = 0, $offset = 0 ) {
		return $this->get_rows_by_name_param_orderby(
			'catid_array', $param, $orderby, $limit, $offset );
	}

	function get_rows_by_like_datetime_orderby( $param, $orderby, $limit = 0, $offset = 0 ) {
		return $this->get_rows_by_name_param_orderby(
			'like_datetime', $param, $orderby, $limit, $offset );
	}

	function get_rows_by_place_orderby( $param, $orderby, $limit = 0, $offset = 0 ) {
		return $this->get_rows_by_name_param_orderby(
			'place', $param, $orderby, $limit, $offset );
	}

	function get_rows_by_place_array_orderby( $param, $orderby, $limit = 0, $offset = 0 ) {
		return $this->get_rows_by_name_param_orderby(
			'place_array', $param, $orderby, $limit, $offset );
	}

	function get_rows_by_uid_orderby( $param, $orderby, $limit = 0, $offset = 0 ) {
		return $this->get_rows_by_name_param_orderby(
			'uid', $param, $orderby, $limit, $offset );
	}

	function get_rows_by_search_orderby( $param, $orderby, $limit = 0, $offset = 0 ) {
		return $this->get_rows_by_name_param_orderby(
			'search', $param, $orderby, $limit, $offset );
	}

	function get_rows_by_gmap_catid_array( $catid_array, $orderby, $limit = 0, $offset = 0 ) {
		return $this->get_rows_by_name_param_orderby(
			'gmap_catid_array', $catid_array, $orderby, $limit, $offset );
	}

	function get_rows_by_gmap_latest( $limit = 0, $offset = 0, $key = false ) {
		return $this->get_rows_by_name_param_orderby(
			'gmap_latest', null, $this->_ORDERBY_LATEST, $limit, $offset, $key );
	}

	function get_rows_by_gmap_area( $id, $lat, $lon, $ns, $ew, $limit = 0, $offset = 0, $key = false ) {
		return $this->get_rows_by_name_param_orderby(
			'gmap_area', array( $id, $lat, $lon, $ns, $ew ), $this->_ORDERBY_ASC, $limit, $offset, $key );
	}

	function get_rows_by_name_param_orderby( $name, $param, $orderby, $limit = 0, $offset = 0, $key = false ) {
		$item_key = null;
		if ( $key ) {
			$item_key = 'item_id';
		}

		if ( $this->_cfg_perm_cat_read == _C_WEBPHOTO_OPT_PERM_READ_ALL ) {
			return $this->_item_cat_handler->get_rows_item_by_name_param_orderby(
				$name, $param, $orderby, $limit, $offset, $item_key );

		} else {
			return $this->_item_cat_handler->get_rows_item_cat_by_name_param_orderby(
				$name, $param,
				$this->_item_cat_handler->convert_item_field( $orderby ),
				$limit, $offset,
				$this->_item_cat_handler->convert_item_field( $item_key ) );
		}
	}


// get id array

	function get_id_array_by_catid_orderby( $param, $orderby, $limit = 0, $offset = 0 ) {
		return $this->_item_cat_handler->get_id_array_item_by_name_param_orderby(
			'catid', $param, $orderby, $limit, $offset );
	}

// --- class end ---
}

?>
