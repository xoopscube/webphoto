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


class webphoto_qr extends webphoto_base_this {
	public $_user_handler;

	public $_QR_MODULE_SIZE = 3;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
		//$this->webphoto_base_this( $dirname, $trust_dirname );

		$this->_user_handler
			=& webphoto_user_handler::getInstance( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_qr( $dirname, $trust_dirname );
		}

		return $instance;
	}


// qr code

	public function create_mobile_qr( $id ) {
		$file = $this->_QRS_DIR . '/' . $this->build_mobile_filename( $id );
		if ( ! is_file( $file ) ) {
			$qrimage = new Qrcode_image;
			$qrimage->set_module_size( $this->_QR_MODULE_SIZE );
			$qrimage->qrcode_image_out( $this->build_mobile_url( $id ), 'png', $file );
		}
	}

	public function build_mobile_param( $photo_id ) {
		return array(
			'mobile_email'    => $this->get_mobile_email(),
			'mobile_url'      => $this->build_mobile_url( $photo_id ),
			'mobile_qr_image' => $this->build_mobile_filename( $photo_id )
		);
	}

	public function build_mobile_url( $id ) {
		$url = $this->_MODULE_URL . '/i.php';
		if ( $id > 0 ) {
			$url .= '?id=' . $id;
		}

		return $url;
	}

	public function build_mobile_filename( $id ) {
		$file = 'qr_index.png';
		if ( $id > 0 ) {
			$file = 'qr_id_' . $id . '.png';
		}

		return $file;
	}

	public function get_mobile_email() {
		$row = $this->_user_handler->get_row_by_uid( $this->_xoops_uid );
		if ( is_array( $row ) ) {
			return $row['user_email'];
		}

		return null;
	}

}
