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


class webphoto_lib_mail_send extends webphoto_lib_error {
	public $_mail_class;

	public $_xoops_sitename;
	public $_xoops_adminmail;
	public $_msg_array = array();

	public $_LANG_ERR_NO_TO_EMAIL = 'Not Set Email Address';

	public function __construct() {

		parent::__construct();

		$this->_mail_class =& webphoto_lib_mail::getInstance();

		$this->_xoops_sitename  = $this->get_xoops_sitename();
		$this->_xoops_adminmail = $this->get_xoops_adminmail();
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_mail_send();
		}

		return $instance;
	}


// send email

	function send( $param ) {
		$to_emails  = $param['to_emails'] ?? null;
		$users      = $param['users'] ?? null;
		$subject    = $param['subject'] ?? null;
		$body       = $param['body'] ?? null;
		$tags       = $param['tags'] ?? null;
		$debug      = $param['debug'] ?? false;
		$from_name  = $param['from_name'] ?? $this->_xoops_sitename;
		$from_email = $param['from_email'] ?? $this->_xoops_adminmail;

		if ( empty( $to_emails ) && empty( $users ) ) {
			$this->set_error( $this->_LANG_ERR_NO_TO_EMAIL );

			return false;
		}

		$this->clear_errors();
		$this->clear_msg_array();

// mail start
		$mailer =& getMailer();
		$mailer->reset();
		$mailer->setFromName( $from_name );
		$mailer->setFromEmail( $from_email );
		$mailer->setSubject( $subject );
		$mailer->setBody( $body );
		$mailer->useMail();

		if ( $to_emails ) {
			$mailer->setToEmails( $to_emails );
		}

		if ( is_array( $users ) && count( $users ) ) {
			$mailer->setToUsers( $users );
		}

		if ( is_array( $tags ) && count( $tags ) ) {
			$mailer->assign( $tags );
		}

		$ret = $mailer->send( $debug );
		if ( ! $ret ) {
			$this->set_error( $mailer->getErrors( false ) );

			return false;
		}

		$this->set_msg( $mailer->getSuccess( false ) );

		return true;
	}

	function get_valid_mail_addr( $addr ) {
		return $this->_mail_class->get_valid_addr( $addr );
	}


// msg

	function clear_msg_array() {
		$this->_msg_array = array();
	}

	function get_msg_array() {
		return $this->_msg_array;
	}

	function set_msg( $msg, $flag_highlight = false ) {
// array type
		if ( is_array( $msg ) ) {
			$arr = $msg;

// string type
		} else {
			$arr = $this->str_to_array( $msg, "\n" );
			if ( $flag_highlight ) {
				$arr2 = array();
				foreach ( $arr as $m ) {
					$arr2[] = $this->highlight( $m );
				}
				$arr = $arr2;
			}
		}

		foreach ( $arr as $m ) {
			$m = trim( $m );
			if ( $m ) {
				$this->_msg_array[] = $m;
			}
		}
	}


// XOOPS system

	function get_xoops_sitename() {
		global $xoopsConfig;

		return $xoopsConfig['sitename'];
	}

	function get_xoops_adminmail() {
		global $xoopsConfig;

		return $xoopsConfig['adminmail'];
	}

}
