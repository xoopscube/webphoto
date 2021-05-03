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


class webphoto_inc_base_ini extends webphoto_inc_handler {
	public $_ini_class;

	public $_msg_array = array();

	public $_DIRNAME;
	public $_TRUST_DIRNAME;
	public $_MODULE_DIR;
	public $_TRUST_DIR;

	public function __construct() {

		parent::__construct();

	}

	public function init_base_ini( $dirname, $trust_dirname ) {
		$this->_DIRNAME       = $dirname;
		$this->_MODULE_DIR    = XOOPS_ROOT_PATH . '/modules/' . $dirname;
		$this->_TRUST_DIRNAME = $trust_dirname;
		$this->_TRUST_DIR     = XOOPS_TRUST_PATH . '/modules/' . $trust_dirname;

		$this->_ini_class =& webphoto_inc_ini::getSingleton( $dirname, $trust_dirname );
		$this->_ini_class->read_main_ini();

		$this->set_debug_sql_by_ini_name( _C_WEBPHOTO_NAME_DEBUG_SQL );
		$this->set_debug_error_by_ini_name( _C_WEBPHOTO_NAME_DEBUG_ERROR );
	}

	public function get_ini( $name ) {
		return $this->_ini_class->get_ini( $name );
	}

	public function explode_ini( $name ) {
		return $this->_ini_class->explode_ini( $name );
	}

	public function set_msg( $msg ) {
// array type
		if ( is_array( $msg ) ) {
			foreach ( $msg as $m ) {
				$this->_msg_array[] = $m;
			}

// string type
		} else {
			$arr = explode( "\n", $msg );
			foreach ( $arr as $m ) {
				$this->_msg_array[] = $m;
			}
		}
	}

	public function get_msg_array() {
		return $this->_msg_array;
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

