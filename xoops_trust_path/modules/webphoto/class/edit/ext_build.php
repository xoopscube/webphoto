<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief class webphoto_d3_notification_select
 * subsitute for core's notification_select.php
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_edit_ext_build extends webphoto_edit_base_create {
	public $_ext_class;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_ext_class
			=& webphoto_ext::getInstance( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_ext_build( $dirname, $trust_dirname );
		}

		return $instance;
	}

	public function get_exif( $row, $src_file ) {
		$param = $this->_ext_class->execute(
			'exif',
			$this->build_param( $row, $src_file ) );

		if ( is_array( $param ) ) {
			$this->set_result( $param );

			return 1;
		}

		return 0;
	}

	public function get_video_info( $row, $src_file ) {
		$param = $this->_ext_class->execute(
			'video_info',
			$this->build_param( $row, $src_file ) );

		if ( is_array( $param ) ) {
			$this->set_result( $param );

			return 1;
		}

		return 0;
	}

	public function get_text_content( $row, $file_id_array ) {
		$file_cont = $this->get_file_full_by_key( $file_id_array, 'cont_id' );
		$file_pdf  = $this->get_file_full_by_key( $file_id_array, 'pdf_id' );

		$param              = $row;
		$param['src_ext']   = $row['item_ext'];
		$param['file_cont'] = $file_cont;
		$param['file_pdf']  = $file_pdf;

		$extra_param = $this->_ext_class->execute( 'text_content', $param );

		if ( isset( $extra_param['content'] ) ) {
			$this->set_result( $extra_param['content'] );

			return 1;

		} elseif ( isset( $extra_param['errors'] ) ) {
			$this->set_error( $extra_param['errors'] );

			return - 1;
		}

		return 0;
	}

	public function build_param( $row, $src_file ) {
		$param             = $row;
		$param['src_ext']  = $row['item_ext'];
		$param['src_file'] = $src_file;

		return $param;
	}

	public function get_file_full_by_key( $arr, $key ) {
		$id = isset( $arr[ $key ] ) ? (int) $arr[ $key ] : 0;
		if ( $id > 0 ) {
			return $this->_file_handler->get_full_path_by_id( $id );
		}

		return null;
	}

}
