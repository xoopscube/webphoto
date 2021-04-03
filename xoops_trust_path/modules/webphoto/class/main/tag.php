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


class webphoto_main_tag extends webphoto_show_list {
	public $_LIST_LIMIT = 0;
	public $_LIST_START = 0;
	public $_LIST_PHOTO_LIMIT = 10;

	public $_list_rows = null;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->set_mode( 'tag' );
		$this->init_preload();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_main_tag( $dirname, $trust_dirname );
		}

		return $instance;
	}


// overwrite
	function list_build_list() {
		$this->assign_xoops_header_default();

		$param1 = $this->list_build_list_common();
		$param2 = $this->_get_tagcloud_param();

		$ret = array_merge( $param1, $param2 );

		return $this->add_show_js_windows( $ret );
	}

// overwrite
	function list_get_photo_list() {
		$list_rows = $this->_public_class->get_tag_rows( $this->_LIST_LIMIT, $this->_LIST_START );
		if ( ! is_array( $list_rows ) ) {
			return false;
		}

		$this->_list_rows = $list_rows;

		$i   = 0;
		$arr = array();
		foreach ( $list_rows as $row ) {
			$tag_name = $row['tag_name'];
			$total    = $row['photo_count'];

			$photo_row = $this->_public_class->get_first_row_by_tag_orderby(
				$tag_name, $this->_PHOTO_LIST_ORDER, $this->_PHOTO_LIST_LIMIT );

			$arr[] = $this->list_build_photo_array(
				$tag_name, $tag_name, $total, $photo_row );

			$i ++;
			if ( $i > $this->_LIST_PHOTO_LIMIT ) {
				break;
			}
		}

		return $arr;
	}

	function _get_tagcloud_param() {
		$show     = false;
		$tagcloud = null;
		$error    = null;

		if ( is_array( $this->_list_rows ) && count( $this->_list_rows ) ) {
			$tagcloud = $this->_public_class->build_tagcloud_by_rows( $this->_list_rows );
			if ( is_array( $tagcloud ) && count( $tagcloud ) ) {
				$show = true;
			}
		}

		if ( ! $show ) {
			$error = $this->get_constant( 'NO_TAG' );
		}

		$arr = array(
			'show_tagcloud' => $show,
			'tagcloud'      => $tagcloud,
			'error'         => $error,
		);

		return $arr;
	}


// detail list

// overwrite
	function list_build_detail( $tag_in ) {
		$rows    = null;
		$limit   = $this->_MAX_PHOTOS;
		$start   = $this->pagenavi_calc_start( $limit );
		$orderby = $this->get_orderby_by_post();

		$tag_name   = $this->decode_uri_str( $tag_in );
		$init_param = $this->list_build_init_param( true );

		$title = $this->get_constant( 'TITLE_TAGS' ) . ' : ' . $tag_name;
		$total = $this->_public_class->get_count_by_tag( $tag_name );

		if ( $total > 0 ) {
			$rows = $this->_public_class->get_rows_by_tag_orderby(
				$tag_name, $orderby, $limit, $start );
		}

		$param          = $this->list_build_detail_common( $title, $total, $rows );
		$tagcloud_param = $this->_public_class->build_tagcloud( $this->_MAX_TAG_CLOUD );
		$navi_param     = $this->list_build_navi( $total, $limit );

		$this->list_assign_xoops_header();

		$ret = array_merge( $param, $init_param, $tagcloud_param, $navi_param );

		return $this->add_show_js_windows( $ret );
	}

// --- class end ---
}

?>
