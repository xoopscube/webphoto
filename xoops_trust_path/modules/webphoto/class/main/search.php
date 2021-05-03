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


class webphoto_main_search extends webphoto_show_list {
	public $_search_class;

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->set_mode( 'search' );

		$this->_search_class =& webphoto_lib_search::getInstance();
		$this->_search_class->set_lang_zenkaku( $this->get_constant( 'SR_ZENKAKU' ) );
		$this->_search_class->set_lang_hankaku( $this->get_constant( 'SR_HANKAKU' ) );
		$this->_search_class->set_min_keyword( $this->_search_class->get_xoops_config_search_keyword_min() );
		$this->_search_class->set_is_japanese( $this->_is_japanese );

		$this->init_preload();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_main_search( $dirname, $trust_dirname );
		}

		return $instance;
	}


// main

// overwrite
	public function list_sel() {
		return true;
	}


// detail list

// overwrite
	public function list_build_detail( $query_in ) {

		$rows    = null;
		$limit   = $this->_MAX_PHOTOS;
		$start   = $this->pagenavi_calc_start( $limit );
		$orderby = $this->get_orderby_by_post();

		$query_in    = $this->_utility_class->decode_slash( $query_in );
		$photo_param = $this->_get_photos( $query_in, $orderby, $limit, $start );
		$total       = $photo_param['total'];
		$rows        = $photo_param['rows'];
		$error       = $photo_param['error'];

		$query_param = $this->_search_class->get_query_param();
		$query       = $query_param['search_query'];
		$query_array = $query_param['search_query_array'];

		$this->set_param_out( $query );

		$this->set_flag_highlight( true );
		$this->set_keyword_array( $query_array );

		$init_param = $this->list_build_init_param( true );
		$param      = $this->list_build_detail_common( _SR_SEARCH, $total, $rows );
		$navi_param = $this->list_build_navi( $total, $limit );

		$this->list_assign_xoops_header();

		$arr = array(
			'show_search'                  => true,
			'show_search_lang_keytooshort' => $error,
		);

		$ret = array_merge( $arr, $param, $init_param, $navi_param, $query_param );

		return $this->add_show_js_windows( $ret );
	}

	public function _get_photos( $query, $orderby, $limit, $start ) {
		$rows = null;

		$this->_search_class->get_post_get_param();
		$this->_search_class->set_query( $query );

		$ret = $this->_search_class->parse_query();
		if ( ! $ret ) {
			$arr = array(
				'total' => 0,
				'rows'  => null,
				'error' => true,
			);

			return $arr;
		}

		$sql_query = $this->_search_class->build_sql_query( 'item_search' );
		$total     = $this->_public_class->get_count_by_search( $sql_query );

		if ( $total > 0 ) {
			$rows = $this->_public_class->get_rows_by_search_orderby( $sql_query, $orderby, $limit, $start );
		}

		$arr = array(
			'total' => $total,
			'rows'  => $rows,
			'error' => false,
		);

		return $arr;
	}

}
