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


class webphoto_main_visit extends webphoto_item_public {
	public $_post_class;

	public $_FLAG_REDIRECT = true;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_post_class =& webphoto_lib_post::getInstance();

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_main_visit( $dirname, $trust_dirname );
		}

		return $instance;
	}


// main

	function main() {
		$item_id  = $this->_post_class->get_get_int( 'item_id' );
		$item_row = $this->get_item_row( $item_id );
		if ( ! is_array( $item_row ) ) {
			exit();
		}

		$this->_item_handler->countup_hits( $item_id, true );

		$siteurl   = $item_row['item_siteurl'];
		$siteurl   = preg_replace( '/javascript:/si', 'java script:', $siteurl );
		$siteurl_s = $this->sanitize( $siteurl );

		if ( $this->_FLAG_REDIRECT ) {
			header( 'Location: ' . $siteurl );

		} else {
			echo '<html><head>';
			echo '<meta http-equiv="Refresh" content="0; URL=' . $siteurl_s . '"></meta>';
			echo '</head><body></body></html>';
		}

		exit();
	}

// --- class end ---
}

?>
