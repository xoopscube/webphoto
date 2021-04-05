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


class webphoto_ext_html extends webphoto_ext_base {
	public $_HTML_EXTS = array( 'html', 'htm' );


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
	}

// check ext
	public function is_ext( $ext ) {
		return $this->is_html_ext( $ext );
	}

	public function is_html_ext( $ext ) {
		return $this->is_ext_in_array( $ext, $this->_HTML_EXTS );
	}

// create image

// text content
	public function get_text_content( $param ) {
		$file_cont = isset( $param['file_cont'] ) ? $param['file_cont'] : null;

		if ( ! is_file( $file_cont ) ) {
			return false;
		}

		$text = file_get_contents( $file_cont );

		$encoding = $this->find_html_encoding( $text, true );
		if ( $encoding ) {
			$text = $this->_multibyte_class->convert_encoding( $text, _CHARSET, $encoding );
		}

		$text = $this->_multibyte_class->build_plane_text( $text );

		return $text;
	}

// find HTML encoding
// < meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
	public function find_html_encoding( $text, $flag_auto = false ) {
		$encoding = null;
		if ( preg_match( '/<(meta.*Content-Type.*)>/is', $text, $match1 ) ) {
			if ( preg_match( '/charset=([a-zA-Z0-9\-\_]+)/is', $match1[1], $match2 ) ) {
				$encoding = trim( $match2[1] );
			}
		}
		if ( empty( $encoding ) && $flag_auto ) {
			$encoding = $this->_multibyte_class->m_mb_detect_encoding( $text );
		}

		return $encoding;
	}
}
