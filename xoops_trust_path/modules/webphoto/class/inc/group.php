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


class webphoto_inc_group {
	public $_member_handler;
	public $_groupperm_handler;

	public $_DIRNAME;
	public $_MODULE_ID = 0;

	public $_SYSTEM_GROUPS =
		array( XOOPS_GROUP_ADMIN, XOOPS_GROUP_USERS, XOOPS_GROUP_ANONYMOUS );

	public function __construct( $dirname ) {
		$this->_DIRNAME = $dirname;

		$this->_member_handler    =& xoops_gethandler( 'member' );
		$this->_groupperm_handler =& xoops_gethandler( 'groupperm' );

		$this->_init_xoops_module( $dirname );
	}

	public static function &getSingleton( $dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] = new webphoto_inc_group( $dirname );
		}

		return $singletons[ $dirname ];
	}


// group

	public function delete_group( $group_id ) {
		$group_id = (int) $group_id;
		if ( $group_id <= 0 ) {
			return false;    // no action
		}
		if ( in_array( $group_id, $this->_SYSTEM_GROUPS ) ) {
			return false;    // no action
		}
		$this->delete_member_group( $group_id );
		$this->delete_gperm_by_group( $group_id );

		return true;
	}


// member handler
	public function create_member_group( $name, $desc ) {
		$group = $this->_member_handler->createGroup();
		$group->setVar( 'name', $name );
		$group->setVar( 'description', $desc );

		$ret = $this->_member_handler->insertGroup( $group );
		if ( ! $ret ) {
			return false;
		}

		return $group->getVar( 'groupid' );
	}

	public function delete_member_group( $group_id ) {
		$group = $this->_member_handler->getGroup( $group_id );
		$this->_member_handler->deleteGroup( $group );
	}


// groupperm handler

	public function create_gperm_webphoto_groupid( $groupid, $perms ) {
		foreach ( $perms as $id ) {
			$this->create_gperm_webphoto_itemid( $groupid, $id );
		}
	}

	public function create_gperm_module_admin( $groupid ) {
		$gperm = $this->_groupperm_handler->create();
		$gperm->setVar( 'gperm_name', 'module_admin' );
		$gperm->setVar( 'gperm_groupid', $groupid );
		$gperm->setVar( 'gperm_modid', 1 );
		$gperm->setVar( 'gperm_itemid', $this->_MODULE_ID );
		$this->_groupperm_handler->insert( $gperm );
		unset( $gperm );
	}

	public function create_gperm_module_read( $groupid ) {
		$gperm = $this->_groupperm_handler->create();
		$gperm->setVar( "gperm_name", 'module_read' );
		$gperm->setVar( "gperm_groupid", $groupid );
		$gperm->setVar( "gperm_modid", 1 );
		$gperm->setVar( "gperm_itemid", $this->_MODULE_ID );
		$this->_groupperm_handler->insert( $gperm );
		unset( $gperm );
	}

	public function create_gperm_webphoto_itemid( $groupid, $itemid ) {
		$gperm =& $this->_groupperm_handler->create();
		$gperm->setVar( "gperm_name", _C_WEBPHOTO_GPERM_NAME );
		$gperm->setVar( "gperm_groupid", $groupid );
		$gperm->setVar( "gperm_modid", $this->_MODULE_ID );
		$gperm->setVar( "gperm_itemid", $itemid );
		$this->_groupperm_handler->insert( $gperm );
		unset( $gperm );
	}

	public function delete_gperm_by_group( $group_id, $mod_id = null ) {
		$this->_groupperm_handler->deleteByGroup( $group_id, $mod_id );
	}


// xoops_module

	public function _init_xoops_module( $dirname ) {
		$module_handler =& xoops_gethandler( 'module' );
		$module         = $module_handler->getByDirname( $dirname );
		if ( is_object( $module ) ) {
			$this->_MODULE_ID = $module->getVar( 'mid' );
		}
	}
}
