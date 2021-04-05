<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @deprecated UPDATE PLUGIN / API / JSON
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_ext_ppt extends webphoto_ext_base {
	public $_pdf_class;
	public $_jod_class;

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_pdf_class
			=& webphoto_pdf::getInstance( $dirname, $trust_dirname );
		$this->_jod_class
			=& webphoto_jodconverter::getInstance( $dirname, $trust_dirname );

		$this->set_debug_by_name( 'PPT' );
	}

// check ext
	public function is_ext( $ext ) {
		return $this->match_ext_kind( $ext, _C_WEBPHOTO_MIME_KIND_OFFICE_PPT );
	}

// create pdf
	public function create_pdf( $param ) {
		$src_file = $param['src_file'];
		$pdf_file = $param['pdf_file'];

		return $this->_jod_class->create_pdf( $src_file, $pdf_file );
	}

// create swf
	public function create_swf( $param ) {
		$src_file = $param['src_file'];
		$swf_file = $param['swf_file'];

		return $this->_jod_class->create_swf( $src_file, $swf_file );
	}

// create jpeg
	public function create_jpeg( $param ) {
		$pdf_file  = $param['pdf_file'];
		$jpeg_file = $param['jpeg_file'];

		return $this->_pdf_class->create_jpeg( $pdf_file, $jpeg_file );
	}

// text content
	public function get_text_content( $param ) {
		$file_cont = isset( $param['file_cont'] ) ? $param['file_cont'] : null;

		return $this->_jod_class->get_text_content_for_xls_ppt( $file_cont );
	}

}

