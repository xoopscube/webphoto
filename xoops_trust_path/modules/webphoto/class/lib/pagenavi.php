<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * class webphoto_lib_pagenavi
 * base on happy_linux_pagenavi
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_lib_pagenavi {

//	public $_MAX_PAGELIST = 10;

// input parameter
	public $_perpage = - 1;
	public $_total = - 1;
	public $_page = - 1;
	public $_position = - 1;

// GET POST parameter
	public $_sortid = - 1;
	public $_page_current = 0;

// local
	public $_script;
	public $_start;
	public $_end;
	public $_flag_sortid = 0;
	public $_sort_arr = array();
	public $_id_array = array();

	public $_SEPARATOR_PATH = '?';
	public $_SEPARATOR_QUERY = '&';

	public $_MARK_PREV = '<b>&laquo;</b>';
	public $_MARK_NEXT = '<b>&raquo;</b>';

	public $_MARK_ID_FIRST = '';
	public $_MARK_ID_LAST = '';
	public $_MARK_ID_PREV = '<b>Prev</b>';
	public $_MARK_ID_NEXT = '<b>Next</b>';

	public $_PAGE_NAME = 'page';
	public $_PERPAGE_NAME = 'perpage';
	public $_SORTID_NAME = 'sortid';

	public $_MIN_SORTID = 0;
	public $_MAX_SORTID = 0;
	public $_MIN_TOTAL = 0;
	public $_MIN_PAGE = 1;
	public $_MIN_PERPAGE = 1;

	public $_PERPAGE_DEFAULT = 10;
	public $_SORTID_DEFAULT = 0;

	public $_FLAG_DEBUG_MSG = false;
	public $_FLAG_DEBUG_TRACE = false;


	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_pagenavi();
		}

		return $instance;
	}

// Public
// same as XoopsPageNav
// use positon (start offset 0.10.20...)

	public function XoopsPageNav( $total, $perpage, $position, $start_name = 'start', $extra_arg = '' ) {
		$this->_total    = (int) $total;
		$this->_perpage  = (int) $perpage;
		$this->_position = (int) $position;

		$amp = '';
		if ( ( $extra_arg != '' ) && ! $this->_check_tail_amp( $extra_arg ) ) {
			$amp = '&amp;';
		}

		$url           = xoops_getenv( 'PHP_SELF' ) . '?' . $extra_arg . $amp . trim( $start_name ) . '=';
		$this->_script = $this->_sanitize_url( $url );
	}

	public function renderNav( $offset = 4 ) {
		$navi = '';

		if ( $this->_total <= $this->_perpage ) {
			return $navi;
		}

		$total_pages = $this->_calc_total_pages( $this->_total, $this->_perpage );
		if ( $total_pages <= 1 ) {
			return $navi;
		}

		$prev_pos = $this->_position - $this->_perpage;
		$next_pos = $this->_position + $this->_perpage;
		$current  = $this->_position_to_page( $this->_position, $this->_perpage );

// prev mark
		if ( $prev_pos >= 0 ) {
			$navi .= $this->_build_link( $prev_pos, $this->_MARK_PREV );
		}

		for ( $i = 1; $i <= $total_pages; $i ++ ) {

// current page
			if ( $i == $current ) {
				$navi .= '<b>(' . $i . ')</b> ';

// within offset, first , last
			} elseif ( $this->_check_within( $i, $current, $offset ) || $i == 1 || $i == $total_pages ) {

// at last
				if ( ( $i == $total_pages ) && ( $current < $total_pages - $offset ) ) {
					$navi .= '... ';
				}

//			$navi .= '<a href="'. $this->_url . $this->_page_to_position( $i , $this->_perpage ) .'">'.$i.'</a> ';
				$navi .= $this->_build_link( $this->_page_to_position( $i, $this->_perpage ), $i );

// at first
				if ( ( $i == 1 ) && ( $current > 1 + $offset ) ) {
					$navi .= '... ';
				}

			}
		}

// next mark
		if ( $this->_total > $next_pos ) {
			$navi .= $this->_build_link( $next_pos, $this->_MARK_NEXT );

		}

		return $navi;
	}

	public function _calc_total_pages( $total, $perpage ) {
		return ceil( $total / $perpage );
	}

	public function _check_within( $page, $current, $offset ) {
		return ( $page > $current - $offset ) && ( $page < $current + $offset );
	}

	public function _position_to_page( $position, $perpage ) {
		return (int) floor( ( $position + $perpage ) / $perpage );
	}

	public function _page_to_position( $page, $perpage ) {
		$pos = ( $page - 1 ) * $perpage;
		if ( $pos < 0 ) {
			$pos = 0;
		}

		return $pos;
	}

	public function _check_tail_amp( $str ) {
		if ( substr( $str, - 5 ) == '&amp;' ) {
			return true;
		} elseif ( substr( $str, - 1 ) == '&' ) {
			return true;
		}

		return false;
	}

	public function _build_link( $extra, $name ) {
		return '<a href="' . $this->_script . $extra . '" >' . $name . "</a> \n";
	}


// build pagenavi
// use page (1.2.3...)

	public function build( $script, $page = - 1, $perpage = - 1, $total = - 1, $window = 8 ) {
		$page = $this->_get_page_internal( $page );
		if ( $page === false ) {
			return false;
		}

		$perpage = $this->_get_perpage_internal( $perpage );
		if ( $perpage === false ) {
			return false;
		}

		$total = $this->_get_total_internal( $total );
		if ( $total === false ) {
			return false;
		}

		if ( $perpage >= $total ) {
			return '';
		}

		$total_pages = $this->_calc_total_pages( $total, $perpage );
		if ( $total_pages <= 1 ) {
			return '';
		}

		if ( empty( $script ) ) {
			$script = xoops_getenv( 'PHP_SELF' );
		}

		$this->_script = $this->_sanitize_url( $this->add_script_pagename( $script ) );

// Page Numbering
		$page_last    = $total_pages;
		$page_current = $this->_adjust_page( $page, $total_pages );

		$prev = $page_current - 1;
		$next = $page_current + 1;

		$half = (int) ( $window / 2 );

		$start = $this->_MIN_PAGE;
		$end   = $page_last;

		if ( $page_last > ( $page_current + $half ) ) {
			$start = $page_current - $half;

			if ( $start < $this->_MIN_PAGE ) {
				$start = $this->_MIN_PAGE;
			}

			$end = $start + $window;

			if ( $end > $page_last ) {
				$end = $page_last;
			}

		} elseif ( $page_last > $window ) {
			$end = $page_current + $half;

			if ( $end > $page_last ) {
				$end = $page_last;
			}

			$start = $end - $window;

			if ( $start < $this->_MIN_PAGE ) {
				$start = $this->_MIN_PAGE;
			}

		}

		$navi = '';

// Build Link - Prev mark
		if ( $prev > 0 ) {
			$navi .= $this->_build_link( $prev, $this->_MARK_PREV );

		}

		if ( $start > $this->_MIN_PAGE ) {
			$navi .= $this->_build_link( $this->_MIN_PAGE, '[' . $this->_MIN_PAGE . ']' );
			if ( ( $start - 1 ) > $this->_MIN_PAGE ) {
				$navi .= ' ... ';
			}
		}

		for ( $i = $start; $i <= $end; $i ++ ) {
			if ( $i == $page_current ) {
				$navi .= '<b>(' . $i . ')</b> ';

			} else {
				$navi .= $this->_build_link( $i, $i );
			}
		}

		if ( $page_last > $end ) {
			if ( $page_last > ( $end + 1 ) ) {
				$navi .= ' ... ';
			}
			$navi .= $this->_build_link( $page_last, '[' . $page_last . ']' );
		}

// Build Link - Next mark
		if ( $page_last >= $next ) {
			$navi .= $this->_build_link( $next, $this->_MARK_NEXT );
		}

		return $navi;
	}


// build pagenavi
// use id (1.2.3...)

	public function build_id_array( $script, $id_array, $id_current, $window = 7 ) {
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
		$navi .= $this->build_link_id_array( 0, $this->_MARK_ID_FIRST );
		$navi .= ' &nbsp; ';

		// prev mark
		if ( $this->_get_id_array( 0 ) != $id_current ) {
			$navi .= $this->build_link_id_array( ( $pos - 1 ), $this->_MARK_ID_PREV );
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
			if ( $this->_get_id_array( $i - 1 ) == $id_current ) {
				$navi .= '(' . $i . ') ' . "\n";
			} else {
				$navi .= $this->build_link_id_array( ( $i - 1 ), $i );
			}
		}

		// next mark
		if ( $this->_get_id_array( $total - 1 ) != $id_current ) {
			$navi .= $this->build_link_id_array( ( $pos + 1 ), $this->_MARK_ID_NEXT );
		}

		$navi .= ' &nbsp; ';
		$navi .= $this->build_link_id_array( ( $total - 1 ), $this->_MARK_ID_LAST );

		return $navi;
	}

	public function build_link_id_array( $num, $name ) {
		return $this->_build_link( $this->_get_id_array( $num ), $name );
	}

	public function _get_id_array( $num ) {
		return $this->_id_array[ $num ] ?? false;
	}


// calc start end

	public function calc_page( $page = - 1, $perpage = - 1, $total = - 1 ) {
		$page = $this->_get_page_internal( $page );
		if ( $page === false ) {
			return false;
		}

		$perpage = $this->_get_perpage_internal( $perpage );
		if ( $perpage === false ) {
			return false;
		}

		$total = $this->_get_total_internal( $total );
		if ( $total === false ) {
			return false;
		}

		$total_pages = $this->_calc_total_pages( $total, $perpage );
		if ( $total_pages < 1 ) {
			return $this->_MIN_PAGE;
		}

		return $this->_adjust_page( $page, $total_pages );
	}

	public function calc_start( $page = - 1, $perpage = - 1 ) {
		$page = $this->_get_page_internal( $page );
		if ( $page === false ) {
			return false;
		}

		$perpage = $this->_get_perpage_internal( $perpage );
		if ( $perpage === false ) {
			return false;
		}

		return $this->_page_to_position( $page, $perpage );
	}

	public function calc_end( $start, $perpage = - 1, $total = - 1 ) {
		$perpage = $this->_get_perpage_internal( $perpage );
		if ( $perpage === false ) {
			return false;
		}

		$total = $this->_get_total_internal( $total );
		if ( $total === false ) {
			return false;
		}

		$end = $start + $perpage;

		if ( $end > $total ) {
			$end = $total;
		}

		return $end;
	}


// GET paramter

	public function set_page_by_get() {
		$this->set_page( $this->get_page_from_get() );
	}

	public function set_perpage_by_get() {
		$this->set_perpage( $this->get_perpage_from_get() );
	}

	public function set_sortid_by_get() {
		$this->set_sortid( $this->get_sortid_from_get() );
	}

	public function get_page_from_get() {
		$val = $this->get_get_int( $this->_PAGE_NAME );
		if ( $val < $this->_MIN_PAGE ) {
			$val = $this->_MIN_PAGE;
		}

		return $val;
	}

	public function get_perpage_from_get() {
		$val = $this->get_get_int( $this->_PERPAGE_NAME, $this->_PERPAGE_DEFAULT );
		if ( $val < $this->_MIN_PERPAGE ) {
			$val = $this->_MIN_PERPAGE;
		}

		return $val;
	}

	public function get_sortid_from_get() {
		$val = $this->get_get_int( $this->_SORTID_NAME, $this->_SORTID_DEFAULT );
		$val = $this->_adjust_sortid( $val );

		return $val;
	}

	public function get_get_int( $key, $default = 0 ) {
		return isset( $_GET[ $key ] ) ? (int) $_GET[ $key ] : (int) $default;
	}


// set and get parameter

	public function set_total( $val ) {
		$this->_total = (int) $val;
	}

	public function set_page( $val ) {
		$this->_page = (int) $val;
	}

	public function set_perpage( $val ) {
		$this->_perpage = (int) $val;
	}

	public function set_sortid( $val ) {
		$this->_sortid = (int) $val;
	}

	public function set_perpage_default( $val ) {
		$this->_PERPAGE_DEFAULT = (int) $val;
	}

	public function set_sortid_default( $val ) {
		$this->_SORTID_DEFAULT = (int) $val;
	}

	public function set_max_sortid( $val ) {
		$this->_MAX_SORTID = (int) $val;
	}

	public function set_separator_path( $val ) {
		$this->_SEPARATOR_PATH = $val;
	}

	public function set_separator_query( $val ) {
		$this->_SEPARATOR_QUERY = $val;
	}

	public function set_mark_id_prev( $val ) {
		$this->_MARK_ID_PREV = $val;
	}

	public function set_mark_id_next( $val ) {
		$this->_MARK_ID_NEXT = $val;
	}

	public function set_flag_debug_msg( $val ) {
		$this->_FLAG_DEBUG_MSG = (bool) $val;
	}

	public function set_flag_debug_trace( $val ) {
		$this->_FLAG_DEBUG_TRACE = (bool) $val;
	}

	public function get_total() {
		return $this->_total;
	}

	public function get_page() {
		return $this->_page;
	}

	public function get_perpage() {
		return $this->_perpage;
	}

	public function get_sortid() {
		return $this->_sortid;
	}

	public function get_perpage_default( $val ) {
		$this->_PERPAGE_DEFAULT = (int) $val;
	}

	public function get_max_sortid() {
		return $this->_MAX_SORTID;
	}

	public function get_separator_path() {
		return $this->_SEPARATOR_PATH;
	}

	public function get_separator_query() {
		return $this->_SEPARATOR_QUERY;
	}

	public function _get_page_internal( $val ) {
		$val = (int) $val;
		if ( $val < $this->_MIN_PAGE ) {
			if ( $this->_page >= $this->_MIN_PAGE ) {
				$val = $this->_page;
			} else {
				$this->_debug_msg( 'not set page' );

				return false;
			}
		}

		return $val;
	}

	public function _get_perpage_internal( $val ) {
		$val = (int) $val;
		if ( $val < $this->_MIN_PERPAGE ) {
			if ( $this->_perpage >= $this->_MIN_PERPAGE ) {
				$val = $this->_perpage;
			} else {
				$this->_debug_msg( 'not set perpage' );

				return false;
			}
		}

		return $val;
	}

	public function _get_total_internal( $val ) {
		$val = (int) $val;
		if ( $val < $this->_MIN_TOTAL ) {
			if ( $this->_total >= $this->_MIN_TOTAL ) {
				$val = $this->_total;
			} else {
				$this->_debug_msg( 'not set total' );

				return false;
			}
		}

		return $val;
	}

	public function _get_sortid_internal( $val ) {
		$val = (int) $val;
		if ( $val < $this->_MIN_SORTID ) {
			if ( $this->_sortid >= $this->_MIN_SORTID ) {
				$val = $this->_sortid;
			} else {
				$this->_debug_msg( 'not set sortid' );

				return false;
			}
		}

		return $val;
	}


// sort parameter

	public function clear_sort() {
		$this->_MAX_SORTID = 0;
		$this->_sort_arr   = array();
	}

	public function add_sort( $title, $sort, $order = 'ASC' ) {
		if ( strtoupper( $order ) == 'DESC' ) {
			$order = 'DESC';
		} else {
			$order = 'ASC';
		}

		$this->_sort_arr[ $this->_MAX_SORTID ] = array(
			'title' => $title,
			'sort'  => $sort,
			'order' => $order,
		);

		$this->_MAX_SORTID ++;
	}

	public function get_sort( $sortid = - 1 ) {
		$sortid = $this->_get_sortid_internal( $val );
		if ( $sortid === false ) {
			return false;
		}

		$sortid = $this->_adjust_sortid( $sortid );

		return $this->_sort_arr[ $sortid ] ?? false;
	}

	public function get_sort_value( $key, $sort_id = - 1 ) {
		$sortid = $this->_get_sortid_internal( $val );
		if ( $sortid === false ) {
			return false;
		}

		$sortid = $this->_adjust_sortid( $sortid );

		return $this->_sort_arr[ $sortid ][ $key ] ?? false;
	}



// add script
//
// sortid:
//   normal: add sortid and page
//       ex) foo.php? sortid=$sortid
//   -1: substitute local variable
//       ex) foo.php? sortid=$this->_sortid
//   -2: dont add sortid
//       ex) foo.php

	public function add_script_sortid( $script, $separator = null ) {
		if ( $this->_sortid > $this->_MIN_SORTID ) {
			if ( empty( $separator ) ) {
				$separator = $this->_get_seprator_from_script( $script );
			}
			$script .= $separator . $this->_SORTID_NAME . '=' . $this->_sortid;
		}

		return $script;
	}

	public function add_script_perpage( $script, $separator = null ) {
		if ( $this->_perpage > $this->_MIN_PERPAGE ) {
			if ( empty( $separator ) ) {
				$separator = $this->_get_seprator_from_script( $script );
			}
			$script .= $separator . $this->_PERPAGE_NAME . '=' . $this->_perpage;
		}

		return $script;
	}

	public function add_script_pagename( $script, $separator = null ) {
		if ( empty( $separator ) ) {
			$separator = $this->_get_seprator_from_script( $script );
		}
		$str = $script . $separator . $this->_PAGE_NAME . '=';

		return $str;
	}

	public function _get_seprator_from_script( $script ) {
		return $this->_get_separator_from_type( $this->_analyze_script_type( $script ) );
	}

	public function _get_separator_from_type( $type ) {
		if ( $type == 1 ) {
			$str = '';
		} elseif ( $type == 2 ) {
			$str = $this->_SEPARATOR_QUERY;
		} else {
			$str = $this->_SEPARATOR_PATH;
		}

		return $str;
	}


// analyze_script_type
//
// script:
//   type 0: foo.php
//   type 1: foo.php?
//   type 2: foo.php?bar=abc

	public function _analyze_script_type( $script ) {
		$type = 0;    // foo.php

// set script_type, if ? in script
		if ( preg_match( '/\?/', $script ) ) {
			$script_arr = explode( '?', $script );
			if ( $script_arr[1] ) {
				$type = 2;    // foo.php?bar=abc
			} else {
				$type = 1;    // foo.php?
			}
		}

		return $type;
	}


// adjust

	public function _adjust_page( $page, $total_pages ) {
		if ( $page < $this->_MIN_PAGE ) {
			$page = $this->_MIN_PAGE;
		} elseif ( $page > $total_pages ) {
			$page = $total_pages;
		}

		return $page;
	}

	public function _adjust_sortid( $val ) {
		$val = (int) $val;
		if ( $val < $this->_MIN_SORTID ) {
			$val = $this->_MIN_SORTID;
		}
		if ( $val > $this->_MAX_SORTID ) {
			$val = $this->_MAX_SORTID;
		}

		return $val;
	}


// sanitize

	public function _sanitize_url( $str ) {
		$str = $this->_deny_javascript( $str );
		$str = preg_replace( '/&amp;/i', '&', $str );
		$str = htmlspecialchars( $str, ENT_QUOTES );

		return $str;
	}

// Checks if Javascript are included in string
	public function _deny_javascript( $str ) {
		$str = preg_replace( '/[\x00-\x1F]/', '', $str );
		$str = preg_replace( '/[\x7F]/', '', $str );

		if ( preg_match( '/javascript:/si', $str ) ) {
			return '';    // include Javascript
		}
		if ( preg_match( '/about:/si', $str ) ) {
			return '';    // include about
		}
		if ( preg_match( '/vbscript:/si', $str ) ) {
			return '';    // include vbscript
		}

		return $str;
	}


// debug

	public function _debug_msg( $msg ) {
		if ( $this->_FLAG_DEBUG_MSG ) {
			echo $msg;
		}
		if ( $this->_FLAG_DEBUG_TRACE && function_exists( 'debug_print_backtrace' ) ) {
			debug_print_backtrace();
		}
	}

}
