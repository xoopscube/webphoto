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


class webphoto_admin_syno_table_manage extends webphoto_lib_manage {


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
		$this->set_manage_handler(
			webphoto_syno_handler::getInstance( $dirname, $trust_dirname ) );
		$this->set_manage_title_by_name( 'SYNO_TABLE_MANAGE' );

		$this->set_manage_sub_title_array(
			array( 'ID ascent', 'ID descent', 'Weight ascent', 'Weight descent' ) );

		$this->set_manage_list_column_array(
			array( 'syno_weight', 'syno_key', 'syno_value' ) );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_syno_table_manage( $dirname, $trust_dirname );
		}

		return $instance;
	}


	function main() {
		$this->_main();
	}


// override for caller

	function _build_row_by_post( $row = array() ) {
		$row = array(
			'syno_id'          => $this->_post_class->get_post_get_int( 'syno_id' ),
			'syno_time_create' => $this->_post_class->get_post_int( 'syno_time_create' ),
			'syno_time_update' => $this->_post_class->get_post_int( 'syno_time_update' ),
			'syno_weight'      => $this->_post_class->get_post_int( 'syno_weight' ),
			'syno_key'         => $this->_post_class->get_post_text( 'syno_key' ),
			'syno_value'       => $this->_post_class->get_post_text( 'syno_value' ),
		);

		return $row;
	}


// list

	function _get_list_total() {
		switch ( $this->pagenavi_get_sortid() ) {
			case 0:
			case 1:
			case 2:
			case 3:
			default:
				$total = $this->_manage_handler->get_count_all();
				break;
		}

		$this->_manage_total = $total;

		return $total;
	}

	function _get_list_rows( $limit, $start ) {
		switch ( $this->pagenavi_get_sortid() ) {
			case 1:
				$rows = $this->_manage_handler->get_rows_all_desc( $limit, $start );
				break;

			case 2:
				$rows = $this->_manage_handler->get_rows_orderby_weight_asc( $limit, $start );
				break;

			case 3:
				$rows = $this->_manage_handler->get_rows_orderby_weight_desc( $limit, $start );
				break;

			case 0:
			default:
				$rows = $this->_manage_handler->get_rows_all_asc( $limit, $start );
				break;
		}

		return $rows;
	}


// form

	function _print_form( $row ) {
		echo $this->build_manage_form_begin( $row );

		echo $this->build_table_begin();
		echo $this->build_manage_header();

		echo $this->build_manage_id();
		echo $this->build_comp_text( 'syno_time_create' );
		echo $this->build_comp_text( 'syno_time_update' );
		echo $this->build_comp_text( 'syno_weight' );
		echo $this->build_comp_text( 'syno_key' );
		echo $this->build_comp_text( 'syno_value' );

		echo $this->build_manage_submit();

		echo "</table></form>\n";
	}


}


