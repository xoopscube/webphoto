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


class webphoto_edit_factory_create extends webphoto_edit_base {

	public $_cont_create_class;
	public $_middle_thumb_create_class;
	public $_small_create_class;
	public $_flash_create_class;
	public $_docomo_create_class;
	public $_pdf_create_class;
	public $_swf_create_class;
	public $_jpeg_create_class;
	public $_mp3_create_class;
	public $_wav_create_class;
	public $_file_action_class;
	public $_video_middle_thumb_create_class;
	public $_video_images_create_class;
	public $_item_build_class;
	public $_icon_build_class;
	public $_search_build_class;
	public $_ext_build_class;
	public $_msg_main_class;
	public $_msg_sub_class;
	public $_multibyte_class;
	public $_image_create_class;

// config
	public $_has_image_resize = false;
	public $_has_image_rotate = false;

// set param
	public $_flag_print_first_msg = false;
	public $_flag_force_db = false;

// result
	public $_item_row = null;
	public $_flag_resized = false;
	public $_flag_video_image_created = false;
	public $_flag_video_image_failed = false;
	public $_flag_flash_created = false;
	public $_flag_flash_failed = false;
	public $_flag_pdf_created = false;
	public $_flag_pdf_failed = false;
	public $_flag_swf_created = false;
	public $_flag_swf_failed = false;
	public $_flag_jpeg_created = false;
	public $_flag_jpeg_failed = false;
	public $_is_jpeg_cmyk = false;
	public $_flag_mp3_created = false;
	public $_flag_mp3_failed = false;
	public $_flag_wav_created = false;
	public $_flag_wav_failed = false;

	public $_cont_param = null;
	public $_video_param = null;
	public $_msg_item = null;

	public $_TITLE_DEFAULT = 'no title';

	public $_EXT_JPEG = 'jpg';
	public $_EXT_WAV = 'wav';

	public $_CONTENT_LENGTH = 65000; // 64KB
	public $_GMAP_ZOOM = _C_WEBPHOTO_GMAP_ZOOM;

	public $_FLAG_ADMIN = false;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_search_build_class
			=& webphoto_edit_search_build::getInstance( $dirname, $trust_dirname );
		$this->_item_build_class
			=& webphoto_edit_item_build::getInstance( $dirname, $trust_dirname );
		$this->_cont_create_class
			=& webphoto_edit_cont_create::getInstance( $dirname, $trust_dirname );
		$this->_flash_create_class
			=& webphoto_edit_flash_create::getInstance( $dirname, $trust_dirname );
		$this->_docomo_create_class
			=& webphoto_edit_docomo_create::getInstance( $dirname, $trust_dirname );
		$this->_small_create_class
			=& webphoto_edit_small_create::getInstance( $dirname, $trust_dirname );
		$this->_middle_thumb_create_class
			=& webphoto_edit_middle_thumb_create::getInstance( $dirname, $trust_dirname );
		$this->_video_images_create_class
			=& webphoto_edit_video_images_create::getInstance( $dirname, $trust_dirname );
		$this->_pdf_create_class
			=& webphoto_edit_pdf_create::getInstance( $dirname, $trust_dirname );
		$this->_swf_create_class
			=& webphoto_edit_swf_create::getInstance( $dirname, $trust_dirname );
		$this->_jpeg_create_class
			=& webphoto_edit_jpeg_create::getInstance( $dirname, $trust_dirname );
		$this->_mp3_create_class
			=& webphoto_edit_mp3_create::getInstance( $dirname, $trust_dirname );
		$this->_wav_create_class
			=& webphoto_edit_wav_create::getInstance( $dirname, $trust_dirname );
		$this->_file_action_class
			=& webphoto_edit_file_action::getInstance( $dirname, $trust_dirname );
		$this->_video_middle_thumb_create_class
			=& webphoto_edit_video_middle_thumb_create::getInstance( $dirname, $trust_dirname );
		$this->_ext_build_class
			=& webphoto_edit_ext_build::getInstance( $dirname, $trust_dirname );
		$this->_image_create_class
			=& webphoto_image_create::getInstance( $dirname );

		$this->_icon_build_class =& webphoto_edit_icon_build::getInstance( $dirname );
		$this->_multibyte_class  =& webphoto_lib_multibyte::getInstance();

		$this->_msg_main_class = new webphoto_lib_msg();
		$this->_msg_sub_class  = new webphoto_lib_msg();

		$this->_has_image_resize = $this->_image_create_class->has_resize();
		$this->_has_image_rotate = $this->_image_create_class->has_rotate();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_factory_create( $dirname, $trust_dirname );
		}

		return $instance;
	}


// set param 

	public function set_flag_admin( $val ) {
		$this->_FLAG_ADMIN = (bool) $val;
		$this->_item_build_class->set_flag_admin( $val );
	}


// create from file

	public function create_item_from_param( $item_row, $param ) {
		$this->_msg_main_class->clear_msg_array();
		$this->_msg_sub_class->clear_msg_array();

		$this->_item_row = null;

		$ret = $this->check_item( $item_row, $param );
		if ( $ret < 0 ) {
			if ( $this->check_msg_level_admin() ) {
				$msg = $item_row['item_title'] . ' : ' . $this->get_msg_sub_str();
				$this->_msg_main_class->set_msg( $msg );
			}

			return $ret;
		}

// --- insert item ---
		$item_row = $this->build_item_row_from_file( $item_row, $param['src_file'] );
		$item_id  = $this->insert_item( $item_row );
		if ( ! $item_id ) {
			if ( $this->check_msg_level_admin() ) {
				$msg = $item_row['item_title'] . ' : ' . $this->get_msg_sub_str();
				$this->_msg_main_class->set_msg( $msg );
			}

			return _C_WEBPHOTO_ERR_DB;
		}

		$item_row['item_id'] = $item_id;
		$this->_item_row     = $item_row;

		if ( $this->_flag_print_first_msg ) {
			$msg = ' ';
			$msg .= $this->build_uri_photo_id_title(
				$item_id, $item_row['item_title'] );
			$msg .= ' : ';
			$this->_msg_main_class->set_msg( $msg );
		}

		$ret             = $this->create_files_from_param( $item_row, $param );
		$this->_item_row = $item_row;

		if ( $this->check_msg_level_admin() ) {
			$this->_msg_main_class->set_msg( $this->get_msg_sub_str() );
		}

		return $ret;
	}

	public function create_files_from_param( $item_row, $param ) {
		$item_ext  = $item_row['item_ext'];
		$item_kind = $item_row['item_kind'];

		$src_file          = $param['src_file'];
		$flag_video_plural = isset( $param['flag_video_plural'] ) ? (bool) $param['flag_video_plural'] : false;

		if ( empty( $src_file ) || ! is_file( $src_file ) ) {
			return 0;    // no action
		}

// --- insert cont ---
		$file_params = array();

		$photo_param = $this->build_photo_param( $item_row, $src_file );

		$this->create_cont_param( $photo_param );
		$file_params['cont'] = $this->_cont_param;

// -- docomo, flash, pdf, video images
		if ( is_array( $this->_cont_param ) ) {
			$sub_params = $this->create_sub_files(
				$photo_param, $this->_cont_param, $flag_video_plural );
			if ( is_array( $sub_params ) ) {
				$file_params = $file_params + $sub_params;
			}

			$file_params['jpeg'] = $this->create_jpeg_param( $photo_param, $file_params );

// Undefined variable: image_params
			$image_params = $this->create_image_params( $photo_param, $file_params );

			if ( is_array( $image_params ) ) {
				$file_params = $file_params + $image_params;
			}
		}

		$file_id_array = $this->insert_files_from_params(
			$item_row['item_id'], $file_params );

// --- update item ---
		$item_row = $this->build_item_row_submit_update( $item_row, $file_id_array );
		$ret      = $this->update_item( $item_row );
		if ( ! $ret ) {
			return _C_WEBPHOTO_ERR_DB;
		}
		$this->_item_row = $item_row;

		return 0;
	}

	public function create_sub_files( $photo_param, $cont_param, $flag_video_plural ) {
		$sub_params           = array();
		$sub_params['docomo'] = $this->create_docomo_param( $photo_param, $cont_param );
		$sub_params['flash']  = $this->create_flash_param( $photo_param );
		$sub_params['pdf']    = $this->create_pdf_param( $photo_param );
		$sub_params['swf']    = $this->create_swf_param( $photo_param );
		$sub_params['wav']    = $this->create_wav_param( $photo_param );
		$sub_params['mp3']
		                      = $this->create_mp3_param( $photo_param, $sub_params['wav'] );

		if ( $flag_video_plural ) {
			$this->create_video_images( $photo_param );
		}

		return $sub_params;
	}

	public function check_item( $item_row, $param ) {
		if ( ! isset( $param['src_file'] ) ) {
			$this->_msg_sub_class->set_msg( 'Empty file', true );

			return _C_WEBPHOTO_ERR_EMPTY_FILE;
		}

// TODO
//	if ( ! is_readable( $param['src_file'] ) ) {
//		$this->print_msg_level_admin( ' Cannot read file, ', true );
//		return _C_WEBPHOTO_ERR_FILEREAD;
//	}

		if ( ! isset( $item_row['item_cat_id'] ) ) {
			$this->_msg_sub_class->set_msg( 'Empty cat_id', true );

			return _C_WEBPHOTO_ERR_EMPTY_CAT;
		}

		return 0;
	}

	public function get_item_row() {
		return $this->_item_row;
	}

	public function print_main_msg() {
		echo $this->get_main_msg();
	}

	public function get_main_msg() {
		return $this->_msg_main_class->get_msg_str( ' ' );
	}


// item row

	public function build_item_row_from_file( $row, $src_file ) {
		$row = $this->build_row_ext_kind( $row, $src_file );
		$row = $this->build_row_exif( $row, $src_file );
		$row = $this->build_row_video_info( $row, $src_file );
		$row = $this->build_row_onclick( $row );
		$row = $this->build_row_status( $row );
		$row = $this->build_row_uid( $row );
		$row = $this->build_row_displaytype( $row );
		$row = $this->build_row_detail_onclick( $row );
		$row = $this->build_row_icon_if_empty( $row );
		$row = $this->build_row_title_if_empty( $row );
		$row = $this->build_row_search( $row );

		return $row;
	}

	public function build_item_row_photo( $row, $photo_name, $media_name ) {
		$file = $this->_TMP_DIR . '/' . $photo_name;

// ext kind exif duration
		$row = $this->build_row_ext_kind( $row, $photo_name );
		$row = $this->build_row_title_media( $row, $media_name );
		$row = $this->build_row_exif( $row, $file );
		$row = $this->build_row_video_info( $row, $file );

		return $row;
	}

	public function build_item_row_submit_insert( $row, $tag_name_array = null ) {
// status onclick search
		$row = $this->build_row_onclick( $row );
		$row = $this->build_row_status( $row );
		$row = $this->build_row_uid( $row );
		$row = $this->build_row_displaytype( $row );
		$row = $this->build_row_detail_onclick( $row );
		$row = $this->build_row_title_if_empty( $row );
		$row = $this->build_row_search( $row, $tag_name_array );

		return $row;
	}

	public function build_item_row_submit_update( $row, $file_id_array, $tag_name_array = null ) {
// files content icon search
		$row = $this->build_row_content( $row, $file_id_array );
		$row = $this->build_row_files( $row, $file_id_array );
		$row = $this->build_row_width( $row );
		$row = $this->build_row_cmyk( $row );
		$row = $this->build_row_icon_if_empty( $row );
		$row = $this->build_row_search( $row, $tag_name_array );

		return $row;
	}

	public function build_item_row_submit_small( $row ) {
// small
		return $this->build_row_small_if_empty( $row );
	}

	public function build_item_row_modify_post( $row, $checkbox ) {
		return $this->_item_build_class->build_row_modify_by_post( $row, $checkbox );
	}

	public function build_item_row_modify_update( $row, $file_id_array, $tag_name_array ) {
// files content search
		$row = $this->build_row_content( $row, $file_id_array );
		$row = $this->build_row_files( $row, $file_id_array );
		$row = $this->build_row_search( $row, $tag_name_array );

		return $row;
	}

	public function build_row_submit_by_post( $row, $checkbox ) {
		return $this->_item_build_class->build_row_submit_by_post( $row, $checkbox );
	}

	public function build_row_files( $row, $file_id_array ) {
		return $this->_item_build_class->build_row_files( $row, $file_id_array );
	}

	public function build_row_ext_kind( $row, $file ) {
		return $this->_item_build_class->build_row_ext_kind_from_file( $row, $file );
	}

	public function build_row_onclick( $row ) {
		return $this->_item_build_class->build_row_onclick( $row );
	}

	public function build_row_status( $row ) {
		return $this->_item_build_class->build_row_status_if_empty( $row );
	}

	public function build_row_uid( $row ) {
		return $this->_item_build_class->build_row_uid_if_empty( $row );
	}

	public function build_row_displaytype( $row ) {
		return $this->_item_build_class->build_row_displaytype_if_empty( $row );
	}

	public function build_row_detail_onclick( $row ) {
		return $this->_item_build_class->build_row_detail_onclick_if_empty( $row );
	}

	public function build_row_title_if_empty( $row ) {
		return $this->_item_build_class->build_row_title_if_empty( $row );
	}

	public function build_row_title_media( $row, $media_name ) {
		if ( empty( $row['item_title'] ) ) {
			$row['item_title'] = $this->strip_ext( $media_name );
		}

		return $row;
	}

	public function build_item_perm_by_level_catid( $level, $cat_id ) {
		return $this->_item_build_class->build_item_perm_by_level_catid(
			$level, $cat_id );
	}

	public function use_item_perm_level() {
		return $this->_item_build_class->use_item_perm_level();
	}


// create copy param

	public function create_single_copy_param( $param ) {
		$src_kind = $param['src_kind'];

		$ret = null;

		switch ( $src_kind ) {
			case _C_WEBPHOTO_FILE_KIND_PDF :
				$ret = $this->create_pdf_copy_param( $param );
				break;

			case _C_WEBPHOTO_FILE_KIND_SWF :
				$ret = $this->create_swf_copy_param( $param );
				break;

			case _C_WEBPHOTO_FILE_KIND_WAV :
				$ret = $this->create_wav_copy_param( $param );
				break;

			case _C_WEBPHOTO_FILE_KIND_MP3 :
				$ret = $this->create_mp3_copy_param( $param );
				break;

			case _C_WEBPHOTO_FILE_KIND_THUMB :
			case _C_WEBPHOTO_FILE_KIND_LARGE :
			case _C_WEBPHOTO_FILE_KIND_MIDDLE :
			case _C_WEBPHOTO_FILE_KIND_SMALL:
				$ret = $this->create_image_copy_param( $param );
				break;
		}

		return $ret;
	}


// create cont

	public function build_photo_param( $item_row, $src_file ) {
		$param             = $item_row;
		$param['src_file'] = $src_file;

// Undefined variable: item_ext
		$param['src_ext']  = $item_row['item_ext'];
		$param['src_kind'] = $item_row['item_kind'];

		return $param;
	}

	public function create_cont_param( $param ) {
		$ret = $this->_cont_create_class->create_param( $param );
		if ( $ret < 0 ) {
			return $ret;
		}
		$this->_cont_param = $this->_cont_create_class->get_param();
		$this->_msg_sub_class->set_msg( $this->_cont_create_class->get_msg_array() );

		return 0;
	}

// for preview
	public function rotate_image( $src_file, $dst_file, $rotate ) {
		return $this->_image_create_class->cmd_resize_rotate(
			$src_file, $dst_file, 0, 0, $rotate );
	}

	public function get_cont_param() {
		return $this->_cont_param;
	}

	public function get_resized() {
		return $this->_flag_resized;
	}


// create image

	public function create_image_params( $photo_param, $file_params = null ) {
		$param = $photo_param;

// if jpeg file
		if ( isset( $file_params['jpeg']['file'] ) ) {
			$param['src_file'] = $file_params['jpeg']['file'];
			$param['src_ext']  = $file_params['jpeg']['ext'];
		}

// not valid source
		if ( ! isset( $param['src_file'] ) && empty( $param['src_file'] ) ) {
			return false;
		}

		$ret = $this->_middle_thumb_create_class->create_image_params( $param );
		$this->_msg_sub_class->set_msg( $this->_middle_thumb_create_class->get_msg_array() );

		return $ret;
	}

	public function create_image_copy_param( $param ) {
// no action if not image
		if ( ! $this->is_image_ext( $param['src_ext'] ) ) {
			return null;
		}

		$ret = $this->_middle_thumb_create_class->create_copy_param( $param );
		$this->_msg_sub_class->set_msg( $this->_middle_thumb_create_class->get_msg_array() );

		return $ret;
	}


// small image

	public function create_small_param_from_external_icon( $row ) {
// BUG : Notice [PHP]: Undefined variable: ret
		$ret = $this->_small_create_class->create_small_param_from_external_icon( $row );
		$this->_msg_sub_class->set_msg( $this->_small_create_class->get_msg_array() );

		return $ret;
	}


// create jpeg

	public function create_jpeg_param( $photo_param, $file_params = null ) {
		if ( ! is_array( $photo_param ) ) {
			return null;
		}

		$param = $photo_param;

// if pdf file
		$param['pdf_file'] = isset( $file_params['pdf']['file'] ) ? $file_params['pdf']['file'] : null;

		$jpeg_param               = $this->_jpeg_create_class->create_param( $param );
		$this->_flag_jpeg_created = $this->_jpeg_create_class->get_flag_created();
		$this->_flag_jpeg_failed  = $this->_jpeg_create_class->get_flag_failed();
		$this->_is_jpeg_cmyk      = $this->_jpeg_create_class->is_cmyk();
		$this->_msg_sub_class->set_msg( $this->_jpeg_create_class->get_msg_array() );

//print_r($jpeg_param);

		return $jpeg_param;
	}

	public function create_jpeg_param_by_tmp( $item_row, $tmp_name ) {
		if ( empty( $tmp_name ) ) {
			return null;
		}

		$ext = $this->parse_ext( $tmp_name );

		$param             = $item_row;
		$param['src_file'] = $this->_TMP_DIR . '/' . $tmp_name;
		$param['src_ext']  = $ext;

// jpeg
		if ( $this->is_jpeg_ext( $ext ) ) {
			$ret = $this->_jpeg_create_class->create_copy_param( $param );
			$this->_msg_sub_class->set_msg( $this->_jpeg_create_class->get_msg_array() );

// gif, png
		} elseif ( $this->is_image_ext( $ext ) ) {
			$ret = $this->_jpeg_create_class->create_image_param( $param );
			$this->_msg_sub_class->set_msg( $this->_jpeg_create_class->get_msg_array() );

// not image
		} else {
			return null;
		}

		return $ret;
	}

	public function get_flag_jpeg_created() {
		return $this->_flag_jpeg_created;
	}

	public function get_flag_jpeg_failed() {
		return $this->_flag_jpeg_failed;
	}


// create video docomo

	public function create_docomo_param( $photo_param, $cont_param ) {
		$param = array_merge( $photo_param, $cont_param );

		if ( $this->is_video_docomo_ext( $param['src_ext'] ) ) {
			return null;
		}

		$ret = $this->_docomo_create_class->create_param( $param );
		$this->_msg_sub_class->set_msg( $this->_docomo_create_class->get_msg_array() );

		return $ret;
	}


// create video flash

	public function create_flash_param( $param ) {
		if ( $this->is_flash_ext( $param['src_ext'] ) ) {
			return null;
		}

		$flash_param               = $this->_flash_create_class->create( $param );
		$this->_flag_flash_created = $this->_flash_create_class->get_flag_created();
		$this->_flag_flash_failed  = $this->_flash_create_class->get_flag_failed();
		$this->_msg_sub_class->set_msg( $this->_flash_create_class->get_msg_array() );
		$this->set_error( $this->_flash_create_class->get_errors() );

		return $flash_param;
	}

	public function get_flag_flash_created() {
		return $this->_flag_flash_created;
	}

	public function get_flag_flash_failed() {
		return $this->_flag_flash_failed;
	}


// create pdf

	public function create_pdf_param( $param ) {
// no action if pdf
		if ( $this->is_pdf_ext( $param['src_ext'] ) ) {
			return null;
		}

		$pdf_param               = $this->_pdf_create_class->create_param( $param );
		$this->_flag_pdf_created = $this->_pdf_create_class->get_flag_created();
		$this->_flag_pdf_failed  = $this->_pdf_create_class->get_flag_failed();
		$this->_msg_sub_class->set_msg( $this->_pdf_create_class->get_msg_array() );

		return $pdf_param;
	}

	public function create_pdf_copy_param( $param ) {
// no action if not pdf
		if ( ! $this->is_pdf_ext( $param['src_ext'] ) ) {
			return null;
		}

		$pdf_param               = $this->_pdf_create_class->create_copy_param( $param );
		$this->_flag_pdf_created = $this->_pdf_create_class->get_flag_created();
		$this->_flag_pdf_failed  = $this->_pdf_create_class->get_flag_failed();
		$this->_msg_sub_class->set_msg( $this->_pdf_create_class->get_msg_array() );

		return $pdf_param;
	}

	public function get_flag_pdf_created() {
		return $this->_flag_pdf_created;
	}

	public function get_flag_pdf_failed() {
		return $this->_flag_pdf_failed;
	}


// create swf

	public function create_swf_param( $param ) {
// no action if swf
		if ( $this->is_swf_ext( $param['src_ext'] ) ) {
			return null;
		}

		$swf_param               = $this->_swf_create_class->create_param( $param );
		$this->_flag_swf_created = $this->_swf_create_class->get_flag_created();
		$this->_flag_swf_failed  = $this->_swf_create_class->get_flag_failed();
		$this->_msg_sub_class->set_msg( $this->_swf_create_class->get_msg_array() );

		return $swf_param;
	}

	public function create_swf_copy_param( $param ) {
// no action if not swf
		if ( ! $this->is_swf_ext( $param['src_ext'] ) ) {
			return null;
		}

		$swf_param               = $this->_swf_create_class->create_copy_param( $param );
		$this->_flag_swf_created = $this->_swf_create_class->get_flag_created();
		$this->_flag_swf_failed  = $this->_swf_create_class->get_flag_failed();
		$this->_msg_sub_class->set_msg( $this->_swf_create_class->get_msg_array() );

		return $swf_param;
	}

	public function get_flag_swf_created() {
		return $this->_flag_swf_created;
	}

	public function get_flag_swf_failed() {
		return $this->_flag_swf_failed;
	}


// create mp3

	public function create_mp3_param( $photo_param, $wav_param ) {
// no action if same ext
		if ( $this->is_mp3_ext( $photo_param['src_ext'] ) ) {
			return null;
		}

		$mp3_param = $photo_param;

// if wav file
		if ( isset( $wav_param['file'] ) ) {
			$mp3_param['src_file'] = $wav_param['file'];
			$mp3_param['src_ext']  = $this->_EXT_WAV;
		}

// no action if not wav ext
		if ( ! $this->is_wav_ext( $mp3_param['src_ext'] ) ) {
			return null;
		}

		$param_out               = $this->_mp3_create_class->create_param( $mp3_param );
		$this->_flag_mp3_created = $this->_mp3_create_class->get_flag_created();
		$this->_flag_mp3_failed  = $this->_mp3_create_class->get_flag_failed();
		$this->_msg_sub_class->set_msg( $this->_mp3_create_class->get_msg_array() );

		return $param_out;
	}

	public function create_mp3_copy__param( $param ) {
// no action if not mp3t
		if ( ! $this->is_mp3_ext( $param['src_ext'] ) ) {
			return null;
		}

		$param_out               = $this->_mp3_create_class->create_copy_param( $param );
		$this->_flag_mp3_created = $this->_mp3_create_class->get_flag_created();
		$this->_flag_mp3_failed  = $this->_mp3_create_class->get_flag_failed();
		$this->_msg_sub_class->set_msg( $this->_mp3_create_class->get_msg_array() );

		return $param_out;
	}

	public function get_flag_mp3_created() {
		return $this->_flag_mp3_created;
	}

	public function get_flag_mp3_failed() {
		return $this->_flag_mp3_failed;
	}


// create wav

	public function create_wav_param( $param ) {
// no action if wave
		if ( $this->is_wav_ext( $param['src_ext'] ) ) {
			return null;
		}

		$wav_param               = $this->_wav_create_class->create_param( $param );
		$this->_flag_wav_created = $this->_wav_create_class->get_flag_created();
		$this->_flag_wav_failed  = $this->_wav_create_class->get_flag_failed();
		$this->_msg_sub_class->set_msg( $this->_wav_create_class->get_msg_array() );

		return $wav_param;
	}

	public function create_wav_copy_param( $param ) {
// no action if not wave
		if ( ! $this->is_wav_ext( $param['src_ext'] ) ) {
			return null;
		}

		$wav_param               = $this->_wav_create_class->create_copy_param( $param );
		$this->_flag_wav_created = $this->_wav_create_class->get_flag_created();
		$this->_flag_wav_failed  = $this->_wav_create_class->get_flag_failed();
		$this->_msg_sub_class->set_msg( $this->_wav_create_class->get_msg_array() );

		return $wav_param;
	}

	public function get_flag_wav_created() {
		return $this->_flag_wav_created;
	}

	public function get_flag_wav_failed() {
		return $this->_flag_wav_failed;
	}


// vodeo images

	public function create_video_images( $param ) {
		$ret                             = $this->_video_images_create_class->create( $param );
		$this->_flag_video_image_created = $this->_video_images_create_class->get_flag_created();
		$this->_flag_video_image_failed  = $this->_video_images_create_class->get_flag_failed();

		return $ret;
	}

	public function get_flag_video_image_created() {
		return $this->_flag_video_image_created;
	}

	public function get_flag_video_image_failed() {
		return $this->_flag_video_image_failed;
	}

	public function video_thumb( $row ) {
		return $this->_video_middle_thumb_create_class->video_thumb( $row );
	}


// file extention

	public function build_row_exif( $row, $src_file ) {
		$ret = $this->_ext_build_class->get_exif( $row, $src_file );
		if ( $ret != 1 ) {
			return $row;
		}

		$this->_msg_sub_class->set_msg( 'get exif' );
		$result = $this->_ext_build_class->get_result();

		$datetime  = $result['datetime_mysql'];
		$equipment = $result['equipment'];
		$latitude  = $result['latitude'];
		$longitude = $result['longitude'];
		$exif      = $result['all_data'];

		if ( $datetime ) {
			$row['item_datetime'] = $datetime;
		}
		if ( $equipment ) {
			$row['item_equipment'] = $equipment;
		}
		if ( ( $latitude != 0 ) || ( $longitude != 0 ) ) {
			$row['item_gmap_latitude']  = $latitude;
			$row['item_gmap_longitude'] = $longitude;
			$row['item_gmap_zoom']      = $this->_GMAP_ZOOM;
		}
		if ( $exif ) {
			$row['item_exif'] = $exif;
		}

		return $row;
	}

	public function build_row_video_info( $row, $src_file ) {
		$ret = $this->_ext_build_class->get_video_info( $row, $src_file );
		if ( $ret != 1 ) {
			return $row;
		}

		$this->_msg_sub_class->set_msg( 'get video info' );
		$result               = $this->_ext_build_class->get_result();
		$row['item_duration'] = $result['duration'];
		$row['item_width']    = $result['width'];
		$row['item_height']   = $result['height'];
		if ( $result['is_h264_aac'] ) {
			$row['item_kind']        = _C_WEBPHOTO_ITEM_KIND_VIDEO_H264;
			$row['item_displayfile'] = _C_WEBPHOTO_FILE_KIND_CONT;
		}

		return $row;
	}

	public function build_row_content( $row, $file_id_array ) {
		$ret = $this->_ext_build_class->get_text_content( $row, $file_id_array );
		if ( $ret == 1 ) {
			$row['item_content'] = $this->_ext_build_class->get_result();
			$this->_msg_sub_class->set_msg( 'get content' );

		} elseif ( $ret == - 1 ) {
			$this->set_error( $this->_ext_build_class->get_errors() );
		}

		return $row;
	}


// width cmyk

	public function build_row_width( $row ) {
		if ( isset( $this->_cont_param['width'] ) && $this->_cont_param['width'] &&
		     isset( $this->_cont_param['height'] ) && $this->_cont_param['height'] ) {
			$row['item_width']  = $this->_cont_param['width'];
			$row['item_height'] = $this->_cont_param['height'];
		}

		return $row;
	}

	public function build_row_cmyk( $row ) {
		if ( $this->_is_jpeg_cmyk ) {
			$row['item_kind']           = _C_WEBPHOTO_ITEM_KIND_IMAGE_CMYK;
			$row['item_onclick']        = _C_WEBPHOTO_ONCLICK_PAGE;
			$row['item_detail_onclick'] = _C_WEBPHOTO_DETAIL_ONCLICK_DOWNLOAD;
		}

		return $row;
	}


// icon

	public function build_row_icon_if_empty( $row, $ext = null ) {
		return $this->_icon_build_class->build_row_icon_if_empty( $row, $ext );
	}


// search

	public function build_row_search( $row, $tag_name_array = null ) {
		return $this->_search_build_class->build_row( $row, $tag_name_array );
	}


// item handler

	public function insert_item( $row ) {
		$newid = $this->format_and_insert_item( $row, $this->_flag_force_db );
		if ( ! $newid ) {
			$this->_msg_sub_class->set_msg( 'DB Error', true );

			return false;
		}

		return $newid;
	}

	public function update_item( $row ) {
		$ret = $this->format_and_update_item( $row, $this->_flag_force_db );
		if ( ! $ret ) {
			$this->_msg_sub_class->set_msg( 'DB Error', true );

			return false;
		}

		return true;
	}


// file handler

	public function insert_files_from_params( $item_id, $params ) {
		return $this->_file_action_class->insert_files_from_params( $item_id, $params );
	}

	public function update_files_from_params( $item_id, $params ) {
		return $this->_file_action_class->update_files_from_params( $item_id, $params );
	}

// action.php
	public function insert_file_by_param( $item_id, $param ) {
		return $this->_file_action_class->insert_file_by_param( $item_id, $param );
	}

	public function get_file_full_by_key( $arr, $key ) {
		$id = isset( $arr[ $key ] ) ? (int) $arr[ $key ] : 0;
		if ( $id > 0 ) {
			return $this->_file_handler->get_full_path_by_id( $id );
		}

		return null;
	}


// msg

	public function get_msg_sub_str() {
		return $this->_msg_sub_class->get_msg_str( ', ' );
	}


// set & get param

	public function set_flag_force_db( $val ) {
		$this->_flag_force_db = (bool) $val;
		$this->_file_action_class->set_flag_force_db( $val );
	}

	public function set_flag_print_first_msg( $val ) {
		$this->_flag_print_first_msg = (bool) $val;
	}

	public function has_image_resize() {
		return $this->_has_image_resize;
	}

	public function has_image_rotate() {
		return $this->_has_image_rotate;
	}
}


