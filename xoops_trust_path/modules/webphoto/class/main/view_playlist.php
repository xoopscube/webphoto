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


class webphoto_main_view_playlist extends webphoto_file_read {
	public $_config_class;
	public $_kind_class;
	public $_readfile_class;

	public $_PLAYLISTS_DIR;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_config_class   =& webphoto_config::getInstance( $dirname );
		$this->_kind_class     =& webphoto_kind::getInstance();
		$this->_readfile_class =& webphoto_lib_readfile::getInstance();

		$uploads_path         = $this->_config_class->get_uploads_path();
		$this->_PLAYLISTS_DIR = XOOPS_ROOT_PATH . $uploads_path . '/playlists';

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_main_view_playlist( $dirname, $trust_dirname );
		}

		return $instance;
	}


// public

	function main() {
		$item_id  = $this->_post_class->get_post_get_int( 'item_id' );
		$item_row = $this->get_item_row( $item_id );
		if ( ! is_array( $item_row ) ) {
			exit();
		}

		$kind  = $item_row['item_kind'];
		$cache = $item_row['item_playlist_cache'];
		$file  = $this->_PLAYLISTS_DIR . '/' . $cache;

		if ( ! $this->_kind_class->is_playlist_kind( $kind ) ) {
			exit();
		}

		if ( empty( $cache ) || ! file_exists( $file ) ) {
			exit();
		}

		$this->_readfile_class->readfile_xml( $file );

		exit();
	}

// --- class end ---
}

?>
