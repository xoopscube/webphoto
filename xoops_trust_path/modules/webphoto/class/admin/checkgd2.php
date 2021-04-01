<?php
// $Id: checkgd2.php,v 1.1 2008/12/10 19:10:04 ohwada Exp $

//=========================================================
// webphoto module
// 2008-12-07 K.OHWADA
//=========================================================

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

//=========================================================
// class webphoto_admin_checkgd2
//=========================================================
class webphoto_admin_checkgd2 {

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
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

//---------------------------------------------------------
// main
//---------------------------------------------------------
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

