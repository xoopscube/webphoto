<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * class webphoto_lib_groupperm
 * refer myalubum's mygroupperm.php
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_lib_groupperm {
	public $_db;
	public $_module_handler;
	public $_member_handler;
	public $_groupperm_handler;

	public $_errors = array();
	public $_msg_array = array();

	public $_flag_system = false;


	public function __construct() {
		$this->_db                =& Database::getInstance();
		$this->_module_handler    =& xoops_gethandler( 'module' );
		$this->_member_handler    =& xoops_gethandler( 'member' );
		$this->_groupperm_handler =& xoops_gethandler( 'groupperm' );
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_groupperm();
		}

		return $instance;
	}


// main

	public function modify( $mod_id, $perms, $flag_system = false ) {
		$this->_flag_system = $flag_system;

// check by the permission of eather 'altsys' or 'system'
		if ( $mod_id == 1 ) {
			$module =& $this->_module_handler->getByDirname( 'altsys' );
			if ( ! is_object( $module ) ) {
				$module =& $this->_module_handler->getByDirname( 'system' );
				if ( ! is_object( $module ) ) {
					$this->set_error( 'there is no altsys nor system.' );

					return false;
				}
			}
			$mid          = $module->getVar( 'mid' );
			$xoops_groups = $this->get_xoops_groups();
			if ( ! is_array( $xoops_groups ) ||
			     ! $this->_groupperm_handler->checkRight( 'module_admin', $mid, $xoops_groups ) ) {
				$this->set_error( 'only admin of altsys can access this area' );

				return false;
			}

// check the permission of 'module_admin' of the module
		} else {
			if ( $mod_id <= 0 || ! $this->is_admin( $mod_id ) ) {
				$this->set_error( _NOPERM );

				return false;
			}
			$module =& $this->_module_handler->get( $mod_id );
			if ( ! is_object( $module ) || ! $module->getVar( 'isactive' ) ) {
				$this->set_error( _MODULENOEXIST );

				return false;
			}
		}

		if ( ! is_array( $perms['groups'] ) || ! is_array( $perms['itemname'] ) ) {
			$this->set_error( 'not set perms' );

			return false;    // no ection
		}

		$this->include_language();
		$module_name = $module->getVar( 'name' );
		$group_list  = $this->_member_handler->getGroupList();

		foreach ( $perms['groups'] as $group_id => $group_data ) {
			if ( $this->_flag_system ) {
				$ret = $this->delete_gperm_system( $mod_id, $group_id );
				if ( ! $ret ) {
					$this->set_msg( sprintf( _MD_AM_PERMRESETNG, $module_name ) );
				}
			}

			if ( isset( $group_list[ $group_id ] ) ) {
				$group_name = $group_list[ $group_id ];
			} else {
				continue;
			}

			$this->exec_itemname( $mod_id, $module_name, $group_id, $group_name, $group_data, $perms['itemname'] );
		}
	}

	public function exec_itemname( $mod_id, $module_name, $group_id, $group_name, $group_data, $perms_itemname ) {
		foreach ( $perms_itemname as $perm_name => $item_data ) {
			if ( ! $this->check_perm_name( $perm_name ) ) {
				$ret = $this->delete_gperm_local( $mod_id, $group_id, $perm_name );
				if ( ! $ret ) {
					$this->set_msg( sprintf( _MD_AM_PERMRESETNG, $module_name ) );
					continue;
				}
			}

			if ( isset( $group_data[ $perm_name ] ) ) {
				$group_item_ids = $group_data[ $perm_name ];
			} else {
				continue;
			}

			$this->exec_itemdata( $mod_id, $group_id, $group_name, $perm_name, $group_item_ids, $item_data );
		}
	}

	public function exec_itemdata( $mod_id, $group_id, $group_name, $perm_name, $group_item_ids, $item_data ) {
		foreach ( $item_data as $item_id => $item_name ) {
			$selected = isset( $group_item_ids[ $item_id ] ) ? $group_item_ids[ $item_id ] : 0;
			if ( $selected != 1 ) {
				continue;
			}

			if ( ! $this->_flag_system && $this->check_perm_name( $perm_name ) ) {
				continue;
			}

			$ret = $this->insert_groupperm( $mod_id, $group_id, $item_id, $perm_name );
			if ( $ret ) {
				$fmt = _MD_AM_PERMADDOK;
			} else {
				$fmt = _MD_AM_PERMADDNG;
			}
			$this->set_msg( sprintf( $fmt, '<b>' . $perm_name . '</b>', '<b>' . $item_name . '</b>', '<b>' . $group_name . '</b>' ) );

		}
	}

	public function insert_groupperm( $mod_id, $group_id, $item_id, $perm_name ) {
		if ( $this->check_perm_name( $perm_name ) ) {
			$gperm = $this->create_gperm( $group_id, $perm_name, 1, $mod_id );
		} else {
			$gperm = $this->create_gperm( $group_id, $perm_name, $mod_id, $item_id );
		}

		$ret = $this->_groupperm_handler->insert( $gperm );

		unset( $gperm );

		return $ret;
	}

	public function check_parent_ids( $parents, $item_ids ) {
		if ( $parents == '' ) {
			return true;
		}

// one of the parent items were not selected, so skip this item
		$parent_ids = explode( ':', $parents );
		foreach ( $parent_ids as $pid ) {
			if ( $pid != 0 && ! in_array( $pid, array_keys( $item_ids ) ) ) {
				return false;
			}
		}

		return true;
	}

	public function create_gperm( $group_id, $gperm_name, $gperm_modid, $gperm_itemid ) {
		$gperm = $this->_groupperm_handler->create();
		$gperm->setVar( 'gperm_groupid', $group_id );
		$gperm->setVar( 'gperm_name', $gperm_name );
		$gperm->setVar( 'gperm_modid', $gperm_modid );
		$gperm->setVar( 'gperm_itemid', $gperm_itemid );

		return $gperm;
	}

	public function delete_gperm_system( $mod_id, $group_id ) {
		$criteria = new CriteriaCompo( new Criteria( 'gperm_itemid', (int) $mod_id ) );
		$criteria->add( new Criteria( 'gperm_groupid', (int) $group_id ) );
		$criteria->add( new Criteria( 'gperm_modid', 1 ) );
		$criteria2 = new CriteriaCompo( new Criteria( 'gperm_name', 'module_admin' ) );
		$criteria2->add( new Criteria( 'gperm_name', 'module_read' ), 'OR' );
		$criteria->add( $criteria2 );

		return $this->_groupperm_handler->deleteAll( $criteria );
	}

	public function delete_gperm_local( $mod_id, $group_id, $perm_name, $item_id = null ) {
		$criteria = new CriteriaCompo( new Criteria( 'gperm_modid', (int) $mod_id ) );
		$criteria->add( new Criteria( 'gperm_groupid', (int) $group_id ) );
		if ( $perm_name ) {
			$criteria->add( new Criteria( 'gperm_name', $perm_name ) );
			if ( $item_id ) {
				$criteria->add( new Criteria( 'gperm_itemid', (int) $item_id ) );
			}
		}

		return $this->_groupperm_handler->deleteAll( $criteria );
	}

	public function check_perm_name( $perm_name ) {
		return ( $perm_name == 'module_admin' ) ||
		       ( $perm_name == 'module_read' );
	}


// xoops param

	public function include_language() {
		global $xoopsConfig;
		$language = $xoopsConfig['language'];

		$file_xc_lang = XOOPS_ROOT_PATH . '/modules/legacy/language/' . $language . '/admin.php';
		$file_xc_eng  = XOOPS_ROOT_PATH . '/modules/legacy/language/english/admin.php';
		$file_20_lang = XOOPS_ROOT_PATH . '/modules/system/language/' . $language . '/admin.php';
		$file_20_eng  = XOOPS_ROOT_PATH . '/modules/system/language/english/admin.php';

// XOOPS Cube 2.1
		if ( defined( 'XOOPS_CUBE_LEGACY' ) ) {
			if ( file_exists( $file_xc_lang ) ) {
				include_once $file_xc_lang;
			} else {
				include_once $file_xc_eng;
			}

// XOOPS 2.0
		} elseif ( file_exists( $file_20_lang ) ) {
			include_once $file_20_lang;
		} else {
			include_once $file_20_eng;
		}
	}

	public function get_xoops_groups() {
		global $xoopsUser;
		if ( is_object( $xoopsUser ) ) {
			return $xoopsUser->getGroups();
		}

		return false;
	}

	public function is_admin( $mod_id ) {
		global $xoopsUser;
		if ( is_object( $xoopsUser ) ) {
			return $xoopsUser->isAdmin( $mod_id );
		}

		return false;
	}


// error

	public function set_error( $msg ) {
// array type
		if ( is_array( $msg ) ) {
			foreach ( $msg as $m ) {
				$this->_errors[] = $m;
			}

// string type
		} else {
			$arr = explode( "\n", $msg );
			foreach ( $arr as $m ) {
				$this->_errors[] = $m;
			}
		}
	}

	public function get_errors() {
		return $this->_errors;
	}

	public function set_msg( $msg ) {
// array type
		if ( is_array( $msg ) ) {
			$arr = $msg;

// string type
		} else {
			$arr = explode( "\n", $msg );
		}

		foreach ( $arr as $m ) {
			$m = trim( $m );
			if ( $m ) {
				$this->_msg_array[] = $m;
			}
		}
	}

	public function get_msg_array() {
		return $this->_msg_array;
	}
}
