<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_inc_gperm_def {

	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_inc_gperm_def();
		}

		return $instance;
	}


// group

	public function get_perms_admin() {
		return array(
			_B_WEBPHOTO_GPERM_INSERTABLE,
			_B_WEBPHOTO_GPERM_SUPERINSERT | _B_WEBPHOTO_GPERM_INSERTABLE,
			_B_WEBPHOTO_GPERM_SUPEREDIT | _B_WEBPHOTO_GPERM_EDITABLE,
			_B_WEBPHOTO_GPERM_SUPERDELETE | _B_WEBPHOTO_GPERM_DELETABLE,
			_B_WEBPHOTO_GPERM_RATEVIEW,
			_B_WEBPHOTO_GPERM_RATEVOTE | _B_WEBPHOTO_GPERM_RATEVIEW,
			_B_WEBPHOTO_GPERM_TELLAFRIEND,
			_B_WEBPHOTO_GPERM_TAGEDIT,
			_B_WEBPHOTO_GPERM_MAIL,
			_B_WEBPHOTO_GPERM_FILE,
			_B_WEBPHOTO_GPERM_HTML,
		);
	}

	public function get_perms_user() {
		return array(
			_B_WEBPHOTO_GPERM_INSERTABLE,
//		_B_WEBPHOTO_GPERM_SUPERINSERT | _B_WEBPHOTO_GPERM_INSERTABLE ,
			_B_WEBPHOTO_GPERM_SUPEREDIT | _B_WEBPHOTO_GPERM_EDITABLE,
			_B_WEBPHOTO_GPERM_SUPERDELETE | _B_WEBPHOTO_GPERM_DELETABLE,
//		_B_WEBPHOTO_GPERM_RATEVIEW ,
//		_B_WEBPHOTO_GPERM_RATEVOTE    | _B_WEBPHOTO_GPERM_RATEVIEW ,
//		_B_WEBPHOTO_GPERM_TELLAFRIEND ,
//		_B_WEBPHOTO_GPERM_TAGEDIT ,
//		_B_WEBPHOTO_GPERM_MAIL ,
//		_B_WEBPHOTO_GPERM_FILE ,
//		_B_WEBPHOTO_GPERM_HTML ,
		);
	}

	public function get_perm_list() {
		return array(
			_B_WEBPHOTO_GPERM_INSERTABLE => _AM_WEBPHOTO_GPERM_INSERTABLE,
			_B_WEBPHOTO_GPERM_SUPERINSERT | _B_WEBPHOTO_GPERM_INSERTABLE
			                             => _AM_WEBPHOTO_GPERM_SUPERINSERT,

//		_B_WEBPHOTO_GPERM_EDITABLE => _AM_WEBPHOTO_GPERM_EDITABLE ,
			_B_WEBPHOTO_GPERM_SUPEREDIT | _B_WEBPHOTO_GPERM_EDITABLE
			                             => _AM_WEBPHOTO_GPERM_SUPEREDIT,

//		_B_WEBPHOTO_GPERM_DELETABLE => _AM_WEBPHOTO_GPERM_DELETABLE ,
			_B_WEBPHOTO_GPERM_SUPERDELETE | _B_WEBPHOTO_GPERM_DELETABLE
			                             => _AM_WEBPHOTO_GPERM_SUPERDELETE,

			_B_WEBPHOTO_GPERM_RATEVIEW => _AM_WEBPHOTO_GPERM_RATEVIEW,
			_B_WEBPHOTO_GPERM_RATEVOTE | _B_WEBPHOTO_GPERM_RATEVIEW
			                           => _AM_WEBPHOTO_GPERM_RATEVOTE,

			_B_WEBPHOTO_GPERM_TELLAFRIEND => _AM_WEBPHOTO_GPERM_TELLAFRIEND,
			_B_WEBPHOTO_GPERM_TAGEDIT     => _AM_WEBPHOTO_GPERM_TAGEDIT,
			_B_WEBPHOTO_GPERM_MAIL        => _AM_WEBPHOTO_GPERM_MAIL,
			_B_WEBPHOTO_GPERM_FILE        => _AM_WEBPHOTO_GPERM_FILE,
			_B_WEBPHOTO_GPERM_HTML        => _AM_WEBPHOTO_GPERM_HTML,
		);
	}
}
