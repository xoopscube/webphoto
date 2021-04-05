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


class webphoto_editor extends webphoto_plugin_ini {
	public $_has_html = false;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->set_dirname( 'editors' );
		$this->set_prefix( 'webphoto_editor_' );

		$this->_perm_class =& webphoto_permission::getInstance( $dirname, $trust_dirname );
		$this->_has_html = $this->_perm_class->has_html();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_editor( $dirname, $trust_dirname );
		}

		return $instance;
	}


// editor

	public function display_options( $type, $has_html ) {
		if ( empty( $type ) ) {
			$type = $this->get_ini( 'item_editor_default' );
		}

		$class =& $this->get_class_object( $type );
		if ( ! is_object( $class ) ) {
			return false;
		}

		return $class->display_options( $has_html );
	}

	public function init_form( $type, $id, $name, $value, $rows, $cols, $item_row ) {
		$class =& $this->get_class_object( $type );
		if ( ! is_object( $class ) ) {
			return false;
		}

		return array(
			'js'   => $class->build_js(),
			'show' => $class->show_display_options(),
			'desc' => $class->build_textarea( $id, $name, $value, $rows, $cols, $item_row ),
		);
	}

	public function build_list_options( $flag ) {
		$list = $this->build_list();
		$arr  = array();
		foreach ( $list as $type ) {
			if ( $this->exists( $type ) ) {
				$arr[ $type ] = $type;
			}
		}
		if ( $flag &&
		     is_array( $arr ) &&
		     ( count( $arr ) == 1 ) &&
		     isset( $arr[ _C_WEBPHOTO_EDITOR_DEFAULT ] ) ) {
			return false;
		}

		return $arr;
	}

	public function exists( $type ) {
		$class =& $this->get_class_object( $type );
		if ( ! is_object( $class ) ) {
			return false;
		}

		if ( $class->exists() &&
		     ( $this->_has_html || $class->allow_in_not_has_html() ) ) {
			return true;
		}

		return false;
	}

}
