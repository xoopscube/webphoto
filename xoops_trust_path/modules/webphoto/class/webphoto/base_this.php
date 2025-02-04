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


class webphoto_base_this extends webphoto_base_ini {

	public $_config_class;
	public $_item_handler;
	public $_file_handler;
	public $_cat_handler;
	public $_post_class;
	public $_perm_class;
	public $_uri_class;
	public $_preload_class;
	public $_kind_class;
	public $_multibyte_class;
	public $_mysql_utility_class;

	public $_cfg_uploads_path;
	public $_cfg_nameoruname;

	public $_usereal = false;
	public $_is_japanese = false;

	public $_flag_force_db = false;

	public $_UPLOADS_PATH;
	public $_MEDIAS_PATH;
	public $_WORK_DIR;
	public $_FILE_DIR;
	public $_UPLOADS_DIR;
	public $_PHOTOS_PATH;
	public $_PHOTOS_DIR;
	public $_PHOTOS_URL;
	public $_THUMBS_PATH;
	public $_THUMBS_DIR;
	public $_THUMBS_URL;
	public $_LARGES_PATH;
	public $_LARGES_DIR;
	public $_LARGES_URL;
	public $_MIDDLES_PATH;
	public $_MIDDLES_DIR;
	public $_MIDDLES_URL;
	public $_SMALLS_PATH;
	public $_SMALLS_DIR;
	public $_SMALLS_URL;
	public $_FLASHS_PATH;
	public $_FLASHS_DIR;
	public $_FLASHS_URL;
	public $_DOCOMOS_PATH;
	public $_DOCOMOS_DIR;
	public $_DOCOMOS_URL;
	public $_PDFS_PATH;
	public $_PDFS_DIR;
	public $_PDFS_URL;
	public $_SWFS_PATH;
	public $_SWFS_DIR;
	public $_SWFS_URL;
	public $_JPEGS_PATH;
	public $_JPEGS_DIR;
	public $_JPEGS_URL;
	public $_MP3S_PATH;
	public $_MP3S_DIR;
	public $_MP3S_URL;
	public $_WAVS_PATH;
	public $_WAVS_DIR;
	public $_WAVS_URL;
	public $_CATS_PATH;
	public $_CATS_DIR;
	public $_CATS_URL;
	public $_GICONS_PATH;
	public $_GICONS_DIR;
	public $_GICONS_URL;
	public $_GSHADOWS_PATH;
	public $_GSHADOWS_DIR;
	public $_GSHADOWS_URL;
	public $_QRS_DIR;
	public $_QRS_URL;
	public $_PLAYLISTS_DIR;
	public $_PLAYLISTS_URL;
	public $_LOGOS_DIR;
	public $_MEDIAS_DIR;
	public $_MAIL_DIR;
	public $_TMP_DIR;
	public $_LOG_DIR;
	public $_ICONS_URL;
	public $_ROOT_EXTS_DIR;
	public $_ROOT_EXTS_URL;

	public $_EXT_PNG = 'png';
	public $_ICON_NAME_DEFAULT = 'default.png';

	public $_C_YES = 1;

	public $_PHOTO_LIST_LIMIT = 1;
	public $_PHOTO_LIST_UPDATE_ORDER = 'item_time_update DESC, item_id DESC';


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_item_handler =& webphoto_item_handler::getInstance( $dirname, $trust_dirname );
		$this->_cat_handler  =& webphoto_cat_handler::getInstance( $dirname, $trust_dirname );
		$this->_file_handler =& webphoto_file_handler::getInstance( $dirname, $trust_dirname );
		$this->_perm_class   =& webphoto_permission::getInstance( $dirname, $trust_dirname );

		$this->_multibyte_class     =& webphoto_multibyte::getInstance();
		$this->_mysql_utility_class =& webphoto_lib_mysql_utility::getInstance();

		$this->_config_class =& webphoto_config::getInstance( $dirname );
		$this->_post_class   =& webphoto_lib_post::getInstance();
		$this->_uri_class    =& webphoto_uri::getInstance( $dirname );
		$this->_kind_class   =& webphoto_kind::getInstance();

		$this->_UPLOADS_PATH    = $this->_config_class->get_uploads_path();
		$this->_MEDIAS_PATH     = $this->_config_class->get_medias_path();
		$this->_WORK_DIR        = $this->_config_class->get_by_name( 'workdir' );
		$this->_FILE_DIR        = $this->_config_class->get_by_name( 'file_dir' );
		$this->_cfg_nameoruname = $this->_config_class->get_by_name( 'nameoruname' );

		$this->_PHOTOS_PATH   = $this->_UPLOADS_PATH . '/photos';
		$this->_THUMBS_PATH   = $this->_UPLOADS_PATH . '/thumbs';
		$this->_LARGES_PATH   = $this->_UPLOADS_PATH . '/larges';
		$this->_MIDDLES_PATH  = $this->_UPLOADS_PATH . '/middles';
		$this->_SMALLS_PATH   = $this->_UPLOADS_PATH . '/smalls';
		$this->_FLASHS_PATH   = $this->_UPLOADS_PATH . '/flashs';
		$this->_DOCOMOS_PATH  = $this->_UPLOADS_PATH . '/docomos';
		$this->_PDFS_PATH     = $this->_UPLOADS_PATH . '/pdfs';
		$this->_SWFS_PATH     = $this->_UPLOADS_PATH . '/swfs';
		$this->_JPEGS_PATH    = $this->_UPLOADS_PATH . '/jpegs';
		$this->_MP3S_PATH     = $this->_UPLOADS_PATH . '/mp3s';
		$this->_WAVS_PATH     = $this->_UPLOADS_PATH . '/wavs';
		$this->_CATS_PATH     = $this->_UPLOADS_PATH . '/categories';
		$this->_GICONS_PATH   = $this->_UPLOADS_PATH . '/gicons';
		$this->_GSHADOWS_PATH = $this->_UPLOADS_PATH . '/gshadows';
		$qrs_path             = $this->_UPLOADS_PATH . '/qrs';
		$playlists_path       = $this->_UPLOADS_PATH . '/playlists';
		$logos_path           = $this->_UPLOADS_PATH . '/logos';

		$this->_UPLOADS_DIR   = XOOPS_ROOT_PATH . $this->_UPLOADS_PATH;
		$this->_PHOTOS_DIR    = XOOPS_ROOT_PATH . $this->_PHOTOS_PATH;
		$this->_THUMBS_DIR    = XOOPS_ROOT_PATH . $this->_THUMBS_PATH;
		$this->_LARGES_DIR    = XOOPS_ROOT_PATH . $this->_LARGES_PATH;
		$this->_MIDDLES_DIR   = XOOPS_ROOT_PATH . $this->_MIDDLES_PATH;
		$this->_SMALLS_DIR    = XOOPS_ROOT_PATH . $this->_SMALLS_PATH;
		$this->_FLASHS_DIR    = XOOPS_ROOT_PATH . $this->_FLASHS_PATH;
		$this->_DOCOMOS_DIR   = XOOPS_ROOT_PATH . $this->_DOCOMOS_PATH;
		$this->_PDFS_DIR      = XOOPS_ROOT_PATH . $this->_PDFS_PATH;
		$this->_SWFS_DIR      = XOOPS_ROOT_PATH . $this->_SWFS_PATH;
		$this->_JPEGS_DIR     = XOOPS_ROOT_PATH . $this->_JPEGS_PATH;
		$this->_MP3S_DIR      = XOOPS_ROOT_PATH . $this->_MP3S_PATH;
		$this->_WAVS_DIR      = XOOPS_ROOT_PATH . $this->_WAVS_PATH;
		$this->_CATS_DIR      = XOOPS_ROOT_PATH . $this->_CATS_PATH;
		$this->_GICONS_DIR    = XOOPS_ROOT_PATH . $this->_GICONS_PATH;
		$this->_GSHADOWS_DIR  = XOOPS_ROOT_PATH . $this->_GSHADOWS_PATH;
		$this->_QRS_DIR       = XOOPS_ROOT_PATH . $qrs_path;
		$this->_PLAYLISTS_DIR = XOOPS_ROOT_PATH . $playlists_path;
		$this->_LOGOS_DIR     = XOOPS_ROOT_PATH . $logos_path;
		$this->_MEDIAS_DIR    = XOOPS_ROOT_PATH . $this->_MEDIAS_PATH;

		$this->_PHOTOS_URL    = XOOPS_URL . $this->_PHOTOS_PATH;
		$this->_THUMBS_URL    = XOOPS_URL . $this->_THUMBS_PATH;
		$this->_LARGES_URL    = XOOPS_URL . $this->_LARGES_PATH;
		$this->_MIDDLES_URL   = XOOPS_URL . $this->_MIDDLES_PATH;
		$this->_SMALLS_URL    = XOOPS_URL . $this->_SMALLS_PATH;
		$this->_FLASHS_URL    = XOOPS_URL . $this->_FLASHS_PATH;
		$this->_DOCOMOS_URL   = XOOPS_URL . $this->_DOCOMOS_PATH;
		$this->_PDFS_URL      = XOOPS_URL . $this->_PDFS_PATH;
		$this->_SWFS_URL      = XOOPS_URL . $this->_SWFS_PATH;
		$this->_JPEGS_URL     = XOOPS_URL . $this->_JPEGS_PATH;
		$this->_MP3S_URL      = XOOPS_URL . $this->_MP3S_PATH;
		$this->_WAVS_URL      = XOOPS_URL . $this->_WAVS_PATH;
		$this->_CATS_URL      = XOOPS_URL . $this->_CATS_PATH;
		$this->_GICONS_URL    = XOOPS_URL . $this->_GICONS_PATH;
		$this->_GSHADOWS_URL  = XOOPS_URL . $this->_GSHADOWS_PATH;
		$this->_QRS_URL       = XOOPS_URL . $qrs_path;
		$this->_PLAYLISTS_URL = XOOPS_URL . $playlists_path;

		$this->_TMP_DIR  = $this->_WORK_DIR . '/tmp';
		$this->_MAIL_DIR = $this->_WORK_DIR . '/mail';
		$this->_LOG_DIR  = $this->_WORK_DIR . '/log';

		$this->_ICONS_URL     = $this->_MODULE_URL . '/images/icons';
		$this->_ROOT_EXTS_URL = $this->_MODULE_URL . '/images/exts';
		$this->_ROOT_EXTS_DIR = $this->_MODULE_DIR . '/images/exts';

		$this->_usereal     = ( $this->_cfg_nameoruname == 'name' ) ? 1 : 0;
		$this->_is_japanese = $this->_xoops_class->is_japanese( _C_WEBPHOTO_JPAPANESE );
	}


// config class

	public function get_config_by_name( $name ) {
		return $this->_config_class->get_by_name( $name );
	}


// check waiting

	public function build_check_waiting() {
		$url = $this->_MODULE_URL . '/admin/index.php?fct=item_manager&amp;op=list_waiting';
		$str = '';

		$waiting = $this->_item_handler->get_count_waiting();
		if ( $waiting > 0 ) {
			$str = '<a href="' . $url . '" style="color:red;">';
			$str .= sprintf( _AM_WEBPHOTO_CAT_FMT_NEEDADMISSION, $waiting );
			$str .= "</a><br>\n";
		}

		return $str;
	}


// perms

	public function get_group_perms_str_by_post( $name ) {
		$arr = $this->_post_class->get_post( $name );

		return $this->_utility_class->convert_group_perms_array_to_str( $arr );
	}


// jpeg

	public function is_jpeg_not_cmyk( $file, $ext = null ) {
		if ( empty( $ext ) ) {
			$ext = $this->parse_ext( $file );
		}

		if ( $this->is_jpeg_ext( $ext ) &&
		     ! $this->is_image_cmyk( $file ) ) {
			return true;
		}

		return false;
	}


// kind class

	public function get_normal_exts() {
		return $this->_kind_class->get_image_exts();
	}

	public function is_normal_ext( $ext ) {
		return $this->_kind_class->is_image_ext( $ext );
	}

	public function is_image_ext( $ext ) {
		return $this->_kind_class->is_image_ext( $ext );
	}

	public function is_jpeg_ext( $ext ) {
		return $this->_kind_class->is_jpeg_ext( $ext );
	}

	public function is_swf_ext( $ext ) {
		return $this->_kind_class->is_swf_ext( $ext );
	}

	public function is_swfobject_ext( $ext ) {
		return $this->_kind_class->is_swfobject_ext( $ext );
	}

	public function is_mediaplayer_ext( $ext ) {
		return $this->_kind_class->is_mediaplayer_ext( $ext );
	}

	public function is_video_docomo_ext( $ext ) {
		return $this->_kind_class->is_video_docomo_ext( $ext );
	}

	public function is_flash_ext( $ext ) {
		return $this->_kind_class->is_flash_ext( $ext );
	}

	public function is_pdf_ext( $ext ) {
		return $this->_kind_class->is_pdf_ext( $ext );
	}

	public function is_mp3_ext( $ext ) {
		return $this->_kind_class->is_mp3_ext( $ext );
	}

	public function is_wav_ext( $ext ) {
		return $this->_kind_class->is_wav_ext( $ext );
	}

	public function is_video_audio_kind( $kind ) {
		return $this->_kind_class->is_video_audio_kind( $kind );
	}

	public function is_external_kind( $kind ) {
		return $this->_kind_class->is_external_kind( $kind );
	}

	public function is_playlist_kind( $kind ) {
		return $this->_kind_class->is_playlist_kind( $kind );
	}

	public function is_external_embed_playlist_kind( $kind ) {
		return $this->_kind_class->is_external_embed_playlist_kind( $kind );
	}

	public function is_undefined_kind( $kind ) {
		return $this->_kind_class->is_undefined_kind( $kind );
	}

	public function is_none_kind( $kind ) {
		return $this->_kind_class->is_none_kind( $kind );
	}

	public function is_general_kind( $kind ) {
		return $this->_kind_class->is_general_kind( $kind );
	}

	public function is_image_kind( $kind ) {
		return $this->_kind_class->is_image_kind( $kind );
	}

	public function is_video_kind( $kind ) {
		return $this->_kind_class->is_video_kind( $kind );
	}

	public function is_audio_kind( $kind ) {
		return $this->_kind_class->is_audio_kind( $kind );
	}

	public function is_embed_kind( $kind ) {
		return $this->_kind_class->is_embed_kind( $kind );
	}

	public function is_external_general_kind( $kind ) {
		return $this->_kind_class->is_external_general_kind( $kind );
	}

	public function is_external_image_kind( $kind ) {
		return $this->_kind_class->is_embed_kind( $kind );
	}

	public function is_playlist_feed_kind( $kind ) {
		return $this->_kind_class->is_playlist_feed_kind( $kind );
	}

	public function is_playlist_dir_kind( $kind ) {
		return $this->_kind_class->is_playlist_dir_kind( $kind );
	}


// uri class

	public function build_uri_photo_id_title( $id, $title, $target = '_blank', $flag_amp_sanitize = true, $flag_title_sanitize = true ) {
		return $this->_uri_class->build_photo_id_title(
			$id, $title, $target, $flag_amp_sanitize, $flag_title_sanitize );
	}

	public function build_uri_photo_id( $id, $target = '_blank', $flag_amp_sanitize = true ) {
		return $this->_uri_class->build_photo_id(
			$id, $target, $flag_amp_sanitize );
	}

	public function build_uri_photo_title( $id, $title, $target = '_blank', $flag_amp_sanitize = true, $flag_title_sanitize = true ) {
		return $this->_uri_class->build_photo_title(
			$id, $title, $target, $flag_amp_sanitize, $flag_title_sanitize );
	}

	public function build_uri_operate( $op ) {
		return $this->_uri_class->build_operate( $op );
	}

	public function build_uri_photo( $id, $flag_amp_sanitize = true ) {
		return $this->_uri_class->build_photo( $id, $flag_amp_sanitize );
	}

	public function build_uri_category( $id, $param = null ) {
		return $this->_uri_class->build_category( $id, $param );
	}

	public function build_uri_user( $id ) {
		return $this->_uri_class->build_user( $id );
	}

	public function rawurlencode_uri_encode_str( $str ) {
		return $this->_uri_class->rawurlencode_encode_str( $str );
	}

	public function decode_uri_str( $str ) {
		return $this->_uri_class->decode_str( $str );
	}


// item handler

	public function get_item_row_by_id( $item_id ) {
		return $this->_item_handler->get_row_by_id( $item_id );
	}

	public function build_show_icon_image( $item_row ) {
		return $this->_item_handler->build_show_item_image(
			$item_row, $this->_ROOT_EXTS_URL );
	}

	public function build_item_name_by_file_kind( $kind ) {
		return $this->_item_handler->build_name_fileid_by_kind( $kind );
	}


// file handler

	function build_file_full_path( $path ) {
		return $this->_file_handler->build_full_path( $path );
	}

	function build_file_full_url( $path ) {
		return $this->_file_handler->build_full_url( $path );
	}

	function get_file_full_by_kind( $item_row, $kind ) {
		$file_row = $this->get_file_extend_row_by_kind( $item_row, $kind );

		return $this->_file_handler->get_full_path_by_row( $file_row );
	}

	function get_file_row_by_kind( $item_row, $kind ) {
		$file_id = $this->build_value_fileid_by_kind( $item_row, $kind );
		if ( $file_id > 0 ) {
			return $this->_file_handler->get_extend_row_by_id( $file_id );
		}

		return null;
	}

	function get_file_extend_row_by_itemid_kind( $item_id, $kind ) {
		$item_row = $this->get_item_row_by_id( $item_id );

		return $this->get_file_extend_row_by_kind( $item_row, $kind );
	}

	function get_file_extend_row_by_kind( $item_row, $kind ) {
		$file_id = $this->build_value_fileid_by_kind( $item_row, $kind );
		if ( $file_id > 0 ) {
			return $this->get_cached_file_extend_row_by_fileid( $file_id );
		}

		return null;
	}

	function get_cached_file_extend_row_by_kind( $item_row, $kind ) {
		$file_id = $this->build_value_fileid_by_kind( $item_row, $kind );
		if ( $file_id > 0 ) {
			return $this->get_cached_file_extend_row_by_fileid( $file_id );
		}

		return null;
	}

	function get_cached_file_extend_row_by_fileid( $file_id ) {
		return $this->_file_handler->get_cached_extend_row_by_id( $file_id );
	}

	function build_value_fileid_by_kind( $item_row, $kind ) {
		return $this->_item_handler->build_value_fileid_by_kind( $item_row, $kind );
	}

	function build_show_file_image( $file_row ) {
		return $this->_file_handler->build_show_file_image( $file_row );
	}


// cat handler

	function exists_cat_record() {
		return $this->_cat_handler->exists_record();
	}

	function check_valid_catid( $id ) {
		$row = $this->_cat_handler->get_cached_row_by_id( $id );
		if ( is_array( $row ) ) {
			return true;
		}

		return false;
	}

	function get_cached_cat_title_by_id( $cat_id, $flag_sanitize = false ) {
		return $this->_cat_handler->get_cached_value_by_id_name( $cat_id, 'cat_title', $flag_sanitize );
	}

	function get_cached_cat_value_by_id( $cat_id, $name, $flag_sanitize = false ) {
		return $this->_cat_handler->get_cached_value_by_id_name( $cat_id, $name, $flag_sanitize );
	}

	function get_cat_nice_path_from_id( $sel_id, $title, $funcURL, $path = "" ) {
		return $this->_cat_handler->get_nice_path_from_id( $sel_id, $title, $funcURL, $path );
	}


// mime class

	function ext_to_kind( $ext ) {
		return $this->_mime_class->ext_to_kind( $ext );
	}

	function ext_to_mime( $ext ) {
		return $this->_mime_class->ext_to_mime( $ext );
	}

	function mime_to_medium( $mime ) {
		return $this->_mime_class->mime_to_medium( $mime );
	}

	function get_my_allowed_mimes() {
		return $this->_mime_class->get_my_allowed_mimes();
	}

	function is_my_allow_ext( $ext ) {
		return $this->_mime_class->is_my_allow_ext( $ext );
	}


// user

	function build_show_info_morephotos( $uid ) {
		return sprintf( $this->get_constant( 'S_MOREPHOTOS' ), $this->build_show_uname( $uid ) );
	}

	function build_show_uname( $uid ) {
		return $this->get_xoops_uname_by_uid( $uid, $this->_usereal );
	}


// preload class

	function init_preload() {
		$this->preload_init();
		$this->preload_constant();
	}

	function preload_init() {
		$this->_preload_class =& webphoto_d3_preload::getInstance();
		$this->_preload_class->init( $this->_DIRNAME, $this->_TRUST_DIRNAME );
	}

	function preload_constant() {
		$arr = $this->_preload_class->get_preload_const_array();

		if ( ! is_array( $arr ) || ! count( $arr ) ) {
			return true;    // no action
		}

		foreach ( $arr as $k => $v ) {
			$local_name = strtoupper( '_' . $k );

// array type
			if ( strpos( $k, 'array_' ) === 0 ) {
				$temp = $this->str_to_array( $v, '|' );
				if ( is_array( $temp ) && count( $temp ) ) {
					$this->$local_name = $temp;
				}

// string type
			} else {
				$this->$local_name = $v;
			}
		}

	}

	function preload_error( $flag_debug ) {
		$errors = $this->_preload_class->get_errors();
		if ( is_array( $errors ) && count( $errors ) ) {
			$this->set_error( $errors );
			if ( $flag_debug ) {
				echo "<pre>";
				print_r( $errors );
				echo "</pre><br>\n";
			}
		}
	}

	function build_admin_footer() {
		$str = "<hr>\n";
		$str .= $this->_utility_class->build_execution_time( WEBPHOTO_TIME_START );
		$str .= $this->_utility_class->build_memory_usage();

		return $str;
	}


// xoops permission class

	function has_editable_by_uid( $uid ) {
		$has_editable = $this->_perm_class->has_editable();

		if ( $has_editable && $this->is_photo_owner( $uid ) ) {
			return true;
		}
	}

	function is_photo_owner( $uid ) {
		if ( ( $this->_xoops_uid == $uid ) || $this->_is_module_admin ) {
			return true;
		}

		return false;
	}


// file

	function unlink_path( $path ) {
		$file = $this->build_file_full_path( $path );
		if ( $this->check_file( $file ) ) {
			unlink( $file );
		}
	}

	function check_file( $file ) {
		return $this->_utility_class->check_file( $file );
	}


// title

	function build_title_by_mode( $mode ) {
		$str = $this->sanitize( $this->get_constant( 'title_' . $mode ) );

		return $str;
	}


// mysql

	function mysql_datetime_to_str( $date ) {
		return $this->_mysql_utility_class->mysql_datetime_to_str( $date );
	}

	function str_to_mysql_date( $str ) {
		return $this->_utility_class->str_to_mysql_date( $str );
	}

	function get_mysql_date_today() {
		return $this->_mysql_utility_class->get_mysql_date_today();
	}

	function mysql_datetime_to_day_or_month_or_year( $datetime ) {
		return $this->_mysql_utility_class->mysql_datetime_to_day_or_month_or_year( $datetime );
	}

	function mysql_datetime_to_year_month( $datetime ) {
		return $this->_mysql_utility_class->mysql_datetime_to_year_month( $datetime );
	}

	function mysql_datetime_to_year( $datetime ) {
		return $this->_mysql_utility_class->mysql_datetime_to_year( $datetime );
	}

}
