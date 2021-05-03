<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_admin_tag_table_manage extends webphoto_lib_manage {


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
		$this->set_manage_handler(
			webphoto_tag_handler::getInstance( $dirname, $trust_dirname ) );
		$this->set_manage_title_by_name( 'TAG_TABLE_MANAGE' );

		$this->set_manage_list_column_array(
			array( 'tag_name' ) );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_tag_table_manage( $dirname, $trust_dirname );
		}

		return $instance;
	}


	function main() {
		$this->_main();
	}


// override for caller

	function _build_row_by_post( $row = array() ) {
		$row = array(
			'tag_id'          => $this->_post_class->get_post_get_int( 'tag_id' ),
			'tag_time_create' => $this->_post_class->get_post_int( 'tag_time_create' ),
			'tag_time_update' => $this->_post_class->get_post_int( 'tag_time_update' ),
			'tag_name'        => $this->_post_class->get_post_text( 'tag_name' ),
		);

		return $row;
	}


// form

	function _print_form( $row ) {
		echo $this->build_manage_form_begin( $row );

		echo $this->build_table_begin();
		echo $this->build_manage_header();

		echo $this->build_manage_id();
		echo $this->build_comp_text( 'tag_time_create' );
		echo $this->build_comp_text( 'tag_time_update' );
		echo $this->build_comp_text( 'tag_name' );

		echo $this->build_manage_submit();

		echo "</table></form>\n";
	}


}


