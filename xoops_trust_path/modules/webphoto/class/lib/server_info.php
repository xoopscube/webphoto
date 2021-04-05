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


class webphoto_lib_server_info {

	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_server_info();
		}

		return $instance;
	}

// server info

	public function build_server() {
		$db              = XoopsDatabaseFactory::getDatabaseConnection();
		$get_server_info = ( is_object( $db->conn ) && get_class( $db->conn ) === 'mysqli' ) ? 'mysqli_get_server_info' : 'mysql_get_server_info';
		$str             = "OS: " . php_uname() . "<br>\n";
		$str             .= "PHP: " . PHP_VERSION . "<br>\n";
		$str             .= "MySQL: " . $get_server_info( $db->conn ) . "<br>\n";
		$str             .= "XOOPS: " . XOOPS_VERSION . "<br>\n";

		return $str;
	}

	public function build_php_secure( $dsc ) {
		$str = $this->build_ini_on_off( 'register_globals' ) . $dsc . "<br>\n";
		$str .= $this->build_ini_on_off( 'allow_url_fopen' ) . $dsc . "<br>\n";

		return $str;
	}

	public function build_php_etc() {
		$str = "error_reporting: " . error_reporting() . "<br>\n";
		$str .= $this->build_ini_int( 'display_errors' ) . "<br>\n";
		$str .= $this->build_ini_int( 'memory_limit' ) . "<br>\n";
		$str .= "magic_quotes_gpc: " . (int) get_magic_quotes_gpc() . "<br>\n";
		$str .= $this->build_ini_int( 'safe_mode' ) . "<br>\n";
		$str .= $this->build_ini_val( 'open_basedir' ) . "<br>\n";

		return $str;
	}

	public function build_php_exif() {
		$str = "exif extention: " . $this->build_func_load( 'exif_read_data' ) . "<br>\n";

		return $str;
	}

	public function build_php_upload( $dsc = null ) {
		$str = $this->build_ini_on_off( 'file_uploads' ) . $dsc . "<br>\n";
		$str .= $this->build_ini_val( 'upload_max_filesize' ) . "<br>\n";
		$str .= $this->build_ini_val( 'post_max_size' ) . "<br>\n";
		$str .= $this->build_php_upload_tmp_dir();

		return $str;
	}

	public function build_php_upload_tmp_dir() {
		$upload_tmp_dir = ini_get( 'upload_tmp_dir' );

		$str = "upload_tmp_dir : " . $upload_tmp_dir . "<br>\n";

		$tmp_dirs = explode( PATH_SEPARATOR, $upload_tmp_dir );
		foreach ( $tmp_dirs as $dir ) {
			if ( $dir != "" && ( ! is_writable( $dir ) || ! is_readable( $dir ) ) ) {
				$msg = "Error: upload_tmp_dir ($dir) is not writable nor readable .";
				$str .= $this->font_red( $msg ) . "<br>\n";
			}
		}

		return $str;
	}

	public function build_ini_int( $key ) {
		$str = $key . ': ' . (int) ini_get( $key );

		return $str;
	}

	function build_ini_val( $key ) {
		$str = $key . ': ' . ini_get( $key );

		return $str;
	}

	public function build_ini_on_off( $key ) {
		$str = $key . ': ' . $this->build_on_off( ini_get( $key ) );

		return $str;
	}

	public function build_func_load( $func ) {
		if ( function_exists( $func ) ) {
			$str = 'loaded';
		} else {
			$str = $this->font_red( 'not loaded' );
		}

		return $str;
	}


// utility

	public function build_on_off( $val, $flag_red = false ) {
		$str = '';
		if ( $val ) {
			$str = $this->font_green( 'on' );
		} elseif ( $flag_red ) {
			$str = $this->font_red( 'off' );
		} else {
			$str = $this->font_green( 'off' );
		}

		return $str;
	}

	public function font_red( $str ) {
		$str = '<span style="color:#FF0000"><b>' . $str . '</b></span>';

		return $str;
	}

	public function font_green( $str ) {
		$str = '<span style="color:#00FF00"><b>' . $str . '</b></span>';

		return $str;
	}

}
