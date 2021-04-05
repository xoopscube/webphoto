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


class webphoto_editor_base {
	public $_allow_in_not_has_html = false;
	public $_show_display_options = false;
	public $_display_html = 0;
	public $_display_smiley = 0;
	public $_display_xcode = 0;
	public $_display_image = 0;
	public $_display_br = 0;

	public function __construct() {
		// dummy
	}

	function set_allow_in_not_has_html( $val ) {
		$this->_allow_in_not_has_html = (bool) $val;
	}

	function set_show_display_options( $val ) {
		$this->_show_display_options = (bool) $val;
	}

	function set_display_html( $val ) {
		$this->_display_html = intval( $val );
	}

	function set_display_smiley( $val ) {
		$this->_display_smiley = intval( $val );
	}

	function set_display_xcode( $val ) {
		$this->_display_xcode = intval( $val );
	}

	function set_display_image( $val ) {
		$this->_display_image = intval( $val );
	}

	function set_display_br( $val ) {
		$this->_display_br = intval( $val );
	}

	function allow_in_not_has_html() {
// typo
		return $this->_allow_in_not_has_html;
	}

	function show_display_options() {
		return $this->_show_display_options;
	}

	function display_options( $has_html ) {
		$arr = array(
			'html'   => $has_html ? $this->_display_html : 0,
			'smiley' => $this->_display_smiley,
			'xcode'  => $this->_display_xcode,
			'image'  => $this->_display_image,
			'br'     => $this->_display_br
		);

		return $arr;
	}

	function exists() {
		return false;
	}

	function build_js() {
		return null;
	}

	function build_textarea( $id, $name, $value, $rows, $cols, $item_row ) {
		return null;
	}

	function sanitize( $str ) {
		return htmlspecialchars( $str, ENT_QUOTES );
	}

}
