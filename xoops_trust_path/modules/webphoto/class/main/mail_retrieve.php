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


class webphoto_main_mail_retrieve extends webphoto_edit_mail_retrieve {
	public $_TIME_FAIL = 5;
	public $_REDIRECT_THIS_URL;

	public $_DEBUG_MAIL_FILE = null;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->preload_init();
		$this->preload_constant();

		if ( $this->_DEBUG_MAIL_FILE ) {
			$this->_TIME_ACCESS      = 1;
			$this->_FLAG_UNLINK_FILE = false;
		}
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_main_mail_retrieve( $dirname, $trust_dirname );
		}

		return $instance;
	}


// check

	public function check() {
		switch ( $this->check_perm() ) {
			case _C_WEBPHOTO_ERR_NO_PERM:
				redirect_header( $this->_INDEX_PHP, $this->_TIME_FAIL, _NOPERM );
				exit;
		}

		return true;
	}


// main

	public function main() {
		$title = $this->get_constant( 'TITLE_MAIL_RETRIEVE' );
		$url   = $this->_MODULE_URL . '/index.php?fct=mail_retrieve';

		echo $this->build_bread_crumb( $title, $url );
		echo '<h3>' . $title . "</h3>\n";

		$post_submit = $this->_post_class->get_post( 'submit' );

		if ( $post_submit ) {
			$this->submit();

		} else {
			$this->print_form();
		}
	}

	public function submit() {
		$this->set_flag_print_first_msg( true );

		if ( $this->_is_module_admin ) {
			$this->set_msg_level( _C_WEBPHOTO_MSG_LEVEL_ADMIN );
		} else {
			$this->set_msg_level( _C_WEBPHOTO_MSG_LEVEL_USER );
		}

		$this->retrieve();
		echo $this->get_msg();

		$this->print_goto_index();
	}

	public function print_goto_index() {
		echo "<br><br>\n";
		echo '<a href="index.php">';
		echo $this->get_constant( 'GOTO_INDEX' );
		echo "</a><br>\n";
	}

	public function print_form() {

		echo $this->get_constant( 'DSC_MAIL_RETRIEVE' );
		echo "<br><br>\n";

		$param = array(
			'title'        => $this->get_constant( 'TITLE_MAIL_RETRIEVE' ),
			'submit_value' => $this->get_constant( 'BUTTON_RETRIEVE' ),
		);

		$hidden_array = array(
			'fct' => 'mail_retrieve',
			'op'  => 'retrieve',
		);

		$form_class =& webphoto_lib_element::getInstance();
		echo $form_class->build_form_box_with_style( $param, $hidden_array );
	}

}
