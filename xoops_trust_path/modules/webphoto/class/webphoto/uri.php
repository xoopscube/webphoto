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


class webphoto_uri extends webphoto_inc_uri {


	public function __construct( $dirname ) {
		parent::__construct( $dirname );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_uri( $dirname );
		}

		return $instance;
	}


// buiid uri

	public function build_photo_id_title( $id, $title, $target = '_blank', $flag_amp_sanitize = true, $flag_title_sanitize = true ) {
		$str = $this->build_photo_a_href( $id, $target, $flag_amp_sanitize );
		$str .= $id;

		if ( $title ) {
			$str .= ' : ';
			if ( $flag_title_sanitize ) {
				$str .= $this->sanitize( $title );
			} else {
				$str .= $title;
			}
		}

		$str .= '</a>';

		return $str;
	}

	public function build_photo_id( $id, $target = '_blank', $flag_amp_sanitize = true ) {
		$str = $this->build_photo_a_href( $id, $target, $flag_amp_sanitize );
		$str .= $id;
		$str .= '</a>';

		return $str;
	}

	public function build_photo_title( $title, $target = '_blank', $flag_amp_sanitize = true, $flag_title_sanitize = true ) {
		$str = $this->build_photo_a_href( $id, $target, $flag_amp_sanitize );
		if ( $flag_title_sanitize ) {
			$str .= $this->sanitize( $title );
		} else {
			$str .= $title;
		}
		$str .= '</a>';

		return $str;
	}

	public function build_photo_a_href( $id, $target = '_blank', $flag_amp_sanitize = true ) {
		$url = $this->build_photo( $id, $flag_amp_sanitize );
		if ( $target ) {
			$str = '<a href="' . $url . '" target="' . $target . '">';
		} else {
			$str = '<a href="' . $url . '>';
		}

		return $str;
	}


// buiid uri

	public function build_operate( $op ) {
		if ( $this->_cfg_use_pathinfo ) {
			$str = $this->_MODULE_URL . '/index.php/' . $this->sanitize( $op ) . '/';
		} else {
			$str = $this->_MODULE_URL . '/index.php?op=' . $this->sanitize( $op );
		}

		return $str;
	}

	public function build_photo_pagenavi() {
		$str = $this->build_full_uri_mode( 'photo' );
		$str .= $this->build_part_uri_param_name();

		return $str;
	}

	public function build_photo( $id, $flag_amp_sanitize = true ) {
		return $this->build_full_uri_mode_param( 'photo', (int) $id, $flag_amp_sanitize );
	}

	public function build_category( $id, $param = null ) {
		$str = $this->build_full_uri_mode_param( 'category', (int) $id );
		$str .= $this->build_param( $param );

		return $str;
	}

	public function build_user( $id ) {
		return $this->build_full_uri_mode_param( 'user', (int) $id );
	}

	public function build_param( $param ) {
		return $this->build_uri_extention( $param );
	}


// buiid uri for show_main

	public function build_navi_url( $mode, $param, $sort, $kind, $viewtype = null ) {
		$str = $this->_MODULE_URL . '/index.php';
		$str .= $this->build_mode_param( $mode, $param, true );
		$str .= $this->build_sort( $sort );
		$str .= $this->build_kind( $kind );
		$str .= $this->build_viewtype( $viewtype );

		return $str;
	}

	public function build_param_sort( $mode, $param, $kind, $viewtype = null ) {
		$str = $this->build_mode_param( $mode, $param, true );
		$str .= $this->build_kind( $kind );
		$str .= $this->build_viewtype( $viewtype );
		$str .= $this->get_separator();

		return $str;
	}

	public function build_mode_param( $mode, $param, $flag_head_slash = false ) {
		switch ( $mode ) {
			case 'category':
			case 'user':
				$str_1 = $mode . '/' . (int) $param;
				$str_2 = '?fct=' . $mode . '&amp;p=' . (int) $param;
				break;

			case 'tag':
			case 'date':
			case 'place':
			case 'search':
				$str_1 = $mode . '/' . rawurlencode( $param );
				$str_2 = '?fct=' . $mode . '&amp;p=' . rawurlencode( $param );
				break;

			default:
				$str_1 = $this->sanitize( $mode );
				$str_2 = '?op=' . $this->sanitize( $mode );
				break;
		}

		if ( $this->_cfg_use_pathinfo ) {
			if ( $flag_head_slash ) {
				$str = '/' . $str_1;
			} else {
				$str = $str_1;
			}
		} else {
			$str = $str_2;
		}

		return $str;
	}

	public function build_sort( $val ) {
		return $this->build_param_str( 'sort', $val );
	}

	public function build_kind( $val ) {
		return $this->build_param_str( 'kind', $val );
	}

	public function build_viewtype( $val ) {
		return $this->build_param_str( 'viewtype', $val );
	}

	public function build_page( $val ) {
		return $this->build_param_int( 'page', $val );
	}

	public function build_param_str( $name, $val ) {
		$str = '';
		if ( $val ) {
			$str = $this->_SEPARATOR . $name . '=' . $this->sanitize( $val );
		}

		return $str;
	}

	public function build_param_int( $name, $val ) {
		$str = '';
		if ( $val ) {
			$str = $this->_SEPARATOR . $name . '=' . (int) $val;
		}

		return $str;
	}


// buiid uri for show_list

	public function build_list_link( $mode, $param ) {
// not sanitize
		if ( $this->_cfg_use_pathinfo ) {
			$str = 'index.php/' . $mode . '/' . rawurlencode( $param ) . '/';
		} else {
			$str = 'index.php?fct=' . $mode . '&p=' . rawurlencode( $param );
		}

		return $str;
	}

}
