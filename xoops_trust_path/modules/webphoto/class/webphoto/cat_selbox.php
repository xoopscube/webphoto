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

class webphoto_cat_selbox {
	public $_cat_handler;
	public $_item_handler;


	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_cat_selbox();
		}

		return $instance;
	}

	public function init( $dirname, $trust_dirname ) {
		$this->_item_handler = new webphoto_item_handler(
			$dirname, $trust_dirname );
		$this->_cat_handler  = new webphoto_cat_handler(
			$dirname, $trust_dirname );
	}


// selbox

	public function build_selbox(
		$order = 'cat_title', $preset_id = 0, $none_title = '--', $sel_name = 'cat_id', $onchange = ''
	) {
		$options = $this->build_selbox_options(
			$order, $preset_id, $none_title, $sel_name );

		if ( empty( $options ) ) {
			return null;    // no action
		}

		$str = '<select name="' . $sel_name . '" ';
		if ( $onchange != "" ) {
			$str .= ' onchange="' . $onchange . '" ';
		}
		$str .= ">\n";

		$str .= $options;
		$str .= "</select>\n";

		return $str;
	}

	public function build_selbox_options(
		$order = 'cat_title', $preset_id = 0, $none_title = '--', $sel_name = 'cat_id'
	) {
		$tree = $this->_cat_handler->get_all_tree_array( $order );
		if ( ! is_array( $tree ) || ! count( $tree ) ) {
			return null;    // no action
		}

		$str = '';

		if ( $none_title ) {
			$str .= '<option value="0">' . $none_title . "</option>\n";
		}

		foreach ( $tree as $row ) {
			$catid  = $row['cat_id'];
			$title  = $row['cat_title'];
			$prefix = $row['prefix'];

			$num = $this->_item_handler->get_count_by_catid( $catid );

			if ( $prefix ) {
				$prefix = str_replace( ".", '--', $prefix ) . ' ';
			}

			$sel = '';
			if ( $catid == $preset_id ) {
				$sel = ' selected="selected" ';
			}

			$str .= '<option value="' . $catid . '" ' . $sel . '>';
			$str .= $prefix . $this->sanitize( $title ) . ' (' . $num . ')';
			$str .= "</option>\n";
		}

		return $str;
	}

	public function sanitize( $str ) {
		return htmlspecialchars( $str, ENT_QUOTES );
	}

}
