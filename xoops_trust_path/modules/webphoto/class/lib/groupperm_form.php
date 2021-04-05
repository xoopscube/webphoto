<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * class webphoto_lib_groupperm_form
 * refer myalubum's MyXoopsGroupPermForm
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_lib_groupperm_form {
	public $_module_handler;
	public $_member_handler;
	public $_groupperm_handler;

	public $_CHECKED = 'checked="checked"';

	public function __construct() {
		$this->_module_handler    =& xoops_gethandler( 'module' );
		$this->_member_handler    =& xoops_gethandler( 'member' );
		$this->_groupperm_handler =& xoops_gethandler( 'groupperm' );
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_groupperm_form();
		}

		return $instance;
	}

	public function build_param( $mod_id, $action = null ) {
		$arr = array(
			'cols'          => 4,
			'modid'         => $mod_id,
			'action'        => $action,
			'g_ticket'      => $this->get_token(),
			'xoops_dirname' => $this->get_dirname( $mod_id ),
		);
		if ( defined( 'XOOPS_CUBE_LEGACY' ) ) {
			$arr['xoops_cube_legacy'] = XOOPS_CUBE_LEGACY;
		}

		return array_merge( $arr, $this->get_lang() );
	}

	public function build_group_list( $mod_id, $perm_name, $item_array, $flag_admin = false ) {
		$system_list = $this->_member_handler->getGroupList();

		$group_list = array();
		foreach ( array_keys( $system_list ) as $id ) {
			$group_list[ $id ] = $this->build_group_list_single(
				$mod_id, $id, $system_list[ $id ], $perm_name, $item_array, $flag_admin );
		}

		return $group_list;
	}

	public function build_group_list_single( $mod_id, $group_id, $group_name, $perm_name, $item_array, $flag_admin = false ) {
		$module_admin_right = $this->check_right( 'module_admin', $mod_id, $group_id );
		$module_read_right  = $this->check_right( 'module_read', $mod_id, $group_id );

		$all_checked = ( $flag_admin && $module_admin_right );

		$item_id_array = $this->_groupperm_handler->getItemIds( $perm_name, $group_id, $mod_id );

		$item_list = array();
		foreach ( $item_array as $item_id => $item_name ) {
			$item_list[ $item_id ] = array(
				'item_id'   => $item_id,
				'item_name' => $item_name,
				'checked'   => $this->build_checked_array( $item_id, $item_id_array, $all_checked ),
			);
		}

		$group_list = array(
			'group_id'             => $group_id,
			'group_name'           => $group_name,
			'perm_name'            => $perm_name,
			'item_list'            => $item_list,
			'module_admin_checked' => $this->build_checked( $module_admin_right ),
			'module_read_checked'  => $this->build_checked( $module_read_right ),
		);

		return $group_list;
	}

	public function check_right( $perm_name, $mod_id, $group_id ) {
		return $this->_groupperm_handler->checkRight( $perm_name, $mod_id, $group_id );
	}

	public function build_checked_array( $val, $array, $all_checked ) {
		if ( $all_checked ) {
			return $this->_CHECKED;
		}
		if ( is_array( $array ) && in_array( $val, $array ) ) {
			return $this->_CHECKED;
		}

		return '';
	}

	public function build_checked( $val ) {
		if ( $val ) {
			return $this->_CHECKED;
		}

		return '';
	}

	public function get_dirname( $id ) {
		$obj = $this->_module_handler->get( $id );
		if ( is_object( $obj ) ) {
			return $obj->getVar( 'dirname', 'n' );
		}

		return false;
	}

	public function get_group_name( $id ) {
		$obj = $this->_member_handler->getGroup( $id );
		if ( is_object( $obj ) ) {
			return $obj->getVar( 'name' );
		}

		return false;
	}

	public function get_token() {
		global $xoopsGTicket;
		if ( is_object( $xoopsGTicket ) ) {
			return $xoopsGTicket->issue( __LINE__ );
		}

		return false;
	}

	public function get_lang() {
		return array(
			'lang_none'   => _NONE,
			'lang_all'    => _ALL,
			'lang_submit' => _SUBMIT,
			'lang_cancel' => _CANCEL,
		);
	}

}
