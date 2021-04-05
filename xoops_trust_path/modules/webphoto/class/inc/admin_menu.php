<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief class webphoto_inc_admin_menu
 * caller webphoto_lib_admin_menu admin/menu.php
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_inc_admin_menu {
	public $_ini_class;

	public $_DIRNAME;
	public $_TRUST_DIR;

	public function __construct( $dirname, $trust_dirname ) {
		$this->_DIRNAME   = $dirname;
		$this->_TRUST_DIR = XOOPS_TRUST_PATH . '/modules/' . $trust_dirname;

		$this->_ini_class
			=& webphoto_inc_ini::getSingleton( $dirname, $trust_dirname );
		$this->_ini_class->read_main_ini();

	}

	public static function &getSingleton( $dirname, $trust_dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] = new webphoto_inc_admin_menu( $dirname, $trust_dirname );
		}

		return $singletons[ $dirname ];
	}

	public function build_menu() {
		$menu_array = $this->explode_ini( 'admin_menu_list' );

		return $this->build_menu_array( $menu_array );
	}

	public function build_sub_menu() {
		$menu_array = $this->explode_ini( 'admin_sub_menu_list' );

		return $this->build_menu_array( $menu_array );
	}

// utility
	public function build_menu_array( $array ) {
		$arr = array();
		foreach ( $array as $fct ) {
			$arr[] = array(
				'title' => $this->build_title( $fct ),
				'link'  => $this->build_link( $fct ),
			);
		}

		return $arr;
	}

	public function build_title( $fct ) {
		return $this->get_constant( $fct );
	}

	public function build_link( $fct ) {
		$link = 'admin/index.php';
		if ( $this->file_fct_exists( $fct ) ) {
			$link .= '?fct=' . $fct;
		}

		return $link;
	}

	public function file_fct_exists( $fct ) {
		$file = $this->_TRUST_DIR . '/admin/' . $fct . '.php';

		return file_exists( $file );
	}


// language
	public function get_constant( $name ) {
		$const_name = $this->get_constant_name( $name );
		if ( defined( $const_name ) ) {
			return constant( $const_name );
		}

		return $const_name;
	}

	public function get_constant_name( $name ) {
		return strtoupper( '_MI_' . $this->_DIRNAME . '_ADMENU_' . $name );
	}


// ini class
	public function get_ini( $name ) {
		return $this->_ini_class->get_ini( $name );
	}

	public function explode_ini( $name ) {
		return $this->_ini_class->explode_ini( $name );
	}

}

