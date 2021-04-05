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

// XOOPS Cube 2.1
if ( defined( 'XOOPS_CUBE_LEGACY' ) ) {
	include_once XOOPS_ROOT_PATH . '/modules/legacy/include/xoops2_system_constants.inc.php';
}


class webphoto_xoops_groupperm {
	public $_groupperm_handler;


	public function __construct() {
		$this->_groupperm_handler =& xoops_gethandler( 'groupperm' );
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_xoops_groupperm();
		}

		return $instance;
	}


// get

	public function has_system_image() {
		return $this->_check_right( XOOPS_SYSTEM_IMAGE );
	}

	public function has_system_comment() {
		return $this->_check_right( XOOPS_SYSTEM_COMMENT );
	}

	public function _check_right( $itemid, $name = 'system_admin', $groupid = null, $modid = 1 ) {
		if ( empty( $groupid ) ) {
			$groupid = $this->_get_xoops_user_groups();
		}

		return $this->_groupperm_handler->checkRight(
			$name, $itemid, $groupid, $modid );
	}


// xoops param

	public function _get_xoops_user_groups() {
		global $xoopsUser;
		if ( is_object( $xoopsUser ) ) {
			return $xoopsUser->getGroups();
		}

		return XOOPS_GROUP_ANONYMOUS;
	}

}

