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


class webphoto_admin_index extends webphoto_base_this {

	public $_checkconfig_class;
	public $_update_check_class;
	public $_workdir_class;

	public $_DIR_TRUST_MOD_UPLOADS;
	public $_FILE_INSTALL;

	public $_MKDIR_MODE = 0777;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_update_check_class =& webphoto_admin_update_check::getInstance(
			$dirname, $trust_dirname );
		$this->_checkconfig_class  =& webphoto_admin_checkconfigs::getInstance(
			$dirname, $trust_dirname );
		$this->_workdir_class      =& webphoto_inc_workdir::getSingleton(
			$dirname, $trust_dirname );

		$this->_DIR_TRUST_MOD_UPLOADS
			= XOOPS_TRUST_PATH . '/modules/' . $trust_dirname . '/uploads/' . $dirname . '/';

		$this->_FILE_INSTALL = $this->_TRUST_DIR . '/uploads/install.txt';
	}


	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_index( $dirname, $trust_dirname );
		}

		return $instance;
	}


	public function main() {
		xoops_cp_header();

		if ( isset( $_SERVER["PATH_INFO"] ) && $_SERVER["PATH_INFO"] ) {
			restore_error_handler();
			error_reporting( E_ALL );
			echo _AM_WEBPHOTO_PATHINFO_SUCCESS . "<br>\n";
			echo 'PATH_INFO : ' . $_SERVER["PATH_INFO"];
			echo "<br><br>\n";
			echo '<input class="ui-btn formButton" value="' . _CLOSE . '" type="button" onclick="javascript:window.close();" />';
			xoops_cp_footer();
			exit();
		}

		echo $this->build_admin_menu();

		$check_config_title ='<h2><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
									<path d="M4 1h16a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1m0 8h16a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-4a1 1 0 0 1 1-1m0 8h16a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-4a1 1 0 0 1 1-1M9 5h1V3H9v2m0 8h1v-2H9v2m0 8h1v-2H9v2M5 3v2h2V3H5m0 8v2h2v-2H5m0 8v2h2v-2H5z" fill="currentColor"/>
									</svg>';
		$check_config_title .= _AM_WEBPHOTO_H4_ENVIRONMENT . "</h2>";
		echo $check_config_title;
		//echo $this->build_admin_title( 'CHECKCONFIGS' );

		$this->_print_check();
		$this->_checkconfig_class->check();
		$this->_print_file_check();
		$this->_print_timeline();
		$this->_print_command_url();

		echo $this->build_admin_footer();
		xoops_cp_footer();
	}


// check permission

	public function _print_check() {

		echo $this->_make_dir( $this->_UPLOADS_DIR );
		echo $this->_make_dir( $this->_PHOTOS_DIR );
		echo $this->_make_dir( $this->_THUMBS_DIR );
		echo $this->_make_dir( $this->_LARGES_DIR );
		echo $this->_make_dir( $this->_MIDDLES_DIR );
		echo $this->_make_dir( $this->_SMALLS_DIR );
		echo $this->_make_dir( $this->_FLASHS_DIR );
		echo $this->_make_dir( $this->_DOCOMOS_DIR );
		echo $this->_make_dir( $this->_PDFS_DIR );
		echo $this->_make_dir( $this->_SWFS_DIR );
		echo $this->_make_dir( $this->_JPEGS_DIR );
		echo $this->_make_dir( $this->_MP3S_DIR );
		echo $this->_make_dir( $this->_WAVS_DIR );
		echo $this->_make_dir( $this->_CATS_DIR );
		echo $this->_make_dir( $this->_GICONS_DIR );
		echo $this->_make_dir( $this->_GSHADOWS_DIR );
		echo $this->_make_dir( $this->_QRS_DIR );
		echo $this->_make_dir( $this->_PLAYLISTS_DIR );
		echo $this->_make_dir( $this->_LOGOS_DIR );
		echo $this->_make_dir( $this->_WORK_DIR );
		echo $this->_make_dir( $this->_TMP_DIR );
		echo $this->_make_dir( $this->_MAIL_DIR );
		echo $this->_make_dir( $this->_LOG_DIR );
		echo $this->_make_dir( $this->_MEDIAS_DIR, false );

		$this->_workdir_file();

		if ( ! $this->_check_module_version() ) {
			$msg = '<a href="' . $this->_get_module_update_url() . '">';
			$msg .= _AM_WEBPHOTO_MUST_UPDATE;
			$msg .= '</a>';
			echo $this->build_error_msg( $msg, '', false );
		}

		echo $this->_update_check_class->build_msg( '' );

		if ( $this->_cat_handler->get_count_all() == 0 ) {
			$msg = '<a href="' . $this->_MODULE_URL . '/admin/index.php?fct=catmanager">';
			$msg .= _WEBPHOTO_ERR_MUSTADDCATFIRST;
			$msg .= '</a><br>';
			$msg .= _WEBPHOTO_OR;
			$msg .= '<br>';
			$msg .= '<a href="' . $this->_MODULE_URL . '/admin/index.php?fct=import_myalbum">';
			$msg .= _AM_WEBPHOTO_PLEASE_IMPORT_MYALBUM;
			$msg .= '</a><br>';
			echo $this->build_error_msg( $msg, '', false );
		}

// Waiting Admission
		echo $this->build_check_waiting();

		echo "<br>\n";
	}

	public function _check_module_version() {
		$ver1 = $this->_xoops_class->get_my_module_version();
		$ver2 = $this->_xoops_class->get_module_info_version_by_dirname( $this->_DIRNAME, true );

		if ( (int) $ver1 >= (int) $ver2 ) {
			return true;
		}

		return false;
	}

	public function _get_module_update_url() {
		if ( defined( 'XOOPS_CUBE_LEGACY' ) ) {
			$str = XOOPS_URL . "/modules/legacy/admin/index.php?action=ModuleUpdate&amp;dirname=" . $this->_DIRNAME;
		} else {
			$str = XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin&amp;op=update&amp;module=" . $this->_DIRNAME;
		}

		return $str;
	}

	public function _make_dir( $dir, $check_writable = true ) {
		$not_dir = true;
		if ( is_dir( $dir ) ) {
			$not_dir = false;
			if ( $check_writable && is_writable( $dir ) ) {
				return '';
			} elseif ( ! $check_writable ) {
				return '';
			}
		}

		if ( ini_get( 'safe_mode' ) ) {
			return $this->highlight( 'At first create & chmod 777 "' . $dir . '" by ftp or shell.' ) . "<br>\n";
		}

		if ( $not_dir ) {
			$ret = mkdir( $dir, $this->_MKDIR_MODE );
			if ( ! $ret ) {
				return $this->highlight( 'can not create directory : <b>' . $dir . '</b>' ) . "<br>\n";
			}
		}

		$ret = chmod( $dir, $this->_MKDIR_MODE );
		if ( ! $ret ) {
			return $this->highlight( 'can not change mode directory : <b>' . $dir . '</b> ', $this->_MKDIR_MODE ) . "<br>\n";}

		return 'create directory: <b>' . $dir . '</b>' . "<br>\n";
	}

	function _workdir_file() {
		$match = $this->_workdir_class->read_workdir( $this->_WORK_DIR );
		switch ( $match ) {
// complete match
			case 2 :
				return true;

// unmatch
			case 1 :
				$msg = 'ERROR same work dir';
				echo $this->build_error_msg( $msg, '', false );

				return false;

// not yet
			case 0:
			default :
				break;
		}

		$byte = $this->_workdir_class->write_workdir( $this->_WORK_DIR );
		$file = $this->_workdir_class->get_filename();
		if ( $byte > 0 ) {
			echo "add work dir in workdir.txt <br>\n";
		} else {
			echo $this->highlight( 'can not write : <b>' . $file . '</b>' ) . "<br>\n";
		}

		return true;
	}

	public function _print_file_check() {
		$url = $this->_MODULE_URL . '/admin/index.php?fct=check_file';

		echo '<h4><img class="svg tools" src="' . XOOPS_URL .'/images/icons/tools.svg"> ' . _AM_WEBPHOTO_FILE_CHECK . "</h4>\n";
		echo '<div class="tips">'._AM_WEBPHOTO_FILE_CHECK_DSC . "<br>\n";
		echo '<a href="' . $url . '">';
		echo _AM_WEBPHOTO_FILE_CHECK;
		echo "</a></div>\n";
	}

	public function _print_timeline() {
		$timeline_dirname = $this->get_config_by_name( 'timeline_dirname' );
		$TIMELINE_DIR     = XOOPS_TRUST_PATH . '/modules/' . $timeline_dirname;
		$version_file     = $TIMELINE_DIR . '/include/version.php';
		$isactive         = $this->_xoops_class->get_module_value_by_dirname( $timeline_dirname, 'isactive' );

		echo '<h4><img class="svg timeline" src="' . XOOPS_URL .'/images/icons/timeline.svg"> ' . _AM_WEBPHOTO_TIMELINE_MODULE . "</h4>\n";
		echo 'dirname : ' . $timeline_dirname . "<br>\n";

// installed
		if ( $isactive ) {

// version file
			if ( file_exists( $version_file ) ) {
				include_once $version_file;
				echo 'version : ' . _C_TIMELINE_VERSION . "<br>\n";

// check version
				if ( _C_TIMELINE_VERSION < _C_WEBPHOTO_TIMELINE_VERSION ) {
					$msg = 'require version ' . _C_WEBPHOTO_TIMELINE_VERSION . ' or later';
					echo $this->highlight( $msg ) . "<br>\n";
				}

// not find version file
			} else {
				echo $this->highlight( 'not find version file' ) . "<br>\n";
			}

// not install
		} else {
			echo $this->highlight( _AM_WEBPHOTO_MODULE_NOT_INSTALL ) . "<br>\n";
		}

		echo "<br>\n";
	}

	public function _print_command_url() {
		$pass = $this->get_config_by_name( 'bin_pass' );
		$url  = $this->_MODULE_URL . '/bin/retrieve.php?pass=' . $pass;

		echo '<h4>' . _AM_WEBPHOTO_TITLE_BIN . "</h4>\n";
		echo '<a href="' . $url . '">';
		echo _AM_WEBPHOTO_TEST_BIN . ': bin/retrieve.php';
		echo "</a><br><br>\n";
	}

}
