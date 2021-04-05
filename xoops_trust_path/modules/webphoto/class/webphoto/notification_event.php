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


class webphoto_notification_event extends webphoto_d3_notification_event {
	public $_cat_handler;
	public $_uri_class;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct();
		$this->init( $dirname, $trust_dirname );

		$this->_cat_handler
			              =& webphoto_cat_handler::getInstance( $dirname, $trust_dirname );
		$this->_uri_class =& webphoto_uri::getInstance( $dirname );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_notification_event( $dirname, $trust_dirname );
		}

		return $instance;
	}


// function

	public function notify_new_photo( $photo_id, $cat_id, $photo_title ) {
		$cat_title = $this->_cat_handler->get_cached_value_by_id_name( $cat_id, 'cat_title' );

		$photo_uri = $this->_uri_class->build_photo( $photo_id );

		// Global Notification
		$photo_tags = array(
			'PHOTO_TITLE' => $photo_title,
			'PHOTO_URI'   => $photo_uri,
		);

		$this->trigger_event( 'global', 0, 'new_photo', $photo_tags );

		// Category Notification
		if ( $cat_title ) {
			$cat_tags = array(
				'PHOTO_TITLE'    => $photo_title,
				'CATEGORY_TITLE' => $cat_title,
				'PHOTO_URI'      => $photo_uri,
			);

			$this->trigger_event( 'category', $cat_id, 'new_photo', $cat_tags );
		}

	}

	public function notify_waiting( $photo_id, $photo_title ) {
		$url  = $this->_MODULE_URL . '/admin/index.php?fct=item_manager&op=modify_form&item_id=' . $photo_id;
		$tags = array(
			'PHOTO_TITLE' => $photo_title,
			'WAITING_URL' => $url,
		);
		$this->trigger_event( 'global', 0, 'waiting', $tags );
	}

}
