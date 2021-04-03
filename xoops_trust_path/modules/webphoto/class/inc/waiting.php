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


class webphoto_inc_waiting extends webphoto_inc_base_ini {

	function __construct( $dirname, $trust_dirname ) {
		parent::__construct();

		$this->init_base_ini( $dirname, $trust_dirname );
		$this->init_handler( $dirname );
	}

	public static function &getSingleton( $dirname, $trust_dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] = new webphoto_inc_waiting( $dirname, $trust_dirname );
		}

		return $singletons[ $dirname ];
	}


// public
	function waiting() {
		$ret               = array();
		$ret['adminlink']  = $this->_MODULE_URL . '/admin/index.php?fct=admission';
		$ret['pendingnum'] = $this->_get_item_count();

// this constant is defined in wating module
		$ret['lang_linkname'] = _PI_WAITING_WAITINGS;

		return $ret;
	}

	function _get_item_count() {
		$sql = "SELECT COUNT(*) FROM " . $this->prefix_dirname( 'item' );
		$sql .= " WHERE item_status=0";

		return $this->get_count_by_sql( $sql );
	}

}
