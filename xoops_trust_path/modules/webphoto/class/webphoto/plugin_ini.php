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


class webphoto_plugin_ini extends webphoto_lib_plugin {
	public $_ini_class;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
		//$this->webphoto_lib_plugin( $dirname, $trust_dirname );

		$this->_ini_class
			=& webphoto_inc_ini::getSingleton( $dirname, $trust_dirname );
		$this->_ini_class->read_main_ini();
	}


// ini class

	public function get_ini( $name ) {
		return $this->_ini_class->get_ini( $name );
	}

	public function explode_ini( $name ) {
		return $this->_ini_class->explode_ini( $name );
	}

}
