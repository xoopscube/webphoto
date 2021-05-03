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


class webphoto_edit_file_build extends webphoto_edit_base_create {
	public $_exif_class;
	public $_ext_class;
	public $_mime_class;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname );

		$this->_exif_class =& webphoto_exif::getInstance();
		$this->_ext_class  =& webphoto_ext::getInstance( $dirname, $trust_dirname );
		$this->_mime_class =& webphoto_mime::getInstance( $dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_file_build( $dirname, $trust_dirname );
		}

		return $instance;
	}


// item extention

	public function build_exif_duration( $row, $src_file ) {
		$this->clear_msg_array();

		$param             = $row;
		$param['src_file'] = $src_file;
		$param['src_ext']  = $row['item_ext'];
		$param['src_kind'] = $row['item_kind'];

		$row = $this->build_row_exif( $row, $param );
		$row = $this->build_row_duration( $row, $param );

		return $row;
	}

	public function build_content( $row, $file_cont, $file_pdf ) {
		$this->clear_msg_array();

		$param              = $row;
		$param['src_ext']   = $row['item_ext'];
		$param['file_cont'] = $file_cont;
		$param['file_pdf']  = $file_pdf;

		$row = $this->build_row_content( $row, $param );

		return $row;
	}

	public function build_row_exif( $row, $param ) {
		$src_file = $param['src_file'];

		if ( ! $this->is_image_kind( $row['item_kind'] ) ) {
			return $row;
		}

		$flag = $this->_exif_class->build_row_exif( $row, $src_file );
		if ( $flag == 0 ) {
			return $row;

		} elseif ( $flag == 2 ) {
			$this->set_msg( 'get exif' );

		} else {
			$this->set_msg( 'no exif' );
		}

		$row = $this->_exif_class->get_row();

		return $row;
	}

	public function build_row_duration( $row, $param ) {
		$extra_param = $this->_ext_class->get_duration_size( $param );
		if ( is_array( $extra_param ) ) {
			$this->set_msg( 'get duration' );
			$row['item_duration'] = $extra_param['duration'];
			$row['item_width']    = $extra_param['width'];
			$row['item_height']   = $extra_param['height'];
		}

		return $row;
	}

	public function build_row_content( $row, $param ) {
		$content = $this->_ext_class->get_text_content( $param );
		if ( $content ) {
			$row['item_content'] = $content;
			$this->set_msg( 'get content' );
		}

		return $row;
	}
}
