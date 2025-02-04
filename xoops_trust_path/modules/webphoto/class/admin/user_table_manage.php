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


class webphoto_admin_user_table_manage extends webphoto_lib_manage {

	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->set_manage_handler(
			webphoto_user_handler::getInstance( $dirname, $trust_dirname ) );
		$this->set_manage_title_by_name( 'USER_TABLE_MANAGE' );

		$this->set_manage_list_column_array(
			array( 'user_uid', 'user_email' ) );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_user_table_manage( $dirname, $trust_dirname );
		}

		return $instance;
	}


	public function main() {
		$this->_main();
	}


// override for caller

	public function _build_row_by_post( $row = array() ) {

		$row = array(
			'user_id'          => $this->_post_class->get_post_get_int( 'user_id' ),
			'user_time_create' => $this->_post_class->get_post_int( 'user_time_create' ),
			'user_time_update' => $this->_post_class->get_post_int( 'user_time_update' ),
			'user_uid'         => $this->_post_class->get_post_int( 'user_uid' ),
			'user_cat_id'      => $this->_post_class->get_post_int( 'user_cat_id' ),
			'user_email'       => $this->_post_class->get_post_text( 'user_email' ),
			'user_text1'       => $this->_post_class->get_post_text( 'user_text1' ),
			'user_text2'       => $this->_post_class->get_post_text( 'user_text2' ),
			'user_text3'       => $this->_post_class->get_post_text( 'user_text3' ),
			'user_text4'       => $this->_post_class->get_post_text( 'user_text4' ),
			'user_text5'       => $this->_post_class->get_post_text( 'user_text5' ),
		);

		for ( $i = 1; $i <= _C_WEBPHOTO_MAX_CAT_TEXT; $i ++ ) {
			$name         = 'user_text' . $i;
			$row[ $name ] = $this->_post_class->get_post_text( $name );
		}

		return $row;
	}


// form

	public function _print_form( $row ) {
		echo $this->build_manage_form_begin( $row );

		echo $this->build_table_begin();
		echo $this->build_manage_header();

		echo $this->build_manage_id();
		echo $this->build_comp_text( 'user_time_create' );
		echo $this->build_comp_text( 'user_time_update' );
		echo $this->build_comp_text( 'user_uid' );
		echo $this->build_comp_text( 'user_cat_id' );
		echo $this->build_comp_text( 'user_email' );

		for ( $i = 1; $i <= _C_WEBPHOTO_MAX_USER_TEXT; $i ++ ) {
			echo $this->build_comp_text( 'user_text' . $i );
		}

		echo $this->build_manage_submit();

		echo "</table></form>\n";
	}

}


