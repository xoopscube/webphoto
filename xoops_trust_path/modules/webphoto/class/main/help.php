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


class webphoto_main_help extends webphoto_base_this {
	public $_show_menu_mail = false;
	public $_show_menu_file = false;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_page_class =& webphoto_page::getInstance( $dirname, $trust_dirname );

		$this->preload_init();
		$this->preload_constant();
		$this->_page_class->init_preload();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_main_help( $dirname, $trust_dirname );
		}

		return $instance;
	}


// function

	public function main() {
		$this->_assign_xoops_header();

		$main_param = $this->_page_class->build_main_param();

		$this->_show_menu_mail = $main_param['show_menu_mail'];
		$this->_show_menu_file = $main_param['show_menu_file'];
		$cfg_is_set_mail       = $main_param['cfg_is_set_mail'];
		$cfg_file_dir          = $main_param['cfg_file_dir'];

		$param = array(
			'lang_help_mobile_text' => $this->_build_mobile_text(),
			'show_help_mail'        => $cfg_is_set_mail,
			'show_help_mail_text'   => $this->_build_show_mail_text(),
			'lang_help_mail_perm'   => $this->_build_mail_perm(),
			'lang_help_mail_text'   => $this->_build_mail_text(),
			'show_help_file'        => $cfg_file_dir,
			'show_help_file_text'   => $this->_build_show_file_text(),
			'lang_help_file_perm'   => $this->_build_file_perm(),
			'lang_help_file_text_1' => $this->_build_file_text_1(),
			'lang_help_file_text_2' => $this->_build_file_text_2(),
		);

		return array_merge( $param, $main_param );
	}

	public function _build_mobile_text() {
		$str = $this->get_constant( 'HELP_MOBILE_TEXT_FMT' );
		$str = str_replace( '{MODULE_URL}', $this->_MODULE_URL, $str );

		return $str;
	}

	public function _build_show_mail_text() {
		if ( $this->_show_menu_mail ) {
			return true;
		} elseif ( $this->_is_login_user ) {
			return true;
		}

		return false;
	}

	public function _build_mail_perm() {
		return $this->_build_perm( $this->_show_menu_mail );
	}

	public function _build_mail_text() {
		$text = $this->_build_mail_post();
		$text .= $this->_build_mail_retrieve();

		return $text;
	}

	public function _build_mail_post() {
		if ( $this->_show_menu_mail ) {
			$mail_addr  = $this->sanitize( $this->get_config_by_name( 'mail_addr' ) );
			$mail_guest = null;
		} else {
			$mail_addr  = 'user@exsample.com';
			$mail_guest = '<br>' . $this->get_constant( 'HELP_MAIL_GUEST' );
		}

		$str = $this->get_constant( 'HELP_MAIL_POST_FMT' );
		$str = str_replace( '{MODULE_URL}', $this->_MODULE_URL, $str );
		$str = str_replace( '{MAIL_ADDR}', $mail_addr, $str );
		$str = str_replace( '{MAIL_GUEST}', $mail_guest, $str );

		return $str;
	}

	public function _build_mail_retrieve() {
		$text      = $this->get_constant( 'HELP_MAIL_SUBTITLE_RETRIEVE' );
		$auto_time = $this->get_ini( 'mail_retrieve_auto_time' );

		if ( $auto_time > 0 ) {
			$text .= sprintf(
				$this->get_constant( 'HELP_MAIL_RETRIEVE_AUTO_FMT' ), $auto_time );
		} else {
			$str  = $this->get_constant( 'HELP_MAIL_RETRIEVE_FMT' );
			$text .= str_replace( '{MODULE_URL}', $this->_MODULE_URL, $str );
		}

		$text .= $this->get_constant( 'HELP_MAIL_RETRIEVE_TEXT' );

		return $text;
	}

	public function _build_show_file_text() {
		if ( $this->_show_menu_file ) {
			return true;
		} elseif ( $this->_is_login_user ) {
			return true;
		}

		return false;
	}

	public function _build_file_perm() {
		return $this->_build_perm( $this->_show_menu_file );
	}

	public function _build_file_text_1() {
		$str = $this->get_constant( 'HELP_FILE_TEXT_FMT' );
		$str = str_replace( '{MODULE_URL}', $this->_MODULE_URL, $str );

		return $str;
	}

	public function _build_file_text_2() {
		if ( $this->_show_menu_file ) {
			$str = $this->get_config_by_name( 'file_desc' );
		} else {
			$str = null;
		}

		return $str;
	}

	public function _build_perm( $perm ) {
		if ( $perm ) {
			$str = null;
		} elseif ( $this->_is_login_user ) {
			$str = $this->get_constant( 'HELP_NOT_PERM' );
		} else {
			$str = $this->get_constant( 'HELP_MUST_LOGIN' );
		}

		return $str;
	}

	public function _assign_xoops_header() {
// Fatal error: Call to undefined method webphoto_inc_xoops_header::assign_for_main() 
		$header_class
			=& webphoto_xoops_header::getInstance( $this->_DIRNAME, $this->_TRUST_DIRNAME );
		$header_class->set_flag_css( true );
		$header_class->assign_for_main();
	}

// --- class end ---
}

?>
