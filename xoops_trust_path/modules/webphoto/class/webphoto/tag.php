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


class webphoto_tag extends webphoto_base_this {
	public $_tagcloud_class;

	public $_TAG_LIST_START = 0;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_tagcloud_class
			=& webphoto_inc_tagcloud::getSingleton( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_tag( $dirname, $trust_dirname );
		}

		return $instance;
	}


// list

	public function build_rows_for_list() {
		$tag_list_limit  = $this->get_ini( 'tag_list_limit' );
		$tag_photo_limit = $this->get_ini( 'tag_photo_limit' );

		$tag_rows = $this->get_tag_rows(
			$tag_list_limit, $this->_TAG_LIST_START );
		if ( ! is_array( $tag_rows ) || ! count( $tag_rows ) ) {
			return false;
		}

		$i   = 0;
		$arr = array();
		foreach ( $tag_rows as $row ) {
			$tag_name = $row['tag_name'];
			$total    = $row['photo_count'];

			$photo_row = $this->get_first_row_by_tag_orderby(
				$tag_name, $this->_PHOTO_LIST_UPDATE_ORDER, $this->_PHOTO_LIST_LIMIT );

			$arr[] = array( $tag_name, $tag_name, $total, $photo_row );

			$i ++;
			if ( $i > $tag_photo_limit ) {
				break;
			}
		}

		return $arr;
	}


// detail

	public function build_total_for_detail( $tag_in ) {
		$tag_name = $this->decode_uri_str( $tag_in );

		$title = $this->build_title( $tag_name );
		$total = $this->get_count_by_tag( $tag_name );

		return array( $tag_name, $title, $total );
	}

	public function build_rows_for_detail( $tag_name, $orderby, $limit = 0, $start = 0 ) {
		return $this->get_rows_by_tag_orderby(
			$tag_name, $orderby, $limit, $start );
	}

	public function build_title( $tag_name ) {
		$str = $this->get_constant( 'TITLE_TAGS' ) . ' : ' . $tag_name;

		return $str;
	}


// rss

	public function build_rows_for_rss( $tag_in, $orderby, $limit = 0, $start = 0 ) {
		$tag_name = $this->decode_uri_str( $tag_in );

		return $this->build_rows_for_detail(
			$tag_name, $orderby, $limit, $start );
	}


// tagcloud class

	public function get_count_by_tag( $param ) {
		return $this->_tagcloud_class->get_item_count_by_tag( $param );
	}

	public function get_tag_rows( $limit = 0, $offset = 0 ) {
		return $this->_tagcloud_class->get_tag_rows( $limit, $offset );
	}

	public function get_first_row_by_tag_orderby( $param, $orderby, $limit = 0, $offset = 0 ) {
		$row    = null;
		$id_arr = $this->_tagcloud_class->get_item_id_array_by_tag(
			$param, $orderby, $limit, $offset );

		if ( isset( $id_arr[0] ) ) {
			$row = $this->_item_handler->get_row_by_id( $id_arr[0] );
		}

		return $row;
	}

	public function get_rows_by_tag_orderby( $param, $orderby, $limit = 0, $offset = 0 ) {
		$rows   = null;
		$id_arr = $this->_tagcloud_class->get_item_id_array_by_tag(
			$param, $orderby, $limit, $offset );

		if ( is_array( $id_arr ) && count( $id_arr ) ) {
			$rows = $this->_item_handler->get_rows_from_id_array( $id_arr );
		}

		return $rows;
	}

}
