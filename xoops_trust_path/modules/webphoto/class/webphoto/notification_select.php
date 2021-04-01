<?php
// $Id: notification_select.php,v 1.1 2010/01/25 10:05:02 ohwada Exp $

//=========================================================
// webphoto module
// 2010-01-10 K.OHWADA
//=========================================================

if( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

//=========================================================
// class webphoto_notification_select
//=========================================================
class webphoto_notification_select
{
	public $_d3_notification_select_class;
	public $_config_class;

	public $_cfg_use_pathinfo;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
public function __construct( $dirname )
{
	$this->_notification_select_class =& webphoto_d3_notification_select::getInstance();
	$this->_notification_select_class->init( $dirname ); 

	$this->_config_class =& webphoto_config::getInstance( $dirname );
	$this->_cfg_use_pathinfo = $this->_config_class->get_by_name('use_pathinfo');
}

public static function &getInstance( $dirname = null, $trust_dirname = null )
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_notification_select( $dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// notification select class
//---------------------------------------------------------
public function build_notification_select( $cat_id=0 )
{
// for core's notificationSubscribableCategoryInfo
	$_SERVER['PHP_SELF'] = $this->_notification_select_class->get_new_php_self();
	if ( $cat_id > 0 ) {
		$_GET['cat_id'] = $cat_id;
	}

	return $this->_notification_select_class->build( $this->_cfg_use_pathinfo );
}

}

