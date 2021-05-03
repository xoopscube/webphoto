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


class webphoto_admin_checkconfigs extends webphoto_base_this {
	public $_server_class;
	public $_multibyte_class;

	public $_ini_safe_mode = 0;

	public $_MKDIR_MODE = 0777;
	public $_CHAR_SLASH = '/';
	public $_HEX_SLASH = 0x2f;    // 0x2f = slash '/'


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_server_class    =& webphoto_lib_server_info::getInstance();
		$this->_multibyte_class =& webphoto_lib_multibyte::getInstance();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_checkconfigs( $dirname, $trust_dirname );
		}

		return $instance;
	}


	public function check() {
		$this->_check_server();
		echo "<br>\n";
		$this->_check_mulitibyte_link();
		echo "<br>\n";
		$this->_check_pathinfo_link();
		echo "<br>\n";
		$this->_check_program();
		echo "<br>\n";
		$this->_check_directory();
		echo "<br>\n";
	}

	public function _check_server() {
		$on  = ' ( ' . _AM_WEBPHOTO_NEEDON . ' ) ';
		$off = ' ( ' . _AM_WEBPHOTO_RECOMMEND_OFF . ' ) ';

		echo "<details><summary>" . _AM_WEBPHOTO_H4_ENVIRONMENT . "</summary>\n";
		echo $this->_server_class->build_server();
		echo $this->_module_version();
		echo "</details>";


		echo '<details><summary>' . _AM_WEBPHOTO_MYSQL_CONFIG . "</summary>\n";
		$handler = new webphoto_lib_handler();
		echo $handler->build_config_character();
		echo "</details>";

		echo "<details><summary>" . _AM_WEBPHOTO_PHPDIRECTIVE . "</summary>\n";
		echo $this->_server_class->build_php_secure( $off );
		echo $this->_server_class->build_php_upload( $on );
		echo $this->_server_class->build_php_etc();
		echo $this->_server_class->build_php_exif();
		echo "</details>";

		echo '<details><summary>' . _AM_WEBPHOTO_MULTIBYTE_CONFIG . "</summary>\n";
		echo $this->_multibyte_class->build_config_priority();
		echo "<br>\n";
		echo $this->_multibyte_class->build_config_mbstring();
		echo "<br>\n";
		echo $this->_multibyte_class->build_config_iconv();
		echo "</details>";
	}

	public function _module_version() {
		$str = "Webphoto: ";
		$str .= $this->_xoops_class->get_my_module_version( true );
		$str .= "<br>\n";

		return $str;
	}

	public function _check_mulitibyte_link() {
		echo '<br>111Multibyte<br><a href="' . $this->_MODULE_URL . '/admin/index.php?fct=check_mb&amp;charset=UTF-8" target="_blank">';
		echo _AM_WEBPHOTO_MULTIBYTE_LINK;
		echo ' (UTF-8) </a><br>' . "\n";
		if ( $this->_is_japanese ) {
			echo '<a href="' . $this->_MODULE_URL . '/admin/index.php?fct=check_mb&amp;charset=Shift_JIS" target="_blank">';
			echo _AM_WEBPHOTO_MULTIBYTE_LINK;
			echo ' (Shift_JIS) </a><br>' . "\n";
		}
		echo " &nbsp; " . _AM_WEBPHOTO_MULTIBYTE_DSC . "<br>\n";
	}

	public function _check_pathinfo_link() {
		echo '<br>Path-Info-111<br><a href="' . $this->_MODULE_URL . '/admin/index.php/abc/" target="_blank">';
		echo _AM_WEBPHOTO_PATHINFO_LINK;
		echo '</a><br>' . "\n";
		echo " &nbsp; " . _AM_WEBPHOTO_PATHINFO_DSC . "<br>\n";
	}

	public function _check_program() {
		$gd_class          =& webphoto_lib_gd::getInstance();
		$imagemagick_class =& webphoto_lib_imagemagick::getInstance();
		$netpbm_class      =& webphoto_lib_netpbm::getInstance();
		$ffmpeg_class      =& webphoto_lib_ffmpeg::getInstance();
		$lame_class        =& webphoto_lib_lame::getInstance();
		$timidity_class    =& webphoto_lib_timidity::getInstance();
		$xpdf_class        =& webphoto_lib_xpdf::getInstance();
		$jodconverter_class
		                   =& webphoto_jodconverter::getInstance( $this->_DIRNAME, $this->_TRUST_DIRNAME );

		$cfg_imagingpipe  = $this->get_config_by_name( 'imagingpipe' );
		$cfg_use_ffmpeg   = $this->get_config_by_name( 'use_ffmpeg' );
		$cfg_use_lame     = $this->get_config_by_name( 'use_lame' );
		$cfg_use_timidity = $this->get_config_by_name( 'use_timidity' );
		$cfg_use_xpdf     = $this->get_config_by_name( 'use_xpdf' );
		$cfg_imagickpath  = $this->_config_class->get_dir_by_name( 'imagickpath' );
		$cfg_netpbmpath   = $this->_config_class->get_dir_by_name( 'netpbmpath' );
		$cfg_ffmpegpath   = $this->_config_class->get_dir_by_name( 'ffmpegpath' );
		$cfg_lamepath     = $this->_config_class->get_dir_by_name( 'lamepath' );
		$cfg_timiditypath = $this->_config_class->get_dir_by_name( 'timiditypath' );
		$cfg_xpdfpath     = $this->_config_class->get_dir_by_name( 'xpdfpath' );

		echo '<h4><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path d="M12 19c0 .34.03.67.08 1H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1l2 4h3L8 4h2l2 4h3l-2-4h2l2 4h3l-2-4h4v8.68A6.995 6.995 0 0 0 12 19m11.8 1.4c.1 0 .1.1 0 .2l-1 1.7c-.1.1-.2.1-.3.1l-1.2-.4c-.3.2-.5.3-.8.5l-.2 1.3c0 .1-.1.2-.2.2h-2c-.1 0-.2-.1-.3-.2l-.2-1.3c-.3-.1-.6-.3-.8-.5l-1.2.5c-.1 0-.2 0-.3-.1l-1-1.7c-.1-.1 0-.2.1-.3l1.1-.8v-1l-1.1-.8c-.1-.1-.1-.2-.1-.3l1-1.7c.1-.1.2-.1.3-.1l1.2.5c.3-.2.5-.3.8-.5l.2-1.3c0-.1.1-.2.3-.2h2c.1 0 .2.1.2.2l.2 1.3c.3.1.6.3.9.5l1.2-.5c.1 0 .3 0 .3.1l1 1.7c.1.1 0 .2-.1.3l-1.1.8v1l1.1.8M20.5 19c0-.8-.7-1.5-1.5-1.5s-1.5.7-1.5 1.5s.7 1.5 1.5 1.5s1.5-.7 1.5-1.5z" fill="currentColor"/></svg>' . _AM_WEBPHOTO_H4_CONFIG . "</h4>\n";

		echo "<b>" . _AM_WEBPHOTO_PIPEFORIMAGES . " : </b><br><br>\n";

		echo "<b>GD</b><br>\n";
		[ $ret, $msg ] = $gd_class->version();
		$this->_print_ret_msg( $ret, $msg );
		echo "<br>\n";
		if ( $ret ) {
			echo '<a href="' . $this->_MODULE_URL . '/admin/index.php?fct=checkgd2" target="_blank">';
			echo _AM_WEBPHOTO_LNK_CHECKGD2;
			echo '</a><br>' . "\n";
			echo " &nbsp; " . _AM_WEBPHOTO_CHECKGD2 . "<br>\n";
		}
		echo "<br>\n";

		$this->_check_qr_code();
		echo "<br>\n";

		if ( ( $cfg_imagingpipe == _C_WEBPHOTO_PIPEID_IMAGICK ) ||
		     $cfg_imagickpath ) {
			echo "<b>ImageMagick</b><br>\n";
			echo "Path: " . $cfg_imagickpath . "<br>\n";
			[ $ret, $msg ] = $imagemagick_class->version( $cfg_imagickpath );
			$this->_print_ret_msg( $ret, $msg );
			echo "<br>\n";
		}

		if ( ( $cfg_imagingpipe == _C_WEBPHOTO_PIPEID_NETPBM ) ||
		     $cfg_netpbmpath ) {
			echo "<b>NetPBM</b><br>\n";
			echo "Path: " . $cfg_netpbmpath . "<br>\n";
			$arr = $netpbm_class->version( $cfg_netpbmpath );
			if ( is_array( $arr ) ) {
				foreach ( $arr as $ret_msg ) {
					[ $ret, $msg ] = $ret_msg;
					$this->_print_ret_msg( $ret, $msg );
				}
			}
			echo "<br>\n";
		}

		if ( $cfg_use_ffmpeg || $cfg_ffmpegpath ) {
			echo "<b>FFmpeg</b><br>\n";
			echo "Path: $cfg_ffmpegpath <br>\n";
			[ $ret, $msg ] = $ffmpeg_class->version( $cfg_ffmpegpath );
			$this->_print_ret_msg( $ret, $msg );
			echo "<br>\n";

		} else {
			echo "<b>FFmpeg</b> : not use <br><br>\n";
		}

		if ( $cfg_use_lame || $cfg_lamepath ) {
			echo "<b>lame</b><br>\n";
			echo "Path: " . $cfg_lamepath . "<br>\n";
			[ $ret, $msg ] = $lame_class->version( $cfg_lamepath );
			$this->_print_ret_msg( $ret, $msg );
			echo "<br>\n";

		} else {
			echo "<b>lame</b> : not use <br><br>\n";
		}

		if ( $cfg_use_timidity || $cfg_timiditypath ) {
			echo "<b>timidity</b><br>\n";
			echo "Path: " . $cfg_timiditypath . "<br>\n";
			[ $ret, $msg ] = $timidity_class->version( $cfg_timiditypath );
			$this->_print_ret_msg( $ret, $msg );
			echo "<br>\n";

		} else {
			echo "<b>timidity</b> : not use <br><br>\n";
		}

		if ( $cfg_use_xpdf || $cfg_xpdfpath ) {
			echo "<b>xpdf</b><br>\n";
			echo "Path: " . $cfg_xpdfpath . "<br>\n";
			[ $ret, $msg ] = $xpdf_class->version( $cfg_xpdfpath );
			$this->_print_ret_msg( $ret, $msg );
			echo "<br>\n";

		} else {
			echo "<b>xpdf</b> : not use <br><br>\n";
		}

		if ( $jodconverter_class->use_jod() ) {
			echo "<b>jodconverter</b><br>\n";
			echo "Java Path: " . $jodconverter_class->java_path() . "<br>\n";
			[ $ret, $msg ] = $jodconverter_class->version();
			$this->_print_ret_msg( $ret, $msg );
			echo "<br>\n";

		} else {
			echo "<b>jodconverter</b> : not use <br><br>\n";
		}

	}

	public function _check_qr_code() {
		echo '<a href="' . $this->_MODULE_URL . '/admin/index.php?fct=check_qr" target="_blank">';
		echo _AM_WEBPHOTO_QR_CHECK_LINK;
		echo '</a><br>' . "\n";
		echo " &nbsp; " . _AM_WEBPHOTO_QR_CHECK_DSC . "<br>\n";

	}

	public function _check_directory() {
		$cfg_uploadspath = $this->get_config_by_name( 'uploadspath' );
		$cfg_workdir     = $this->get_config_by_name( 'workdir' );
		$cfg_file_dir    = $this->get_config_by_name( 'file_dir' );

// BUG: ths -> this
		$this->_ini_safe_mode = ini_get( "safe_mode" );

		echo "<b>Directory : </b><br><br>\n";

// uploads
		echo _AM_WEBPHOTO_DIRECTORYFOR_UPLOADS . ': ' . XOOPS_ROOT_PATH . $cfg_uploadspath . ' &nbsp; ';
		$this->_check_path( $cfg_uploadspath );

// tmp
		echo _AM_WEBPHOTO_DIRECTORYFOR_TMP . ': ' . $cfg_workdir . ' &nbsp; ';
		$this->_check_full_path( $cfg_workdir, true );

// file
		echo _AM_WEBPHOTO_DIRECTORYFOR_FILE . ': ' . $cfg_file_dir . ' &nbsp; ';
		if ( $cfg_file_dir ) {
			$this->_check_full_path( $cfg_file_dir, true );
		} else {
			$this->_print_green( 'not set' );
			echo "<br>\n";
		}
	}

	public function _check_path( $path ) {
		if ( ord( $path ) != $this->_HEX_SLASH ) {
			$this->_print_red( _AM_WEBPHOTO_ERR_FIRSTCHAR );

		} else {
			$this->_check_full_path( XOOPS_ROOT_PATH . $path );
		}
	}

	public function _check_full_path( $full_path, $flag_root_path = false ) {
		$ret_code = true;

		if ( substr( $full_path, - 1 ) == $this->_CHAR_SLASH ) {
			$this->_print_red( _AM_WEBPHOTO_ERR_LASTCHAR );
			$ret_code = false;

		} elseif ( ! is_dir( $full_path ) ) {
			if ( $this->_ini_safe_mode ) {
				$this->_print_red( _AM_WEBPHOTO_ERR_PERMISSION );
				$ret_code = false;

			} else {
				$rs = mkdir( $full_path, $this->_MKDIR_MODE );
				if ( $rs ) {
					$this->_print_green( 'ok' );
				} else {
					$this->_print_red( _AM_WEBPHOTO_ERR_NOTDIRECTORY );
					$ret_code = false;
				}
			}

		} elseif ( ! is_writable( $full_path ) || ! is_readable( $full_path ) ) {

			if ( $this->_ini_safe_mode ) {
				$this->_print_red( _AM_WEBPHOTO_ERR_READORWRITE );
				$ret_code = false;

			} else {
				$rs = chmod( $full_path, $this->_MKDIR_MODE );
				if ( $rs ) {
					$this->_print_green( 'ok' );
				} else {
					$this->_print_red( _AM_WEBPHOTO_ERR_READORWRITE );
					$ret_code = false;
				}
			}

		} elseif ( $flag_root_path ) {
			if ( strpos( $full_path, XOOPS_ROOT_PATH ) === 0 ) {
				echo "<br>\n";
				$this->_print_red( _AM_WEBPHOTO_WARN_GEUST_CAN_READ );
				echo _AM_WEBPHOTO_WARN_RECOMMEND_PATH . "<br>\n";
			} else {
				$this->_print_green( 'ok' );
			}

		} else {
			$this->_print_green( 'ok' );
		}

		echo "<br>\n";

		return $ret_code;
	}

	public function _print_ret_msg( $ret, $msg ) {
		if ( ! $ret ) {
			$msg = $this->_font_red( $msg );
		}
		echo $msg;
		echo "<br>\n";
	}

	public function _print_on_off( $val, $flag_red = false ) {
		echo $this->_server_class->build_on_off( $val, $flag_red ) . "<br>\n";
	}

	public function _print_red( $str ) {
		echo $this->_font_red( $str ) . "<br>\n";
	}

	public function _print_green( $str ) {
		echo $this->_server_class->font_green( $str ) . "<br>\n";
	}

	public function _font_red( $str ) {
		return $this->_server_class->font_red( $str );
	}
}
