<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief class webphoto_d3_notification
 * subsitute for core's notifcation_handler->triggerEvent()
 * modify from pico_main_trigger_event
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_d3_notification_event {
// xoops param
	public $_MODULE_ID = 0;
	public $_MODULE_DIRNAME = null;
	public $_MODULE_NAME = null;
	public $_xoops_language = null;
	public $_xoops_uid = 0;
	public $_xoops_uname = null;

	public $_DIRNAME;
	public $_MODULE_DIR;
	public $_MODULE_URL;
	public $_TRUST_DIR;


	public function __construct() {
		$this->_init_xoops_param();
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_d3_notification_event();
		}

		return $instance;
	}

	public function init( $dirname, $trust_dirname ) {
		$this->_DIRNAME    = $dirname;
		$this->_MODULE_DIR = XOOPS_ROOT_PATH . '/modules/' . $dirname;
		$this->_MODULE_URL = XOOPS_URL . '/modules/' . $dirname;
		$this->_TRUST_DIR  = XOOPS_TRUST_PATH . '/modules/' . $trust_dirname;

	}


// public
	public function trigger_event( $category, $item_id, $event, $extra_tags = array(), $user_list = array(), $omit_user_id = null ) {
		$notification_handler =& xoops_gethandler( 'notification' );

		// Check if event is enabled
		$config_handler =& xoops_gethandler( 'config' );
		$mod_config     =& $config_handler->getConfigsByCat( 0, $this->_MODULE_ID );
		if ( empty( $mod_config['notification_enabled'] ) ) {
			return false;
		}

		$category_info =& notificationCategoryInfo( $category, $this->_MODULE_ID );
		$event_info    =& notificationEventInfo( $category, $event, $this->_MODULE_ID );
		if ( ! in_array( notificationGenerateConfig( $category_info, $event_info, 'option_name' ), $mod_config['notification_events'] ) && empty( $event_info['invisible'] ) ) {
			return false;
		}

		if ( ! isset( $omit_user_id ) ) {
			$omit_user_id = $this->_xoops_uid;
		}

		$criteria = new CriteriaCompo();
		$criteria->add( new Criteria( 'not_modid', (int) $this->_MODULE_ID ) );
		$criteria->add( new Criteria( 'not_category', $category ) );
		$criteria->add( new Criteria( 'not_itemid', (int) $item_id ) );
		$criteria->add( new Criteria( 'not_event', $event ) );
		$mode_criteria = new CriteriaCompo();
		$mode_criteria->add( new Criteria( 'not_mode', XOOPS_NOTIFICATION_MODE_SENDALWAYS ), 'OR' );
		$mode_criteria->add( new Criteria( 'not_mode', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE ), 'OR' );
		$mode_criteria->add( new Criteria( 'not_mode', XOOPS_NOTIFICATION_MODE_SENDONCETHENWAIT ), 'OR' );
		$criteria->add( $mode_criteria );

		if ( ! empty( $user_list ) ) {
			$user_criteria = new CriteriaCompo();
			foreach ( $user_list as $user ) {
				$user_criteria->add( new Criteria( 'not_uid', $user ), 'OR' );
			}
			$criteria->add( $user_criteria );
		}

		$notifications =& $notification_handler->getObjects( $criteria );
		if ( empty( $notifications ) ) {
			return;
		}

		// Add some tag substitutions here
		$tags = [];
		// {X_ITEM_NAME} {X_ITEM_URL} {X_ITEM_TYPE} from lookup_func are disabled
		$tags['X_MODULE']          = $this->_MODULE_NAME;
		$tags['X_MODULE_URL']      = XOOPS_URL . '/modules/' . $this->_MODULE_DIRNAME . '/';
		$tags['X_NOTIFY_CATEGORY'] = $category;
		$tags['X_NOTIFY_EVENT']    = $event;

		$template = $event_info['mail_template'] . '.tpl';
		$subject  = $event_info['mail_subject'];

		$mail_template_dir = $this->_get_mail_template_dir( $template );
		if ( ! $mail_template_dir ) {
			return;
		}

		foreach ( $notifications as $notification ) {
			if ( empty( $omit_user_id ) || $notification->getVar( 'not_uid' ) != $omit_user_id ) {
				// user-specific tags
				//$tags['X_UNSUBSCRIBE_URL'] = 'TODO';
				// TODO: don't show unsubscribe link if it is 'one-time' ??
				$tags['X_UNSUBSCRIBE_URL'] = XOOPS_URL . '/notifications.php';
				$tags                      = array_merge( $tags, $extra_tags );

				$notification->notifyUser( $mail_template_dir, $template, $subject, $tags );
			}
		}

	}


// private
	public function _get_mail_template_dir( $template ) {
// mail template dir
		$dir_trust_lang = $this->_TRUST_DIR . '/language/' . $this->_xoops_language . '/mail_template/';
		$dir_root_lang  = $this->_MODULE_DIR . '/language/' . $this->_xoops_language . '/mail_template/';
		$dir_trust_eng  = $this->_TRUST_DIR . '/language/english/mail_template/';
		$dir_root_eng   = $this->_MODULE_DIR . '/language/english/mail_template/';

		if ( file_exists( $dir_root_lang . $template ) ) {
			return $dir_root_lang;
		} elseif ( file_exists( $dir_trust_lang . $template ) ) {
			return $dir_trust_lang;
		} elseif ( file_exists( $dir_root_eng . $template ) ) {
			return $dir_root_eng;
		} elseif ( file_exists( $dir_trust_eng . $template ) ) {
			return $dir_trust_eng;
		}

		return false;
	}


// xoops param
	public function _init_xoops_param() {
		global $xoopsConfig, $xoopsUser, $xoopsModule;

		$this->_xoops_language = $xoopsConfig['language'];

		if ( is_object( $xoopsModule ) ) {
			$this->_MODULE_ID      = $xoopsModule->mid();
			$this->_MODULE_DIRNAME = $xoopsModule->getVar( 'dirname', 'n' );
			$this->_MODULE_NAME    = $xoopsModule->getVar( 'name', 'n' );
		}

		if ( is_object( $xoopsUser ) ) {
			$this->_xoops_uid   = $xoopsUser->getVar( 'uid' );
			$this->_xoops_uname = $xoopsUser->getVar( 'uname' );
		}

	}
}
