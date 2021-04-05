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


class webphoto_ext_pdf extends webphoto_ext_base {
	public $_pdf_class;

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_pdf_class
			=& webphoto_pdf::getInstance( $dirname, $trust_dirname );

		$this->set_debug_by_name( 'PDF' );
	}

// check ext
	public function is_ext( $ext ) {
		return $this->match_ext_kind( $ext, _C_WEBPHOTO_MIME_KIND_OFFICE_PDF );
	}

// create jpeg
	public function create_jpeg( $param ) {
		$src_file  = $param['src_file'];
		$jpeg_file = $param['jpeg_file'];

		return $this->_pdf_class->create_jpeg( $src_file, $jpeg_file );
	}

// text content
	public function get_text_content( $param ) {
		$file = isset( $param['file_cont'] ) ? $param['file_cont'] : null;

		return $this->_pdf_class->get_text_content( $file );
	}

}
