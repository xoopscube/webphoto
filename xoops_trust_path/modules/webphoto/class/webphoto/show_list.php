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

class webphoto_show_list extends webphoto_show_main_photo {
	public $_get_uid = - 1;    // not set
	public $_UID_DEFAULT = - 1;    // not set


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_show_list( $dirname, $trust_dirname );
		}

		return $instance;
	}


// main

	public function list_get_template() {
		$this->list_get_pathinfo_param();

		if ( $this->list_sel() ) {
			$str = $this->_TEMPLATE_DETAIL;
		} else {
			$str = $this->_TEMPLATE_LIST;
		}
		$ret = $this->_DIRNAME . '_' . $str;

		return $ret;
	}

	public function list_main() {
		if ( $this->list_sel() ) {
			return $this->list_build_detail( $this->_param );
		}

		return $this->list_build_list();
	}

	public function list_sel() {
		if ( $this->_param ) {
			return true;
		}

		return false;
	}


// get pathinfo param

	public function list_get_pathinfo_param() {
		$this->get_pathinfo_param();
	}


// list

	public function list_build_list() {
		return $this->list_build_list_default();
	}

	public function list_build_list_default() {
		$this->assign_xoops_header_default();

		return $this->list_build_list_common();
	}

	public function list_build_list_common( $show_photo_desc = false, $title = null ) {
		$mode = $this->_mode;

		if ( empty( $title ) ) {
			$const = 'title_' . $mode . '_list';
			$title = $this->get_constant( $const );
		}

		$title_s = $this->sanitize( $title );

		$param = array(
			'xoops_pagetitle'   => $title_s,
			'title_bread_crumb' => $title_s,
			'sub_title_s'       => $title_s,
			'photo_list'        => $this->list_get_photo_list(),
		);

		return array_merge(
			$param,
			$this->build_common_param( $mode, $show_photo_desc )
		);
	}

// overwrite
	public function list_get_photo_list() {
		// dummy
	}

	public function list_build_photo_array( $title, $param, $total, $row, $link = null, $photo = null ) {
		if ( empty( $link ) && $param ) {
			$link = $this->build_uri_list_link( $param );
		}

		if ( empty( $photo ) && is_array( $row ) ) {
			$photo = $this->build_photo_show_main( $row );
		}

		return array(
			'title'   => $title,
			'title_s' => $this->sanitize( $title ),
			'link'    => $link,
			'link_s'  => $this->sanitize( $link ),
			'total'   => $total,
			'photo'   => $photo,
		);
	}


// detail list

// overwrite
	public function list_build_detail( $param ) {
		// dummy
	}

	public function list_build_detail_common( $title, $total, $rows, $photos = null ) {
		$title_s = $this->sanitize( $title );

		$show_photo = false;
		$photos     = null;

		if ( empty( $photos ) && is_array( $rows ) && count( $rows ) ) {
			$photos = $this->build_photo_show_from_rows( $rows );
		}

		if ( is_array( $photos ) && count( $photos ) ) {
			$show_photo = true;
		}

		return array(
			'xoops_pagetitle'   => $title_s,
			'title_bread_crumb' => $title_s,
			'total_bread_crumb' => $total,
			'sub_title_s'       => $title_s,
			'sub_desc_s'        => '',
			'show_photo'        => $show_photo,
			'photo_total'       => $total,
			'photos'            => $photos,
			'show_nomatch'      => $this->build_show_nomatch( $total ),
			'show_sort'         => $this->build_show_sort( $total ),
			'random_more_url_s' => $this->list_build_random_more( $total ),
		);
	}

// BUG : not show cat_id
	public function list_build_init_param( $show_photo_desc = false, $cat_id = 0 ) {
		$param               = $this->build_common_param( $this->_mode, $show_photo_desc, $cat_id );
		$param['param_sort'] = $this->build_uri_list_sort();

		return $param;
	}

	public function list_assign_xoops_header( $rss_param = null, $flag_gmap = false ) {
		if ( empty( $rss_param ) ) {
			$rss_param = $this->_param_out;
		}

		$this->assign_xoops_header( $this->_mode, $rss_param, $flag_gmap );
	}


// navi

	public function list_build_navi( $total, $limit, $get_page = null, $get_sort = null ) {
		if ( empty( $get_sort ) ) {
			$get_sort = $this->_get_sort;
		}

		if ( $this->check_show_navi_sort( $get_sort ) ) {
			$url = $this->build_uri_list_navi_url( $get_sort );

			return $this->build_navi( $url, $total, $limit, $get_page );
		}

		return array(
			'show_navi' => false
		);
	}


// uri class

	public function build_uri_list_navi_url( $get_sort ) {
		return $this->_uri_class->build_list_navi_url(
			$this->_mode, $this->_param_out, $get_sort );
	}

	public function build_uri_list_sort() {
		return $this->_uri_class->build_list_sort(
			$this->_mode, $this->_param_out, $this->_get_viewtype );
	}

}
