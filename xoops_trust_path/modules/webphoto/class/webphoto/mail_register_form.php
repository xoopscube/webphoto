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


class webphoto_mail_register_form extends webphoto_form_this {


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_mail_register_form( $dirname, $trust_dirname );
		}

		return $instance;
	}


// user form

	public function print_user_form( $row ) {
		$this->set_row( $row );

		echo $this->build_form_begin();
		echo $this->build_input_hidden( 'op', 'form' );
		echo $this->build_input_hidden( 'fct', 'mail_register' );

		echo $this->build_table_begin();
		echo $this->build_line_title( $this->get_constant( 'TITLE_MAIL_REGISTER' ) );

		echo $this->build_line_ele( $this->get_constant( 'CAT_USER' ),
			$this->_build_ele_user_submitter() );

		echo $this->build_line_ele( '',
			$this->build_input_submit( 'submit', $this->get_constant( 'BUTTON_REGISTER' ) ) );

		echo $this->build_table_end();
		echo $this->build_form_end();

	}

	public function _build_ele_user_submitter() {
		$uid  = $this->get_row_by_key( 'user_uid' );
		$text = $this->build_form_user_select( 'user_uid', $uid, false );

		return $text;
	}


// submit form

	public function print_submit_form( $row, $param ) {
		$mode = $param['mode'];

		switch ( $mode ) {
			case 'edit':
				$submit = _EDIT;
				break;

			case 'add':
			default:
				$submit = $this->get_constant( 'BUTTON_REGISTER' );
				break;
		}

		$this->set_row( $row );

		echo $this->build_form_begin();
		echo $this->build_html_token();
		echo $this->build_input_hidden( 'op', 'submit' );
		echo $this->build_input_hidden( 'fct', 'mail_register' );

		echo $this->build_table_begin();
		echo $this->build_line_title( $this->get_constant( 'TITLE_MAIL_REGISTER' ) );

		echo $this->build_line_ele( $this->get_constant( 'CAT_USER' ),
			$this->_build_ele_submitter() );

		echo $this->build_line_ele( $this->get_constant( 'CATEGORY' ),
			$this->_build_ele_category() );

		echo $this->build_row_text( $this->get_constant( 'USER_EMAIL' ),
			'user_email' );

		echo $this->build_line_ele( '', $this->build_input_submit( 'submit', $submit ) );

		echo $this->build_table_end();
		echo $this->build_form_end();

	}

	public function _build_ele_category() {
		return $this->_cat_handler->build_selbox_with_perm_post(
			$this->get_row_by_key( 'user_cat_id' ), 'user_cat_id' );
	}

	public function _build_ele_submitter() {
		$uid  = $this->get_row_by_key( 'user_uid' );
		$text = $this->_xoops_class->get_user_uname_from_id( $uid );
		$text .= ' ';
		$text .= $this->build_input_hidden( 'user_uid', $uid );

		return $text;
	}

}
