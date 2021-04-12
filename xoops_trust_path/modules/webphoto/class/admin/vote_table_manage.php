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


class webphoto_admin_vote_table_manage extends webphoto_lib_manage {

	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );
		$this->set_manage_handler(
			webphoto_vote_handler::getInstance( $dirname, $trust_dirname ) );
		$this->set_manage_title_by_name( 'VOTE_TABLE_MANAGE' );

		$this->set_manage_list_column_array(
			array( 'vote_photo_id', 'vote_uid' ) );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_vote_table_manage( $dirname, $trust_dirname );
		}

		return $instance;
	}


	public function main() {
		$this->_main();
	}


// override for caller

	public function _build_row_by_post( $row = array() ) {

		$row = array(
			'vote_id'          => $this->_post_class->get_post_get_int( 'vote_id' ),
			'vote_time_create' => $this->_post_class->get_post_int( 'vote_time_create' ),
			'vote_time_update' => $this->_post_class->get_post_int( 'vote_time_update' ),
			'vote_photo_id'    => $this->_post_class->get_post_int( 'vote_photo_id' ),
			'vote_uid'         => $this->_post_class->get_post_int( 'vote_uid' ),
			'vote_rating'      => $this->_post_class->get_post_int( 'vote_rating' ),
			'vote_hostname'    => $this->_post_class->get_post_text( 'vote_hostname' ),

		);

		return $row;
	}


	public function _print_form( $row ) {
		echo $this->build_manage_form_begin( $row );

		echo $this->build_table_begin();
		echo $this->build_manage_header();

		echo $this->build_manage_id();
		echo $this->build_comp_text( 'vote_time_create' );
		echo $this->build_comp_text( 'vote_time_update' );
		echo $this->build_comp_text( 'vote_photo_id' );
		echo $this->build_comp_text( 'vote_rating' );
		echo $this->build_comp_text( 'vote_hostname' );

		echo $this->build_manage_submit();

		echo "</table></form>\n";
	}
}


