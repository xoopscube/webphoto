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


class webphoto_edit_flashvar_form extends webphoto_edit_form {

	public $_flashvar_handler;

	public $_cfg_captcha = null;

	public $_LOGOS_PATH;
	public $_LOGOS_DIR;
	public $_LOGOS_URL;

	public $_CAPTCHA_API_FILE = null;

	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_flashvar_handler
			=& webphoto_flashvar_handler::getInstance( $dirname, $trust_dirname );

		$uploads_path      = $this->_config_class->get_uploads_path();
		$this->_LOGOS_PATH = $uploads_path . '/logos';
		$this->_LOGOS_DIR  = XOOPS_ROOT_PATH . $this->_LOGOS_PATH;
		$this->_LOGOS_URL  = XOOPS_URL . $this->_LOGOS_PATH;

		$this->_CAPTCHA_API_FILE = XOOPS_ROOT_PATH . '/modules/captcha/include/api.php';
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_flashvar_form( $dirname, $trust_dirname );
		}

		return $instance;
	}


// main

	public function print_form( $mode, $row ) {
		$template = 'db:' . $this->_DIRNAME . '_form_flashvar.html';

		$arr = array_merge(
			$this->build_form_base_param(),
			$this->build_form_flashvar( $mode, $row ),
			$this->build_item_row( $row )
		);

		$tpl = new XoopsTpl();
		$tpl->assign( $arr );
		echo $tpl->fetch( $template );
	}

	public function build_form_flashvar( $mode, $row ) {
		switch ( $mode ) {
			case 'edit';
				$op     = 'flashvar';
				$fct    = 'edit';
				$action = $this->_MODULE_URL . '/index.php';
				break;

			case 'admin_item_submit';
				$op     = 'flashvar_submit';
				$fct    = 'item_manager';
				$action = $this->_MODULE_URL . '/admin/index.php';
				break;

			case 'admin_item_modify';
				$op     = 'flashvar_modify';
				$fct    = 'item_manager';
				$action = $this->_MODULE_URL . '/admin/index.php';
				break;

			case 'admin_modify';
			default:
				$op     = 'modify';
				$fct    = 'flashvar_manager';
				$action = $this->_MODULE_URL . '/admin/index.php';
				break;
		}

		$this->set_row( $row );

		[ $show_logo, $logo_url ]
			= $this->build_logo();

		[ $show_captcha, $cap_captcha, $ele_captcha ]
			= $this->build_captcha();

		$arr = [
			'form_action' => $action,
			'form_fct'    => $fct,
			'form_op'     => $op,
			'item_id'     => $item_id,

			'show_logo' => $show_logo,
			'logo_url'  => $logo_url,

			'show_captcha' => $show_captcha,
			'cap_captcha'  => $cap_captcha,
			'ele_captcha'  => $ele_captcha,

			'flashvar_autostart_options'           => $this->_flashvar_handler->get_autostart_options(),
			'flashvar_overstretch_options'         => $this->_flashvar_handler->get_overstretch_options(),
			'flashvar_transition_options'          => $this->_flashvar_handler->get_transition_options(),
			'flashvar_linktarget_options'          => $this->_flashvar_handler->get_linktarget_options(),
			'flashvar_stretching_options'          => $this->_flashvar_handler->get_stretching_options(),
			'flashvar_player_repeat_options'       => $this->_flashvar_handler->get_player_repeat_options(),
			'flashvar_controlbar_position_options' => $this->_flashvar_handler->get_controlbar_position_options(),
			'flashvar_playlist_position_options'   => $this->_flashvar_handler->get_playlist_position_options(),
			'flashvar_logo_position_options'       => $this->_flashvar_handler->get_logo_position_options(),

			'flashvar_logo_options' => $this->flashvar_logo_options(),
		];

		return $arr;
	}

	public function flashvar_logo_options() {
		$keys   = XoopsLists::getImgListAsArray( $this->_LOGOS_DIR );
		$values = $keys;
		array_unshift( $keys, '---' );
		array_unshift( $values, _NONE );
		$options = array_combine( $keys, $values );

		return $options;
	}

	public function build_logo() {
		$show      = false;
		$logo      = $this->get_row_by_key( 'flashvar_logo' );
		$logo_url  = $this->_LOGOS_URL . '/' . $logo;
		$logo_file = $this->_LOGOS_DIR . '/' . $logo;

		if ( $logo && file_exists( $logo_file ) ) {
			$show = true;
		}

		return array( $show, $logo_url );
	}

	public function build_captcha() {
		$show = false;
		$cap  = '';
		$ele  = '';

// show captcha if anoymous user
		if ( $this->_cfg_captcha && ! $this->_is_login_user &&
		     file_exists( $this->_CAPTCHA_API_FILE ) ) {
			include_once $this->_CAPTCHA_API_FILE;
			$captcha_api =& captcha_api::getInstance();
			$cap         = $captcha_api->make_caption();
			$ele         = $captcha_api->make_img_input();
			$show        = true;
		}

		return array( $show, $cap, $ele );
	}

}
