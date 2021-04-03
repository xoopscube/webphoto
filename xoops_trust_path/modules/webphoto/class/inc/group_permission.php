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


class webphoto_inc_group_permission extends webphoto_inc_base_ini {
	public $_cached_perms = array();

	public $_xoops_mid = 0;
	public $_xoops_uid = 0;
	public $_xoops_groups = null;
	public $_is_module_adimin = false;

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct();
//	$wp = new webphoto_inc_base_ini();
//	$this->$wp;
		$this->init_base_ini( $dirname, $trust_dirname );
		$this->init_handler( $dirname );

		$this->_init_xoops( $dirname );
		$this->_init_permission( $dirname );
	}

	public static function &getSingleton( $dirname, $trust_dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] = new webphoto_inc_group_permission( $dirname, $trust_dirname );
		}

		return $singletons[ $dirname ];
	}


// has permit
	public function has_perm( $name, $flag_admin = false ) {
		if ( $flag_admin && $this->_is_module_adimin ) {
			return true;
		}
		$bit = constant( strtoupper( '_B_WEBPHOTO_GPERM_' . $name ) );

		return $this->_has_perm_by_bit( $bit );
	}


// cache
	public function _has_perm_by_bit( $bit ) {
		return $this->_cached_perms & $bit;
	}


// xoops_group_permission
	public function _init_permission( $dirname ) {
		$perms = 0;

// correct SQL error
// no action when not installed this module
		if ( empty( $this->_xoops_mid ) ) {
			return $perms;
		}

		$sql = "SELECT gperm_itemid FROM " . $this->_db->prefix( 'group_permission' );
		$sql .= " WHERE gperm_modid=" . (int) $this->_xoops_mid;
		$sql .= " AND gperm_name=" . $this->quote( _C_WEBPHOTO_GPERM_NAME );
		$sql .= " AND ( " . $this->_build_where_groupid() . " )";

		$rows = $this->get_rows_by_sql( $sql );
		if ( ! is_array( $rows ) || ! count( $rows ) ) {
			return 0;
		}

		foreach ( $rows as $row ) {
			$perms |= $row['gperm_itemid'];
		}

		$this->_cached_perms = $perms;
	}

	public function _build_where_groupid() {
		if ( is_array( $this->_xoops_groups ) && count( $this->_xoops_groups ) ) {
			$where = "gperm_groupid IN (";
			foreach ( $this->_xoops_groups as $groupid ) {
				$where .= "$groupid,";
			}
			$where = substr( $where, 0, - 1 ) . ")";

		} else {
			$where = "gperm_groupid=" . XOOPS_GROUP_ANONYMOUS;
		}

		return $where;
	}


// xoops class
	public function _init_xoops( $dirname ) {
		$module_handler =& xoops_gethandler( 'module' );
		$module         = $module_handler->getByDirname( $dirname );
		if ( is_object( $module ) ) {
			$this->_xoops_mid = $module->getVar( 'mid' );
		}

		global $xoopsUser;
		if ( is_object( $xoopsUser ) ) {
			$this->_xoops_uid        = $xoopsUser->getVar( 'uid' );
			$this->_xoops_groups     = $xoopsUser->getGroups();
			$this->_is_module_adimin = $xoopsUser->isAdmin( $this->_xoops_mid );
		}
	}
}
