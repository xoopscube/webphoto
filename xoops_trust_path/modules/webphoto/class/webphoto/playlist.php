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


class webphoto_playlist extends webphoto_lib_error {
	public $_config_class;
	public $_item_handler;
	public $_utility_class;
	public $_xml_class;
	public $_remote_class;
	public $_multibyte_class;

	public $_flag_chmod = true;

// result
	public $_report = null;

	public $_DIRNAME;
	public $_MODULE_URL;
	public $_MODULE_DIR;

	public $_PLAYLIST_DIR;
	public $_MEDIA_DIR;
	public $_MEDIA_URL;

	public $_IMAGE_EXTS;
	public $_SWFOBJECT_EXTS;
	public $_MEDIAPLAYER_EXTS;
	public $_CAPTION_EXTS = array( 'xml' );

	public $_XML_EXT = 'xml';

	public $_lang_status_report = "Status Report";
	public $_lang_status_fetched = "This webfeed has been fetched and cached.";
	public $_lang_status_created = "A new playlist has been cached";
	public $_lang_err_cache = "[ERROR] creating cache file";
	public $_lang_err_nodir = "The media directory does not exist";
	public $_lang_err_emptydir = "The media directory is empty";
	public $_lang_err_write = "Can not write the cache file";
	public $_lang_err_fetch = "Failed to fetch the web feed. <br>Please confirm the web feed location and refresh the cache.";


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct();

		$this->_DIRNAME    = $dirname;
		$this->_MODULE_URL = XOOPS_URL . '/modules/' . $dirname;
		$this->_MODULE_DIR = XOOPS_ROOT_PATH . '/modules/' . $dirname;

		$this->_config_class    =& webphoto_config::getInstance( $dirname );
		$this->_utility_class   =& webphoto_lib_utility::getInstance();
		$this->_xml_class       =& webphoto_lib_xml::getInstance();
		$this->_remote_class    =& webphoto_lib_remote_file::getInstance();
		$this->_multibyte_class =& webphoto_lib_multibyte::getInstance();
		$this->_item_handler    =& webphoto_item_handler::getInstance(
			$dirname, $trust_dirname );

		$uploads_path = $this->_config_class->get_uploads_path();
		$medias_path  = $this->_config_class->get_medias_path();

		$this->_PLAYLIST_DIR = XOOPS_ROOT_PATH . $uploads_path . '/playlists';
		$this->_MEDIA_DIR    = XOOPS_ROOT_PATH . $medias_path;
		$this->_MEDIA_URL    = XOOPS_URL . $medias_path;

		$this->_IMAGE_EXTS     = explode( '|', _C_WEBPHOTO_IMAGE_EXTS );
		$this->_AUDIO_EXTS     = explode( '|', _C_WEBPHOTO_MEDIAPLAYER_AUDIO_EXTS );
		$this->_VIDEO_EXTS     = explode( '|', _C_WEBPHOTO_MEDIAPLAYER_VIDEO_EXTS );
		$this->_SWFOBJECT_EXTS = explode( '|', _C_WEBPHOTO_SWFOBJECT_EXTS );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_playlist( $dirname, $trust_dirname );
		}

		return $instance;
	}


// refresh_cache

	public function refresh_cache_by_item_row( $item_row ) {
		$cache = $item_row['item_playlist_cache'];
		$time  = $item_row['item_playlist_time'];

// Check PLAYLIST CACHE
		$check = $this->check_expired( $cache, $time );
		if ( $check ) {
			return $cache;
		}

		$this->create_cache_by_item_row( $item_row );

		return $cache;
	}


// build cache file name

	public function build_name( $item_id ) {
		return $this->build_random_file_name( $item_id, $this->_XML_EXT );
	}


// check
//
// http://www.php.net/manual/en/function.date.php
// U = Unix Epoch

	public function check_expired( $cache, $time ) {
		$filename = $this->_PLAYLIST_DIR . '/' . $cache;
		if ( file_exists( $filename ) ) {
			$filetime = date( "U", filemtime( $filename ) );
			if ( time() < ( $filetime + $time ) ) {
				return true;
			}
		}

		return false;
	}


// create

	public function create_cache_by_item_id( $item_id ) {
		$row = $this->_item_handler->get_row_by_id( $item_id );

		return $this->create_cache_by_item_row( $row );
	}

	public function create_cache_by_item_row( $row ) {
		if ( ! is_array( $row ) ) {
			return false;
		}

		if ( empty( $row['item_playlist_cache'] ) ) {
			return false;
		}

		$ret = false;

		switch ( $row['item_kind'] ) {
			case _C_WEBPHOTO_ITEM_KIND_PLAYLIST_DIR :
				$ret = $this->_create_list( $row );
				break;

			case _C_WEBPHOTO_ITEM_KIND_PLAYLIST_FEED :
				$ret = $this->_fetch_feed( $row );
				break;
		}

		return $ret;
	}

	public function get_report() {
		$msg = null;
		if ( $this->_report ) {
			$msg = $this->_lang_status_report . '<br>';
			$msg .= $this->_report;
		}

		return $msg;
	}


// fetch

	public function _fetch_feed( $row ) {
		$feed  = $row['item_playlist_feed'];
		$cache = $row['item_playlist_cache'];

		if ( empty( $feed ) ) {
			return false;
		}

// Fetch
		$data = $this->read_remote_file( $feed );

		if ( $data ) {
			$ret = $this->_write_cache( $cache, $data );
			if ( $ret ) {
				$this->_report = $this->_lang_status_fetched;

				return true;    // fetched
			}

// not fetch
		} else {
			$this->set_error(
				$this->_build_error( $this->_lang_err_fetch, $feed ) );
		}

		return false;
	}

	public function _write_cache( $cache, $data ) {
		$file = $this->_PLAYLIST_DIR . '/' . $cache;

		$byte = $this->write_file( $file, $data );
		if ( $byte > 0 ) {
			return true;
		}

		$this->set_error(
			$this->_build_error( $this->_lang_err_write, $cache ) );

		return false;
	}

	public function _build_error( $error, $param ) {
		$msg = $_lang_err_cache . '<br>';
		$msg .= $error . '<br>';
		$msg .= $param;

		return $msg;
	}


// create from directory

	public function _create_list( $row ) {
		$this->_report = '';
		$msg           = '';

		$dir   = $row['item_playlist_dir'];
		$type  = $row['item_playlist_type'];
		$cache = $row['item_playlist_cache'];

		if ( empty( $dir ) ) {
			return false;
		}

		$media_dir = $this->_MEDIA_DIR . '/' . $dir;
		$media_url = $this->_MEDIA_URL . '/' . $dir;

		$params = array();

		if ( ! file_exists( $media_dir ) || ! is_dir( $media_dir ) ) {
			$this->set_error(
				$this->_build_error( $this->_lang_err_nodir, $media_dir ) );

			return false;
		}

		$files = $this->get_files_in_dir( $media_dir, null, false, true );
		if ( ! is_array( $files ) || ! count( $files ) ) {
			$this->set_error(
				$this->_build_error( $this->_lang_err_nodir, $cache ) );

			return false;
		}

		foreach ( $files as $file ) {
			$name = $this->strip_ext( $file );

			list( $item, $image, $caption )
				= $this->_parse_entry( $file, $type );

			if ( $item ) {
				$params[ $name ]['item'] = $file;
			}
			if ( $image ) {
				$params[ $name ]['image'] = $file;
			}
			if ( $caption ) {
				$params[ $name ]['caption'] = $file;
			}
		}

		if ( ! is_array( $params ) || ! count( $params ) ) {
			$this->set_error(
				$this->_build_error( $this->_lang_err_emptydir, $cache ) );

			return false;
		}

		$data = $this->_build_playlist_xml( $media_url, $row, $params );

		$ret = $this->_write_cache( $cache, $data );
		if ( $ret ) {
			$this->_report = $this->_lang_status_created . '<br>';
			$this->_report .= $cache;

			return true;    // created
		}

		return false;
	}

	public function _parse_entry( $file, $type ) {
		$file_ext = strtolower( $this->parse_ext( $file ) );

		$item    = false;
		$image   = false;
		$caption = false;

		$exts = $this->_type_to_exts( $type );
		if ( is_array( $exts ) && in_array( $file_ext, $exts ) ) {
			$item = true;
		}

		if ( in_array( $file_ext, $this->_IMAGE_EXTS ) ) {
			$image = true;
		}

		if ( in_array( $file_ext, $this->_CAPTION_EXTS ) ) {
			$caption = true;
		}

		return array( $item, $image, $caption );

	}

	public function _type_to_exts( $type ) {
		$exts = null;

		switch ( $type ) {
			case _C_WEBPHOTO_PLAYLIST_TYPE_IMAGE :
				$exts = $this->_IMAGE_EXTS;
				break;

			case _C_WEBPHOTO_PLAYLIST_TYPE_AUDIO :
				$exts = $this->_AUDIO_EXTS;
				break;

			case _C_WEBPHOTO_PLAYLIST_TYPE_VIDEO :
				$exts = $this->_VIDEO_EXTS;
				break;
		}

		return $exts;
	}


// the playlist is built in xspf format
// we'll first add an xml header and the opening tags .. 
// header(\"content-type:text/xml;charset=utf-8\"); //NEEDS WORK

	public function _build_playlist_xml( $media_url, $row, $params ) {
		$item_id   = $row['item_id'];
		$siteurl   = $row['item_siteurl'];
		$artist    = $row['item_artist'];
		$album     = $row['item_album'];
		$label     = $row['item_label'];
		$top_title = $row['item_title'];

		if ( $siteurl ) {
			$trackinfo = $siteurl;
		} else {
			$trackinfo = $this->_MODULE_URL . '/index.php?fct=photo&photo_id=' . $item_id;
		}

		$trackinfo_xml = $this->_xml( $trackinfo );
		$top_title_xml = $this->_xml( $this->_utf8( $top_title ) );
		$artist_xml    = $this->_xml( $this->_utf8( $artist ) );
		$album_xml     = $this->_xml( $this->_utf8( $album ) );
		$label_xml     = $this->_xml( $this->_utf8( $label ) );

		$data = '<playlist version="1" xmlns="http://xspf.org/ns/0/">' . "\n";
		$data .= '<title>' . $top_title_xml . '</title>' . "\n";
		$data .= '<info>' . $trackinfo_xml . '</info>' . "\n";
		$data .= '<trackList>' . "\n";

//  then we loop through the directory files ...
		foreach ( $params as $name => $param ) {
			$item  = null;
			$image = null;
			$title = null;
			if ( isset( $param['item'] ) ) {
				$item  = $param['item'];
				$title = $this->_utf8( $this->strip_ext( $item ) );
			}
			if ( isset( $param['image'] ) ) {
				$image = $param['image'];
			}

			if ( empty( $item ) ) {
				continue;
			}

			$data .= '<track>' . "\n";
			$data .= '<title>' . $this->_xml( $title ) . '</title>' . "\n";
			$data .= '<location>' . $this->_xml_url( $media_url . '/' . $item ) . '</location>' . "\n";
			$data .= '<info>' . $trackinfo_xml . '</info>' . "\n";
			if ( $artist ) {
				$data .= '<creator>' . $artist_xml . '</creator>' . "\n";
			}
			if ( $album ) {
				$data .= '<album>' . $album_xml . '</album>' . "\n";
			}
			if ( $label ) {
				$data .= '<label>' . $label_xml . '</label>' . "\n";
			}
			if ( $image ) {
				$data .= '<image>' . $this->_xml_url( $media_url . '/' . $image ) . '</image>' . "\n";
			}
			$data .= '</track>' . "\n";
		}

// .. and last we add the closing tags
		$data .= '</trackList>' . "\n";
		$data .= '</playlist>' . "\n";

		return $data;
	}


// refresh_all

	public function refresh_cache_all() {
		$rows = $this->_item_handler->get_rows_public_by_kind( _C_WEBPHOTO_ITEM_KIND_PLAYLIST_FEED );
		if ( is_array( $rows ) && count( $rows ) ) {
			foreach ( $rows as $row ) {
				$this->_update_item_cache( $row );
				$this->_fetch_feed( $row );
			}
		}

		$rows = $this->_item_handler->get_rows_public_by_kind( _C_WEBPHOTO_ITEM_KIND_PLAYLIST_DIR );
		if ( is_array( $rows ) && count( $rows ) ) {
			foreach ( $rows as $row ) {
				$this->_update_item_cache( $row );
				$this->_create_list( $row );
			}
		}
	}

	public function _update_item_cache( $row ) {
		$item_id = $row['item_id'];
		$cache   = $row['item_playlist_cache'];

		if ( empty( $cache ) ) {
			$this->_item_handler->update_playlist_cache(
				$item_id, $cache = $this->build_name( $item_id ) );
		}
	}


// delete

	public function delete( $item_id ) {
		$cache = '';

		$row = $this->_item_handler->get_row_by_id( $item_id );
		if ( isset( $row['item_playlist_cache'] ) ) {
			$cache = $row['item_playlist_cache'];
		}

		if ( $cache != '' ) {
			$cache = $this->_PLAYLIST_DIR . '/' . $cache;
			if ( file_exists( $cache ) ) {
				unlink( $cache );
			}
		}
	}


// utility

	public function parse_ext( $file ) {
		return $this->_utility_class->parse_ext( $file );
	}

	public function strip_ext( $file ) {
		return $this->_utility_class->strip_ext( $file );
	}

	public function get_files_in_dir( $path, $ext = null, $flag_dir = false, $flag_sort = false, $id_as_key = false ) {
		return $this->_utility_class->get_files_in_dir( $path, $ext, $flag_dir, $flag_sort, $id_as_key );
	}

	public function write_file( $file, $data, $mode = 'w' ) {
		return $this->_utility_class->write_file( $file, $data, $mode, $this->_flag_chmod );
	}

	public function build_random_file_name( $id, $ext, $extra = null ) {
		return $this->_utility_class->build_random_file_name( $id, $ext, $extra );
	}


// remote

	public function read_remote_file( $url ) {
		return $this->_remote_class->read_file( $url );
	}


// xml

	public function _xml( $str ) {
		return $this->_xml_class->xml_text( $str );
	}

	public function _xml_url( $str ) {
		return $this->_xml_class->xml_url( $str );
	}


// multibyte

	public function _utf8( $str ) {
		return $this->_multibyte_class->convert_to_utf8( $str );
	}

}
