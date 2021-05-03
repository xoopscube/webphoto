<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_edit_video_images_create extends webphoto_edit_base_create {
	public $_ext_class;

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_ext_class
			=& webphoto_ext::getInstance( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_video_images_create(
				$dirname, $trust_dirname );
		}

		return $instance;
	}


// create

	public function create( $param ) {
		$this->clear_flags();

		$ret = $this->_ext_class->execute( 'video_images', $param );
		if ( $ret == 1 ) {
			$this->set_flag_created();

			return 1;
		} elseif ( $ret == - 1 ) {
			$this->set_flag_failed();

			return - 1;
		}

		return 0;
	}
}
