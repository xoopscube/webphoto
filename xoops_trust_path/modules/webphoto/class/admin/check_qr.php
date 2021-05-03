<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_admin_check_qr extends webphoto_base_this {
	public $_TITLE = 'QR code check';
	public $_QR_MODULE_SIZE = 3;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_check_qr( $dirname, $trust_dirname );
		}

		return $instance;
	}


	public function main() {
		restore_error_handler();
		error_reporting( E_ALL );

		$mode = $this->_post_class->get_get_int( 'mode' );

		$dir_err = false;
		$file    = '';
		$url     = '';

		if ( $mode == 0 ) {
			if ( is_dir( $this->_QRS_DIR ) && is_writable( $this->_QRS_DIR ) ) {
				$file = $this->_QRS_DIR . '/qr_test.png';
				$url  = $this->_QRS_URL . '/qr_test.png';
				if ( is_file( $file ) ) {
					unlink( $file );
				}
			} else {
				$dir_err = true;
			}
		}

		if ( $mode == 2 ) {
			header( "Content-type: image/png" );
		}

		if ( $mode != 2 ) {
			echo $this->build_html_head( $this->_TITLE );
			echo $this->build_html_body_begin();
		}

		if ( $mode == 0 ) {
			echo _AM_WEBPHOTO_QR_CHECK_SUCCESS . "<br><br>\n";
			echo '<a href="' . $this->_MODULE_URL . '/admin/index.php?fct=check_qr&amp;mode=1">';
			echo _AM_WEBPHOTO_QR_CHECK_SHOW;
			echo '</a><br>' . "\n";
		}

		if ( $mode == 1 ) {
			echo '<b>' . _AM_WEBPHOTO_QR_CHECK_INFO . '</b>';
			echo "<br><br>\n";
		}
		//!Fix $data    = 'test' . rand();
		$data    = 'test' . mt_rand();
		$qrimage = new Qrcode_image;
		$qrimage->set_module_size( $this->_QR_MODULE_SIZE );
		$qrimage->qrcode_image_out( $data, 'png', $file );

		if ( $mode == 0 ) {
			echo "<br>\n";
			if ( $dir_err ) {
				echo "not writable <b>" . $this->_QRS_DIR . "</b><br>\n";
			} elseif ( ! is_file( $file ) ) {
				echo "not create QR file <br>\n";
			}
			echo '<img src="' . $url . '" >';
		}

		if ( $mode != 2 ) {
			echo "<br><br>\n";
			echo '<input class="formButton" value="' . _CLOSE . '" type="button" onclick="javascript:window.close();" />';
			echo $this->build_html_body_end();
		}
	}
}
