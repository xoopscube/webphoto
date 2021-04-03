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


class webphoto_mail_retrieve extends webphoto_mail_photo {
	public $_pop_class;

	public $_flag_retrive_chmod = false;

	public $_is_set_mail = false;
	public $_has_mail = false;

	public $_mail_count = 0;
	public $_mail_array = null;

	public $_MAX_MAILLOG = 1000;

	public $_FILE_ACCESS = null;
	public $_TIME_ACCESS = 60; // 60 sec ( 1 min )

	public $_DEBUG_MAIL_FILE = null;


// constructor

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
		//$this->webphoto_mail_photo( $dirname , $trust_dirname );
		$this->set_mail_groups( XOOPS_GROUP_USERS );
		$this->set_flag_chmod( true );

		$this->_pop_class =& webphoto_lib_mail_pop::getInstance();

		$cfg_mail_host        = $this->get_config_by_name( 'mail_host' );
		$cfg_mail_user        = $this->get_config_by_name( 'mail_user' );
		$cfg_mail_pass        = $this->get_config_by_name( 'mail_pass' );
		$this->_cfg_makethumb = $this->get_config_by_name( 'makethumb' );

		$this->_pop_class->set_host( $cfg_mail_host );
		$this->_pop_class->set_user( $cfg_mail_user );
		$this->_pop_class->set_pass( $cfg_mail_pass );

		$this->_is_set_mail = $this->_config_class->is_set_mail();
		$this->_has_mail    = $this->_perm_class->has_mail();

		$this->_FILE_ACCESS = $this->_MAIL_DIR . '/mail_access';

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_mail_retrieve( $dirname, $trust_dirname );
		}

		return $instance;
	}


// check

	public function check_perm() {
		if ( ! $this->_is_set_mail ) {
			return _C_WEBPHOTO_ERR_NO_PERM;
		}

		if ( ! $this->_has_mail ) {
			return _C_WEBPHOTO_ERR_NO_PERM;
		}

		return 0;
	}

	public function is_set_mail() {
		return $this->_is_set_mail;
	}

	public function has_mail() {
		return $this->_has_mail;
	}

	public function set_flag_chmod( $val ) {
		$this->set_image_video_flag_chmod( $val );
		$this->set_flag_mail_chmod( $val );
		$this->_flag_retrive_chmod = (bool) $val;
	}


// retrieve

	public function retrieve() {
		if ( ! $this->check_access_time() ) {
			$msg = $this->get_constant( 'TEXT_MAIL_ACCESS_TIME' );
			$msg .= "<br>\n";
			$msg .= $this->get_constant( 'TEXT_MAIL_RETRY' );
			$msg .= "<br>\n";
			$this->print_msg_level_user( $msg );

			return _C_WEBPHOTO_RETRIEVE_CODE_ACCESS_TIME;
		}

		$ret = $this->retrieve_exec();

// set time after execute
		$this->renew_access_time();

		return $ret;
	}

	public function check_access_time() {
		return $this->_utility_class->check_file_time(
			$this->_FILE_ACCESS, $this->_TIME_ACCESS );
	}

	public function renew_access_time() {
		$this->_utility_class->renew_file_time(
			$this->_FILE_ACCESS, $this->_flag_retrive_chmod );
	}

	public function retrieve_exec() {
		if ( $this->_DEBUG_MAIL_FILE ) {
			$this->print_msg_level_user( 'DEBUG MODE', false, true );
			$this->_mail_count = 1;
			$this->_mail_array = array(
				$this->build_mail_file( $this->_DEBUG_MAIL_FILE )
			);

		} else {
			$ret = $this->mail_pop();
			if ( $ret < 0 ) {
				return $ret;
			}

			if ( ! is_array( $this->_mail_array ) || ! count( $this->_mail_array ) ) {
				return _C_WEBPHOTO_RETRIEVE_CODE_NO_NEW;
			}
		}

		$this->clear_maillog( $this->_MAX_MAILLOG );

		$ret_arr = $this->mail_parse( $this->_mail_array );
		if ( ! is_array( $ret_arr ) || ! count( $ret_arr ) ) {
			return 0;
		}

		$this->add_photos( $ret_arr );

		return 0;
	}

	public function mail_pop() {
		$this->_mail_count = 0;
		$this->_mail_array = null;
		$file_arr          = array();

		$msg = "<h4>" . $this->get_constant( 'SUBTITLE_MAIL_ACCESS' ) . "</h4>\n";
		$this->print_msg_level_user( $msg );

		$ret = $this->_pop_class->recv_mails();
		if ( $ret == - 1 ) {
			$errors = $this->_pop_class->get_errors();
			$msg    = $this->array_to_str( $errors, "\n" );
			$msg    = nl2br( $this->sanitize( $msg ) );
			$this->print_msg_level_admin( 'POP Error', true, true );
			$this->print_msg_level_admin( $msg, false, true );
			$this->print_msg_level_user( $this->get_constant( 'TEXT_MAIL_NOT_RETRIEVE' ), true );

			return _C_WEBPHOTO_RETRIEVE_CODE_NOT_RETRIEVE;
		}

		$mail_arr = $this->_pop_class->get_mails();
		$count    = count( $mail_arr );

		if ( ! is_array( $mail_arr ) || ! $count ) {
			$this->print_msg_level_user( $this->get_constant( 'TEXT_MAIL_NO_NEW' ) );

			return _C_WEBPHOTO_RETRIEVE_CODE_NO_NEW;
		}

		$msg = sprintf( $this->get_constant( 'TEXT_MAIL_RETRIEVED_FMT' ), $count );
		$this->print_msg_level_user( $msg, false, true );

		foreach ( $mail_arr as $mail ) {
			$file_name = uniqid( 'mail_' ) . '.txt';
			$file_path = $this->_MAIL_DIR . '/' . $file_name;

			$this->print_msg_level_admin( $file_name, false, true );

			$this->_utility_class->write_file(
				$file_path, $mail, 'w', $this->_flag_retrive_chmod );
			$file_arr[] = $this->build_mail_file( $file_name );
		}

		$this->_mail_count = $count;
		$this->_mail_array = $file_arr;

		return 0;
	}

	public function get_mail_count() {
		return $this->_mail_count;
	}

	public function build_mail_file( $file ) {
		$arr = array(
			'maillog_id' => $this->add_maillog( $file ),
			'file'       => $file,
		);

		return $arr;
	}

	public function mail_parse( $file_arr ) {
		$msg = "<h4>" . $this->get_constant( 'SUBTITLE_MAIL_PARSE' ) . "</h4>\n";
		$this->print_msg_level_user( $msg );

		$param_arr = $this->parse_mails( $file_arr );

		if ( ! is_array( $param_arr ) || ! count( $param_arr ) ) {
			$msg = $this->get_constant( 'TEXT_MAIL_NO_VALID' );
			$this->print_msg_level_user( $msg, false, true );
		}

		return $param_arr;
	}

	public function add_photos( $file_arr ) {
		$msg = "<h4>" . $this->get_constant( 'SUBTITLE_MAIL_PHOTO' ) . "</h4>\n";
		$this->print_msg_level_user( $msg );

		$count = $this->add_photos_from_mail( $file_arr );

		$msg = "<br>\n";
		$msg .= sprintf( $this->get_constant( 'TEXT_MAIL_SUBMITED_FMT' ), $count );
		$this->print_msg_level_user( $msg, false, true );

	}

// --- class end ---
}

?>
