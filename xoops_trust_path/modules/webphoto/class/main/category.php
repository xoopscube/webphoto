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


class webphoto_main_category extends webphoto_show_list {


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->set_mode( 'category' );

		$this->set_navi_mode( $this->get_ini( 'navi_mode' ) );
		$this->_SHOW_PHOTO_VIEW = $this->get_ini( 'show_photo_in_category' );
		$this->_TEMPLATE_DETAIL = $this->get_ini( 'template_category_detail' );

		$this->init_preload();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_main_category( $dirname, $trust_dirname );
		}

		return $instance;
	}


// list

// overwrite
	public function list_build_list() {
		$this->assign_xoops_header_default();

		$param1 = $this->list_build_list_common();
		$param2 = $this->build_catlist(
			0, $this->_TOP_CATLIST_COLS, $this->_TOP_CATLIST_DELMITA );

		$ret = array_merge( $param1, $param2 );

		return $this->add_show_js_windows( $ret );
	}

// overwrite
	public function list_get_photo_list() {
		$cat_rows = $this->_public_class->get_cat_all_tree_array();
		if ( ! is_array( $cat_rows ) || ! count( $cat_rows ) ) {
			return false;
		}

		$arr = array();
		foreach ( $cat_rows as $row ) {
			$cat_id = $row['cat_id'];

			$show_catpath = false;

			$catpath = $this->build_cat_path( $cat_id );
			if ( is_array( $catpath ) && count( $catpath ) ) {
				$show_catpath = true;
			}

			list( $photo, $total, $this_sum ) = $this->_get_photo_for_list( $cat_id );

			$cat_desc_disp = $this->build_cat_desc_disp( $row );

			$arr[] = array(
				'title'            => '',
				'title_s'          => '',
				'link'             => '',
				'link_s'           => '',
				'total'            => $total,
				'photo'            => $photo,
				'sum'              => $this_sum,
				'show_catpath'     => $show_catpath,
				'catpath'          => $catpath,
				'cat_desc_disp'    => $cat_desc_disp,
				'cat_summary_disp' => $this->_build_cat_summary_disp( $cat_desc_disp )
			);

		}

		return $arr;
	}

	public function _get_photo_for_list( $cat_id ) {
		$photo = null;

		list( $rows, $total, $this_sum ) =
			$this->get_rows_total_by_catid(
				$cat_id, $this->_PHOTO_LIST_ORDER, $this->_PHOTO_LIST_LIMIT );

		if ( is_array( $rows ) && count( $rows ) ) {
			$photo = $this->build_photo_show( $rows[0] );
		}

		return array( $photo, $total, $this_sum );
	}

	public function _build_cat_summary_disp( $desc ) {
		return $this->_multibyte_class->build_summary( $desc, $this->_cfg_cat_summary );
	}


// detail list

// overwrite
	public function list_build_detail( $cat_id ) {
// BUG : not show cat_id
		$init_param = $this->list_build_init_param( true, $cat_id );

		$photo_param = $this->build_photos_param_in_category( $cat_id );
		$title       = $photo_param['cat_title'];
		$photo_rows  = $photo_param['cat_photo_rows'];
		$show_sort   = $photo_param['cat_show_sort'];

		$title_s = $this->sanitize( $title );
		$param   = array(
			'xoops_pagetitle' => $title_s,
			'show_sort'       => $show_sort,
		);

		if ( $this->_SHOW_PHOTO_VIEW && isset( $photo_rows[0] ) ) {
			$photo_param['photo']           = $this->build_photo_show_photo( $photo_rows[0] );
			$photo_param['show_photo_desc'] = true;
		}

		$catlist_param = $this->build_catlist(
			$cat_id, $this->_CAT_CATLIST_COLS, $this->_CAT_CATLIST_DELMITA );

		$gmap_param = $this->build_gmap( $cat_id, $this->_MAX_GMAPS );
		$show_gmap  = $gmap_param['show_gmap'];

		$noti_param = $this->build_notification_select( $cat_id );

		$this->list_assign_xoops_header( $cat_id, $show_gmap );

		$arr            = array_merge( $init_param, $param, $photo_param, $catlist_param, $gmap_param, $noti_param );
		$arr['show_qr'] = false;

		return $this->add_show_js_windows( $arr );
	}

}
