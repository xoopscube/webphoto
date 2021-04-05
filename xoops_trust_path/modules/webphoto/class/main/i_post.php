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


class webphoto_main_i_post extends webphoto_imode {
	public $_retrieve_class;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_retrieve_class =& webphoto_edit_mail_retrieve::getInstance(
			$dirname, $trust_dirname );

		$this->_retrieve_class->set_flag_force_db( true );
		$this->_retrieve_class->set_flag_print_first_msg( true );

// preload
		$this->_retrieve_class->preload_init();
		$this->_retrieve_class->preload_constant();
		$this->preload_init();
		$this->preload_constant();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_main_i_post( $dirname, $trust_dirname );
		}

		return $instance;
	}


// main

	public function main() {
		$this->output_header();
		$this->_post();
	}


// post

	public function _post() {
		$text = $this->build_html_head( $this->_TITLE_S, $this->_MOBILE_CHARSET_OUTPUT );
		$text .= $this->build_html_body_begin();
		$text .= $this->_post_exec();
		$text .= $this->build_goto();
		$text .= $this->build_html_body_end();

		echo $this->conv( $text );
	}

	public function _post_exec() {
		$text = '';

		if ( ! $this->check_perm() ) {
			$text .= _NOPERM;

			return $text;
		}

		$text .= $this->get_constant( 'TITLE_MAIL_POST' ) . "<br>\n";

		if ( $this->_is_module_admin ) {
			$level = _C_WEBPHOTO_MSG_LEVEL_ADMIN;
		} else {
			$level = _C_WEBPHOTO_MSG_LEVEL_NON;
		}

		$this->_retrieve_class->set_msg_level( $level );
		$this->_retrieve_class->set_flag_force_db( true );

		$ret   = $this->_retrieve_class->retrieve();
		$count = $this->_retrieve_class->get_mail_count();
		switch ( $ret ) {
			case _C_WEBPHOTO_RETRIEVE_CODE_ACCESS_TIME :
				$text .= $this->_build_retry();
				break;

			case _C_WEBPHOTO_RETRIEVE_CODE_NOT_RETRIEVE :
			case _C_WEBPHOTO_RETRIEVE_CODE_NO_NEW :
				$text .= $this->get_constant( 'TEXT_MAIL_NO_NEW' );
				break;

			default:
				$text .= sprintf( $this->get_constant( 'TEXT_MAIL_RETRIEVED_FMT' ), $count );
				break;
		}

		if ( $this->_is_module_admin ) {
			$text .= "<br><br>\n";
			$text .= "--- <br>\n";
			$text .= $this->_retrieve_class->get_msg();
			$text .= "<br>\n";
			$text .= "--- <br>\n";
		}

		return $text;
	}

	public function _build_retry() {
		$url  = $this->_MODULE_URL . '/index.php?fct=i_post';
		$text = $this->get_constant( 'TEXT_MAIL_ACCESS_TIME' );
		$text .= "<br>\n";
		$text .= $this->get_constant( 'TEXT_MAIL_RETRY' );
		$text .= "<br>\n";
		$text .= '<a href="' . $url . '">';
		$text .= $this->get_constant( 'TITLE_MAIL_POST' );
		$text .= "</a><br>\n";

		return $text;
	}

}
