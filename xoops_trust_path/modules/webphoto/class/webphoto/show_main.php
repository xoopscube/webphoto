<?php
// $Id: show_main.php,v 1.24 2009/12/24 06:32:22 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

//---------------------------------------------------------
// change log
// 2009-12-06 K.OHWADA
// Fatal error: Call to undefined method build_uri_list_navi_url()
// build_uri_list_navi_url()
// 2009-11-11 K.OHWADA
// $trust_dirname in webphoto_photo_public
// 2009-10-25 K.OHWADA
// get_photo_kind_name_by_pathinfo()
// 2009-05-30 K.OHWADA
// BUG : not show cat_id
// 2009-05-17 K.OHWADA
// $show_photo_desc -> $show_summary in build_common_param()
// 2009-05-05 K.OHWADA
// Undefined variable: photos 
// 2009-04-19 K.OHWADA
// build_cat_sub_title()
// 2009-04-18 K.OHWADA
// BUG: not show description
// 2009-04-10 K.OHWADA
// webphoto_page
// 2009-03-15 K.OHWADA
// webphoto_timeline
// 2009-01-25 K.OHWADA
// webphoto_inc_xoops_header -> webphoto_xoops_header
// get_gmap_center()
// 2008-12-12 K.OHWADA
// webphoto_photo_public
// 2008-12-07 K.OHWADA
// build_photo_show() -> build_photo_show_main()
// 2008-11-29 K.OHWADA
// webphoto_inc_catlist
// 2008-11-08 K.OHWADA
// build_show_imgurl()
// 2008-10-01 K.OHWADA
// use QRS_DIR
// 2008-08-24 K.OHWADA
// photo_handler -> item_handler
// added build_qr_code()
// used preload_init()
// 2008-07-01 K.OHWADA
// used build_uri_category() build_main_navi_url() etc
//---------------------------------------------------------

if( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

//=========================================================
// class webphoto_show_main
//=========================================================
class webphoto_show_main extends webphoto_show_photo
{
	public $_page_class;
	public $_user_handler;
	public $_pathinfo_class;
	public $_gmap_class;
	public $_header_class;
	public $_pagenavi_class;
	public $_d3_notification_select_class;
	public $_sort_class;
	public $_rate_check_class;
	public $_public_class ;
	public $_timeline_class ;

	public $_sort_name;

// pathinfo param
	public $_get_op;
	public $_get_sort;
	public $_get_kind;
	public $_get_page;

	public $_use_box_js;

	public $_mode       = null;
	public $_list_mode  = null;
	public $_navi_mode  = null;
	public $_param      = null;
	public $_param_out  = null;

	public $_init_timeline ;

// set by config
	public $_MAX_PHOTOS;
	public $_MAX_GMAPS;
	public $_MAX_TAG_CLOUD;
	public $_VIEWTYPE_DEFAULT;
	public $_USE_POPBOX_JS;
	public $_TEMPLATE_MAIN = null ;

	public $_SORT_ARRAY = array();

	public $_PAGE_DEFAULT  = 1;

	public $_get_uid     = -1;	// not set
	public $_UID_DEFAULT = -1;	// not set

	public $_ACTION_DEFAULT  = 'latest';

	public $_TOP_CATLIST_COLS    = 3;
	public $_TOP_CATLIST_DELMITA = '<br>';
	public $_CAT_CATLIST_COLS    = 3;
	public $_CAT_CATLIST_DELMITA = '<br>';

	public $_PHOTO_LIST_LIMIT      = 1;
	public $_PHOTO_LIST_ORDER      = 'item_time_update DESC, item_id DESC';
	public $_PHOTO_LIST_DATE_ORDER = 'item_datetime DESC, item_id DESC';
	public $_ORDERBY_RANDOM = 'rand()';
	public $_ORDERBY_ASC    = 'item_id ASC';
	public $_ORDERBY_LATEST = 'item_time_update DESC, item_id DESC';

	public $_MODE_DEFAULT = 'latest';
	public $_RSS_LIMIT    = 100;

	public $_OFFSET_ZERO = 0 ;
	public $_KEY_TRUE    = true ;
	public $_KEY_NAME    = 'item_id' ;

	public $_QR_MODULE_SIZE = 3;

// show
	public $_SHOW_RSS          = true;
	public $_SHOW_CAT_SUB      = true;
	public $_SHOW_CAT_MAIN_IMG = true;
	public $_SHOW_CAT_SUB_IMG  = true;

// kind
	public $_PHOTO_KIND_ARRAY = array(
		'latest', 'new', 'popular', 'random', 'video', 'picture', 'office' );
	public $_PHOTO_KIND_DEFAULT = 'latest';

	public $_DEBUG_PRELOAD = false ;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
public function __construct( $dirname, $trust_dirname )
{
	parent::__construct( $dirname, $trust_dirname);
	//$this->webphoto_show_photo( $dirname, $trust_dirname );

	$this->_user_handler     
		=& webphoto_user_handler::getInstance( $dirname, $trust_dirname );
	$this->_page_class       
		=& webphoto_page::getInstance( $dirname , $trust_dirname );
	$this->_gmap_class       
		=& webphoto_gmap::getInstance( $dirname , $trust_dirname );
	$this->_rate_check_class 
		=& webphoto_rate_check::getInstance( $dirname, $trust_dirname );
	$this->_public_class     
		=& webphoto_photo_public::getInstance( $dirname, $trust_dirname  );

	$this->_header_class     =& webphoto_xoops_header::getInstance( $dirname );
	$this->_pathinfo_class   =& webphoto_lib_pathinfo::getInstance();

	$this->_notification_select_class =& webphoto_d3_notification_select::getInstance();
	$this->_notification_select_class->init( $dirname ); 

	$this->_pagenavi_class =& webphoto_lib_pagenavi::getInstance();
	$this->_pagenavi_class->set_mark_id_prev( '<b>'. $this->get_constant('NAVI_PREVIOUS') .'</b>' );
	$this->_pagenavi_class->set_mark_id_next( '<b>'. $this->get_constant('NAVI_NEXT') .'</b>' );

	$this->_MAX_PHOTOS       = $this->_cfg_newphotos;
	$this->_MAX_GMAPS        = $this->_cfg_gmap_photos;
	$this->_MAX_TAG_CLOUD    = $this->_cfg_tags;
	$this->_VIEWTYPE_DEFAULT = $this->_cfg_viewcattype;
	$this->_USE_POPBOX_JS    = $this->_cfg_use_popbox;

	$this->_use_box_js = $this->_page_class->get_use_box_js();

	$this->_sort_class =& webphoto_photo_sort::getInstance( $dirname, $trust_dirname );
	$this->_sort_class->set_photo_sort_default( $this->_cfg_sort );

// separator
	if ( $this->_cfg_use_pathinfo ) {
		$this->_pagenavi_class->set_separator_path(  '/' );
		$this->_pagenavi_class->set_separator_query( '/' );
	}

// auto publish
	$this->auto_publish();
}

public static function &getInstance( $dirname = null, $trust_dirname = null )
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_show_main( $dirname, $trust_dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// preload
//---------------------------------------------------------
function init_preload()
{
	$this->preload_init();
	$this->preload_error( $this->_DEBUG_PRELOAD );
	$this->preload_constant();
	$this->_preload_photo_sort_array();

	$this->_page_class->init_preload();

	$this->_timeline_class =& webphoto_timeline::getInstance( $this->_DIRNAME );
	$this->_init_timeline = $this->_timeline_class->init( $this->_cfg_timeline_dirname );
}

function _preload_photo_sort_array()
{
	if ( $this->_preload_class->exists_class( 'show_main' ) ) {
		$arr = $this->_preload_class->exec_class_method(
			'show_main', 'get_photo_sort_array_extend' );
		if ( is_array($arr) && count($arr) ) {
			$this->_sort_class->set_photo_sort_array( $arr );
		}
	}
}

//---------------------------------------------------------
// mode
//---------------------------------------------------------
function set_mode( $val )
{
	$this->_mode      = $val;
	$this->_list_mode = $val;
}

// for myphoto
function set_list_mode( $val )
{
	$this->_list_mode = $val;
}

// for photo
function set_navi_mode( $val )
{
	$this->_navi_mode = $val;
}

//---------------------------------------------------------
// template
//---------------------------------------------------------
function set_template_main( $val )
{
	$this->_TEMPLATE_MAIN = $val;
}

function get_template_main()
{
	$str = $this->_DIRNAME .'_'. $this->_TEMPLATE_MAIN ;
	return $str;
}

//---------------------------------------------------------
// build param
//---------------------------------------------------------
function build_main_param( $mode, $show_summary=false )
{
// BUG: not show description
	$param = $this->build_common_param( $mode, $show_summary );
	$param['param_sort'] = $this->build_uri_main_sort( $mode ) ;
	return $param;
}

function build_common_param( $mode, $show_summary=false, $cat_id=0 )
{
	$param = array_merge( 
		$this->page_build_main_param( $mode, $cat_id ) ,
		$this->build_get_param( $mode ) 
	);
	$param['show_photo_summary'] = $show_summary ;
	return $param;
}

function build_get_param( $mode )
{
	$arr = array(
		'op'                => $this->_get_op,
		'page'              => $this->_get_page,
		'sort'              => $this->_get_sort,
		'lang_cursortedby'  => $this->get_lang_sortby( $this->_get_sort ),
	);
	return $arr;
}

function build_param_viewtype( $mode )
{
	return null ;	// dummy
}

//---------------------------------------------------------
// build list
//---------------------------------------------------------
function build_list_common( $const_name, $show_photo_desc=false )
{
	$title_s   = $this->sanitize( $this->get_constant( $const_name ) );
	$total_all = $this->_public_class->get_count();

	$arr = array(
		'xoops_pagetitle'   => $title_s ,
		'title_bread_crumb' => $title_s,
		'sub_title_s'       => $title_s ,
		'show_photo_desc'   => $show_photo_desc ,
		'use_popbox_js'     => $this->_USE_POPBOX_JS ,
		'use_box_js'        => $this->_use_box_js ,
		'photo_total_all'   => $total_all ,
		'lang_thereare'     => sprintf( $this->get_constant('S_THEREARE') , $total_all ),
		'photo_list'        => $this->get_photo_list() ,
	);

	return $arr;
}

// for overwrite
function get_photo_list()
{
	// dummy
}

//---------------------------------------------------------
// show
//---------------------------------------------------------
function build_photo_show_from_rows( $rows )
{
	$arr = array();
	foreach ( $rows as $row ) {
		$arr[] = $this->build_photo_show_main( $row ) ;
	}
	return $arr;
}

function build_photo_show_from_id_array( $id_array )
{
	$arr = array();
	foreach ( $id_array as $id )
	{
		$arr[] = $this->build_photo_show_main( 
			$this->_item_handler->get_row_by_id( $id ) ) ;
	}
	return $arr;
}

function build_photo_show_main( $row )
{
	$arr = $this->build_photo_show( $row ) ;
	$arr['can_rate'] = $this->_rate_check_class->can_rate( $row['item_id'] ) ;
	return $arr;
}

function build_show_sort( $total )
{
	if ( $total > 1 ) {
		return true;
	}
	return false;
}

function build_show_nomatch( $total )
{
	if ( $total == 0 ) {
		return true;
	}
	return false;
}

//---------------------------------------------------------
// catlist
//---------------------------------------------------------
function build_catlist( $cat_id, $cols, $delmita )
{
	$show = false ;

	list( $cats, $cols, $width ) =
		$this->_public_class->build_catlist( 
			$cat_id, $this->_SHOW_CAT_SUB, $cols ) ;

	if ( is_array($cats) && count($cats) ) {
		$show = true ;
	}

	$catlist = array(
		'cats'            => $cats ,
		'cols'            => $cols ,
		'width'           => $width ,
		'delmita'         => $delmita ,
		'show_sub'        => $this->_SHOW_CAT_SUB ,
		'show_main_img'   => $this->_SHOW_CAT_MAIN_IMG ,
		'show_sub_img'    => $this->_SHOW_CAT_SUB_IMG ,
		'main_width'      => $this->_cfg_cat_main_width ,
		'sub_width'       => $this->_cfg_cat_sub_width ,
		'lang_total'      => $this->get_constant( 'CAPTION_TOTAL' ) ,
	);

	$arr = array(
		'show_catlist'     => $show,
		'cfg_use_pathinfo' => $this->_cfg_use_pathinfo ,
		'catlist'          => $catlist,
	);

	return $arr ;
}

//---------------------------------------------------------
// cat handler
//---------------------------------------------------------
function build_cat_path( $cat_id )
{
	$rows = $this->_cat_handler->get_parent_path_array( $cat_id );
	if ( !is_array($rows) || !count($rows) ) {
		return false;
	}

	$arr   = array();
	$count = count($rows);
	$last  = $count - 1;

	for ( $i = $last ; $i >= 0; $i-- ) {
		$arr[] = $this->_public_class->build_cat_show( $rows[ $i ] );
	}

	$ret = array();
	$ret['list']  = $arr;
	$ret['first'] = $arr[ 0 ];
	$ret['last']  = $arr[ $last ];

	return $ret;
}

function build_cat_desc_disp( $row )
{
	return $this->_cat_handler->build_show_desc_disp( $row ) ; 
}

//---------------------------------------------------------
// random more
//---------------------------------------------------------
function list_build_random_more( $total, $url=null )
{
	if ( empty($url) ) {
		$url = $this->build_uri_list_link( $this->_param_out ) ;
	}
	return $this->build_random_more_url_with_check_sort( $url, $total );
}

function build_random_more_url_with_check_sort( $url, $total, $get_sort=null, $flag_sanitize=true )
{
	if ( $total == 0 ) {
		return null;
	}

	if ( empty($get_sort) ) {
		$get_sort = $this->_get_sort;
	}

	if ( $get_sort != 'random' ) {
		return null;
	}

	$url .= 'sort=random/';

	if ( $flag_sanitize ) {
		$url = $this->sanitize( $url );
	}

	return $url;
}

//---------------------------------------------------------
// sort class
//---------------------------------------------------------
function get_orderby_by_post()
{
	return $this->_sort_class->sort_to_orderby( $this->_get_sort );
}

function get_orderby_default()
{
	return $this->_sort_class->sort_to_orderby( null );
}

function get_lang_sortby( $name )
{
	return $this->_sort_class->get_lang_sortby( $name );
}

function convert_orderby_join( $str )
{
	return $this->_sort_class->convert_orderby_join( $str );
}

//---------------------------------------------------------
// pagenavi class
//---------------------------------------------------------
function build_navi( $url, $total, $limit, $get_page=null )
{
	if ( empty($get_page) ) {
		$get_page = $this->_get_page;
	}

	$show      = false ;
	$navi_page = '' ;
	$navi_info = '' ;

	if ( $total > $limit ) {
		$show      = true ;
		$navi_page = $this->build_navi_page( $url, $get_page, $limit, $total ) ;
		$navi_info = $this->build_navi_info( $get_page, $limit, $total );
	}

	$arr = array(
		'show_navi'  => $show ,
		'navi_page'  => $navi_page ,
		'navi_info'  => $navi_info ,
	);
	return $arr;
}

function build_navi_page( $url, $page, $limit, $total )
{
	return $this->_pagenavi_class->build( $url, $page, $limit, $total );
}

function build_navi_info( $page, $limit, $total )
{
	$start = $this->pagenavi_calc_start( $limit, $page );
	$end   = $this->pagenavi_calc_end( $start, $limit, $total );

	return sprintf( $this->get_constant('S_NAVINFO') , $start + 1 , $end , $total ) ;
}

function pagenavi_calc_start( $limit, $page=null )
{
	if ( empty($page) ) {
		$page = $this->_get_page;
	}

	return $this->_pagenavi_class->calc_start( $page, $limit );
}

function pagenavi_calc_end( $start, $limit, $total )
{
	return $this->_pagenavi_class->calc_end( $start, $limit, $total );
}

//---------------------------------------------------------
// gmap class
//---------------------------------------------------------
function build_gmap( $cat_id=0, $limit )
{
	$rows = $this->_public_class->get_rows_by_gmap( $cat_id, $limit );
	return $this->build_gmap_from_rows( $rows, $cat_id );
}

function build_gmap_param( $rows )
{
	$latest_rows = $this->_public_class->get_rows_by_gmap_latest( $this->_MAX_GMAPS, $this->_OFFSET_ZERO, $this->_KEY_TRUE );

	$all_rows = $this->_gmap_class->array_merge_unique( $latest_rows, $rows );

	if ( is_array($all_rows) && count($all_rows)  ) {
		return $this->build_gmap_from_rows( $all_rows );
	}

	$arr = array(
		'show_gmap' => false ,
	);
	return $arr;
}

function build_gmap_from_rows( $rows, $cat_id=0 )
{
	$mode  = $this->_mode; 
	$show  = false;
	$icons = null;

// Undefined variable: photos 
	$photos = null;

	list( $code, $latitude, $longitude, $zoom ) =
		$this->_gmap_class->get_gmap_center( 0, $cat_id );

	if ( is_array($rows) && count($rows) ) {
		$photos = $this->_gmap_class->build_show_from_rows( $rows );
		if ( is_array($photos) && count($photos) ) {
			$show  = true;
			$icons = $this->_gmap_class->build_icon_list();
		}
	}

	$arr = array(
		'show_gmap'       => $show ,
		'gmap_photos'     => $photos ,
		'gmap_icons'      => $icons ,
		'gmap_latitude'   => $latitude,
		'gmap_longitude'  => $longitude,
		'gmap_zoom'       => $zoom,
		'gmap_class'      => $this->get_gmap_class( $mode ) ,
		'show_map_large'  => ! $this->is_map_mode( $mode ) ,
		'gmap_lang_not_compatible' => $this->get_constant('GMAP_NOT_COMPATIBLE') ,
	);
	return $arr;
}

function get_gmap_class( $mode )
{
	if ( $this->is_map_mode( $mode ) ) {
		return 'webphoto_gmap_large';
	}
	return 'webphoto_gmap_normal';
}

function is_map_mode( $mode )
{
	if ( $mode == 'map' ) {
		return true;
	}
	return false;
}

//---------------------------------------------------------
// timeline class
//---------------------------------------------------------
function build_timeline_param( $unit, $date, $rows )
{
	$latest = $this->get_config_by_name('timeline_latest');
	$random = $this->get_config_by_name('timeline_random');

	$latest_rows = $this->_public_class->get_rows_by_orderby( 
		$this->_ORDERBY_LATEST, $latest, $this->_OFFSET_ZERO, $this->_KEY_TRUE );

	$random_rows = $this->_public_class->get_rows_by_orderby( 
		$this->_ORDERBY_RANDOM, $random, $this->_OFFSET_ZERO, $this->_KEY_TRUE );

	$all_rows = $this->_utility_class->array_merge_unique( $random_rows, $latest_rows, $this->_KEY_NAME );
	$all_rows = $this->_utility_class->array_merge_unique( $all_rows,    $rows,        $this->_KEY_NAME );

	if ( is_array($all_rows) && count($all_rows)  ) {
		$photos = $this->build_photo_show_from_rows( $all_rows );
		return $this->build_timeline( $unit, $date, $photos );
	}

	$arr = array(
		'show_timeline' => false ,
	);
	return $arr;
}

function build_timeline( $unit, $date, $photos )
{
	$mode    = $this->_mode; 
	$show    = false ;
	$js      = null ;
	$element = null;

	if ( $this->_init_timeline ) {
		$param = $this->_timeline_class->fetch_timeline( 
			'painter', $unit, $date, $photos );
		$js      = $param['timeline_js'] ;
		$element = $param['timeline_element'] ;
		$show    = true ;
	}

	$is_timeline_mode = $this->is_timeline_mode( $mode );

	$arr = array(
		'show_timeline'       => $show ,
		'show_timeline_large' => ! $is_timeline_mode ,
		'show_timeline_unit'  => $is_timeline_mode ,
		'timeline_class'      => $this->get_timeline_class( $mode ) ,
		'timeline_js'         => $js ,
		'timeline_element'    => $element ,
	);
	return $arr;
}

function get_timeline_class( $mode )
{
	if ( $this->is_timeline_mode( $mode ) ) {
		return 'webphoto_timeline_large';
	}
	return 'webphoto_timeline_normal';
}

function is_timeline_mode( $mode )
{
	if ( $mode == 'timeline' ) {
		return true;
	}
	return false;
}

//---------------------------------------------------------
// notification select class
//---------------------------------------------------------
function build_notification_select( $cat_id=0 )
{
	$show  = false;
	$param = null;

// for core's notificationSubscribableCategoryInfo
	$_SERVER['PHP_SELF'] = $this->_notification_select_class->get_new_php_self();
	if ( $cat_id > 0 ) {
		$_GET['cat_id'] = $cat_id;
	}

	$param = $this->_notification_select_class->build( $this->_cfg_use_pathinfo );
	if ( is_array($param) && count($param) ) {
		$show  = true;
	}

	$arr = array(
		'show_notification_select' => $show ,
		'notification_select'      => $param ,
	);
	return $arr;
}

//---------------------------------------------------------
// uri class
//---------------------------------------------------------
function build_uri_main_navi_url( $mode )
{
	return $this->_uri_class->build_main_navi_url( $mode, $this->_get_sort );
}

function build_uri_main_sort( $mode )
{
	return $this->_uri_class->build_main_sort( $mode );
}

function get_uri_list_pathinfo_param()
{
// list_mode for myphoto
	return $this->_uri_class->get_list_pathinfo_param( $this->_list_mode );
}

// Fatal error: Call to undefined method build_uri_list_navi_url()
function build_uri_list_navi_url( $mode, $param, $kind )
{
	return $this->_uri_class->build_list_navi_url( 
		$mode, $param, $kind );
}

function build_uri_list_navi_url_kind( $mode, $param, $kind )
{
	return $this->_uri_class->build_list_navi_url_kind( 
		$mode, $param, $kind );
}

function build_uri_list_kind( $mode, $param, $viewtype=null )
{
	return $this->_uri_class->build_list_sort(
		$mode, $param, $viewtype );
}

function build_uri_list_link( $param )
{
	return $this->_uri_class->build_list_link( $this->_mode, $param );
}

//---------------------------------------------------------
// get pathinfo param
//---------------------------------------------------------
function get_pathinfo_param()
{
	$this->_get_op   = $this->get_pathinfo_op() ;
	$this->_get_page = $this->get_pathinfo_page() ;
	$this->_get_sort = $this->get_photo_sort_name_by_pathinfo();
	$this->_get_kind = $this->get_photo_kind_name_by_pathinfo();
	$this->_param    = $this->get_uri_list_pathinfo_param() ;
	$this->set_param_out( $this->_param );
}

function get_pathinfo_op()
{
	$op = $this->_pathinfo_class->get('op');
	if ( $op ) { return $op ; }

	return $this->_pathinfo_class->get_path( 0 ) ;
}

function get_pathinfo_page()
{
	$page = $this->_pathinfo_class->get_int('page');
	if ( $page < $this->_PAGE_DEFAULT ) {
		 $page = $this->_PAGE_DEFAULT ;
	}
	return $page ;
}

function get_photo_sort_name_by_pathinfo()
{
	return $this->_sort_class->get_photo_sort_name(
		$this->_pathinfo_class->get_text( 'sort' ) );
}

function get_photo_kind_name_by_pathinfo()
{
	return $this->get_photo_kind_name(
		$this->_pathinfo_class->get_text( 'kind' ) );
}

function get_photo_kind_name( $name )
{
	if ( $name && in_array( $name, $this->_PHOTO_KIND_ARRAY ) ) {
		return $name ;
	} elseif( in_array( $this->_PHOTO_KIND_DEFAULT, $this->_PHOTO_KIND_ARRAY ) ) {
		return $this->_PHOTO_KIND_DEFAULT ;
	}
	return false;
}

function set_param_out( $val )
{
	$this->_param_out = $val;
}

//---------------------------------------------------------
// page class
//---------------------------------------------------------
function check_show_catlist( $mode )
{
	return $this->check_show_common( $mode, 'catlist' );
}

function check_show_tagcloud( $mode )
{
	return $this->check_show_common( $mode, 'tagcloud' );
}

function check_show_gmap( $mode )
{
	return $this->check_show_common( $mode, 'gmap' );
}

function check_show_timeline( $mode )
{
	return $this->check_show_common( $mode, 'timeline' );
}

function check_show_notification( $mode )
{
	return $this->check_show_common( $mode, 'notification' );
}

function check_show_desc( $mode )
{
	return $this->check_show_common( $mode, 'desc' );
}

function check_show_navi_sort( $sort )
{
	return $this->check_show_common( $sort, 'navi_sort' );
}

function check_show_navi( $mode, $sort )
{
	return $this->_page_class->check_show_navi( $mode, $sort );
}

function check_show_common( $mode, $name )
{
	return $this->_page_class->check_show_common( $mode, $name );
}

// BUG : not show cat_id
function page_build_main_param( $mode, $cat_id=0 )
{
	return $this->_page_class->build_main_param( $mode, $cat_id ) ;
}

function add_show_js_windows( $param )
{
	return $this->_page_class->add_show_js_windows( $param );
}

function build_box_list( $param )
{
	return $this->_page_class->build_box_list( $param );
}

//---------------------------------------------------------
// auto plublish
//---------------------------------------------------------
function auto_publish()
{
	$publish_class =& webphoto_inc_auto_publish::getSingleton( 
		$this->_DIRNAME, $this->_TRUST_DIRNAME  );
	$publish_class->set_workdir( $this->_WORK_DIR );
	$publish_class->auto_publish();
}

//---------------------------------------------------------
// qr code
//---------------------------------------------------------
function create_mobile_qr( $id )
{
	$file = $this->_QRS_DIR.'/'.$this->build_mobile_filename( $id );
	if ( !is_file( $file) ) {
		$qrimage=new Qrcode_image;
		$qrimage->set_module_size( $this->_QR_MODULE_SIZE ); 
		$qrimage->qrcode_image_out( $this->build_mobile_url( $id ), 'png', $file );
	}
}

function build_mobile_url( $id )
{
	$url = $this->_MODULE_URL.'/i.php';
	if ( $id > 0 ) {
		$url .= '?id='.$id;
	}
	return $url;
}

function build_mobile_filename( $id )
{
	$file = 'qr_index.png';
	if ( $id > 0 ) {
		$file = 'qr_id_'.$id.'.png';
	}
	return $file;
}

function get_mobile_email()
{
	$row = $this->_user_handler->get_row_by_uid( $this->_xoops_uid );
	if ( is_array($row) ) {
		return $row['user_email'] ;
	}
	return null;
}

//---------------------------------------------------------
// xoops header
//---------------------------------------------------------
function assign_xoops_header_default()
{
	$this->assign_xoops_header( $this->_MODE_DEFAULT );
}

function assign_xoops_header( $mode, $rss_param=null, $flag_gmap=false )
{
	$param = array(
		'dirname'     => $this->_DIRNAME ,
		'flag_css'    => true ,
		'flag_popbox' => $this->_USE_POPBOX_JS ,
		'flag_box'    => $this->_use_box_js ,
		'flag_gmap'   => $flag_gmap ,
		'gmap_apikey' => $this->_cfg_gmap_apikey ,
		'flag_rss'    => true ,
		'rss_mode'    => $mode ,
		'rss_param'   => $rss_param ,
		'rss_limit'   => $this->_RSS_LIMIT ,
		'lang_popbox_revert' => $this->get_constant('POPBOX_REVERT') ,
	);

	$this->_header_class->assign_for_main( $param );
}

// --- class end ---
}

?>
