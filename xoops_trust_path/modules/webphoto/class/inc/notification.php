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


class webphoto_inc_notification extends webphoto_inc_base_ini {
	public $_uri_class;

	public $_INDEX_URL;

	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct();

		$this->init_base_ini( $dirname, $trust_dirname );
		$this->init_handler( $dirname );

		$this->_INDEX_URL = $this->_MODULE_URL . '/index.php';

		$this->_uri_class =& webphoto_inc_uri::getSingleton( $dirname );
	}

	public static function &getSingleton( $dirname, $trust_dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] = new webphoto_inc_notification( $dirname, $trust_dirname );
		}

		return $singletons[ $dirname ];
	}


// public

	public function notify( $category, $id ) {
		$info = array();

		switch ( $category ) {
			case 'global':
				$info['name'] = '';
				$info['url']  = '';
				break;

			case 'category':
				$info['name'] = $this->_get_cat_title( $id );
				$info['url']  = $this->_get_url( $category, $id );
				break;

			case 'photo':
				$info['name'] = $this->_get_item_title( $id );
				$info['url']  = $this->_get_url( $category, $id );
				break;
		}

		return $info;
	}

	public function _get_url( $category, $id ) {
		return $this->_uri_class->build_full_uri_mode_param( $category, $id );
	}


// handler

	public function _get_item_title( $item_id ) {
		$row = $this->get_item_row_by_id( $item_id );

		return $row['item_title'] ?? false;
	}

	public function _get_cat_title( $cat_id ) {
		$row = $this->get_cat_row_by_id( $cat_id );
		if ( isset( $row['cat_title'] ) ) {
			return $row['cat_title'];
		}

		return false;
	}

}
