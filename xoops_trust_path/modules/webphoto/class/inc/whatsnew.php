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


class webphoto_inc_whatsnew extends webphoto_inc_public {
	public $_uri_class;

	public $_SHOW_IMAGE = true;
	public $_SHOW_ICON = false;

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct();

		$this->init_public( $dirname, $trust_dirname );
		$this->auto_publish();

		$this->set_normal_exts( _C_WEBPHOTO_IMAGE_EXTS );

		$this->_uri_class =& webphoto_inc_uri::getSingleton( $dirname );

// preload
		$show_image = $this->get_ini( 'whatsnew_show_image' );
		$show_icon  = $this->get_ini( 'whatsnew_show_icon' );

		if ( $show_image ) {
			$this->_SHOW_IMAGE = $show_image;
		}
		if ( $show_icon ) {
			$this->_SHOW_ICON = $show_icon;
		}
	}

	public static function &getSingleton( $dirname, $trust_dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] = new webphoto_inc_whatsnew( $dirname, $trust_dirname );
		}

		return $singletons[ $dirname ];
	}


// public

	function whatsnew( $limit = 0, $offset = 0 ) {
		$item_rows = $this->get_item_rows_for_whatsnew( $limit, $offset );
		if ( ! is_array( $item_rows ) ) {
			return array();
		}

		$i   = 0;
		$ret = array();

		foreach ( $item_rows as $item_row ) {
			$cat_title = null;
			$cont_mime = null;
			$image     = null;
			$width     = 0;
			$height    = 0;

			$item_id     = $item_row['item_id'];
			$cat_id      = $item_row['item_cat_id'];
			$time_update = $item_row['item_time_update'];
			$time_create = $item_row['item_time_create'];
			$item_kind   = $item_row['item_kind'];

			$is_image = $this->is_image_kind( $item_kind );
			$is_video = $this->is_video_kind( $item_kind );

			$cat_row = $this->get_cat_cached_row_by_id( $cat_id );
			if ( is_array( $cat_row ) ) {
				$cat_title = $cat_row['cat_title'];
			}

			$cont_row  = $this->get_file_row_by_kind( $item_row, _C_WEBPHOTO_FILE_KIND_CONT );
			$thumb_row = $this->get_file_row_by_kind( $item_row, _C_WEBPHOTO_FILE_KIND_THUMB );

			if ( is_array( $cont_row ) ) {
				$cont_mime = $cont_row['file_mime'];
			}

			list( $cont_url, $cont_width, $cont_height ) =
				$this->build_show_file_image( $cont_row );

			list( $thumb_url, $thumb_width, $thumb_height ) =
				$this->build_show_file_image( $thumb_row );

			list( $image, $width, $height ) =
				$this->build_img_url( $item_row, $this->_SHOW_IMAGE, $this->_SHOW_ICON );

			$link     = $this->_uri_class->build_photo( $item_id );
			$cat_link = $this->_uri_class->build_category( $cat_id );

			$arr = array(
				'link'        => $link,
				'cat_link'    => $cat_link,
				'title'       => $item_row['item_title'],
				'cat_name'    => $cat_title,
				'uid'         => $item_row['item_uid'],
				'hits'        => $item_row['item_hits'],
				'time'        => $time_update,

// atom
				'id'          => $item_id,
				'modified'    => $time_update,
				'issued'      => $time_create,
				'created'     => $time_create,
				'description' => $this->build_item_description( $item_row ),
			);

// photo image
			if ( $image ) {
				$arr['image']  = $image;
				$arr['width']  = $width;
				$arr['height'] = $height;
			}

// media rss
			if ( $is_image ) {
				if ( $cont_url ) {
					$arr['content_url']    = $cont_url;
					$arr['content_width']  = $cont_width;
					$arr['content_height'] = $cont_height;
					$arr['content_type']   = $cont_mime;
				}
				if ( $thumb_url ) {
					$arr['thumbnail_url']    = $thumb_url;
					$arr['thumbnail_width']  = $thumb_width;
					$arr['thumbnail_height'] = $thumb_height;
				}
			}

// geo rss
			if ( $this->_is_gmap( $item_row ) ) {
				$arr['geo_lat']  = (float) $item_row['item_gmap_latitude'];
				$arr['geo_long'] = (float) $item_row['item_gmap_longitude'];
			}

			$ret[ $i ] = $arr;
			$i ++;
		}

		return $ret;
	}


// private

	function _is_gmap( $row ) {
		if ( ( (float) $row['item_gmap_latitude'] != 0 ) ||
		     ( (float) $row['item_gmap_longitude'] != 0 ) ||
		     ( (int) $row['item_gmap_zoom'] != 0 ) ) {
			return true;
		}

		return false;
	}

}

