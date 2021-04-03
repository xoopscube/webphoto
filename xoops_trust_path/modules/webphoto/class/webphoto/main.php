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


class webphoto_main extends webphoto_base_this {
	public $_public_class;
	public $_sort_class;


// constructor

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
		//$this->webphoto_base_this( $dirname , $trust_dirname );

		$this->_public_class
			=& webphoto_photo_public::getInstance( $dirname, $trust_dirname );
		$this->_sort_class
			=& webphoto_photo_sort::getInstance( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_main( $dirname, $trust_dirname );
		}

		return $instance;
	}


// detail

	public function build_total_for_detail( $mode ) {
		$title = $this->build_title_by_mode( $mode );
		$name  = $this->_sort_class->mode_to_name( $mode );
		$total = $this->_public_class->get_count_by_name_param( $name, null );

		return array( $title, $total );
	}

	public function build_rows_for_detail( $mode, $sort, $limit = 0, $start = 0 ) {
		$name    = $this->_sort_class->mode_to_name( $mode );
		$orderby = $this->_sort_class->mode_to_orderby( $mode, $sort );

		return $this->_public_class->get_rows_by_name_param_orderby(
			$name, null, $orderby, $limit, $start );
	}


// rss

	public function build_rows_for_rss( $mode, $limit = 0, $start = 0 ) {
		$sort = null;

		return $this->build_rows_for_detail( $mode, $sort, $limit, $start );
	}

// --- class end ---
}

?>
