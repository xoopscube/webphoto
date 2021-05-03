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


class webphoto_inc_xoops_config {

	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_inc_xoops_config();
		}

		return $instance;
	}


// xoops class

	public function get_config_by_dirname( $dirname ) {
		$modid = $this->get_modid_by_dirname( $dirname );

		return $this->get_config_by_modid( $modid );
	}

	public function get_config_by_modid( $modid ) {
		$config_handler =& xoops_gethandler( 'config' );

		return $config_handler->getConfigsByCat( 0, $modid );
	}

	public function get_modid_by_dirname( $dirname ) {
		$module_handler =& xoops_gethandler( 'module' );
		$module         = $module_handler->getByDirname( $dirname );
		if ( ! is_object( $module ) ) {
			return false;
		}

		return $module->getVar( 'mid' );
	}

}
