<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_edit_playlist_build extends webphoto_base_ini {
	public $_playlist_class;
	public $_icon_build_class;
	public $_msg_class;

	public $_item_row = null;

	public $_THUMB_EXT_DEFAULT = 'playlist';

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );


		$this->_playlist_class   =& webphoto_playlist::getInstance(
			$dirname, $trust_dirname );
		$this->_icon_build_class =& webphoto_edit_icon_build::getInstance( $dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_playlist_build( $dirname, $trust_dirname );
		}

		return $instance;
	}


// public 

	public function is_type( $row ) {
		if ( $row['item_playlist_type'] ) {
			return true;
		}

		return false;
	}

// called before crete item
	public function build_row( $row ) {
		if ( ! $this->is_type( $row ) ) {
			return 1;    // no action
		}

		$this->_item_row = $row;

		$item_title         = $row['item_title'];
		$item_playlist_type = $row['item_playlist_type'];
		$item_playlist_feed = $row['item_playlist_feed'];
		$item_playlist_dir  = $row['item_playlist_dir'];

		if ( $item_playlist_feed ) {
			$row['item_kind'] = _C_WEBPHOTO_ITEM_KIND_PLAYLIST_FEED;

		} elseif ( $item_playlist_dir ) {
			$row['item_kind'] = _C_WEBPHOTO_ITEM_KIND_PLAYLIST_DIR;

		} else {
			return _C_WEBPHOTO_ERR_PLAYLIST;
		}

		if ( empty( $item_title ) ) {
			$row['item_title'] = $this->build_title( $row );
		}

		switch ( $item_playlist_type ) {
// general
			case _C_WEBPHOTO_PLAYLIST_TYPE_AUDIO :
			case _C_WEBPHOTO_PLAYLIST_TYPE_VIDEO :
			case _C_WEBPHOTO_PLAYLIST_TYPE_FLASH :
				$row['item_displaytype'] = _C_WEBPHOTO_DISPLAYTYPE_MEDIAPLAYER;
				$row['item_player_id']   = _C_WEBPHOTO_PLAYER_ID_PLAYLIST;
				break;

// image
			case _C_WEBPHOTO_PLAYLIST_TYPE_IMAGE :
				$row['item_displaytype'] = _C_WEBPHOTO_DISPLAYTYPE_IMAGEROTATOR;
				break;
		}

		$row = $this->build_row_icon_if_empty( $row, $this->_THUMB_EXT_DEFAULT );

		$this->_item_row = $row;

		return 0;    // OK
	}

// called after crete item
	public function create_cache( $row ) {
		if ( ! $this->is_type( $row ) ) {
			return 1;    // no action
		}

		$this->_item_row = $row;
		$item_id         = $row['item_id'];

// playlist cache
		$row['item_playlist_cache'] = $this->_playlist_class->build_name( $item_id );

		$ret = $this->_playlist_class->create_cache_by_item_row( $row );
		if ( ! $ret ) {
			$this->set_error( $this->_playlist_class->get_errors() );

			return _C_WEBPHOTO_ERR_PLAYLIST;
		}

		$this->_item_row = $row;

		return 0;    // OK
	}

	public function build_title( $row ) {
		$playlist_dir  = $row['item_playlist_dir'];
		$playlist_feed = $row['item_playlist_feed'];

		$title = null;

		if ( $playlist_dir ) {
			$title = $playlist_dir;

		} elseif ( $playlist_feed ) {

// BUG: Notice [PHP]: Undefined variable: laylist_feed
			$param = parse_url( $playlist_feed );

			$title = $param['host'] ?? date( "YmdHis" );
		}

		if ( $title ) {
			$title = 'playlist: ' . $title;
		}

		return $title;
	}

	public function get_item_row() {
		return $this->_item_row;
	}


// icon

	public function build_row_icon_if_empty( $row, $ext = null ) {
		return $this->_icon_build_class->build_row_icon_if_empty( $row, $ext );
	}

}
