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


class webphoto_main_flash_config extends webphoto_item_public {
	public $_file_handler;
	public $_player_handler;
	public $_flashvar_handler;
	public $_player_clss;
	public $_post_class;
	public $_xml_class;
	public $_multibyte_class;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_file_handler
			=& webphoto_file_handler::getInstance( $dirname, $trust_dirname );
		$this->_player_handler
			=& webphoto_player_handler::getInstance( $dirname, $trust_dirname );
		$this->_flashvar_handler
			=& webphoto_flashvar_handler::getInstance( $dirname, $trust_dirname );
		$this->_player_clss
			=& webphoto_flash_player::getInstance( $dirname, $trust_dirname );
		$this->_playlist_class
			=& webphoto_playlist::getInstance( $dirname, $trust_dirname );

		$this->_post_class      =& webphoto_lib_post::getInstance();
		$this->_xml_class       =& webphoto_lib_xml::getInstance();
		$this->_multibyte_class =& webphoto_lib_multibyte::getInstance();

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_main_flash_config( $dirname, $trust_dirname );
		}

		return $instance;
	}


// main

	public function main() {
		$item_id  = $this->_post_class->get_get_int( 'item_id' );
		$item_row = $this->get_item_row( $item_id );
		if ( ! is_array( $item_row ) ) {
			exit();
		}

		$player_id   = $item_row['item_player_id'];
		$flashvar_id = $item_row['item_flashvar_id'];
		$player_row  = $this->_player_handler->get_row_by_id_or_default( $player_id );

		$param = array(
			'item_row'       => $item_row,
			'cont_row'       => $this->_get_file_row_by_name( $item_row, _C_WEBPHOTO_ITEM_FILE_CONT ),
			'thumb_row'      => $this->_get_file_row_by_name( $item_row, _C_WEBPHOTO_ITEM_FILE_THUMB ),
			'middle_row'     => $this->_get_file_row_by_name( $item_row, _C_WEBPHOTO_ITEM_FILE_MIDDLE ),
			'flash_row'      => $this->_get_file_row_by_name( $item_row, _C_WEBPHOTO_ITEM_FILE_VIDEO_FLASH ),
			'player_row'     => $player_row,
			'flashvar_row'   => $this->_flashvar_handler->get_row_by_id_or_default( $flashvar_id ),
			'playlist_cache' => $this->_playlist_class->refresh_cache_by_item_row( $item_row ),
			'player_style'   => $player_row['player_style'],
		);

		$this->_player_clss->set_variables_in_buffer( $param );

		$buffers = $this->_player_clss->get_variable_buffers();
		if ( ! is_array( $buffers ) ) {
			exit();
		}

// VIEW HIT  Adds 1 if not submitter or admin.
		if ( $this->check_not_owner( $item_row['item_uid'] ) ) {
			$this->_item_handler->countup_views( $item_id, true );
		}

		$var = '<?xml version="1.0" ?>' . "\n";
		$var .= '<config>' . "\n";

		foreach ( $buffers as $k => $v ) {
			$var .= '<' . $k . '>';
			$var .= $this->_xml_utf8( $v[0] );
			$var .= '</' . $k . '>' . "\n";
		}

		$var .= '</config>' . "\n";

		$this->_http_output( 'pass' );
		header( "Content-Type:text/xml; charset=utf-8" );
		echo $var;

	}

	public function _get_file_row_by_name( $item_row, $item_name ) {
		if ( isset( $item_row[ $item_name ] ) ) {
			$file_id = $item_row[ $item_name ];
		} else {
			return false;
		}

		if ( $file_id > 0 ) {
			return $this->_file_handler->get_row_by_id( $file_id );
		}

		return false;
	}

	public function _http_output( $encoding ) {
		return $this->_multibyte_class->m_mb_http_output( $encoding );
	}

	public function _xml_utf8( $str ) {
		return $this->_xml_class->xml_text(
			$this->_multibyte_class->convert_to_utf8( $str ) );
	}

// --- class end ---
}

?>
