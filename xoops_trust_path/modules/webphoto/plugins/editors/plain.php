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

class webphoto_editor_plain extends webphoto_editor_base {

	public function __construct() {

		parent::__construct();

		$this->set_display_smiley( 1 );
		$this->set_display_xcode( 1 );
		$this->set_display_image( 1 );
		$this->set_display_br( 1 );
	}

	public function exists() {
		return true;
	}

	public function build_textarea( $id, $name, $value, $rows, $cols, $item_row ) {
		$str = '<textarea id="' . $id . '" name="' . $name . '" rows="' . $rows . '" cols="' . $cols . '" >';
		$str .= $this->sanitize( $value );
		$str .= '</textarea>';

		return $str;
	}

}
