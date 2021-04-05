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


class webphoto_ext_image_convert extends webphoto_ext_base {
	public $_imagemagick_class;

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_imagemagick_class =& webphoto_imagemagick::getInstance( $dirname, $trust_dirname );

		$this->set_debug_by_name( 'IMAGE_CONVERT' );
	}

// check ext
	public function is_ext( $ext ) {
		return $this->is_image_convert_ext( $ext );
	}

	public function is_image_convert_ext( $ext ) {
		return $this->match_ext_kind( $ext, _C_WEBPHOTO_MIME_KIND_IMAGE_CONVERT );
	}

// create jpeg
	public function create_jpeg( $param ) {
		$src_file  = $param['src_file'];
		$jpeg_file = $param['jpeg_file'];

		return $this->_imagemagick_class->create_jpeg( $src_file, $jpeg_file );
	}
}
