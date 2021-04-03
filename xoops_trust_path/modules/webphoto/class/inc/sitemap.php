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


class webphoto_inc_sitemap extends webphoto_inc_base_ini {
	public $_uri_class;

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct();
//	$wp = new webphoto_inc_base_ini();
//	$this->$wp;
		$this->init_base_ini( $dirname, $trust_dirname );
		$this->init_handler( $dirname );

		$this->_uri_class =& webphoto_inc_uri::getSingleton( $dirname );
	}

	public static function &getSingleton( $dirname, $trust_dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] = new webphoto_inc_sitemap( $dirname, $trust_dirname );
		}

		return $singletons[ $dirname ];
	}


// public

	function sitemap() {
		$table_cat = $this->prefix_dirname( 'cat' );

		$link = $this->_uri_class->build_sitemap_category();

// this function is defined in sitemap module
		if ( function_exists( 'sitemap_get_categoires_map' ) ) {
			return sitemap_get_categoires_map(
				$table_cat, 'cat_id', 'cat_pid', 'cat_title', $link, 'cat_title' );
		}

		return array();
	}

}

