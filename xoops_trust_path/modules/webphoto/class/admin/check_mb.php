<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief $MY_DIRNAME WEBPHOTO_TRUST_PATH are set by calle
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_admin_check_mb extends webphoto_base_this {
	public $_multibyte_class;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_multibyte_class =& webphoto_lib_multibyte::getInstance();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_check_mb( $dirname, $trust_dirname );
		}

		return $instance;
	}


	public function main() {
		restore_error_handler();
		error_reporting( E_ALL );

		$charset = $this->_post_class->get_get_text( 'charset', _CHARSET );

		$this->http_output( 'pass' );
		header( 'Content-Type:text/html; charset=' . $charset );

		$title = 'Check Multibyte';

		$text = $this->build_html_head( $title, $charset );
		$text .= $this->build_html_body_begin();
		$text .= 'charset : ' . $charset . "<br><br>\n";

		if ( $this->mb_exists() ) {
			$text .= "<b>mb_convert_encoding</b> <br>\n";
			$text .= $this->mb_conv( _AM_WEBPHOTO_MULTIBYTE_SUCCESS, $charset );
			$text .= "<br><br>\n";
		} else {
			$text .= "<b>mb_convert_encoding</b> not exist <br><br>\n";
		}

		if ( $this->i_exists() ) {
			$text .= "<b>iconv</b> <br>\n";
			$text .= $this->i_conv( _AM_WEBPHOTO_MULTIBYTE_SUCCESS, $charset );
			$text .= "<br><br>\n";
		} else {
			$text .= "<b>iconv</b> not exist <br><br>\n";
		}

		$text .= '<input class="formButton" value="CLOSE" type="button" onclick="javascript:window.close();" />';
		$text .= $this->build_html_body_end();

		echo $text;
	}


// multibyte

	public function http_output( $encoding ) {
		return $this->_multibyte_class->m_mb_http_output( $encoding );
	}

	public function conv( $str, $charset ) {
		return $this->_multibyte_class->convert_encoding( $str, $charset, _CHARSET );
	}

	public function mb_exists() {
		if ( function_exists( 'mb_convert_encoding' ) ) {
			return true;
		}

		return false;
	}

	public function mb_conv( $str, $to ) {
		if ( $to == _CHARSET ) {
			return $str;
		}

		return mb_convert_encoding( $str, $to, _CHARSET );
	}

	public function i_exists() {
		if ( function_exists( 'iconv' ) ) {
			return true;
		}

		return false;
	}

	public function i_conv( $str, $to, $extra = '//IGNORE' ) {
		if ( $to == _CHARSET ) {
			return $str;
		}

		return iconv( _CHARSET, $to . $extra, $str );
	}
}
