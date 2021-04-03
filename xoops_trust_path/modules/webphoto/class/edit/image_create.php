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


class webphoto_edit_image_create extends webphoto_edit_base_create {

	public $_ext_class;

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_ext_class
			=& webphoto_ext::getInstance( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_image_create( $dirname, $trust_dirname );
		}

		return $instance;
	}


// create

	public function create( $param ) {
		$extra_param = $this->_ext_class->execute( 'image', $param );
		if ( isset( $extra_param['src_file'] ) ) {
			$this->set_flag_created();
			$this->set_result( $extra_param );

			return 1;

		} elseif ( isset( $extra_param['errors'] ) ) {
			$this->set_flag_failed();
			$this->set_error( $extra_param['errors'] );

			return - 1;
		}

		return 0;
	}

}

