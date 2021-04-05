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


class webphoto_ext extends webphoto_lib_plugin {
	public $_cached_list = null;
	public $_cached_objs_by_ext = array();


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->set_dirname( 'exts' );
		$this->set_prefix( 'webphoto_ext_' );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_ext( $dirname, $trust_dirname );
		}

		return $instance;
	}


// public

	function execute( $method, $param ) {
		$ext = isset( $param['src_ext'] ) ? $param['src_ext'] : null;
		if ( empty( $ext ) ) {
			return null;    // no action
		}

		$class =& $this->get_cached_class_object_by_ext( $ext );
		if ( ! is_object( $class ) ) {
			return null;    // no action
		}

		return $class->execute( $method, $param );
	}


// private

	function &get_cached_class_object_by_ext( $ext ) {
		if ( isset( $this->_cached_objs_by_ext[ $ext ] ) ) {
			return $this->_cached_objs_by_ext[ $ext ];
		}

		$list = $this->get_cached_list();
		foreach ( $list as $type ) {
			$class =& $this->get_cached_class_object( $type );
			if ( ! is_object( $class ) ) {
				continue;
			}
			if ( ! $class->is_ext( $ext ) ) {
				continue;
			}

			return $class;
		}

		$false = false;

		return $false;
	}

	function get_cached_list() {
		if ( is_array( $this->_cached_list ) ) {
			return $this->_cached_list;
		}

		$list               = $this->build_list();
		$this->_cached_list = $list;

		return $list;
	}

// overwrite
	function &get_class_object( $type ) {
		$false = false;

		if ( empty( $type ) ) {
			return $false;
		}

		$this->include_once_file( $type );

		$class_name = $this->get_class_name( $type );
		if ( empty( $class_name ) ) {
			return $false;
		}

		$class = new $class_name( $this->_DIRNAME, $this->_TRUST_DIRNAME );

		return $class;
	}

}
