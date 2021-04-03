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


class webphoto_edit_pdf_create extends webphoto_edit_base_create {
	public $_ext_class;

	public $_param_ext = 'pdf';
	public $_param_dir = 'pdfs';
	var $_param_mime = 'application/pdf';
	public $_param_medium = '';
	public $_param_kind = _C_WEBPHOTO_FILE_KIND_PDF;
	public $_msg_created = 'create pdf';
	public $_msg_failed = 'fail to create pdf';


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_ext_class =& webphoto_ext::getInstance( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_pdf_create( $dirname, $trust_dirname );
		}

		return $instance;
	}


// create pdf

	public function create_param( $param ) {
		$this->clear_msg_array();

		$item_id  = $param['item_id'];
		$src_file = $param['src_file'];
		$src_ext  = $param['src_ext'];

// return input file is pdf 
		if ( $this->is_pdf_ext( $src_ext ) ) {
			return null;
		}

		$pdf_param = $this->create_pdf( $item_id, $src_file, $src_ext );
		if ( ! is_array( $pdf_param ) ) {
			return null;
		}

		return $pdf_param;
	}

	public function create_pdf( $item_id, $src_file, $src_ext ) {
		$name_param = $this->build_name_param( $item_id );
		$file       = $name_param['file'];

		$param = array(
			'src_file' => $src_file,
			'src_ext'  => $src_ext,
			'pdf_file' => $file,
		);

		$ret = $this->_ext_class->execute( 'pdf', $param );

		return $this->build_result( $ret, $name_param );
	}

}
