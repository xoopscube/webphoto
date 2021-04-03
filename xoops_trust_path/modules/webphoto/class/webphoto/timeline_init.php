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

if ( ! class_exists( 'webphoto_timeline_init' ) ) {


	class webphoto_timeline_init {
		public $_config_class;
		public $_timeline_class;

		public $_cfg_timeline_dirname;
		public $_init_timeline;


		function __construct( $dirname ) {
			$this->_config_class   =& webphoto_config::getInstance( $dirname );
			$this->_timeline_class =& webphoto_inc_timeline::getSingleton( $dirname );

			$this->_cfg_timeline_dirname =
				$this->_config_class->get_by_name( 'timeline_dirname' );
			$this->_init_timeline        =
				$this->_timeline_class->init( $this->_cfg_timeline_dirname );
		}

		public static function &getInstance( $dirname = null, $trust_dirname = null ) {
			static $instance;
			if ( ! isset( $instance ) ) {
				$instance = new webphoto_timeline_init( $dirname );
			}

			return $instance;
		}


// webphoto_inc_timeline

		function fetch_timeline( $mode, $unit, $date, $photos ) {
			return $this->_timeline_class->fetch_timeline(
				$mode, $unit, $date, $photos );
		}


// function

		function get_timeline_dirname() {
			return $this->_timeline_dirname;
		}

		function get_init() {
			return $this->_init_timeline;
		}

		function get_scale_options( $flag_none = false ) {
			$arr1 = array(
				'none' => _WEBPHOTO_TIMELINE_OFF,
			);

			$arr2 = $this->_timeline_class->get_scale_options();

// Fatal error: Unsupported operand types
			if ( ! is_array( $arr2 ) ) {
				return false;
			}

			if ( $flag_none ) {
				$arr = $arr1 + $arr2;
			} else {
				$arr = $arr2;
			}

			return $arr;
		}

		function scale_to_unit( $scale, $default = 'month' ) {
			if ( $scale == 0 ) {
				return $default;
			}

			$arr = $this->_timeline_class->get_int_unit_array();

			if ( isset( $arr[ $scale ] ) ) {
				return $arr[ $scale ];
			}

			return $default;
		}

		function unit_to_scale( $unit, $default = 6 ) {
			$arr1 = $this->_timeline_class->get_int_unit_array();
			$arr2 = array_flip( $arr1 );

			if ( isset( $arr2[ $unit ] ) ) {
				return $arr2[ $unit ];
			}

			return $default;
		}

		function get_lang_param() {
			$param = $this->_timeline_class->get_scale_options();
			if ( ! is_array( $param ) ) {
				return false;
			}

			$arr = array();
			foreach ( $param as $k => $v ) {
				$arr[ 'lang_timeline_unit_' . $k ] = $v;
			}

			return $arr;
		}

// --- class end ---
	}

// === class end ===
}

?>
