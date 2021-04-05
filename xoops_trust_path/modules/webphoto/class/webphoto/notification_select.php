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


class webphoto_notification_select {
	public $_d3_notification_select_class;
	public $_config_class;

	public $_cfg_use_pathinfo;


	public function __construct( $dirname ) {
		$this->_notification_select_class =& webphoto_d3_notification_select::getInstance();
		$this->_notification_select_class->init( $dirname );

		$this->_config_class     =& webphoto_config::getInstance( $dirname );
		$this->_cfg_use_pathinfo = $this->_config_class->get_by_name( 'use_pathinfo' );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_notification_select( $dirname );
		}

		return $instance;
	}


// notification select class

	public function build_notification_select( $cat_id = 0 ) {
// for core's notificationSubscribableCategoryInfo
		$_SERVER['PHP_SELF'] = $this->_notification_select_class->get_new_php_self();
		if ( $cat_id > 0 ) {
			$_GET['cat_id'] = $cat_id;
		}

		return $this->_notification_select_class->build( $this->_cfg_use_pathinfo );
	}

}

