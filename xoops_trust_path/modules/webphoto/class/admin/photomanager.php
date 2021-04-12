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


class webphoto_admin_photomanager extends webphoto_edit_base {
	public $_search_class;
	public $_delete_class;

	public $_get_perpage;
	public $_get_catid;
	public $_get_pos;
	public $_get_txt;
	public $_get_mes;

	public $_ADMIN_PHOTO_PHP;
	public $_THIS_URL;

	public $_MAX_COL = 4;
	public $_PERPAGE_DEFAULT = 20;

	public $_TIME_SUCCESS = 1;
	public $_TIME_FAIL = 5;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_search_class =& webphoto_edit_search_build::getInstance( $dirname, $trust_dirname );
		$this->_delete_class =& webphoto_edit_item_delete::getInstance( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_photomanager( $dirname, $trust_dirname );
		}

		return $instance;
	}


	function main() {
		$this->_get_perpage = $this->_post_class->get_get_int( 'perpage', $this->_PERPAGE_DEFAULT );
		$this->_get_catid   = $this->_post_class->get_get_int( 'cat_id' );
		$this->_get_pos     = $this->_post_class->get_get_int( 'pos' );
		$this->_get_txt     = $this->_post_class->get_get_text( 'txt' );
		$this->_get_mes     = $this->_post_class->get_get_text( 'mes' );

		switch ( $this->_get_action() ) {
			case 'delete':
				$this->_delete();
				exit();

			case 'update':
				$this->_update();
				exit();

			default:
				break;
		}

		xoops_cp_header();
		echo $this->build_admin_menu();

		$this->_print_form();

		xoops_cp_footer();
	}

	function _get_action() {
		$action = null;
		if ( ! empty( $_POST['action'] ) && $_POST['action'] == 'delete' && isset( $_POST['ids'] ) && is_array( $_POST['ids'] ) ) {
			$action = 'delete';
		} else if ( isset( $_POST['update'] ) && isset( $_POST['ids'] ) && is_array( $_POST['ids'] ) ) {
			$action = 'update';
		}

		return $action;
	}


// delete

	function _delete() {
		if ( ! $this->check_token() ) {
			redirect_header( $this->_ADMIN_PHOTO_PHP, $this->_TIME_FAIL, $this->get_token_errors() );
			exit();
		}

		foreach ( $_POST['ids'] as $id ) {
			$this->_delete_class->delete_photo_by_item_id( $id );
		}

		$url = 'index.php?fct=photomanager&amp;cat_id=' . $this->_get_catid;
		redirect_header( $url, $this->_TIME_SUCCESS, _WEBPHOTO_DELETED );
		exit;
	}


// update

	function _update() {
		if ( ! $this->check_token() ) {
			redirect_header( $this->_ADMIN_PHOTO_PHP, $this->_TIME_FAIL, $this->get_token_errors() );
			exit();
		}

		$post_cat_id      = $this->_post_class->get_post_int( 'new_cat_id' );
		$post_uid         = $this->_post_class->get_post_int( 'new_uid' );
		$post_title       = $this->_post_class->get_post_text( 'new_title' );
		$post_place       = $this->_post_class->get_post_text( 'new_place' );
		$post_equipment   = $this->_post_class->get_post_text( 'new_equipment' );
		$post_description = $this->_post_class->get_post_text( 'new_description' );

		$post_text = array();
		for ( $i = 1; $i <= _C_WEBPHOTO_MAX_PHOTO_TEXT; $i ++ ) {
			$post_text[ $i ] = $this->_post_class->get_post_text( 'new_text' . $i );
		}

		$post_new_datetime_checkbox = $this->_post_class->get_post_int( 'new_datetime_checkbox' );
		$post_new_datetime          = $this->_item_create_class->build_datetime_by_post( 'new_datetime' );

		$post_new_time_update_checkbox = $this->_post_class->get_post_int( 'new_time_update_checkbox' );
		$post_new_time_update          = $this->_post_class->get_post_text( 'new_time_update' );

		$flag_cat_id      = false;
		$flag_uid         = false;
		$flag_title       = false;
		$flag_place       = false;
		$flag_equipment   = false;
		$flag_description = false;
		$flag_datetime    = false;
		$post_datetime    = '';
		$flag_time_update = false;
		$post_time_update = '';

		if ( $post_cat_id > 0 ) {
			$flag_cat_id = true;
		}

		if ( $post_uid > 0 ) {
			$flag_uid = true;
		}

		if ( $post_title ) {
			$flag_title = true;
		}

		if ( $post_place ) {
			$flag_place = true;
		}

		if ( $post_equipment ) {
			$flag_equipment = true;
		}

		if ( $post_description ) {
			$flag_description = true;
		}

		if ( $post_new_datetime_checkbox && $post_new_datetime ) {
			$flag_datetime = true;
			$post_datetime = $post_new_datetime;
		}

		if ( $post_new_time_update_checkbox && $post_new_time_update ) {
			$new_update = strtotime( $post_new_time_update );
			if ( $new_update != - 1 ) {
				$flag_time_update = true;
				$post_time_update = $new_update;
			}
		}

		foreach ( $_POST['ids'] as $id ) {
			$row = $this->_item_create_class->get_row_by_id( $id );
			if ( ! is_array( $row ) ) {
				continue;
			}

			if ( $flag_cat_id ) {
				$row['item_cat_id'] = $post_cat_id;
			}

			if ( $flag_uid ) {
				$row['item_uid'] = $post_uid;
			}

			if ( $flag_title ) {
				$row['item_title'] = $post_title;
			}

			if ( $flag_place ) {
				$row['item_place'] = $post_place;
			}

			if ( $flag_equipment ) {
				$row['item_equipment'] = $post_equipment;
			}

			if ( $flag_description ) {
				$row['item_description'] = $post_description;
			}

			for ( $i = 1; $i <= _C_WEBPHOTO_MAX_PHOTO_TEXT; $i ++ ) {
				if ( $post_text[ $i ] ) {
					$row[ 'item_text_' . $i ] = $post_text[ $i ];
				}
			}

			if ( $flag_datetime ) {
				$row['item_datetime'] = $post_datetime;
			}

			if ( $flag_time_update ) {
				$row['item_time_update'] = $post_time_update;
			}

			$row['item_search'] = $this->_search_class->build_with_tag( $row );

			$this->format_and_update_item( $row );
		}

		$url = 'index.php?fct=photomanager&amp;perpage=' . $this->_get_perpage;
		$url .= '&amp;cat_id=' . $this->_get_catid . '&amp;txt=' . urlencode( $this->_get_txt );

		redirect_header( $url, $this->_TIME_SUCCESS, _WEBPHOTO_DBUPDATED );
		exit;
	}


// print_form

	function _print_form() {
		$form_class =& webphoto_admin_photo_form::getInstance(
			$this->_DIRNAME, $this->_TRUST_DIRNAME );

		$keyword_array = $this->str_to_array( $this->_get_txt, ' ' );
		$where         = $this->_item_create_class->build_where_by_keyword_array_catid(
			$keyword_array, $this->_get_catid );

		$limit = $this->_get_perpage;
		$start = $this->_get_pos;

		if ( $where ) {
			$total = $this->_item_create_class->get_count_by_where( $where );
			$rows  = $this->_item_create_class->get_rows_by_where( $where, $limit, $start );

		} else {
			$total = $this->_item_create_class->get_count_all();
			$rows  = $this->_item_create_class->get_rows_all_asc( $limit, $start );
		}

// Information of page navigating
		$end          = $form_class->_pagenavi_class->calc_end( $start, $limit, $total );
		$photonavinfo = sprintf( _WEBPHOTO_S_NAVINFO, $start + 1, $end, $total );

// --- print ---
		echo $this->build_admin_title( 'PHOTOMANAGER' );

		$form_class->print_form( $total, $rows, $limit, $photonavinfo );

	}


}


