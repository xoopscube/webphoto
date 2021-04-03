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


class webphoto_admin_check_file extends webphoto_base_this {
	public $_file_check_class;

// color: green;
	public $_SPAN_STYLE_GREEN = 'color: #00ff00;';


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_file_check_class =& webphoto_lib_file_check::getInstance(
			$dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_check_file( $dirname, $trust_dirname );
		}

		return $instance;
	}


	function main() {
		xoops_cp_header();

		echo $this->build_admin_menu();
		echo "<h3>" . _AM_WEBPHOTO_FILE_CHECK . "</h3>\n";

		echo _AM_WEBPHOTO_FILE_CHECK_DSC . "<br><br>\n";
		$this->_print_file_check();

		xoops_cp_footer();
	}


// check file

	function _print_file_check() {
		$flag_error = false;

		$msg = $this->_file_check_class->check_list( 'trust' );
		if ( $msg ) {
			$flag_error = true;
			echo $this->highlight( $msg );
		}

		$msg = $this->_file_check_class->check_list( 'root' );
		if ( $msg ) {
			$flag_error = true;
			echo $this->highlight( $msg );
		}

		if ( ! $flag_error ) {
			echo $this->green( "OK" );
		}
		echo "<br>\n";
	}

	function green( $msg ) {
		$str = '<span style="' . $this->_SPAN_STYLE_GREEN . '">';
		$str .= $msg;
		$str .= "</span>\n";

		return $str;
	}


}

