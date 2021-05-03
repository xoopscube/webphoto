<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief class webphoto_d3_notification_select
 * subsitute for core's notification_select.php
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_edit_action extends webphoto_edit_submit {
	public $_delete_class;
	public $_file_action_class;

	public $_delete_error = '';


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_delete_class
			=& webphoto_edit_item_delete::getInstance( $dirname, $trust_dirname );
		$this->_file_action_class
			=& webphoto_edit_file_action::getInstance( $dirname, $trust_dirname );
	}

// for admin_photo_manage admin_catmanager
	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_action( $dirname, $trust_dirname );
		}

		return $instance;
	}


	public function check_edit_perm( $item_row ) {
		if ( $this->_is_module_admin ) {
			return true;
		}

// user can touch photos status > 0
		if ( ( $item_row['item_uid'] == $this->_xoops_uid ) && ( $item_row['item_status'] > 0 ) ) {
			return true;
		}

		return false;
	}


// modify form

	public function set_param_modify_default( $item_row ) {
		$publish_checkbox = _C_WEBPHOTO_NO;
		$expire_checkbox  = _C_WEBPHOTO_NO;
		if ( $item_row['item_time_publish'] > 0 ) {
			$publish_checkbox = _C_WEBPHOTO_YES;
		}
		if ( $item_row['item_time_expire'] > 0 ) {
			$expire_checkbox = _C_WEBPHOTO_YES;
		}
		$this->set_checkbox_by_name( 'item_datetime_checkbox', _C_WEBPHOTO_YES );
		$this->set_checkbox_by_name( 'item_time_update_checkbox', _C_WEBPHOTO_YES );
		$this->set_checkbox_by_name( 'item_time_publish_checkbox', $publish_checkbox );
		$this->set_checkbox_by_name( 'item_time_expire_checkbox', $expire_checkbox );
		$this->set_tag_name_array( $this->tag_handler_tag_name_array( $item_row['item_id'] ) );
	}

	public function build_item_row_modify_post( $item_row ) {
		$checkbox = $this->get_checkbox_by_name( 'item_datetime_checkbox' );
		$item_row = $this->_factory_create_class->build_item_row_modify_post(
			$item_row, $checkbox );

		return $item_row;
	}


// build form delete confirm

	public function build_form_delete_confirm_with_template( $item_row ) {
		$template = 'db:' . $this->_DIRNAME . '_form_confirm.html';

		$arr = array_merge(
			$this->_admin_item_form_class->build_form_base_param(),
			$this->build_form_delete_confirm( $item_row )
		);

		$tpl = new XoopsTpl();
		$tpl->assign( $arr );

		return $tpl->fetch( $template );
	}

	public function build_form_delete_confirm( $item_row ) {
		$src    = null;
		$width  = 0;
		$height = 0;

		$image = $this->_show_image_class->build_image_by_item_row( $item_row, true );
		if ( is_array( $image ) ) {
			$src    = $image['img_thumb_src'];
			$width  = $image['img_thumb_width'];
			$height = $image['img_thumb_height'];
		}

		$param = [
			'thumb_src_s'  => $this->sanitize( $src ),
			'thumb_width'  => $width,
			'thumb_height' => $height,
			'item_id'      => $item_row['item_id'],
			'item_title_s' => $this->sanitize( $item_row['item_title'] ),
		];

		return $param;
	}


	public function modify( $item_row ) {
		$this->get_post_param();
		$ret1 = $this->modify_exec( $item_row );

		if ( $this->_is_video_thumb_form ) {
			return _C_WEBPHOTO_RET_VIDEO_FORM;
		}

		$ret2 = $this->build_failed_msg( $ret1 );
		if ( ! $ret2 ) {
			return _C_WEBPHOTO_RET_ERROR;
		}

		return _C_WEBPHOTO_RET_SUCCESS;
	}

	public function get_updated_row() {
		return $this->_row_update;
	}

	public function modify_exec( $item_row ) {
// save
		$this->_row_update = $item_row;

		$photo_tmp_name = null;
		$jpeg_tmp_name  = null;
		$image_info     = null;
		$file_id_array  = null;
		$cont_id        = 0;

		$this->clear_msg_array();

		$item_row  = $this->build_item_row_modify_post( $item_row );
		$item_id   = $item_row['item_id'];
		$item_kind = $item_row['item_kind'];

		switch ( $item_kind ) {
// embed
// playlist
			case _C_WEBPHOTO_ITEM_KIND_EMBED :
			case _C_WEBPHOTO_ITEM_KIND_PLAYLIST_FEED :
			case _C_WEBPHOTO_ITEM_KIND_PLAYLIST_DIR  :
				break;

// fetch photo
			default:
				$ret = $this->modify_fetch_photo();
				if ( $ret < 0 ) {
					return $ret;    // failed
				}
				break;
		}

// fetch thumb middle
		if ( $this->_ini_file_jpeg ) {
			$this->upload_fetch_jpeg();
		}

		$this->upload_fetch_files();

		$photo_name      = $this->_photo_tmp_name;
		$jpeg_name       = $this->_jpeg_tmp_name;
		$file_name_array = $this->_file_tmp_name_array;

// no upload
		if ( empty( $photo_name ) && empty( $jpeg_name ) && ! count( $file_name_array ) ) {
			return $this->update_photo_no_image( $item_row );
		}

// ext kind exif duration
		if ( $photo_name ) {
			$item_row = $this->_factory_create_class->build_item_row_photo(
				$item_row, $photo_name, $this->_photo_media_name );
			$item_row = $this->delete_file_jpeg_if_upload_jpeg( $item_row );
		}

		if ( $photo_name || $jpeg_name ) {
			$ret = $this->create_media_file_params( $item_row, $is_submit = false );
			if ( $ret < 0 ) {
				return $ret;
			}
		}

		if ( count( $file_name_array ) ) {
			$ret = $this->create_files_params( $item_row );
			if ( $ret < 0 ) {
				return $ret;
			}
		}

		$this->unlink_uploaded_files();

// --- update files
		$file_id_array = $this->_factory_create_class->update_files_from_params(
			$item_row, $this->_media_file_params );

// files content search
		$item_row = $this->_factory_create_class->build_item_row_modify_update(
			$item_row, $file_id_array, $this->_tag_name_array );

// --- update item
		$ret = $this->format_and_update_item( $item_row );
		if ( ! $ret ) {
			return _C_WEBPHOTO_ERR_DB;
		}

		$this->update_all_file_duration_if_not_cont( $item_row, $file_id_array );
		$this->tag_handler_update_tags( $item_id, $this->get_tag_name_array() );
		$this->notify_new_photo_if_appove( $item_row );

// save
		$this->_row_update = $item_row;

		return 0;
	}

	public function modify_fetch_photo() {
		if ( ! $this->check_edit( 'file_photo' ) ) {
			return 0;    // no action
		}
		if ( ! $this->check_xoops_upload_file( $this->_ini_file_jpeg ) ) {
			return _C_WEBPHOTO_ERR_NO_SPECIFIED;
		}
		$ret = $this->upload_fetch_photo( true );
		if ( $ret < 0 ) {
			return $ret;    // failed
		}

		return 0;    // ok
	}

	public function update_all_file_duration_if_not_cont( $item_row, $file_id_array ) {
		$cont_id = $this->get_array_value_by_key( $file_id_array, 'cont_id' );
		if ( $cont_id == 0 ) {
			$this->update_all_file_duration( $item_row );
		}
	}

	public function get_array_value_by_key( $array, $key ) {
		return (int) $this->_utility_class->get_array_value_by_key( $array, $key, 0 );
	}


// update_photo_no_image

	public function update_photo_no_image( $item_row ) {
		$this->update_all_file_duration( $item_row );

// --- update item
// search
		$item_row = $this->_factory_create_class->build_item_row_modify_update(
			$item_row, null, $this->_tag_name_array );
		$ret      = $this->format_and_update_item( $item_row );
		if ( ! $ret ) {
			return _C_WEBPHOTO_ERR_DB;
		}

		$this->tag_handler_update_tags( $item_row['item_id'], $this->_tag_name_array );
		$this->notify_new_photo_if_appove( $item_row );

// save
		$this->_row_update = $item_row;

		return 0;
	}

	public function update_all_file_duration( $item_row ) {
		$duration = $item_row['item_duration'];

		$cont_duration = 0;
		$cont_row      = $this->_file_action_class->get_file_row_by_item_name( $item_row, _C_WEBPHOTO_ITEM_FILE_CONT );
		if ( is_array( $cont_row ) ) {
			$cont_duration = $cont_row['file_duration'];
		}

		if ( $duration != $cont_duration ) {
			$this->update_file_duration( $item_row, $duration, _C_WEBPHOTO_ITEM_FILE_CONT );
			$this->update_file_duration( $item_row, $duration, _C_WEBPHOTO_ITEM_FILE_VIDEO_FLASH );
			$this->update_file_duration( $item_row, $duration, _C_WEBPHOTO_ITEM_FILE_VIDEO_DOCOMO );
		}
	}

	public function update_file_duration( $item_row, $duration, $item_name ) {
		return $this->_file_action_class->update_duration( $item_row, $duration, $item_name );
	}


	public function delete( $item_row ) {
		$err  = null;
		$ret1 = $this->delete_exec( $item_row );

		$ret2 = $this->build_failed_msg( $ret1 );
		if ( ! $ret2 ) {
			return false;
		}

		return true;
	}

	public function delete_exec( $item_row ) {
		if ( ! $this->_has_deletable ) {
			return _C_WEBPHOTO_ERR_NO_PERM;
		}

		if ( ! $this->check_edit_perm( $item_row ) ) {
			return _C_WEBPHOTO_ERR_NO_PERM;
		}

		$ret = $this->_delete_class->delete_photo_by_item_row( $item_row );
		if ( ! $ret ) {
			$this->set_error( $delete_class->get_errors() );

			return _C_WEBPHOTO_ERR_DB;
		}

		if ( $this->is_waiting_status( $item_row['item_status'] ) ) {
			$this->mail_refuse( $item_row );
		}

		return 0;
	}


	public function video_redo( $item_row ) {
		$flag_thumb = $this->_post_class->get_post_int( 'redo_thumb' );
		$flag_flash = $this->_post_class->get_post_int( 'redo_flash' );

		$ret1 = $this->video_redo_exec( $item_row, $flag_thumb, $flag_flash );

		if ( $this->_is_video_thumb_form ) {
			return _C_WEBPHOTO_RET_VIDEO_FORM;
		}

		$ret2 = $this->build_failed_msg( $ret1 );
		if ( ! $ret2 ) {
			return _C_WEBPHOTO_RET_ERROR;
		}

		return _C_WEBPHOTO_RET_SUCCESS;
	}

	public function video_redo_exec( $item_row, $flag_thumb, $flag_flash ) {
		$this->clear_msg_array();

		$this->_is_video_thumb_form = false;
		$flash_param                = null;

		$item_id   = $item_row['item_id'];
		$item_ext  = $item_row['item_ext'];
		$item_kind = $item_row['item_kind'];

		$cont_full  = null;
		$flash_full = null;
		$param      = null;

		$cont_row = $this->get_file_extend_row_by_kind(
			$item_row, _C_WEBPHOTO_FILE_KIND_CONT );
		if ( is_array( $cont_row ) ) {
			$cont_path     = $cont_row['file_path'];
			$cont_width    = $cont_row['file_width'];
			$cont_height   = $cont_row['file_height'];
			$cont_duration = $cont_row['file_duration'];
			$cont_full     = $cont_row['full_path'];

			$param             = $item_row;
			$param['src_file'] = $cont_full;
			$param['src_kind'] = $item_kind;
			$param['src_ext']  = $item_ext;

		}

		$flash_row = $this->get_file_extend_row_by_kind(
			$item_row, _C_WEBPHOTO_FILE_KIND_VIDEO_FLASH );
		if ( is_array( $flash_row ) ) {
			$flash_full = $flash_row['full_path'];
		}

		$flash_tmp_file = $this->_TMP_DIR . '/tmp_' . uniqid( $item_id . '_' );

// create flash
		if ( $flag_flash && is_array( $param ) ) {
// save file
			$this->rename_file( $flash_full, $flash_tmp_file );

			$flash_param = $this->create_flash_param( $param );

			if ( is_array( $flash_param ) ) {
// remove file if success
				$this->unlink_file( $flash_tmp_file );

			} else {
// recovery file if fail
				$this->rename_file( $flash_tmp_file, $flash_full );
			}
		}

// create video thumb
		if ( $flag_thumb && is_array( $param ) ) {
			$this->create_video_images( $param );
		}

// update
		$row_update = $item_row;

		if ( is_array( $flash_param ) ) {
			$flash_id = $this->insert_file_by_param( $item_id, $flash_param );

// success
			if ( $flash_id > 0 ) {
				$row_update[ _C_WEBPHOTO_ITEM_FILE_VIDEO_FLASH ] = $flash_id;
				$row_update['item_displaytype']                  = _C_WEBPHOTO_DISPLAYTYPE_MEDIAPLAYER;

				$ret = $this->format_and_update_item( $row_update );
				if ( ! $ret ) {
					return _C_WEBPHOTO_ERR_DB;
				}

// fail
			} else {
				$this->set_error( $this->_factory_create_class->get_errors() );
			}
		}

// save
		$this->_row_update = $row_update;

		return 0;
	}

	public function create_flash_param( $photo_param ) {
		$flash_param = $this->_factory_create_class->create_flash_param( $photo_param );
		if ( $this->_factory_create_class->get_flag_flash_failed() ) {
			$this->set_msg_array( $this->get_constant( 'ERR_VIDEO_FLASH' ) );
		}

		return $flash_param;
	}

	public function create_video_images( $param ) {
		$ret = $this->_factory_create_class->create_video_images( $param );
		if ( $this->_factory_create_class->get_flag_video_image_created() ) {
			$this->_is_video_thumb_form = true;
		}
		if ( $this->_factory_create_class->get_flag_video_image_failed() ) {
			$this->set_msg_array( $this->get_constant( 'ERR_VIDEO_THUMB' ) );
		}

		return $ret;
	}


// file delete

	public function delete_file_jpeg_if_upload_jpeg( $item_row ) {
		if ( $this->is_jpeg_ext( $item_row['item_ext'] ) ) {
			$this->delete_file( $item_row, _C_WEBPHOTO_ITEM_FILE_JPEG );
			$item_row[ _C_WEBPHOTO_ITEM_FILE_JPEG ] = 0;
		}

		return $item_row;
	}

	public function video_flash_delete( $item_row ) {
		$ret = $this->delete_file( $item_row, _C_WEBPHOTO_ITEM_FILE_VIDEO_FLASH );
		if ( $ret == - 1 ) {
			$this->_delete_error = 'No file record';

			return false;
		}
		if ( $ret == - 2 ) {
			return false;
		}

		$item_row[ _C_WEBPHOTO_ITEM_FILE_VIDEO_FLASH ] = 0;
		$item_row['item_displaytype']                  = _C_WEBPHOTO_DISPLAYTYPE_GENERAL;

		$ret = $this->format_and_update_item( $item_row );
		if ( ! $ret ) {
			$this->_delete_error = "DB Error";
			if ( $this->_FLAG_ADMIN ) {
				$this->_delete_error .= "<br>\n" . $this->get_format_error();
			}

			return false;
		}

		return true;
	}

	public function jpeg_thumb_delete( $item_row, $flag_thmub = true ) {
		$ret = $this->delete_file( $item_row, _C_WEBPHOTO_ITEM_FILE_JPEG );
		if ( $ret == - 1 ) {
			$this->_delete_error = 'No file record';

			return false;
		}
		if ( $ret == - 2 ) {
			return false;
		}

		$item_row[ _C_WEBPHOTO_ITEM_FILE_JPEG ] = 0;

		if ( $flag_thmub ) {
			$this->delete_file( $item_row, _C_WEBPHOTO_ITEM_FILE_THUMB );
			$this->delete_file( $item_row, _C_WEBPHOTO_ITEM_FILE_LARGE );
			$this->delete_file( $item_row, _C_WEBPHOTO_ITEM_FILE_MIDDLE );
			$this->delete_file( $item_row, _C_WEBPHOTO_ITEM_FILE_SMALL );
			$item_row[ _C_WEBPHOTO_ITEM_FILE_THUMB ]  = 0;
			$item_row[ _C_WEBPHOTO_ITEM_FILE_LARGE ]  = 0;
			$item_row[ _C_WEBPHOTO_ITEM_FILE_MIDDLE ] = 0;
			$item_row[ _C_WEBPHOTO_ITEM_FILE_SMALL ]  = 0;
		}

		$item_row = $this->_factory_create_class->build_row_icon_if_empty( $item_row );
		$ret      = $this->format_and_update_item( $item_row );
		if ( ! $ret ) {
			$this->_delete_error = "DB Error";
			if ( $this->_FLAG_ADMIN ) {
				$this->_delete_error .= "<br>\n" . $this->get_format_error();
			}

			return false;
		}

		return true;
	}

	public function cont_delete( $item_row ) {
		return $this->file_delete_common(
			$item_row, _C_WEBPHOTO_ITEM_FILE_CONT );
	}

	public function file_delete_common( $item_row, $item_name ) {
		$ret = $this->delete_file( $item_row, $item_name );
		if ( $ret == - 1 ) {
			$this->_delete_error = 'No file record';

			return false;
		}
		if ( $ret == - 2 ) {
			return false;
		}

// BUG: not clear file id when delete file
		$item_row[ $item_name ] = 0;
		$ret                    = $this->format_and_update_item( $item_row );
		if ( ! $ret ) {
			$this->_delete_error = "DB Error";
			if ( $this->_FLAG_ADMIN ) {
				$this->_delete_error .= "<br>\n" . $this->get_format_error();
			}

			return false;
		}

		return true;
	}

	public function delete_file( $item_row, $item_name ) {
		$ret = $this->_file_action_class->delete_file( $item_row, $item_name );
		if ( $ret == - 2 ) {
			$this->_delete_error = "DB Error";
			if ( $this->_FLAG_ADMIN ) {
				$this->_delete_error .= "<br>\n" . $this->_file_action_class->get_format_error();
			}
		}

		return $ret;
	}


// tag class

	public function tag_handler_update_tags( $item_id, $tag_name_array ) {
		if ( $this->_FLAG_ADMIN ) {
			return $this->_tag_build_class->update_tags_admin( $item_id, $this->_xoops_uid, $tag_name_array );
		} else {
			return $this->_tag_build_class->update_tags( $item_id, $this->_xoops_uid, $tag_name_array );
		}

// dummy
		return false;
	}

	public function tag_handler_tag_name_array( $item_id ) {
		return $this->_tag_build_class->get_tag_name_array_by_photoid_uid( $item_id, $this->_xoops_uid );
	}


// notify

	public function notify_new_photo_if_appove( $item_row ) {
		if ( $this->is_apporved_status( $item_row['item_status'] ) ) {
			$this->notify_new_photo( $item_row );
			$this->mail_approve( $item_row );
		}
	}

	public function is_apporved_status( $status ) {
		return $status == _C_WEBPHOTO_STATUS_APPROVED;
	}

	public function is_waiting_status( $status ) {
		return $status == _C_WEBPHOTO_STATUS_WAITING;
	}

}

