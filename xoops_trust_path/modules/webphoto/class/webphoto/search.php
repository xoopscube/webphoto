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


class webphoto_search extends webphoto_base_this {
	public $_public_class;
	public $_search_class;

	public $_min_keyword;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_public_class
			=& webphoto_photo_public::getInstance( $dirname, $trust_dirname );

		$this->_search_class =& webphoto_lib_search::getInstance();

		$this->_min_keyword =
			$this->_search_class->get_xoops_config_search_keyword_min();

		$this->_search_class->set_lang_zenkaku( $this->get_constant( 'SR_ZENKAKU' ) );
		$this->_search_class->set_lang_hankaku( $this->get_constant( 'SR_HANKAKU' ) );
		$this->_search_class->set_min_keyword( $this->_min_keyword );
		$this->_search_class->set_is_japanese( $this->_is_japanese );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_search( $dirname, $trust_dirname );
		}

		return $instance;
	}


// detail

	public function build_total_for_detail( $query ) {
		$title = _SR_SEARCH;
		$total = 0;

		$sql_query = $this->build_sql_query( $query );
		if ( ! $sql_query ) {
			return array( $sql_query, $title, $total );
		}

		$total = $this->_public_class->get_count_by_search( $sql_query );
		if ( $total > 0 ) {
			$title = _SR_SEARCH . ' : ' . $this->_search_class->get_query_raw( 's' );
		}

		return array( $sql_query, $title, $total );
	}

	public function build_sql_query( $query ) {
		$this->_search_class->get_post_get_param();
		$this->_search_class->set_query( $query );

		$ret = $this->_search_class->parse_query();
		if ( ! $ret ) {
			return null;
		}

		$sql_query = $this->_search_class->build_sql_query( 'item_search' );

		return $sql_query;
	}

	public function build_rows_for_detail( $sql_query, $orderby, $limit = 0, $start = 0 ) {
		return $this->_public_class->get_rows_by_search_orderby(
			$sql_query, $orderby, $limit, $start );
	}

	public function build_query_param( $total ) {
		$param                          = $this->_search_class->get_query_param();
		$param['show_search']           = true;
		$param['lang_keytooshort']      = $this->build_lang_keytooshort();
		$param['show_lang_keytooshort'] = $this->build_show_lang_keytooshort( $total, $param );

		return $param;
	}

	public function build_lang_keytooshort() {
		$str = sprintf( $this->get_constant( 'SEARCH_KEYTOOSHORT' ), $this->_min_keyword );

		return $str;
	}

	public function build_show_lang_keytooshort( $total, $param ) {
		return $param['search_query'] && ( $total == 0 );
	}


// rss

	public function build_rows_for_rss( $query, $orderby, $limit = 0, $start = 0 ) {
		$sql_query = $this->build_sql_query( $query );
		if ( ! $sql_query ) {
			return null;
		}

		return $this->build_rows_for_detail(
			$sql_query, $orderby, $limit, $start );
	}

}
