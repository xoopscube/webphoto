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


class webphoto_admin_maillog_table_manage extends webphoto_lib_manage {
	public $_unlink_class;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->set_manage_handler(
			webphoto_maillog_handler::getInstance( $dirname, $trust_dirname ) );
		$this->set_manage_title_by_name( 'MAILLOG_TABLE_MANAGE' );

		$this->set_manage_list_column_array(
			array( 'maillog_from', 'maillog_subject' ) );

		$this->_unlink_class =& webphoto_edit_mail_unlink::getInstance( $dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_maillog_table_manage( $dirname, $trust_dirname );
		}

		return $instance;
	}


	public function main() {
		$this->_main();
	}


// override for caller

	public function _build_row_by_post( $row = array() ) {
		$row = array(
			'maillog_id'          => $this->_post_class->get_post_get_int( 'maillog_id' ),
			'maillog_time_create' => $this->_post_class->get_post_int( 'maillog_time_create' ),
			'maillog_time_update' => $this->_post_class->get_post_int( 'maillog_time_update' ),
			'maillog_photo_ids'   => $this->_post_class->get_post_int( 'maillog_photo_ids' ),
			'maillog_status'      => $this->_post_class->get_post_int( 'maillog_status' ),
			'maillog_from'        => $this->_post_class->get_post_text( 'maillog_from' ),
			'maillog_subject'     => $this->_post_class->get_post_text( 'maillog_subject' ),
			'maillog_body'        => $this->_post_class->get_post_int( 'maillog_body' ),
			'maillog_file'        => $this->_post_class->get_post_text( 'maillog_file' ),
			'maillog_attach'      => $this->_post_class->get_post_text( 'maillog_attach' ),
			'maillog_comment'     => $this->_post_class->get_post_text( 'maillog_comment' ),
		);

		return $row;
	}


// delete

	public function _manage_delete_option( $row ) {
		$this->_unlink_class->unlink_by_maillog_row( $row );
	}

	public function _manage_delete_all_each_option( $row ) {
		$this->_unlink_class->unlink_by_maillog_row( $row );
	}


// form

	public function _print_form( $row ) {
		echo $this->build_manage_form_begin( $row );

		echo $this->build_table_begin();
		echo $this->build_manage_header();

		echo $this->build_manage_id();
		echo $this->build_comp_text( 'maillog_time_create' );
		echo $this->build_comp_text( 'maillog_time_update' );
		echo $this->build_comp_text( 'maillog_photo_ids' );
		echo $this->build_comp_text( 'maillog_status' );
		echo $this->build_comp_text( 'maillog_from' );
		echo $this->build_comp_text( 'maillog_subject' );
		echo $this->build_comp_text( 'maillog_body' );
		echo $this->build_comp_text( 'maillog_file' );
		echo $this->build_comp_textarea( 'maillog_attach' );
		echo $this->build_comp_textarea( 'maillog_comment' );

		echo $this->build_manage_submit();

		echo "</table></form>\n";
	}

}
