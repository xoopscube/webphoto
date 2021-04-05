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


class webphoto_cat_handler extends webphoto_handler_base_ini {

	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->set_table_prefix_dirname( 'cat' );
		$this->set_id_name( 'cat_id' );
		$this->set_pid_name( 'cat_pid' );
		$this->set_order_default( 'cat_weight ASC, cat_title ASC, cat_id ASC' );
		$this->init_xoops_tree();

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_cat_handler( $dirname, $trust_dirname );
		}

		return $instance;
	}


// create

	public function create( $flag_new = false ) {
		$time_create = 0;
		$time_update = 0;

		if ( $flag_new ) {
			$time        = time();
			$time_create = $time;
			$time_update = $time;
		}

		$arr = array(
			'cat_id'             => 0,
			'cat_time_create'    => $time_create,
			'cat_time_update'    => $time_update,
			'cat_gicon_id'       => 0,
			'cat_forum_id'       => 0,
			'cat_pid'            => 0,
			'cat_title'          => '',
			'cat_img_path'       => '',
			'cat_img_name'       => '',
			'cat_weight'         => $this->get_ini( 'cat_weight_default' ),
			'cat_depth'          => 0,
			'cat_allowed_ext'    => $this->get_ini( 'cat_allowed_ext_default' ),
			'cat_img_mode'       => 0,
			'cat_orig_width'     => 0,
			'cat_orig_height'    => 0,
			'cat_main_width'     => 0,
			'cat_main_height'    => 0,
			'cat_sub_width'      => 0,
			'cat_sub_height'     => 0,
			'cat_item_type'      => 0,
			'cat_gmap_mode'      => 0,
			'cat_gmap_latitude'  => 0,
			'cat_gmap_longitude' => 0,
			'cat_gmap_zoom'      => 0,
			'cat_gmap_type'      => 0,
			'cat_perm_read'      => $this->get_ini( 'cat_perm_read_default' ),
			'cat_perm_post'      => $this->get_ini( 'cat_perm_post_default' ),
			'cat_description'    => '',
			'cat_group_id'       => '0',
			'cat_timeline_mode'  => 0,
			'cat_timeline_scale' => $this->get_ini( 'cat_timeline_scale_default' ),
		);

		for ( $i = 1; $i <= _C_WEBPHOTO_MAX_CAT_TEXT; $i ++ ) {
			$arr[ 'cat_text' . $i ] = '';
		}

		return $arr;
	}


// insert

	public function insert( $row, $force = false ) {
		extract( $row );

		$sql = 'INSERT INTO ' . $this->_table . ' (';

		if ( $cat_id > 0 ) {
			$sql .= 'cat_id, ';
		}

		$sql .= 'cat_time_create, ';
		$sql .= 'cat_time_update, ';
		$sql .= 'cat_gicon_id, ';
		$sql .= 'cat_forum_id, ';
		$sql .= 'cat_pid, ';
		$sql .= 'cat_title, ';
		$sql .= 'cat_img_path, ';
		$sql .= 'cat_img_name, ';
		$sql .= 'cat_weight, ';
		$sql .= 'cat_depth, ';
		$sql .= 'cat_allowed_ext, ';
		$sql .= 'cat_img_mode, ';
		$sql .= 'cat_orig_width, ';
		$sql .= 'cat_orig_height, ';
		$sql .= 'cat_main_width, ';
		$sql .= 'cat_main_height, ';
		$sql .= 'cat_sub_width, ';
		$sql .= 'cat_sub_height, ';
		$sql .= 'cat_item_type, ';
		$sql .= 'cat_gmap_mode, ';
		$sql .= 'cat_gmap_latitude, ';
		$sql .= 'cat_gmap_longitude, ';
		$sql .= 'cat_gmap_zoom, ';
		$sql .= 'cat_gmap_type, ';
		$sql .= 'cat_perm_read, ';
		$sql .= 'cat_perm_post, ';
		$sql .= 'cat_group_id, ';
		$sql .= 'cat_timeline_mode, ';
		$sql .= 'cat_timeline_scale, ';

		for ( $i = 1; $i <= _C_WEBPHOTO_MAX_CAT_TEXT; $i ++ ) {
			$sql .= 'cat_text' . $i . ', ';
		}

		$sql .= 'cat_description ';

		$sql .= ') VALUES ( ';

		if ( $cat_id > 0 ) {
			$sql .= (int) $cat_id . ', ';
		}

		$sql .= (int) $cat_time_create . ', ';
		$sql .= (int) $cat_time_update . ', ';
		$sql .= (int) $cat_gicon_id . ', ';
		$sql .= (int) $cat_forum_id . ', ';
		$sql .= (int) $cat_pid . ', ';
		$sql .= $this->quote( $cat_title ) . ', ';
		$sql .= $this->quote( $cat_img_path ) . ', ';
		$sql .= $this->quote( $cat_img_name ) . ', ';
		$sql .= (int) $cat_weight . ', ';
		$sql .= (int) $cat_depth . ', ';
		$sql .= $this->quote( $cat_allowed_ext ) . ', ';
		$sql .= (int) $cat_img_mode . ', ';
		$sql .= (int) $cat_orig_width . ', ';
		$sql .= (int) $cat_orig_height . ', ';
		$sql .= (int) $cat_main_width . ', ';
		$sql .= (int) $cat_main_height . ', ';
		$sql .= (int) $cat_sub_width . ', ';
		$sql .= (int) $cat_sub_height . ', ';
		$sql .= (int) $cat_item_type . ', ';
		$sql .= (int) $cat_gmap_mode . ', ';
		$sql .= (float) $cat_gmap_latitude . ', ';
		$sql .= (float) $cat_gmap_longitude . ', ';
		$sql .= (int) $cat_gmap_zoom . ', ';
		$sql .= (int) $cat_gmap_type . ', ';
		$sql .= $this->quote( $cat_perm_read ) . ', ';
		$sql .= $this->quote( $cat_perm_post ) . ', ';
		$sql .= (int) $cat_group_id . ', ';
		$sql .= (int) $cat_timeline_mode . ', ';
		$sql .= (int) $cat_timeline_scale . ', ';

		for ( $i = 1; $i <= _C_WEBPHOTO_MAX_CAT_TEXT; $i ++ ) {
			$sql .= $this->quote( $row[ 'cat_text' . $i ] ) . ', ';
		}

		$sql .= $this->quote( $cat_description ) . ' ';

		$sql .= ')';

		$ret = $this->query( $sql );
		if ( ! $ret ) {
			return false;
		}

		return $this->_db->getInsertId();
	}


// update

	public function update( $row, $force = false ) {
		extract( $row );

		$sql = 'UPDATE ' . $this->_table . ' SET ';
		$sql .= 'cat_time_create=' . (int) $cat_time_create . ', ';
		$sql .= 'cat_time_update=' . (int) $cat_time_update . ', ';
		$sql .= 'cat_gicon_id=' . (int) $cat_gicon_id . ', ';
		$sql .= 'cat_forum_id=' . (int) $cat_forum_id . ', ';
		$sql .= 'cat_pid=' . (int) $cat_pid . ', ';
		$sql .= 'cat_title=' . $this->quote( $cat_title ) . ', ';
		$sql .= 'cat_img_path=' . $this->quote( $cat_img_path ) . ', ';
		$sql .= 'cat_img_name=' . $this->quote( $cat_img_name ) . ', ';
		$sql .= 'cat_weight=' . (int) $cat_weight . ', ';
		$sql .= 'cat_depth=' . (int) $cat_depth . ', ';
		$sql .= 'cat_allowed_ext=' . $this->quote( $cat_allowed_ext ) . ', ';
		$sql .= 'cat_img_mode=' . (int) $cat_img_mode . ', ';
		$sql .= 'cat_orig_width=' . (int) $cat_orig_width . ', ';
		$sql .= 'cat_orig_height=' . (int) $cat_orig_height . ', ';
		$sql .= 'cat_main_width=' . (int) $cat_main_width . ', ';
		$sql .= 'cat_main_height=' . (int) $cat_main_height . ', ';
		$sql .= 'cat_sub_width=' . (int) $cat_sub_width . ', ';
		$sql .= 'cat_sub_height=' . (int) $cat_sub_height . ', ';
		$sql .= 'cat_item_type=' . (int) $cat_item_type . ', ';
		$sql .= 'cat_gmap_mode=' . (int) $cat_gmap_mode . ', ';
		$sql .= 'cat_gmap_latitude=' . (float) $cat_gmap_latitude . ', ';
		$sql .= 'cat_gmap_longitude=' . (float) $cat_gmap_longitude . ', ';
		$sql .= 'cat_gmap_zoom=' . (int) $cat_gmap_zoom . ', ';
		$sql .= 'cat_gmap_type=' . (int) $cat_gmap_type . ', ';
		$sql .= 'cat_perm_read=' . $this->quote( $cat_perm_read ) . ', ';
		$sql .= 'cat_perm_post=' . $this->quote( $cat_perm_post ) . ', ';
		$sql .= 'cat_group_id=' . (int) $cat_group_id . ', ';
		$sql .= 'cat_timeline_mode=' . (int) $cat_timeline_mode . ', ';
		$sql .= 'cat_timeline_scale=' . (int) $cat_timeline_scale . ', ';

		for ( $i = 1; $i <= _C_WEBPHOTO_MAX_CAT_TEXT; $i ++ ) {
			$name = 'cat_text' . $i;
			$sql  .= $name . '=' . $this->quote( $row[ $name ] ) . ', ';
		}

		$sql .= 'cat_description=' . $this->quote( $cat_description ) . ' ';
		$sql .= 'WHERE cat_id=' . (int) $cat_id;

		return $this->query( $sql );
	}

	public function update_pid( $cat_id, $cat_pid ) {
		$sql = 'UPDATE ' . $this->_table . ' SET ';
		$sql .= 'cat_pid=' . (int) $cat_pid . ' ';
		$sql .= 'WHERE cat_id=' . (int) $cat_id;

		return $this->query( $sql );
	}

	public function update_weight( $cat_id, $cat_weight ) {
		$sql = 'UPDATE ' . $this->_table . ' SET ';
		$sql .= 'cat_weight=' . (int) $cat_weight . ' ';
		$sql .= 'WHERE cat_id=' . (int) $cat_id;

		return $this->query( $sql );
	}

	public function clear_gicon_id( $gicon_id ) {
		$sql = 'UPDATE ' . $this->_table . ' SET ';
		$sql .= 'cat_gicon_id=0 ';
		$sql .= 'WHERE cat_gicon_id=' . (int) $gicon_id;

		return $this->query( $sql );
	}


// cached

	public function get_cached_title_by_id( $cat_id, $flag_sanitize = false ) {
		return $this->get_cached_value_by_id_name(
			$cat_id, 'cat_title', $flag_sanitize );
	}

	public function get_cached_timeline_scale_by_id( $cat_id, $flag_sanitize = false ) {
		return $this->get_cached_value_by_id_name(
			$cat_id, 'cat_timeline_scale', $flag_sanitize );
	}


// rows

	public function get_rows_ghost() {
		$live_cids = $this->getAllChildId( 0 );

		$where = 'cat_id NOT IN ( ';
		foreach ( $live_cids as $cid ) {
			$where .= $cid . ', ';
		}
		$where .= ' 0 )';

		return $this->get_rows_by_where( $where );
	}

	public function get_rows_by_pid( $pid, $limit = 0, $offset = 0 ) {
		$sql = 'SELECT * FROM ' . $this->_table;
		$sql .= ' WHERE cat_pid=' . $pid;
		$sql .= ' ORDER BY cat_title ASC';

		return $this->get_rows_by_sql( $sql, $limit, $offset );
	}

	public function get_rows_by_pid_orderby( $pid, $order, $limit = 0, $offset = 0 ) {
		return $this->get_rows_by_pid_order( $pid, $order, $limit, $offset );
	}


// permission

	public function get_perm_read_array( $row ) {
		return $this->get_perm_array_by_row_name( $row, 'cat_perm_read' );
	}

	public function get_perm_post_array( $row ) {
		return $this->get_perm_array_by_row_name( $row, 'cat_perm_post' );
	}

	public function check_perm_read_by_id( $id, $flag_admin = false ) {
		$row = $this->get_row_by_id( $id );

		return $this->check_perm_read_by_row( $row, $flag_admin );
	}

	public function check_perm_post_by_id( $id, $flag_admin = false ) {
		$row = $this->get_row_by_id( $id );

		return $this->check_post_read_by_row( $row, $flag_admin );
	}

	public function check_perm_read_by_row( $row, $flag_admin = false ) {
		return $this->check_perm_by_row_name_groups( $row, 'cat_perm_read', $flag_admin );
	}

	public function check_perm_post_by_row( $row, $flag_admin = false ) {
		return $this->check_perm_by_row_name_groups( $row, 'cat_perm_post', $flag_admin );
	}

	public function is_cached_public_read_in_all_parents_by_id( $id ) {
		return $this->check_cached_perm_in_parents_by_id_name_groups_key(
			$id, 'cat_perm_read', array( XOOPS_GROUP_ANONYMOUS ) );
	}


// for show
	public function build_show_desc_disp( $row ) {
		( method_exists( 'MyTextSanitizer', 'sGetInstance' ) and $myts =& MyTextSanitizer::sGetInstance() ) || $myts =& MyTextSanitizer::getInstance();

		return $myts->displayTarea( $row['cat_description'], 0, 1, 1, 1, 1, 1 );
	}

	public function build_show_img_path( $row ) {
		$img_path = $row['cat_img_path'];
		if ( $this->check_http_null( $img_path ) ) {
			$url = '';
		} elseif ( $this->check_http_start( $img_path ) ) {
			$url = $img_path;
		} else {
			$url = XOOPS_URL . $this->add_slash_to_head( $img_path );
		}

		return $url;
	}

	public function check_http_null( $str ) {
		return ( $str == '' ) || ( $str == 'http://' ) || ( $str == 'https://' );
	}

	public function check_http_start( $str ) {
		if ( preg_match( "|^https?://|", $str ) ) {
			return true;    // include HTTP
		}

		return false;
	}

	public function add_slash_to_head( $str ) {
// ord : the ASCII value of the first character of string
// 0x2f slash

		if ( ord( $str ) != 0x2f ) {
			$str = "/" . $str;
		}

		return $str;
	}


// selbox

	public function build_selbox_catid( $cat_id, $sel_name = 'cat_id' ) {
		return $this->make_my_sel_box( 'cat_title', '', $cat_id, 0, $sel_name );
	}

	public function build_selbox_pid( $pid ) {
		return $this->make_my_sel_box( 'cat_title', '', $pid, 1, 'cat_pid' );
	}

	public function build_selbox_with_perm_post( $cat_id, $sel_name, $show = false, $flag_admin = false ) {
		$str = $this->build_form_select_tag( $sel_name );

// Warning [PHP]: Missing argument
		$str .= $this->build_options_with_perm_post( $cat_id, $show, $flag_admin );

		$str .= $this->build_form_select_tag_close();

		return $str;
	}

	public function build_options_with_perm_post( $value, $show = false, $flag_admin = false ) {
		$rows = $this->get_all_tree_array();

		return $this->build_form_select_options_with_perm_post( $rows, 'cat_title', $value, 'cat_perm_post', 'cat_perm_read', $show, $flag_admin );
	}

	public function build_id_options( $none = false, $none_name = '---' ) {
		return $this->get_tree_name_list( 'cat_title', $none, $none_name );
	}

}

