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


class webphoto_admin_p2t_table_manage extends webphoto_lib_manage {


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->set_manage_handler(
			webphoto_p2t_handler::getInstance( $dirname, $trust_dirname ) );
		$this->set_manage_title_by_name( 'P2T_TABLE_MANAGE' );

		$this->set_manage_list_column_array(
			array( 'p2t_photo_id', 'p2t_tag_id' ) );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_p2t_table_manage( $dirname, $trust_dirname );
		}

		return $instance;
	}


	function main() {
		$this->_main();
	}


// override for caller

	function _build_row_by_post( $row = array() ) {
		$row = array(
			'p2t_id'          => $this->_post_class->get_post_get_int( 'p2t_id' ),
			'p2t_time_create' => $this->_post_class->get_post_int( 'p2t_time_create' ),
			'p2t_time_update' => $this->_post_class->get_post_int( 'p2t_time_update' ),
			'p2t_photo_id'    => $this->_post_class->get_post_int( 'p2t_photo_id' ),
			'p2t_tag_id'      => $this->_post_class->get_post_int( 'p2t_tag_id' ),
			'p2t_uid'         => $this->_post_class->get_post_int( 'p2t_uid' ),
		);

		return $row;
	}


// form

	function _print_form( $row ) {
		echo $this->build_manage_form_begin( $row );

		echo $this->build_table_begin();
		echo $this->build_manage_header();

		echo $this->build_manage_id();
		echo $this->build_comp_text( 'p2t_time_create' );
		echo $this->build_comp_text( 'p2t_time_update' );
		echo $this->build_comp_text( 'p2t_photo_id' );
		echo $this->build_comp_text( 'p2t_tag_id' );
		echo $this->build_comp_text( 'p2t_uid' );
		echo $this->build_manage_submit();

		echo "</table></form>\n";
	}

}
