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


class webphoto_page extends webphoto_base_this {
	public $_public_class;
	public $_timeline_class;

	public $_cfg_file_dir;
	public $_cfg_is_set_mail;
	public $_cfg_uploads_path;

	public $_has_mail;
	public $_has_file;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_timeline_class =& webphoto_inc_timeline::getSingleton( $dirname );
		$this->_public_class
		                       =& webphoto_photo_public::getInstance( $dirname, $trust_dirname );

		$this->_cfg_file_dir     = $this->_config_class->get_by_name( 'file_dir' );
		$this->_cfg_is_set_mail  = $this->_config_class->is_set_mail();
		$this->_cfg_uploads_path = $this->_config_class->get_uploads_path();

		$this->_has_mail = $this->_perm_class->has_mail();
		$this->_has_file = $this->_perm_class->has_file();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_page( $dirname, $trust_dirname );
		}

		return $instance;
	}


// build main param

	public function build_main_param() {
		$arr = array_merge(
			$this->build_xoops_param(),
			$this->build_config_param(),
			$this->build_perm_param(),
			$this->build_show_param(),
			$this->build_menu_param(),
			$this->build_footer_param(),
			$this->get_lang_array()
		);

		return $arr;
	}

	public function build_xoops_param() {
		$arr = array(
			'mydirname'        => $this->_DIRNAME,

// for XOOPS 2.0.18
			'xoops_dirname'    => $this->_DIRNAME,
			'xoops_modulename' => $this->xoops_module_name( 's' ),
		);

		return $arr;
	}

	public function build_config_param() {
		$config_array = $this->get_config_array();
		foreach ( $config_array as $k => $v ) {
			$arr[ 'cfg_' . $k ] = $v;
		}
		$arr['cfg_is_set_mail'] = $this->_cfg_is_set_mail;

		return $arr;
	}

	public function build_perm_param() {
		$arr = array(
			'has_rateview'    => $this->_perm_class->has_rateview(),
			'has_ratevote'    => $this->_perm_class->has_ratevote(),
			'has_tellafriend' => $this->_perm_class->has_tellafriend(),
			'has_insertable'  => $this->_perm_class->has_insertable(),
			'has_mail'        => $this->_has_mail,
			'has_file'        => $this->_has_file,
		);

		return $arr;
	}

	public function build_show_param() {
		$show_rateview    = false;
		$show_ratevote    = false;
		$show_tellafriend = false;
		if ( $this->get_ini( 'use_rating' ) ) {
			$show_rateview = $this->_perm_class->has_rateview();
			$show_ratevote = $this->_perm_class->has_ratevote();
		}
		if ( $this->get_ini( 'use_tellafriend' ) ) {
			$show_tellafriend = $this->_perm_class->has_tellafriend();
		}

		return array(
			'show_rateview'    => $show_rateview,
			'show_ratevote'    => $show_ratevote,
			'show_tellafriend' => $show_tellafriend,
		);
	}

	public function build_menu_param() {
		$total = $this->get_public_total();

		return array(
			'photo_total_all'    => $total,
			'lang_thereare'      => $this->build_lang_thereare( $total ),
			'show_menu_mail'     => $this->get_show_menu_mail(),
			'show_menu_file'     => $this->get_show_menu_file(),
			'show_menu_map'      => $this->get_show_menu_map(),
			'show_menu_timeline' => $this->timeline_check_exist(),
		);
	}

	public function build_footer_param() {
		return array(
			'is_module_admin' => $this->xoops_is_module_admin(),
			'happy_linux_url' => $this->get_happy_linux_url(),
		);
	}

	public function build_qrs_param() {
		$qrs_path = $this->_cfg_uploads_path . '/qrs';
		$qrs_url  = XOOPS_URL . $qrs_path;

		return array(
			'qrs_path' => $qrs_path,
			'qrs_url'  => $qrs_url,
		);
	}

	public function build_lang_thereare( $total_all ) {
		return sprintf( $this->get_constant( 'S_THEREARE' ), $total_all );
	}

	public function get_show_menu_mail() {
		return $this->_cfg_is_set_mail && $this->_has_mail;
	}

	public function get_show_menu_file() {
		return $this->_cfg_file_dir && $this->_has_file;
	}

	public function get_show_menu_map() {
		$gmap_apikey = $this->_config_class->get_by_name( 'gmap_apikey' );

		return empty( $gmap_apikey ) ? false : true;
	}

	public function get_is_taf_module() {
		$file = XOOPS_ROOT_PATH . '/modules/tellafriend/index.php';
		if ( file_exists( $file ) ) {
			return true;
		}

		return false;
	}


// show JavaScript

	public function add_show_js_windows( $param ) {
		return array_merge( $param, $this->build_show_js_windows( $param ) );
	}

	public function build_show_js_windows( $param ) {
		$use_box_js    = isset( $param['use_box_js'] ) ? (bool) $param['use_box_js'] : false;
		$show_gmap     = isset( $param['show_gmap'] ) ? (bool) $param['show_gmap'] : false;
		$show_timeline = isset( $param['show_timeline'] ) ? (bool) $param['show_timeline'] : false;

		$show_js_window  = false;
		$show_js_boxlist = false;
		$show_js_load    = false;
		$show_js_unload  = false;
		$js_load         = null;

		if ( $use_box_js && $show_gmap && $show_timeline ) {
			$show_js_window  = true;
			$show_js_boxlist = true;
			$show_js_load    = true;
			$show_js_unload  = true;
			$js_load         = 'webphoto_box_gmap_timeline_init';

		} elseif ( $use_box_js && $show_gmap ) {
			$show_js_window  = true;
			$show_js_boxlist = true;
			$show_js_load    = true;
			$show_js_unload  = true;
			$js_load         = 'webphoto_box_gmap_init';

		} elseif ( $use_box_js && $show_timeline ) {
			$show_js_window  = true;
			$show_js_boxlist = true;
			$show_js_load    = true;
			$js_load         = 'webphoto_box_timeline_init';

		} elseif ( $show_gmap && $show_timeline ) {
			$show_js_window = true;
			$show_js_load   = true;
			$show_js_unload = true;
			$js_load        = 'webphoto_gmap_timeline_init';

		} elseif ( $use_box_js ) {
			$show_js_window  = true;
			$show_js_boxlist = true;
			$show_js_load    = true;
			$js_load         = 'webphoto_box_init';

		} elseif ( $show_gmap ) {
			$show_js_window = true;
			$show_js_load   = true;
			$show_js_unload = true;
			$js_load        = 'webphoto_gmap_init';

		} elseif ( $show_timeline ) {
			$show_js_window = true;
			$show_js_load   = true;
			$js_load        = 'webphoto_timeline_init';
		}

		$boxlist = $this->build_box_list( $param );

		return array(
			'box_list'        => $boxlist,
			'js_boxlist'      => $boxlist,
			'show_js_window'  => $show_js_window,
			'show_js_boxlist' => $show_js_boxlist,
			'show_js_load'    => $show_js_load,
			'show_js_unload'  => $show_js_unload,
			'js_load'         => $js_load,
			'js_unload'       => 'GUnload',
		);
	}

	public function build_box_list( $param ) {
		if ( ! isset( $param['use_box_js'] ) || ! $param['use_box_js'] ) {
			return '';
		}

		$arr = array();
		if ( isset( $param['show_catlist'] ) && $param['show_catlist'] ) {
			$arr[] = 'webphoto_box_catlist';
		}
		if ( isset( $param['show_tagcloud'] ) && $param['show_tagcloud'] ) {
			$arr[] = 'webphoto_box_tagcloud';
		}
		if ( isset( $param['show_gmap'] ) && $param['show_gmap'] ) {
			$arr[] = 'webphoto_box_gmap';
		}
		if ( isset( $param['show_timeline'] ) && $param['show_timeline'] ) {
			$arr[] = 'webphoto_box_timeline';
		}

// show_photo -> show_photo_list
		if ( isset( $param['show_photo_list'] ) && $param['show_photo_list'] ) {
			$arr[] = 'webphoto_box_photo';
		}

		if ( count( $arr ) ) {
			return implode( ',', $arr );
		}

		return '';
	}


// preload

	public function init_preload() {
		$this->_preload_class =& webphoto_d3_preload::getInstance();
		$this->_preload_class->init( $this->_DIRNAME, $this->_TRUST_DIRNAME );

		$this->preload_constant();
	}

	public function preload_constant() {
		$arr = $this->_preload_class->get_preload_const_array();

		if ( ! is_array( $arr ) || ! count( $arr ) ) {
			return true;    // no action
		}

		foreach ( $arr as $k => $v ) {
			$local_name = strtoupper( '_' . $k );

// array type
			if ( strpos( $k, 'array_' ) === 0 ) {
				$temp = $this->str_to_array( $v, '|' );
				if ( is_array( $temp ) && count( $temp ) ) {
					$this->$local_name = $temp;
				}

// string type
			} else {
				$this->$local_name = $v;
			}
		}

	}


// d3 language

	public function _init_d3_language( $dirname, $trust_dirname ) {
		$this->_language_class =& webphoto_d3_language::getInstance();
		$this->_language_class->init( $dirname, $trust_dirname );
	}

	public function get_lang_array() {
		return $this->_language_class->get_lang_array();
	}

	public function get_constant( $name ) {
		return $this->_language_class->get_constant( $name );
	}


// xoops class

	public function xoops_is_module_admin() {
		return $this->_xoops_class->get_my_user_is_module_admin();
	}

	public function xoops_is_japanese() {
		return $this->_xoops_class->is_japanese( _C_WEBPHOTO_JPAPANESE );
	}

	public function xoops_module_name( $format = 's' ) {
		return $this->_xoops_class->get_my_module_name( $format );
	}


// config class

	public function get_config_array() {
		return $this->_config_class->get_config_array();
	}


// public class

	public function get_public_total() {
		return $this->_public_class->get_count();
	}


// timeline class

	public function timeline_check_exist() {
		$timeline_dirname = $this->_config_class->get_by_name( 'timeline_dirname' );

		return $this->_timeline_class->check_exist( $timeline_dirname );
	}


// utility class

	public function str_to_array( $str, $pattern ) {
		return $this->_utility_class->str_to_array( $str, $pattern );
	}

	public function get_execution_time() {
		return $this->_utility_class->get_execution_time( WEBPHOTO_TIME_START );
	}

	public function get_memory_usage() {
		return $this->_utility_class->get_memory_usage();
	}

	public function get_happy_linux_url() {
		return $this->_utility_class->get_happy_linux_url( $this->xoops_is_japanese() );
	}

}
