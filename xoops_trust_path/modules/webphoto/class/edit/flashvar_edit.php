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


class webphoto_edit_flashvar_edit extends webphoto_edit_base {

	public $_config_class;
	public $_flashvar_handler;
	public $_upload_class;
	public $_image_cmd_class;

	public $_cfg_logo_width;

	public $_newid = 0;
	public $_error_upload = false;

	public $_PLAYERLOGO_SIZE = _C_WEBPHOTO_PLAYERLOGO_SIZE;    // 30 KB
	public $_PLAYERLOGO_FIELD_NAME = _C_WEBPHOTO_UPLOAD_FIELD_PLOGO;

	public $_NORMAL_EXTS = null;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_flashvar_handler
			=& webphoto_flashvar_handler::getInstance( $dirname, $trust_dirname );
		$this->_upload_class
			=& webphoto_upload::getInstance( $dirname, $trust_dirname );

		$this->_image_cmd_class =& webphoto_lib_image_cmd::getInstance();

		$this->_cfg_logo_width = $this->_config_class->get_by_name( 'logo_width' );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_flashvar_edit( $dirname, $trust_dirname );
		}

		return $instance;
	}


// ssubmit

	public function submit() {
		$this->_newid = 0;

		$row = $this->_flashvar_handler->create( true );
		$row = $this->build_row_by_post( $row );

// logo
		$logo = $this->fetch_logo();
		if ( $logo ) {
			$row['flashvar_logo'] = $logo;
		}

		$newid = $this->_flashvar_handler->insert( $row );
		if ( ! $newid ) {
			$this->set_error( $this->_flashvar_handler->get_errors() );

			return _C_WEBPHOTO_ERR_DB;
		}

		$this->_newid = $newid;

		return 0;
	}

	public function build_row_by_post( $row ) {
		$row['flashvar_item_id']          = $this->_post_class->get_post_int( 'flashvar_item_id' );
		$row['flashvar_width']            = $this->_post_class->get_post_int( 'flashvar_width' );
		$row['flashvar_height']           = $this->_post_class->get_post_int( 'flashvar_height' );
		$row['flashvar_displaywidth']     = $this->_post_class->get_post_int( 'flashvar_displaywidth' );
		$row['flashvar_displayheight']    = $this->_post_class->get_post_int( 'flashvar_displayheight' );
		$row['flashvar_image_show']       = $this->_post_class->get_post_int( 'flashvar_image_show' );
		$row['flashvar_searchbar']        = $this->_post_class->get_post_int( 'flashvar_searchbar' );
		$row['flashvar_showeq']           = $this->_post_class->get_post_int( 'flashvar_showeq' );
		$row['flashvar_showicons']        = $this->_post_class->get_post_int( 'flashvar_showicons' );
		$row['flashvar_shownavigation']   = $this->_post_class->get_post_int( 'flashvar_shownavigation' );
		$row['flashvar_showstop']         = $this->_post_class->get_post_int( 'flashvar_showstop' );
		$row['flashvar_showdigits']       = $this->_post_class->get_post_int( 'flashvar_showdigits' );
		$row['flashvar_showdownload']     = $this->_post_class->get_post_int( 'flashvar_showdownload' );
		$row['flashvar_usefullscreen']    = $this->_post_class->get_post_int( 'flashvar_usefullscreen' );
		$row['flashvar_autoscroll']       = $this->_post_class->get_post_int( 'flashvar_autoscroll' );
		$row['flashvar_thumbsinplaylist'] = $this->_post_class->get_post_int( 'flashvar_thumbsinplaylist' );
		$row['flashvar_autostart']        = $this->_post_class->get_post_int( 'flashvar_autostart' );
		$row['flashvar_repeat']           = $this->_post_class->get_post_int( 'flashvar_repeat' );
		$row['flashvar_shuffle']          = $this->_post_class->get_post_int( 'flashvar_shuffle' );
		$row['flashvar_smoothing']        = $this->_post_class->get_post_int( 'flashvar_smoothing' );
		$row['flashvar_enablejs']         = $this->_post_class->get_post_int( 'flashvar_enablejs' );
		$row['flashvar_linkfromdisplay']  = $this->_post_class->get_post_int( 'flashvar_linkfromdisplay' );
		$row['flashvar_link_type']        = $this->_post_class->get_post_int( 'flashvar_link_type' );
		$row['flashvar_bufferlength']     = $this->_post_class->get_post_int( 'flashvar_bufferlength' );
		$row['flashvar_rotatetime']       = $this->_post_class->get_post_int( 'flashvar_rotatetime' );
		$row['flashvar_volume']           = $this->_post_class->get_post_int( 'flashvar_volume' );
		$row['flashvar_linktarget']       = $this->_post_class->get_post_text( 'flashvar_linktarget' );
		$row['flashvar_overstretch']      = $this->_post_class->get_post_text( 'flashvar_overstretch' );
		$row['flashvar_transition']       = $this->_post_class->get_post_text( 'flashvar_transition' );
		$row['flashvar_screencolor']      = $this->_post_class->get_post_text( 'flashvar_screencolor' );
		$row['flashvar_backcolor']        = $this->_post_class->get_post_text( 'flashvar_backcolor' );
		$row['flashvar_frontcolor']       = $this->_post_class->get_post_text( 'flashvar_frontcolor' );
		$row['flashvar_lightcolor']       = $this->_post_class->get_post_text( 'flashvar_lightcolor' );
		$row['flashvar_type']             = $this->_post_class->get_post_text( 'flashvar_type' );
		$row['flashvar_file']             = $this->_post_class->get_post_text( 'flashvar_file' );
		$row['flashvar_image']            = $this->_post_class->get_post_text( 'flashvar_image' );
		$row['flashvar_logo']             = $this->_post_class->get_post_text( 'flashvar_logo' );
		$row['flashvar_link']             = $this->_post_class->get_post_text( 'flashvar_link' );
		$row['flashvar_captions']         = $this->_post_class->get_post_text( 'flashvar_captions' );
		$row['flashvar_fallback']         = $this->_post_class->get_post_text( 'flashvar_fallback' );
		$row['flashvar_callback']         = $this->_post_class->get_post_text( 'flashvar_callback' );
		$row['flashvar_javascriptid']     = $this->_post_class->get_post_text( 'flashvar_javascriptid' );
		$row['flashvar_recommendations']  = $this->_post_class->get_post_text( 'flashvar_recommendations' );
		$row['flashvar_streamscript']     = $this->_post_class->get_post_text( 'flashvar_streamscript' );
		$row['flashvar_searchlink']       = $this->_post_class->get_post_text( 'flashvar_searchlink' );
		$row['flashvar_audio']            = $this->_post_class->get_post_url( 'flashvar_audio' );

// JW Player 5.6
		$row['flashvar_dock']                = $this->_post_class->get_post_int( 'flashvar_dock' );
		$row['flashvar_icons']               = $this->_post_class->get_post_int( 'flashvar_icons' );
		$row['flashvar_mute']                = $this->_post_class->get_post_int( 'flashvar_mute' );
		$row['flashvar_duration']            = $this->_post_class->get_post_int( 'flashvar_duration' );
		$row['flashvar_start']               = $this->_post_class->get_post_int( 'flashvar_start' );
		$row['flashvar_item']                = $this->_post_class->get_post_int( 'flashvar_item' );
		$row['flashvar_logo_hide']           = $this->_post_class->get_post_int( 'flashvar_logo_hide' );
		$row['flashvar_logo_margin']         = $this->_post_class->get_post_int( 'flashvar_logo_margin' );
		$row['flashvar_logo_timeout']        = $this->_post_class->get_post_int( 'flashvar_logo_timeout' );
		$row['flashvar_controlbar_idlehide'] = $this->_post_class->get_post_int( 'flashvar_controlbar_idlehide' );
		$row['flashvar_display_showmute']    = $this->_post_class->get_post_int( 'flashvar_display_showmute' );
		$row['flashvar_playlist_size']       = $this->_post_class->get_post_int( 'flashvar_playlist_size' );

		$row['flashvar_logo_over'] = $this->_post_class->get_post_float( 'flashvar_logo_over' );
		$row['flashvar_logo_out']  = $this->_post_class->get_post_float( 'flashvar_logo_out' );

		$row['flashvar_playlistfile']        = $this->_post_class->get_post_text( 'flashvar_playlistfile' );
		$row['flashvar_mediaid']             = $this->_post_class->get_post_text( 'flashvar_mediaid' );
		$row['flashvar_provider']            = $this->_post_class->get_post_text( 'flashvar_provider' );
		$row['flashvar_streamer']            = $this->_post_class->get_post_text( 'flashvar_streamer' );
		$row['flashvar_skin']                = $this->_post_class->get_post_text( 'flashvar_skin' );
		$row['flashvar_playerready']         = $this->_post_class->get_post_text( 'flashvar_playerready' );
		$row['flashvar_plugins']             = $this->_post_class->get_post_text( 'flashvar_plugins' );
		$row['flashvar_stretching']          = $this->_post_class->get_post_text( 'flashvar_stretching' );
		$row['flashvar_netstreambasepath']   = $this->_post_class->get_post_text( 'flashvar_netstreambasepath' );
		$row['flashvar_player_repeat']       = $this->_post_class->get_post_text( 'flashvar_player_repeat' );
		$row['flashvar_controlbar_position'] = $this->_post_class->get_post_text( 'flashvar_controlbar_position' );
		$row['flashvar_playlist_position']   = $this->_post_class->get_post_text( 'flashvar_playlist_position' );
		$row['flashvar_logo_file']           = $this->_post_class->get_post_text( 'flashvar_logo_file' );
		$row['flashvar_logo_link']           = $this->_post_class->get_post_text( 'flashvar_logo_link' );
		$row['flashvar_logo_linktarget']     = $this->_post_class->get_post_text( 'flashvar_logo_linktarget' );
		$row['flashvar_logo_position']       = $this->_post_class->get_post_text( 'flashvar_logo_position' );

		return $row;
	}

	public function fetch_logo() {
		$this->_error_upload = false;

		$ret = $this->_upload_class->fetch_image( $this->_PLAYERLOGO_FIELD_NAME );
		if ( $ret < 0 ) {
			$this->_error_upload = true;
			$this->set_error( 'ERROR failed to update player logo' );
			$this->set_error( $this->_upload_class->get_errors() );

			return 0;    // failed
		}

		$tmp_name   = $this->_upload_class->get_uploader_file_name();
		$media_name = $this->_upload_class->get_uploader_media_name();

		if ( $tmp_name && $media_name ) {
			$tmp_file  = $this->_TMP_DIR . '/' . $tmp_name;
			$logo_file = $this->_LOGOS_DIR . '/' . $media_name;

			$this->_image_cmd_class->resize_rotate(
				$tmp_file, $logo_file, $this->_cfg_logo_width, $this->_cfg_logo_width );

			return $media_name;
		}

		return 0;
	}

	public function get_newid() {
		return $this->_newid;
	}

	public function get_error_upload() {
		return $this->_error_upload;
	}


// modify

	public function modify() {
		$flashvar_id = $this->_post_class->get_post_int( 'flashvar_id' );

		$row = $this->_flashvar_handler->get_row_by_id( $flashvar_id );
		if ( ! is_array( $row ) ) {
			$this->set_error( $this->_flashvar_handler->get_errors() );

			return _C_WEBPHOTO_ERR_NO_FALSHVAR;
		}

		$row                         = $this->build_row_by_post( $row );
		$row['flashvar_time_update'] = time();

// logo
		$logo = $this->fetch_logo();
		if ( $logo ) {
			$row['flashvar_logo'] = $logo;
		}

		$ret = $this->_flashvar_handler->update( $row );
		if ( ! $ret ) {
			$this->set_error( $this->_flashvar_handler->get_errors() );

			return _C_WEBPHOTO_ERR_DB;
		}

		return 0;
	}


// restore

	public function restore() {
		$flashvar_id = $this->_post_class->get_post_int( 'flashvar_id' );

		$current_row = $this->_flashvar_handler->get_row_by_id( $flashvar_id );
		if ( ! is_array( $current_row ) ) {
			$this->set_error( $this->_flashvar_handler->get_errors() );

			return _C_WEBPHOTO_ERR_NO_FALSHVAR;
		}

		$update_row                         = $this->_flashvar_handler->create( true );
		$update_row['flashvar_id']          = $current_row['flashvar_id'];
		$update_row['flashvar_item_id']     = $current_row['flashvar_item_id'];
		$update_row['flashvar_time_create'] = $current_row['flashvar_time_create'];
		$update_row['flashvar_time_update'] = time();

		$ret = $this->_flashvar_handler->update( $update_row );
		if ( ! $ret ) {
			$this->set_error( $this->_flashvar_handler->get_errors() );

			return _C_WEBPHOTO_ERR_DB;
		}

		return 0;
	}

}
