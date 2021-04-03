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


class webphoto_inc_oninstall_cat extends webphoto_inc_base_ini {
	public $_table_cat;

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct();
//	$wp = new webphoto_inc_base_ini();
//	$this->$wp;
		$this->init_base_ini( $dirname, $trust_dirname );
		$this->init_handler( $dirname );

		$this->_table_cat = $this->prefix_dirname( 'cat' );
	}

	public static function &getSingleton( $dirname, $trust_dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] = new webphoto_inc_oninstall_cat( $dirname, $trust_dirname );
		}

		return $singletons[ $dirname ];
	}


// cat table

	public function update() {
		$this->_cat_add_column_260();
		$this->_cat_add_column_060();
		$this->_cat_add_column_200();
	}

	public function _cat_add_column_260() {

// return if already exists
		if ( $this->exists_column( $this->_table_cat, 'cat_timeline_mode' ) ) {
			return true;
		}

		$sql = "ALTER TABLE " . $this->_table_cat . " ADD ( ";
		$sql .= "cat_timeline_mode  TINYINT(2) NOT NULL DEFAULT '0', ";
		$sql .= "cat_timeline_scale INT(5) NOT NULL DEFAULT '0' ";
		$sql .= " )";

		$ret = $this->query( $sql );
		if ( $ret ) {
			$this->set_msg( 'Add cat_timeline_scale in <b>' . $this->_table_cat . '</b>' );

			return true;
		} else {
			$this->set_msg( $this->highlight( 'ERROR: Could not update <b>' . $this->_table_cat . '</b>.' ) );

			return false;
		}

	}

	public function _cat_add_column_060() {

// return if already exists
		if ( $this->exists_column( $this->_table_cat, 'cat_img_name' ) ) {
			return true;
		}

		$sql = "ALTER TABLE " . $this->_table_cat . " ADD ( ";
		$sql .= "cat_img_name VARCHAR(191) NOT NULL DEFAULT '' ";
		$sql .= " )";

		$ret = $this->query( $sql );
		if ( $ret ) {
			$this->set_msg( 'Add cat_img_name in <b>' . $this->_table_cat . '</b>' );

			return true;
		} else {
			$this->set_msg( $this->highlight( 'ERROR: Could not update <b>' . $this->_table_cat . '</b>.' ) );

			return false;
		}

	}

	public function _cat_add_column_200() {

// return if already exists
		if ( $this->exists_column( $this->_table_cat, 'cat_group_id' ) ) {
			return true;
		}

		$sql = "ALTER TABLE " . $this->_table_cat . " ADD ( ";
		$sql .= "cat_group_id INT(5) UNSIGNED NOT NULL DEFAULT '0' ";
		$sql .= " )";

		$ret = $this->query( $sql );
		if ( $ret ) {
			$this->set_msg( 'Add cat_img_name in <b>' . $this->_table_cat . '</b>' );

			return true;
		} else {
			$this->set_msg( $this->highlight( 'ERROR: Could not update <b>' . $this->_table_cat . '</b>.' ) );

			return false;
		}

	}

}

