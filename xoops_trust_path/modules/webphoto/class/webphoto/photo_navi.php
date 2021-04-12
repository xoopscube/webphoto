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


class webphoto_photo_navi extends webphoto_lib_error {

	public $_item_handler;
	public $_image_class;

	public $_script = null;
	public $_id_array = null;

	public $_MARK_ID_FIRST = '';
	public $_MARK_ID_LAST = '';
	public $_MARK_ID_PREV = '<b>Prev</b>';
	public $_MARK_ID_NEXT = '<b>Next</b>';

	public $_max_small_width = _C_WEBPHOTO_SMALL_WIDTH;
	public $_max_small_height = _C_WEBPHOTO_SMALL_HEIGHT;
	public $_max_current_width = _C_WEBPHOTO_SMALL_CURRENT_WIDTH;
	public $_max_current_height = _C_WEBPHOTO_SMALL_CURRENT_HEIGHT;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct();

		$this->_item_handler =& webphoto_item_handler::getInstance(
			$dirname, $trust_dirname );
		$this->_image_class  =& webphoto_show_image::getInstance(
			$dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_photo_navi( $dirname, $trust_dirname );
		}

		return $instance;
	}


// set parameter

	public function set_mark_id_prev( $val ) {
		$this->_MARK_ID_PREV = $val;
	}

	public function set_mark_id_next( $val ) {
		$this->_MARK_ID_NEXT = $val;
	}


// build pagenavi
// use id (1.2.3...)

	public function build_navi( $script, $id_array, $id_current, $window = 7 ) {
		if ( ! is_array( $id_array ) ) {
			return '';
		}

		$total = count( $id_array );
		if ( $total <= 1 ) {
			return '';
		}

		$pos = array_search( $id_current, $id_array );

		$this->_script   = $script;
		$this->_id_array = $id_array;

		$half = $window / 2;

		$navi = '';
		$navi .= $this->build_link_id( 0, $this->_MARK_ID_FIRST );
		$navi .= ' &nbsp; ';

		// prev mark
		if ( $this->get_id_from_array( 0 ) != $id_current ) {
			$navi .= $this->build_link_id( ( $pos - 1 ), $this->_MARK_ID_PREV );
		}

		if ( $total > $window ) {
			if ( $pos > $half ) {
				if ( $pos > round( $total - $half - 1 ) ) {
					$start = $total - $window + 1;
				} else {
					$start = round( $pos - $half ) + 1;
				}
			} else {
				$start = 1;
			}
		} else {
			$start = 1;
		}

		for ( $i = $start; $i < $total + 1 && $i < $start + $window; $i ++ ) {
			$flag_current = false;
			if ( $this->get_id_from_array( $i - 1 ) == $id_current ) {
				$flag_current = true;
			}
			$navi .= $this->build_link_photo( ( $i - 1 ), $flag_current );
		}

		// next mark
		if ( $this->get_id_from_array( $total - 1 ) != $id_current ) {
			$navi .= $this->build_link_id( ( $pos + 1 ), $this->_MARK_ID_NEXT );
		}

		$navi .= ' &nbsp; ';
		$navi .= $this->build_link_id( ( $total - 1 ), $this->_MARK_ID_LAST );

		return $navi;
	}

	public function build_link_photo( $num, $flag_current ) {
		$title = null;

		$item_id  = $this->get_id_from_array( $num );
		$item_row = $this->_item_handler->get_cached_row_by_id( $item_id );
		if ( is_array( $item_row ) ) {
			$title = $item_row['item_title'];
			$param = $this->_image_class->build_image_by_item_row( $item_row, false );
			if ( is_array( $param ) ) {
				$img = $this->build_img( $param, $title, $flag_current );
			}
		}

		if ( empty( $img ) ) {
			$img = $num + 1;
			if ( $flag_current ) {
				$str = ' (<b>' . $img . '</b>) ';

				return $str;
			}
		}


		return $this->build_link( $item_id, $img, $title );
	}

	public function build_img( $param, $title, $flag_current ) {
		$thumb_src    = $param['img_thumb_src'];
		$thumb_width  = $param['img_thumb_width'];
		$thumb_height = $param['img_thumb_height'];

		if ( empty( $thumb_src ) ) {
			return false;
		}

		[ $width, $height ]
			= $this->adjust_size( $thumb_width, $thumb_height, $flag_current );

		$title_s = $this->sanitize( $title );
		$src_s   = $this->sanitize( $thumb_src );

		if ( $width && $height ) {
			$img = '<img src="' . $src_s . '" alt="' . $title_s . '" width="' . $width . '" height="' . $height . '" />';
		} else {
			$img = '<img src="' . $src_s . '" alt="' . $title_s . '" width="' . $width . '" />';
		}

		return $img;
	}

	public function build_link_id( $num, $name ) {
		$title = null;

		$item_id  = $this->get_id_from_array( $num );
		$item_row = $this->_item_handler->get_cached_row_by_id( $item_id );
		if ( is_array( $item_row ) ) {
			$title = $item_row['item_title'];
		}

		return $this->build_link( $item_id, $name, $title );
	}

	public function build_link( $extra, $name, $title ) {
		$href = $this->_script . $extra;

		if ( $title ) {
			$str = '<a href="' . $href . '" title="' . $this->sanitize( $title ) . '">';
		} else {
			$str = '<a href="' . $href . '" >';
		}

		$str .= $name . "</a> \n";

		return $str;
	}

	public function get_id_from_array( $num ) {
		return $this->_id_array[ $num ] ?? false;
	}


// adjust

	public function adjust_size( $width, $height, $flag_current ) {
		if ( $flag_current ) {
			return $this->adjust_current_size( $width, $height );
		}

		return $this->adjust_small_size( $width, $height );
	}

	public function adjust_small_size( $width, $height ) {

		[ $new_width, $new_height ] =
			$this->_image_class->adjust_image_size(
				$width, $height, $this->_max_small_width, $this->_max_small_height );

		if ( $new_width && $new_height ) {
			return array( $new_width, $new_height );
		}

		return array( $this->_max_small_width, 0 );
	}

	public function adjust_current_size( $width, $height ) {

		[ $new_width, $new_height ] =
			$this->_image_class->adjust_image_size(
				$width, $height, $this->_max_current_width, $this->_max_current_height );

		if ( $new_width && $new_height ) {
			return array( $new_width, $new_height );
		}

		return array( $this->_max_current_width, 0 );
	}

}
