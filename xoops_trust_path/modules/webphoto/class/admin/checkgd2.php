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


class webphoto_admin_checkgd2 {


	public function __construct( $dirname, $trust_dirname ) {
		// dummy
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_checkgd2( $dirname, $trust_dirname );
		}

		return $instance;
	}


	public function main() {
		xoops_cp_header();

		restore_error_handler();
		error_reporting( E_ALL );

		if ( imagecreatetruecolor( 200, 200 ) ) {
			echo _AM_WEBPHOTO_GD2SUCCESS;

		} else {
			echo 'Failed';
		}

		echo "<br><br>\n";
		echo '<input class="formButton" value="' . _CLOSE . '" type="button" onclick="javascript:window.close();" />';

		xoops_cp_footer();
	}
}

