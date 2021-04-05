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


class webphoto_lib_plugin {
	public $_utility_class;

	public $_cached_by_type = array();

	public $_DIRNAME;
	public $_TRUST_DIRNAME;
	public $_MODULE_URL;
	public $_MODULE_DIR;
	public $_TRUST_DIR;

	public $_TRUST_PLUGIN_DIR = null;
	public $_ROOT_PLUGIN_DIR = null;
	var $_PLUGIN_PREFIX = null;

	public function __construct( $dirname, $trust_dirname ) {
		$this->_DIRNAME       = $dirname;
		$this->_MODULE_URL    = XOOPS_URL . '/modules/' . $dirname;
		$this->_MODULE_DIR    = XOOPS_ROOT_PATH . '/modules/' . $dirname;
		$this->_TRUST_DIRNAME = $trust_dirname;
		$this->_TRUST_DIR     = XOOPS_TRUST_PATH . '/modules/' . $trust_dirname;

		$this->_utility_class =& webphoto_lib_utility::getInstance();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_plugin( $dirname, $trust_dirname );
		}

		return $instance;
	}


// set param

	public function set_dirname( $sub_dir ) {
		$dir                     = '/plugins/' . $sub_dir;
		$this->_TRUST_PLUGIN_DIR = $this->_TRUST_DIR . $dir;
		$this->_ROOT_PLUGIN_DIR  = $this->_MODULE_DIR . $dir;
	}

	public function set_prefix( $val ) {
		$this->_PLUGIN_PREFIX = $val;
	}


// plugin

	public function build_list() {
		$files = $this->_utility_class->get_files_in_dir( $this->_TRUST_PLUGIN_DIR, 'php', false, true );
		$arr   = array();
		foreach ( $files as $file ) {
			$arr[] = str_replace( '.php', '', $file );
		}

		return $arr;
	}

	public function &get_cached_class_object( $type ) {
		if ( isset( $this->_cached_by_type[ $type ] ) ) {
			return $this->_cached_by_type[ $type ];
		}

		$obj =& $this->get_class_object( $type );
		if ( is_object( $obj ) ) {
			$this->_cached_by_type[ $type ] =& $obj;
		}

		return $obj;
	}

	public function &get_class_object( $type ) {
		$false = false;

		if ( empty( $type ) ) {
			return $false;
		}

		$this->include_once_file( $type );

		$class_name = $this->get_class_name( $type );
		if ( empty( $class_name ) ) {
			return $false;
		}

		$class = new $class_name();

		return $class;
	}

	public function include_once_file( $type ) {
		$file = $this->get_file_name( $type );
		if ( $file ) {
			include_once $file;
		}
	}

	public function get_file_name( $type ) {
		$type_php   = $type . '.php';
		$file_trust = $this->_TRUST_PLUGIN_DIR . '/' . $type_php;
		$file_root  = $this->_ROOT_PLUGIN_DIR . '/' . $type_php;

		if ( file_exists( $file_root ) ) {
			return $file_root;
		} elseif ( file_exists( $file_trust ) ) {
			return $file_trust;
		}

		return false;
	}

	public function get_class_name( $type ) {
		$class = $this->_PLUGIN_PREFIX . $type;
		if ( class_exists( $class ) ) {
			return $class;
		}

		return false;
	}


}
