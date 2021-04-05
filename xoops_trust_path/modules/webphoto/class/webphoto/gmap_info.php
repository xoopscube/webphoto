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


class webphoto_gmap_info extends webphoto_base_this {


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_IMG_EDIT = '<img src="' . $this->_ICONS_URL . '/edit.png" width="18" height="15" border="0" alt="' . _WEBPHOTO_TITLE_EDIT . '" title="' . _WEBPHOTO_TITLE_EDIT . '" />';
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_gmap_info( $dirname, $trust_dirname );
		}

		return $instance;
	}


// gmap

	public function build_info( $param ) {
		return $this->build_info_default( $param );
	}

	public function build_info_default( $param ) {
		$info = '<div style="text-align:center; font-size: 80%; ">';
		$info .= $this->build_info_thumb( $param );
		$info .= $this->build_info_title( $param );
		$info .= $this->build_info_author( $param );
		$info .= $this->build_info_datetime( $param );
		$info .= $this->build_info_place( $param );
		$info .= '</div>';

		return $info;
	}

	public function build_info_thumb( $param ) {
		$a_photo   = $this->build_a_photo( $param );
		$img_thumb = $this->build_img_thumb( $param );

		$str = null;
		if ( $img_thumb && $a_photo ) {
			$str = $a_photo . $img_thumb . '</a><br>';
		} elseif ( $img_thumb ) {
			$str = $img_thumb . '<br>';
		}

		return $str;
	}

	public function build_info_title( $param ) {
		$str = '';

		$title_s = $this->sanitize( $param['item_title'] );
		$a_photo = $this->build_a_photo( $param );

		if ( $this->has_editable_by_uid( $param['item_uid'] ) ) {
			$href = $this->_MODULE_URL . '/index.php?fct=edit&amp;photo_id=' . intval( $param['item_id'] );
			$str  .= '<a href="' . $href . '" target="_top" >';
			$str  .= $this->_IMG_EDIT;
			$str  .= '</a> ';
		}

		if ( $title_s && $a_photo ) {
			$str .= $a_photo . $title_s . '</a><br>';
		} elseif ( $title_s ) {
			$str .= $title_s . '<br>';
		}

		return $str;
	}

	public function build_info_author( $param ) {
		$uid   = intval( $param['item_uid'] );
		$href  = $this->build_uri_user( $uid );
		$uname = $this->get_xoops_uname_by_uid( $uid );
		if ( $uid > 0 ) {
			$str = '<a href="' . $href . '">';
			$str .= $uname . '</a><br>';
		} else {
			$str = $uname . '<br>';
		}

		return $str;
	}

	public function build_info_datetime( $param ) {
		$datetime_disp = $this->mysql_datetime_to_str( $param['item_datetime'] );
		if ( $datetime_disp ) {
			$str = $datetime_disp . '<br>';

			return $str;
		}

		return null;
	}

	public function build_info_place( $param ) {
		$place_s = $this->sanitize( $param['item_place'] );
		if ( $place_s ) {
			$str = $place_s . '<br>';

			return $str;
		}

		return null;
	}

	public function build_img_thumb( $param ) {
		$title_s = $this->sanitize( $param['item_title'] );
		$url_s   = $this->sanitize( $param['thumb_url'] );
		$width   = (int) $param['thumb_width'];
		$height  = (int) $param['thumb_height'];

		$img = null;
		if ( $url_s && $width && $height ) {
			$img = '<img src="' . $url_s . '" width="' . $width . '"  height="' . $height . '" alt="' . $title_s . ' "border="0" />';
		} elseif ( $url_s ) {
			$img = '<img src="' . $url_s . '" alt="' . $title_s . '" border="0" />';
		}

		return $img;
	}

	public function build_a_photo( $param ) {
		$href   = $this->build_href_photo( $param );
		$target = $this->build_target_photo( $param );
		if ( $href && $target ) {
			$str = '<a href="' . $href . '" target="' . $target . '">';

			return $str;
		}

		return null;
	}

	public function build_href_photo( $param ) {
		return $this->build_uri_photo( $param['item_id'] );
	}

	public function build_target_photo( $param ) {
		$str = '_top';
		if ( ! $this->check_normal_ext( $param ) ) {
			$str = '_blank';
		}

		return $str;
	}

	public function check_normal_ext( $param ) {
		return $this->is_normal_ext( $param['item_ext'] );
	}

}
