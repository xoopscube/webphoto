<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief class webphoto_xoops_base
 * substitute for clsss/xoops/base.php
 * _include_once_file() -> _include_global_php()
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_xoops_base extends webphoto_lib_handler {
	public $_cached_config_search_array = null;

	public $_cached_group_objs = null;

	public $_MY_MODULE_ID = 0;
	public $_LANGUAGE;

	public $_STR_JPAPANESE = 'japanese|japaneseutf|ja_utf8';

	public $_xoops_config = null;


	public function __construct() {

		parent::__construct();

		$this->_init();
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_xoops_base();
		}

		return $instance;
	}

	public function _init() {
		$this->get_system_config();

		$this->_MY_MODULE_ID = $this->get_my_module_id();
		$this->_LANGUAGE     = $this->get_config_by_name( 'language' );

		$this->_include_global_php();
		$this->_include_setting_php();
	}

	public function _include_global_php() {
		$file = 'global.php';

		$file_sys_lang = $this->_build_system_lang_file( $file, $this->_LANGUAGE );
		$file_sys_eng  = $this->_build_system_lang_file( $file, 'english' );

// for XCL 2.1
		$file_leg_lang = $this->_build_legacy_lang_file( $file, $this->_LANGUAGE );
		$file_leg_eng  = $this->_build_legacy_lang_file( $file, 'english' );

		if ( file_exists( $file_sys_lang ) ) {
			include_once $file_sys_lang;

		} elseif ( file_exists( $file_sys_eng ) ) {
			include_once $file_sys_eng;

		} elseif ( file_exists( $file_leg_lang ) ) {
			include_once $file_leg_lang;

		} elseif ( file_exists( $file_leg_eng ) ) {
			include_once $file_leg_eng;
		}
	}

	public function _include_setting_php() {
// for XCL 2.2
		$file = 'setting.php';

		$file_leg_lang = $this->_build_legacy_lang_file( $file, $this->_LANGUAGE );
		$file_leg_eng  = $this->_build_legacy_lang_file( $file, 'english' );

		if ( file_exists( $file_leg_lang ) ) {
			include_once $file_leg_lang;

		} elseif ( file_exists( $file_leg_eng ) ) {
			include_once $file_leg_eng;
		}
	}

	public function _build_system_lang_file( $file, $lang ) {
		return XOOPS_ROOT_PATH . '/language/' . $lang . '/' . $file;
	}

	public function _build_legacy_lang_file( $file, $lang ) {
		return $this->_build_mod_lang_file( $file, $lang, 'legacy' );
	}

	public function _build_mod_lang_file( $file, $lang, $module ) {
		return XOOPS_ROOT_PATH . '/modules/' . $module . '/language/' . $lang . '/' . $file;
	}

	public function get_language() {
		return $this->_LANGUAGE;
	}

	public function set_db_charset() {
		return $this->_db->set_charset();
	}


// config

	public function get_config_by_name( $name ) {
		return $this->_xoops_config[ $name ] ?? false;
	}

	public function is_japanese( $str = null ) {
		if ( empty( $str ) ) {
			$str = $this->_STR_JPAPANESE;
		}

		if ( in_array( $this->_LANGUAGE, explode( '|', $str ) ) ) {
			return true;
		}

		return false;
	}


// my module

	public function get_my_module_id( $format = 's' ) {
		return $this->get_module_mid_by_dirname( WEBPHOTO_DIRNAME );
	}

	public function get_my_module_name( $format = 's' ) {
		return $this->get_my_module_value_by_name( 'name', $format );
	}

	public function get_my_module_value_by_name( $name, $format = 's' ) {
		global $xoopsModule;
		if ( is_object( $xoopsModule ) ) {
			return $xoopsModule->getVar( $name, $format );
		}

		return false;
	}


// my user

	public function get_my_user_uid( $format = 's' ) {
		return $this->get_my_user_value_by_name( 'uid', $format );
	}

	public function get_my_user_uname( $format = 's' ) {
		return $this->get_my_user_value_by_name( 'uname', $format );
	}

	public function get_my_user_value_by_name( $name, $format = 's' ) {
		global $xoopsUser;
		if ( is_object( $xoopsUser ) ) {
			return $xoopsUser->getVar( $name, $format );
		}

		return false;
	}

	public function get_my_user_groups() {
		global $xoopsUser;
		if ( is_object( $xoopsUser ) ) {
			return $xoopsUser->getGroups();
		}

		return false;
	}

	public function get_my_user_is_login() {
		global $xoopsUser;
		if ( is_object( $xoopsUser ) ) {
			return true;
		}

		return false;
	}

	public function get_my_user_is_module_admin() {
		global $xoopsUser;
		if ( is_object( $xoopsUser ) ) {
			if ( $xoopsUser->isAdmin( $this->_MY_MODULE_ID ) ) {
				return true;
			}
		}

		return false;
	}


// config handler

	public function get_system_config() {
		$conf = $this->get_config_by_modid_catid( 0, 1 );

		$GLOBALS['xoopsConfig'] = $conf;
		$this->_xoops_config    = $conf;

		return $conf;
	}

	public function has_my_module_config() {
		$config_handler =& xoops_gethandler( 'config' );

		return count( $config_handler->getConfigs(
			new Criteria( 'conf_modid', $this->_MY_MODULE_ID ) ) );
	}

	public function get_module_config_by_dirname( $dirname ) {
		return $this->get_module_config_by_mid(
			$this->get_module_mid_by_dirname( $dirname ) );
	}

	public function get_module_config_by_mid( $mid ) {
		return $this->get_config_by_modid_catid( $mid, 0 );
	}

	public function get_config_by_modid_catid( $modid, $catid ) {
		$sql = 'SELECT * FROM ' . $this->db_prefix( 'config' );
		$sql .= ' WHERE (conf_modid = ' . (int) $modid;
		$sql .= ' AND conf_catid = ' . (int) $catid;
		$sql .= ' ) ';
		$sql .= ' ORDER BY conf_order ASC';

		$rows = $this->get_rows_by_sql( $sql );

		$arr = array();
		foreach ( $rows as $row ) {
			$arr[ $row['conf_name'] ] = $row['conf_value'];
		}

		return $arr;
	}

	public function get_search_config() {
		$config_handler                    =& xoops_gethandler( 'config' );
		$conf                              = $config_handler->getConfigsByCat( XOOPS_CONF_SEARCH );
		$this->_cached_config_search_array = $conf;

		return $conf;
	}

	public function get_search_config_by_name( $name ) {
		if ( ! is_array( $this->_cached_config_search_array ) ) {
			$this->_cached_config_search_array = $this->get_search_config();
		}

		return $this->_cached_config_search_array[ $name ] ?? false;
	}


// module handler

	public function get_module_mid_by_dirname( $dirname, $format = 's' ) {
		$sql = 'SELECT * FROM ' . $this->db_prefix( 'modules' );
		$sql .= ' WHERE dirname = ' . $this->quote( $dirname );
		$row = $this->get_row_by_sql( $sql );

		return $row['mid'];
	}

	public function get_module_name_by_dirname( $dirname, $format = 's' ) {
		return $this->get_module_value_by_dirname( $dirname, 'name', $format );
	}

	public function get_module_value_by_dirname( $dirname, $name, $format = 's' ) {
		$module_handler =& xoops_gethandler( 'module' );
		$module         = $module_handler->getByDirname( $dirname );
		if ( is_object( $module ) ) {
			return $module->getVar( $name, $format = 's' );
		}

		return false;
	}


// user handler

	public function get_user_uname_from_id( $uid, $usereal = 0 ) {
		return XoopsUser::getUnameFromId( $uid, $usereal );
	}

	public function build_userinfo( $uid, $usereal = 0 ) {
		$uname = $this->get_user_uname_from_id( $uid, $usereal );

// geust
		$uid = (int) $uid;
		if ( $uid == 0 ) {
			return $uname;
		}

		return '<a href="' . XOOPS_URL . '/userinfo.php?uid=' . $uid . '">' . $uname . '</a>';
	}


// group handler

	public function get_group_obj() {
		$group_handler            = xoops_gethandler( "group" );
		$objs                     = $group_handler->getObjects( null, true );
		$this->_cached_group_objs = $objs;

		return $objs;
	}

	public function get_group_by_id_name( $id, $name, $format = 's' ) {
		if ( ! is_array( $this->_cached_group_objs ) ) {
			$this->_cached_group_objs = $this->get_group_obj();
		}
		if ( isset( $this->_cached_group_objs[ $id ] ) ) {
			return $this->_cached_group_objs[ $id ]->getVar( $name, $format );
		}

		return false;
	}


// member handler

	public function get_member_user_list( $limit = 0, $start = 0 ) {
		$criteria = new CriteriaCompo();
		$criteria->setStart( $start );
		$criteria->setLimit( $limit );
		$criteria->setSort( 'uname' );

		$member_handler =& xoops_gethandler( 'member' );

		return $member_handler->getUserList( $criteria );
	}
}
