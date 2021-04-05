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


define( '_C_WEBPHOTO_SR_SQL_NO_CAN', 31 );
define( '_C_WEBPHOTO_SR_SQL_CAN', 32 );
define( '_C_WEBPHOTO_SR_SQL_MERGE', 33 );

define( '_C_WEBPHOTO_SR_HANKAKU', 35 );
define( '_C_WEBPHOTO_SR_ZENKAKU', 36 );

define( '_C_WEBPHOTO_SR_ERR_KEYTOOSHORT', - 1 );

// for Japanese EUC-JP
define( '_C_WEBPHOTO_SR_ZENKAKU_EISU', '/\xA3[\xC1-\xFA]/' );
define( '_C_WEBPHOTO_SR_HANKAKU_EISU', '/[A-Za-z0-9]/' );
define( '_C_WEBPHOTO_SR_ZENKAKU_KANA', '/\xA5[\xA1-\xF6]/' );
define( '_C_WEBPHOTO_SR_HANKAKU_KANA', '/\x8E[\xA6-\xDF]/' );


// xoops system files

global $xoopsConfig;
$XOOPS_LANGUAGE = $xoopsConfig['language'];

if ( file_exists( XOOPS_ROOT_PATH . '/language/' . $XOOPS_LANGUAGE . '/search.php' ) ) {
	include_once XOOPS_ROOT_PATH . '/language/' . $XOOPS_LANGUAGE . '/search.php';
} else {
	include_once XOOPS_ROOT_PATH . '/language/english/search.php';
}

// class webphoto_lib_search
class webphoto_lib_search {

// post
	public $_post_action;
	public $_post_andor;
	public $_post_query;
	public $_post_uid;
	public $_post_mid;
	public $_post_start;
	public $_post_mids;
	public $_post_showcontext;

// input param
	public $_min_keyword = 5;
	public $_flag_candidate = true;
	public $_flag_candidate_once = false;

// result
	public $_query;
	public $_query_raw_array;
	public $_query_array;
	public $_ignore_array;
	public $_candidate_array;
	public $_candidate_keyword_array;
	public $_merged_query_array;
	public $_mode_andor;
	public $_sel_and;
	public $_sel_or;
	public $_sel_exact;
	public $_sql_andor;
	public $_sql_query_array;
	public $_query_urlencode;
	public $_merged_urlencode;

// local
	public $_time_start;
	public $_is_japanese;

	public $_LANG_ZENKAKU = 'zenkaku';
	public $_LANG_HANKAKU = 'hankaku';

	public $_MAX_ARRAY_DEPTH = 10;

	public $_EXCEPT_PLUS = true;
	public $_EXCEPT_COMMA = true;
	public $_EXCEPT_SLASH = true;


	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_search();
		}

		return $instance;
	}

// set param
	public function set_min_keyword( $value ) {
		$this->_min_keyword = (int) $value;
	}

	public function set_flag_candidate( $value ) {
		$this->_flag_candidate = (int) $value;
	}

	public function set_flag_candidate_once( $value ) {
		$this->_flag_candidate_once = (int) $value;
	}

	public function set_lang_zenkaku( $value ) {
		$this->_LANG_ZENKAKU = $value;
	}

	public function set_lang_hankaku( $value ) {
		$this->_LANG_HANKAKU = $value;
	}

	public function set_is_japanese( $val ) {
		return $this->_is_japanese = (bool) $val;
	}


// get $_POST & $_GET

	public function get_post_get_param() {
		$this->get_post_get_action();
		$this->get_post_get_query();
		$this->get_post_get_andor();
		$this->get_post_get_uid();
		$this->get_post_get_mid();
		$this->get_post_get_start();
		$this->get_post_get_mids();
		$this->get_post_get_showcontext();
	}

	public function get_post_get_action( $default = 'search' ) {
		$action = $this->_get_post_get_text( 'action' );

		switch ( $action ) {
			case 'search';
			case 'results':
			case 'showall':
			case 'showallbyuser':
				$ret = $action;
				break;

			default:
				$ret = $default;
				break;
		}

		$this->_post_action = $ret;

		return $ret;
	}

	public function get_post_get_andor( $default = 'AND' ) {
		$andor = $this->_get_post_get_text( 'andor' );

		switch ( $andor ) {
			case 'AND';
			case 'OR';
			case 'exact';
				$ret = $andor;
				break;

			default:
				$ret = $default;
				break;
		}

		$this->_post_andor = $ret;

		return $ret;
	}

	public function get_post_get_query() {
		$this->_post_query = trim( $this->_get_post_get_text( 'query' ) );

		return $this->_post_query;
	}

	public function get_post_get_uid() {
		$this->_post_uid = $this->_get_post_get_int( 'uid' );

		return $this->_post_uid;
	}

	public function get_post_get_mid() {
		$this->_post_mid = $this->_get_post_get_int( 'mid' );

		return $this->_post_mid;
	}

	public function get_post_get_start() {
		$this->_post_start = $this->_get_post_get_int( 'start' );

		return $this->_post_start;
	}

	public function get_post_get_mids() {
		$this->_post_mids = $this->_get_post_get( 'mids' );

		return $this->_post_mids;
	}

	public function get_post_get_showcontext( $default = 1 ) {
		$this->_post_showcontext = $this->_get_post_get_int( 'showcontext', $default );

		return $this->_post_showcontext;
	}

	public function set_query( $val ) {
		$this->_post_query = trim( $val );
	}

// parse query
	public function parse_query_default() {
		$ret = $this->parse_query(
			$this->_post_query,
			$this->_post_andor,
			false
		);

		return $ret;
	}

	public function parse_query( $query = '', $andor = '', $gpc = true ) {
		if ( $query && $gpc ) {
			$query = $this->_strip_slashes_gpc( $query );
		} elseif ( empty( $query ) ) {
			$query = $this->_post_query;
		}

		if ( empty( $andor ) ) {
			$andor = $this->_post_andor;
		}

		$this->_query                   = $query;
		$this->_query_raw_array         = array();
		$this->_query_array             = array();
		$this->_ignore_array            = array();
		$this->_candidate_array         = array();
		$this->_candidate_keyword_array = array();
		$this->_merged_query_array      = array();
		$this->_mode_andor              = '';
		$this->_sel_and                 = '';
		$this->_sel_or                  = '';
		$this->_sel_exact               = '';

		if ( $query == '' ) {
			return false;
		}

		if ( ( $andor != "OR" ) && ( $andor != "exact" ) && ( $andor != "AND" ) ) {
			$andor = "AND";
		}

		if ( $andor == 'exact' ) {
			$this->_query_array = array( $query );
			$this->_sel_exact   = 'selected';

		} else {
			$this->query_to_array( $query );

			if ( $andor == 'OR' ) {
				$this->_sel_or = 'selected';
			} else {
				$this->_sel_and = 'selected';
			}

		}

		$this->_mode_andor = $andor;

		if ( count( $this->_query_array ) == 0 ) {
			return false;
		}

		$this->_merged_query_array = $this->_merge_unique_array( $this->_query_array, $this->_candidate_keyword_array );

		return true;
	}

	public function query_to_array( $query ) {
		$this->_query_raw_array         = array();
		$this->_query_array             = array();
		$this->_ignore_array            = array();
		$this->_candidate_array         = array();
		$this->_candidate_keyword_array = array();

		$query_str = $this->_convert_space_zen_to_han( $query );
		if ( $this->_EXCEPT_PLUS ) {
			$query_str = str_replace( '+', ' ', $query_str );
		}
		if ( $this->_EXCEPT_COMMA ) {
			$query_str = str_replace( ',', ' ', $query_str );
		}
		if ( $this->_EXCEPT_SLASH ) {
			$query_str = str_replace( '/', ' ', $query_str );
		}

		$temp_arr = preg_split( '/[\s]+/', $query_str );

		foreach ( $temp_arr as $q ) {
			$q = trim( $q );
			if ( $q != '' ) {
				$this->_query_raw_array[] = $q;
			}
			if ( strlen( $q ) >= $this->_min_keyword ) {
				$this->_query_array[] = $q;
				$this->_build_candidate( $q );
			} else {
				$this->_ignore_array[] = $q;
			}
		}

		return $this->_query_raw_array;
	}

// build query
	public function build_sql_query( $field_name ) {
		$where = '';
		$code  = $this->check_build_sql_query_array();
		switch ( $code ) {
			case _C_WEBPHOTO_SR_SQL_NO_CAN:
			case _C_WEBPHOTO_SR_SQL_MERGE:
				$query_array = $this->_sql_query_array;
				$where       = $this->build_single_double_where(
					$field_name, $query_array, null, $this->_sql_andor );
				break;

			case _C_WEBPHOTO_SR_SQL_CAN:
				$query_array = $this->_query_array;
				$where       = $this->build_single_double_where(
					$field_name, $query_array, $this->_candidate_keyword_array, $this->_mode_andor );
				break;
		}

		return $where;
	}

	public function check_build_sql_query_array( $query_array = '', $candidate_keyword_array = '', $andor = '' ) {
		if ( empty( $candidate_keyword_array ) ) {
			$candidate_keyword_array = $this->_candidate_keyword_array;
		}

		if ( empty( $query_array ) ) {
			$query_array = $this->_query_array;
		}

		if ( empty( $andor ) ) {
			$andor = $this->_mode_andor;
		}

		$this->_sql_andor       = $andor;
		$this->_sql_query_array = $query_array;

		if ( is_array( $candidate_keyword_array ) && ( count( $candidate_keyword_array ) > 0 ) ) {
			if ( ( count( $query_array ) == 1 ) || ( $andor == 'OR' ) ) {
				$this->_build_sql_query_array( $candidate_keyword_array, $query_array, $andor );

				return _C_WEBPHOTO_SR_SQL_MERGE;

			} else {
				return _C_WEBPHOTO_SR_SQL_CAN;
			}
		}

		return _C_WEBPHOTO_SR_SQL_NO_CAN;
	}

	public function _build_sql_query_array( $query_array, $candidate_keyword_array, $andor ) {
		$this->_sql_andor       = 'OR';
		$this->_sql_query_array = $this->_merge_unique_array( $query_array, $candidate_keyword_array );
	}

// build sql
	public function build_single_double_where( $field_name, $query_array1, $query_array2 = null, $andor = 'AND' ) {
		$where  = '';
		$where1 = '';
		$where2 = '';

		if ( is_array( $query_array1 ) && ( count( $query_array1 ) > 0 ) ) {
			$where1 = $this->build_single_where( $field_name, $query_array1, $andor );
		}

		if ( is_array( $query_array2 ) && ( count( $query_array2 ) > 0 ) ) {
			$where2 = $this->build_single_where( $field_name, $query_array2, $andor );
		}

		if ( $where1 && $where2 ) {
			$where = ' ( ' . $where1 . ' OR ' . $where2 . ' ) ';
		} elseif ( $where1 ) {
			$where = $where1;
		} elseif ( $where2 ) {
			$where = $where2;
		}

		return $where;
	}

	public function build_multi_where( $field_name_array, $query_array, $andor = 'AND' ) {
		$where = '';
		$arr   = array();

		if ( is_array( $field_name_array ) && ( count( $field_name_array ) > 0 ) ) {
			foreach ( $field_name_array as $name ) {
				$arr[] = $this->_build_single_where( $name, $query_array, $andor );
			}
		}

		if ( count( $arr ) > 0 ) {
			$where = ' ( ';
			$where .= implode( ' OR ', $arr );
			$where .= ' ) ';
		}

		return $where;
	}

	public function build_single_where( $field_name, $query_array, $andor = 'AND' ) {
		$where = '';

		if ( is_array( $query_array ) ) {
			$count = count( $query_array );

			if ( $count > 0 ) {
				$q     = addslashes( $query_array[0] );
				$where .= " ( " . $field_name . " LIKE '%" . $q . "%' ";

				for ( $i = 1; $i < $count; $i ++ ) {
					$q     = addslashes( $query_array[ $i ] );
					$where .= $andor . " ";
					$where .= $field_name . " LIKE '%" . $q . "%' ";
				}

				$where .= ") ";
			}
		}

		return $where;
	}

// get query
	public function get_query_param() {
		return array(
			'search_query'              => $this->get_query_raw(),
			'search_query_array'        => $this->get_query_array(),
			'search_keywords'           => $this->get_query_array(),
			'search_ignores'            => $this->get_ignore_array(),
			'search_candidates'         => $this->get_candidate_array(),
			'search_show_ignore'        => $this->get_count_ignore_array(),
			'search_show_candidate'     => $this->get_count_candidate_array(),
			'search_merged_urlencode'   => $this->get_merged_urlencode(),
			'search_lang_keytooshort'   => $this->get_lang_keytooshort(),
			'search_lang_keyignore'     => $this->get_lang_keyignore(),
			'search_lang_ignoredwors'   => $this->get_lang_ignoredwords(),
			'search_lang_searchresults' => _SR_SEARCHRESULTS,
			'search_lang_keywords'      => _SR_KEYWORDS,
		);
	}

	public function get_query_raw( $format = null ) {
		$ret = $this->_array_to_str( $this->_query_raw_array, ' ' );
		if ( $format == 's' ) {
			$ret = $this->_sanitize( $ret );
		}

		return $ret;
	}

	public function get_query_for_form( $glue = ' ', $format = 's' ) {
		return $this->implode_query_array( $this->_query_array, $glue, $format );
	}

	public function get_query_for_google( $glue = '+', $format = null ) {
		return $this->implode_query_array( $this->_query_array, $glue, $format );
	}

	public function get_query_urlencode() {
		return $this->urlencode_implode_array( $this->_query_array );
	}

	public function get_query_array( $format = 's' ) {
		if ( $format ) {
			$arr = $this->_sanitize_array( $this->_query_array );
		} else {
			$arr = $this->_query_array;
		}

		return $arr;
	}

	public function get_merged_query_array() {
		return $this->_merged_query_array;
	}

	public function get_merged_urlencode() {
		return $this->_urlencode_from_array( $this->_merged_query_array );
	}

	public function implode_query_array( $arr, $glue = ' ', $format = null ) {
		$ret = $this->_array_to_str( $arr, $glue );
		if ( $format == 's' ) {
			$ret = $this->_sanitize( $ret );
		}

		return $ret;
	}

// get param
	public function get_action( $format = null ) {
		$ret = $this->_post_action;
		if ( $format == 's' ) {
			$ret = $this->_sanitize( $ret );
		}

		return $ret;
	}

	public function get_start() {
		return (int) $this->_post_start;
	}

	public function get_andor() {
		return $this->_mode_andor;
	}

	public function get_and() {
		return $this->_sel_and;
	}

	public function get_or() {
		return $this->_sel_or;
	}

	public function get_exact() {
		return $this->_sel_exact;
	}

	public function get_ignore_array( $format = 's' ) {
		if ( $format ) {
			$arr = $this->_sanitize_array( $this->_ignore_array );
		} else {
			$arr = $this->_ignore_array;
		}

		return $arr;
	}

	public function get_candidate_array( $format = 's' ) {
		if ( $format ) {
			$arr = $this->_sanitize_array( $this->_candidate_array );
		} else {
			$arr = $this->_candidate_array;
		}

		return $arr;
	}

	public function get_candidate_keyword_array() {
		return $this->_candidate_keyword_array;
	}

	public function get_count_query_array() {
		if ( is_array( $this->_query_array ) ) {
			return count( $this->_query_array );
		}

		return false;
	}

	public function get_count_ignore_array() {
		if ( is_array( $this->_ignore_array ) ) {
			return count( $this->_ignore_array );
		}

		return false;
	}

	public function get_count_candidate_array() {
		if ( is_array( $this->_candidate_array ) ) {
			return count( $this->_candidate_array );
		}

		return false;
	}

	public function get_sql_andor() {
		return $this->_sql_andor;
	}

	public function get_sql_query_array() {
		return $this->_sql_query_array;
	}

	public function get_lang_keytooshort() {
		return sprintf( _SR_KEYTOOSHORT, $this->_min_keyword );
	}

	public function get_lang_keyignore() {
		return sprintf( _SR_KEYIGNORE, $this->_min_keyword );
	}

	public function get_lang_ignoredwords() {
		return sprintf( _SR_IGNOREDWORDS, $this->_min_keyword );
	}

// xoops param
	public function get_xoops_config_search_enable_search() {
		$config_handler    =& xoops_gethandler( 'config' );
		$xoopsConfigSearch =& $config_handler->getConfigsByCat( XOOPS_CONF_SEARCH );

		return $xoopsConfigSearch['enable_search'];
	}

	public function get_xoops_config_search_keyword_min() {
		$config_handler    =& xoops_gethandler( 'config' );
		$xoopsConfigSearch =& $config_handler->getConfigsByCat( XOOPS_CONF_SEARCH );

		return $xoopsConfigSearch['keyword_min'];
	}

// Private
// convert for Japanese EUC-JP
// porting from suin's search <http://suin.jp/>
	private function _convert_space_zen_to_han( $str ) {
		if ( $this->_is_japanese && function_exists( 'mb_convert_kana' ) ) {
			return mb_convert_kana( $str, "s" );
		}

		return $str;
	}

	private function _build_candidate( $q ) {
		if ( ! $this->_flag_candidate ) {
			return;
		}

		if ( ! $this->_is_japanese || ! function_exists( 'mb_convert_kana' ) ) {
			return;
		}

// Zenkaku Eisu
// option a: Convert "zen-kaku" alphabets and numbers to "han-kaku"
		if ( preg_match( _C_WEBPHOTO_SR_ZENKAKU_EISU, $q ) ) {
			$keyword = mb_convert_kana( $q, 'a' );
			$this->_set_candidate_array( $q, $keyword, _C_WEBPHOTO_SR_HANKAKU );

			if ( $this->_flag_candidate_once ) {
				return;
			}
		}

// Hankaku Eisu	
// option A: Convert "han-kaku" alphabets and numbers to "zen-kaku" 
// (Characters included in "a", "A" options are U+0021 - U+007E excluding U+0022, U+0027, U+005C, U+007E)
		if ( preg_match( _C_WEBPHOTO_SR_HANKAKU_EISU, $q ) ) {
			$keyword = mb_convert_kana( $q, 'A' );
			$this->_set_candidate_array( $q, $keyword, _C_WEBPHOTO_SR_ZENKAKU );

			if ( $this->_flag_candidate_once ) {
				return;
			}
		}

// Zenkaku Katakana	
// option k: Convert "zen-kaku kata-kana" to "han-kaku kata-kana"
// option c: Convert "zen-kaku kata-kana" to "zen-kaku hira-kana"
		if ( preg_match( _C_WEBPHOTO_SR_ZENKAKU_KANA, $q ) ) {
			$keyword_k = mb_convert_kana( $q, 'k' );
			$this->_set_candidate_array( $q, $keyword_k, _C_WEBPHOTO_SR_HANKAKU );

			if ( $this->_flag_candidate_once ) {
				return;
			}

			$keyword_c = mb_convert_kana( $q, 'c' );
			$this->_set_candidate_array( $q, $keyword_c, _C_WEBPHOTO_SR_ZENKAKU );

			if ( $this->_flag_candidate_once ) {
				return;
			}
		}

// Hankaku Katakana	
// option K: Convert "han-kaku kata-kana" to "zen-kaku kata-kana"
// option H: Convert "han-kaku kata-kana" to "zen-kaku hira-kana"
// option V: Collapse voiced sound notation and convert them into a character. Use with "K","H"
		if ( preg_match( _C_WEBPHOTO_SR_HANKAKU_KANA, $q ) ) {
			$keyword_kv = mb_convert_kana( $q, 'KV' );
			$this->_set_candidate_array( $q, $keyword_kv, _C_WEBPHOTO_SR_ZENKAKU );

			if ( $this->_flag_candidate_once ) {
				return;
			}

			$keyword_hv = mb_convert_kana( $q, 'HV' );
			$this->_set_candidate_array( $q, $keyword_hv, _C_WEBPHOTO_SR_ZENKAKU );

			if ( $this->_flag_candidate_once ) {
				return;
			}
		}

// option h: Convert "zen-kaku hira-kana" to "han-kaku kata-kana"
// option C: Convert "zen-kaku hira-kana" to "zen-kaku kata-kana"
		$keyword_h  = mb_convert_kana( $q, 'h' );
		$keyword_cc = mb_convert_kana( $q, 'C' );

		if ( $q != $keyword_h ) {
			$this->_set_candidate_array( $q, $keyword_h, _C_WEBPHOTO_SR_HANKAKU );

			if ( $this->_flag_candidate_once ) {
				return;
			}
		}

		if ( $q != $keyword_cc ) {
			$this->_set_candidate_array( $q, $keyword_cc, _C_WEBPHOTO_SR_ZENKAKU );

			if ( $this->_flag_candidate_once ) {
				return;
			}
		}
	}

	public function _set_candidate_array( $q, $keyword, $type ) {
		if ( strlen( $keyword ) < $this->_min_keyword ) {
			return;
		}

		if ( $q == $keyword ) {
			return;
		}

		$this->_candidate_keyword_array[] = $keyword;

		if ( $type == _C_WEBPHOTO_SR_ZENKAKU ) {
			$this->_candidate_array[] = array(
				'keyword' => $keyword,
				'type'    => _C_WEBPHOTO_SR_ZENKAKU,
				'lang'    => $this->_LANG_ZENKAKU,
			);

		} else {
			$this->_candidate_array[] = array(
				'keyword' => $keyword,
				'type'    => _C_WEBPHOTO_SR_HANKAKU,
				'lang'    => $this->_LANG_HANKAKU,
			);
		}
	}

// utility for array
	public function _merge_unique_array( $arr1, $arr2 ) {
		$arr = false;
		if ( is_array( $arr1 ) && is_array( $arr2 ) ) {
			$arr = array_merge( $arr1, $arr2 );
			$arr = array_unique( $arr );
		}

		return $arr;
	}

	public function _implode_array( $glue, $arr ) {
		$val = false;
		if ( is_array( $arr ) && count( $arr ) ) {
			$val = implode( $glue, $arr );
		}

		return $val;
	}

	public function _urlencode_from_array( $arr, $glue = ' ' ) {
		return urlencode( $this->_array_to_str( $arr, $glue ) );
	}

	public function _str_to_array( $str, $pattern ) {
		$arr1 = explode( $pattern, $str );
		$arr2 = array();
		foreach ( $arr1 as $v ) {
			$v = trim( $v );
			if ( $v == '' ) {
				continue;
			}
			$arr2[] = $v;
		}

		return $arr2;
	}

	public function _array_to_str( $arr, $glue ) {
		if ( is_array( $arr ) && count( $arr ) ) {
			return implode( $glue, $arr );
		}

		return false;
	}

// post
	public function _get_post_get( $key, $default = null ) {
		$str = $default;
		if ( isset( $_POST[ $key ] ) ) {
			$str = $_POST[ $key ];
		} elseif ( isset( $_GET[ $key ] ) ) {
			$str = $_GET[ $key ];
		}

		return $str;
	}

	public function _get_post_get_text( $key, $default = null ) {
		return $this->_strip_slashes_gpc( $this->_get_post_get( $key, $default ) );
	}

	public function _get_post_get_int( $key, $default = 0 ) {
		return (int) $this->_get_post_get( $key, $default );
	}

	public function _strip_slashes_gpc( $str ) {
		if ( get_magic_quotes_gpc() && ! is_array( $str ) ) {
			$str = stripslashes( $str );
		}

		return $str;
	}

// sanitize
	public function _sanitize( $str ) {
		return htmlspecialchars( $str, ENT_QUOTES );
	}

	public function _sanitize_array( $arr_in ) {
		return $this->_sanitize_array_recursive( 0, $arr_in );
	}

	public function _sanitize_array_recursive( $num, $arr_in ) {
		$num ++;
		if ( $num > $this->_MAX_ARRAY_DEPTH ) {
			return false;
		}

		if ( is_array( $arr_in ) ) {
			$arr_out = array();
			reset( $arr_in );

			foreach ( $arr_in as $k => $v ) {
				if ( is_array( $v ) ) {
					$arr_out[ $k ] = $this->_sanitize_array_recursive( $num, $v );
				} else {
					$arr_out[ $k ] = $this->_sanitize( $v );
				}
			}

			return $arr_out;
		}

		return $this->_sanitize( $arr_in );
	}
}
