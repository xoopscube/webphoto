<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * http://jp.php.net/manual/ja/function.readfile.php
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_lib_readfile {


	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_readfile();
		}

		return $instance;
	}


// main

	public function readfile_view( $file, $mime ) {
		$this->zlib_off();
		$this->http_output_pass();
		$this->header_view( $file, $mime );
		ob_clean();
		flush();
		readfile( $file );
	}

	public function readfile_down( $file, $mime, $name, $is_rfc2231 = false ) {
		$this->zlib_off();
		$this->http_output_pass();
		$this->header_down( $file, $mime, $name, $is_rfc2231 );
		ob_clean();
		flush();
		readfile( $file );
	}

	public function readfile_xml( $file ) {
		$this->zlib_off();
		$this->http_output_pass();
		$this->header_xml();
		ob_clean();
		flush();
		readfile( $file );
	}


// function

	function header_view( $file, $mime ) {
		$size = filesize( $file );
		header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
		header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		header( 'Cache-Control: no-store, no-cache, max-age=1, s-maxage=1, must-revalidate, post-check=0, pre-check=0' );
		header( 'Content-Type: ' . $mime );
		header( 'Content-Length: ' . $size );
	}

	function header_down( $file, $mime, $name, $is_rfc2231 = false ) {
		if ( $is_rfc2231 ) {
			;
			$dis = 'Content-Disposition: attachment; filename*=';
		} else {
			$dis = 'Content-Disposition: attachment; filename=';
		}

		$size = filesize( $file );
		header( 'Pragma: public' );
		header( 'Cache-Control: must-revaitem_idate, post-check=0, pre-check=0' );
		header( 'Content-Description: File Transfer' );
		header( 'Content-Type: ' . $mime );
		header( 'Content-Length: ' . $size );
		header( $dis . $name );
	}

	function header_down_rfc2131( $file, $mime, $name ) {
		$size = filesize( $file );
		header( 'Pragma: public' );
		header( 'Cache-Control: must-revaitem_idate, post-check=0, pre-check=0' );
		header( 'Content-Description: File Transfer' );
		header( 'Content-Type: ' . $mime );
		header( 'Content-Length: ' . $size );
		header( 'Content-Disposition: attachment; filename*=' . $name );
	}

	function header_xml() {
		header( 'Content-Type:text/xml; charset=utf-8' );
	}

	function zlib_off() {
		if ( ini_get( 'zlib.output_compression' ) ) {
			ini_set( 'zlib.output_compression', 'Off' );
		}
	}


// multibyte

	function http_output_pass() {
		return $this->http_output( 'pass' );
	}

	function http_output( $encoding = null ) {
		if ( function_exists( 'mb_http_output' ) ) {
			if ( $encoding ) {
				return mb_http_output( $encoding );
			} else {
				return mb_http_output();
			}
		}

		return false;
	}

}
