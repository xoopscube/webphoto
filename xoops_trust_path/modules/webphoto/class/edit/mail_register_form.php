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


class webphoto_edit_mail_register_form extends webphoto_edit_form {

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_mail_register_form( $dirname, $trust_dirname );
		}

		return $instance;
	}


// user form

	public function print_user_form( $row ) {
		$userstart = $this->_post_class->get_get( 'userstart' );

		$template = 'db:' . $this->_DIRNAME . '_form_mail_user.html';

		$this->set_row( $row );

		$arr = array_merge(
			$this->build_form_base_param(),
			$this->build_form_user( $userstart )
		);

		$tpl = new XoopsTpl();
		$tpl->assign( $arr );
		echo $tpl->fetch( $template );
	}

	public function build_form_user( $userstart ) {
		$uid = $this->get_row_by_key( 'user_uid' );

		[ $show_user_list, $user_list, $user_uid_options ]
			= $this->get_user_param( $uid, $userstart );

		return array(
			'user_uid_options' => $user_uid_options,
			'show_user_list'   => $show_user_list,
			'user_list'        => $user_list,
		);
	}

	public function _build_ele_user_submitter() {
		$uid  = $this->get_row_by_key( 'user_uid' );
		$list = $this->get_xoops_user_list( 0, 0 );
		$text = $this->build_form_user_select( $list, 'user_uid', $uid, false );

		return $text;
	}


// submit form

	public function print_submit_form( $row, $param ) {
		$template = 'db:' . $this->_DIRNAME . '_form_mail_register.html';

		$arr = array_merge(
			$this->build_form_base_param(),
			$this->build_form_register( $row, $param ),
			$this->build_item_row( $row )
		);

		$tpl = new XoopsTpl();
		$tpl->assign( $arr );
		echo $tpl->fetch( $template );
	}

	public function build_form_register( $row, $param ) {
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

		return array(
			'ele_user_cat_id' => $this->_ele_user_cat_id(),
			'submitter'       => $this->_submitter(),
			'button_submit'   => $submit,
		);
	}

	public function _submitter() {
		$uid = $this->get_row_by_key( 'user_uid' );

		return $this->_xoops_class->get_user_uname_from_id( $uid );
	}

	public function _ele_user_cat_id() {
		return $this->_cat_handler->build_selbox_with_perm_post(
			$this->get_row_by_key( 'user_cat_id' ), 'user_cat_id' );
	}

}
