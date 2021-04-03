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


class webphoto_handler_base_ini extends webphoto_lib_tree_handler {
	public $_utility_class;
	public $_mysql_utility_class;
	public $_ini_class;

	public $_MODULE_DIR;
	public $_TRUST_DIRNAME;
	public $_TRUST_DIR;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname );


		$this->_MODULE_DIR    = XOOPS_ROOT_PATH . '/modules/' . $dirname;
		$this->_TRUST_DIRNAME = $trust_dirname;
		$this->_TRUST_DIR     = XOOPS_TRUST_PATH . '/modules/' . $trust_dirname;

		$this->_utility_class       =& webphoto_lib_utility::getInstance();
		$this->_mysql_utility_class =& webphoto_lib_mysql_utility::getInstance();

		$this->_ini_class
			=& webphoto_inc_ini::getSingleton( $dirname, $trust_dirname );
		$this->_ini_class->read_main_ini();

		$this->set_debug_sql_by_ini_name( _C_WEBPHOTO_NAME_DEBUG_SQL );
		$this->set_debug_error_by_ini_name( _C_WEBPHOTO_NAME_DEBUG_ERROR );
	}


// ini class

	public function get_ini( $name ) {
		return $this->_ini_class->get_ini( $name );
	}

	public function explode_ini( $name, $grue = '|', $prefix = null ) {
		return $this->_ini_class->explode_ini( $name, $grue, $prefix );
	}


// utility class

	public function perm_str_to_array( $str ) {
		return $this->_utility_class->str_to_array( $str, _C_WEBPHOTO_PERM_SEPARATOR );
	}

	public function perm_array_to_str( $str ) {
		return $this->_utility_class->array_to_str( $str, _C_WEBPHOTO_PERM_SEPARATOR );
	}

	public function info_str_to_array( $str ) {
		return $this->_utility_class->str_to_array( $str, _C_WEBPHOTO_INFO_SEPARATOR );
	}

	public function info_array_to_str( $str ) {
		return $this->_utility_class->array_to_str( $str, _C_WEBPHOTO_INFO_SEPARATOR );
	}

	public function perm_str_with_separetor( $str ) {
// &123&
		$ret = _C_WEBPHOTO_PERM_SEPARATOR . $str . _C_WEBPHOTO_PERM_SEPARATOR;

		return $ret;
	}

	public function perm_str_with_like_separetor( $str ) {
// %&123&%
		$like = '%' . $this->perm_str_with_separetor( $str ) . '%';

		return $like;
	}


// mysql

	public function str_to_mysql_datetime( $str ) {
		return $this->_mysql_utility_class->str_to_mysql_datetime( $str );
	}


// debug

	public function set_debug_sql_by_ini_name( $name ) {
		$val = $this->get_ini( $name );
		if ( $val ) {
			$this->set_debug_sql( $val );
		}
	}

	public function set_debug_error_by_ini_name( $name ) {
		$val = $this->get_ini( $name );
		if ( $val ) {
			$this->set_debug_error( $val );
		}
	}

}
