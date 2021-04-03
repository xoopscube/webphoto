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


class webphoto_inc_comment extends webphoto_inc_base_ini {

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct();
//	$wp = new webphoto_inc_base_ini();
//	$this->$wp;
		$this->init_base_ini( $dirname, $trust_dirname );
		$this->init_handler( $dirname );
	}

	public static function &getSingleton( $dirname, $trust_dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] = new webphoto_inc_comment( $dirname, $trust_dirname );
		}

		return $singletons[ $dirname ];
	}


// public

	function update_photo_comments( $item_id, $comments ) {
		$sql = 'UPDATE ' . $this->prefix_dirname( 'item' );
		$sql .= ' SET ';
		$sql .= 'item_comments=' . (int) $comments . ' ';
		$sql .= 'WHERE item_id=' . (int) $item_id;

		return $this->query( $sql );
	}

}
