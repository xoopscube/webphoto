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

if ( ! class_exists( 'webphoto_inc_timeline' ) ) {


	class webphoto_inc_timeline {
		public $_timeline_class;
		public $_mysql_utility_class;

		public $_init_timeline = false;

		public $_show_onload = false;
		public $_show_onresize = false;
		public $_show_timeout = false;
		public $_timeout = 1000;    // 1 sec

		public $_DIRNAME;
		public $_MODULE_URL;
		public $_MODULE_DIR;
		public $_IMAGE_EXTS;

		public $_UNIT_DEFAULT = 'month';
		public $_DATE_DEFAULT = '';

		public $_UNIT_ARRAY = array( 'day', 'week', 'month', 'year', 'decade', 'century' );

		public function __construct( $dirname ) {
			$this->_DIRNAME    = $dirname;
			$this->_MODULE_URL = XOOPS_URL . '/modules/' . $dirname;
			$this->_MODULE_DIR = XOOPS_ROOT_PATH . '/modules/' . $dirname;

			$this->_IMAGE_EXTS = explode( '|', _C_WEBPHOTO_IMAGE_EXTS );

			$this->_mysql_utility_class =& webphoto_lib_mysql_utility::getInstance();
		}

		public static function &getSingleton( $dirname ) {
			static $singletons;
			if ( ! isset( $singletons[ $dirname ] ) ) {
				$singletons[ $dirname ] = new webphoto_inc_timeline( $dirname );
			}

			return $singletons[ $dirname ];
		}


// timeline
		public function init( $timeline_dirname ) {
			$check = $this->check_exist( $timeline_dirname );
			if ( ! $check ) {
				return false;
			}

			$this->_timeline_class =& timeline_compo_timeline::getSingleton( $timeline_dirname );
			$this->_init_timeline  = true;

			return true;
		}

		public function check_exist( $timeline_dirname ) {
			$file = XOOPS_ROOT_PATH . '/modules/' . $timeline_dirname . '/include/api_timeline.php';
			if ( ! file_exists( $file ) ) {
				return false;
			}

			include_once $file;

			return class_exists( 'timeline_compo_timeline' );
		}

		public function fetch_timeline( $mode, $unit, $date, $photos ) {
			if ( ! $this->_init_timeline ) {
				return false;
			}

			$ID     = 0;
			$events = array();

			if ( empty( $unit ) ) {
				$unit = $this->_UNIT_DEFAULT;
			}

			if ( empty( $date ) ) {
				$date = $this->_DATE_DEFAULT;
			}

			foreach ( $photos as $photo ) {
				$event = $this->build_event( $photo );
				if ( is_array( $event ) ) {
					$events[] = $event;
				}
			}

			switch ( $mode ) {
				case 'painter':
					list( $element, $js ) =
						$this->build_painter_events( $ID, $unit, $date, $events );
					break;

				case 'simple':
				default:
					list( $element, $js ) =
						$this->build_simple_events( $ID, $unit, $date, $events );
					break;
			}

			$arr = array(
				'timeline_js'      => $js,
				'timeline_element' => $element,
			);

			return $arr;
		}


// event

		public function build_event( $photo ) {
			$param = $this->build_start( $photo );
			if ( ! is_array( $param ) ) {
				return false;
			}

			$param['title']       = $this->build_title( $photo );
			$param['link']        = $this->build_link( $photo );
			$param['image']       = $this->build_image( $photo );
			$param['icon']        = $this->build_icon( $photo );
			$param['description'] = $this->build_description( $photo );

			return $param;
		}

		public function build_start( $photo ) {
			if ( $photo['item_datetime'] ) {
				$param = $this->build_start_param( $photo['item_datetime'] );
				if ( is_array( $param ) ) {
					return $param;
				}
			}

			if ( $photo['item_time_create'] > 0 ) {
				$param = array(
					'start' => $this->unixtime_to_datetime( $photo['item_time_create'] )
				);

				return $param;
			}

			return false;
		}

		public function build_start_param( $datetime ) {
			$p = $this->_mysql_utility_class->mysql_datetime_to_date_param( $datetime );
			if ( ! is_array( $p ) ) {
				return false;
			}

			$param = array(
				'start_year'   => $p['year'],
				'start_month'  => $p['month'],
				'start_day'    => $p['day'],
				'start_hour'   => $p['hour'],
				'start_minute' => $p['minute'],
				'start_second' => $p['second'],
			);

			return $param;
		}

		public function build_title( $photo ) {
			return $this->sanitize( $photo['item_title'] );
		}

		public function build_description( $photo ) {
			return $this->escape_quotation(
				$this->build_summary( $photo['description_disp'] ) );
		}

		public function build_link( $photo ) {
// no sanitize
			return $photo['photo_uri'];
		}

		public function build_image( $photo ) {
// no sanitize
			if ( $photo['thumb_url'] ) {
				return $photo['thumb_url'];
			}

			return $this->build_icon( $photo );
		}

		public function build_icon( $photo ) {
// no sanitize
			if ( $photo['small_url'] ) {
				return $photo['small_url'];
			} elseif ( $photo['icon_url'] ) {
				return $photo['icon_url'];
			}

			return null;
		}


// timeline class

		public function build_painter_events( $id, $unit, $date, $events ) {
			$this->_timeline_class->init_painter_events();
			$this->_timeline_class->set_band_unit( $unit );
			$this->_timeline_class->set_center_date( $date );
			$this->_timeline_class->set_show_onload( $this->_show_onload );
			$this->_timeline_class->set_show_onresize( $this->_show_onresize );
			$this->_timeline_class->set_show_timeout( $this->_show_timeout );
			$this->_timeline_class->set_timeout( $this->_timeout );
			$param = $this->_timeline_class->build_painter_events( $id, $events );
			$js    = $this->_timeline_class->fetch_painter_events( $param );

			return array( $param['element'], $js );
		}

		public function build_simple_events( $id, $unit, $date, $events ) {
			$this->_timeline_class->init_simple_events();
			$param = $this->_timeline_class->build_simple_events( $id, $events );
			$js    = $this->_timeline_class->fetch_simple_events( $param );

			return array( $param['element'], $js );
		}

		public function build_summary( $str ) {
			return $this->_timeline_class->build_summary( $str );
		}

		public function unixtime_to_datetime( $time ) {
			return $this->_timeline_class->unixtime_to_datetime( $time );
		}

		public function escape_quotation( $str ) {
			return $this->_timeline_class->escape_quotation( $str );
		}


// options

		public function get_scale_options() {
			if ( ! $this->_init_timeline ) {
				return false;
			}

			$lang = $this->_timeline_class->get_unit_lang_array();

			$arr = array();
			foreach ( $lang as $k => $v ) {
				if ( in_array( $k, $this->_UNIT_ARRAY ) ) {
					$arr[ $k ] = $v;
				}
			}

			return $arr;
		}

		public function get_int_unit_array() {
			if ( ! $this->_init_timeline ) {
				return array();
			}

			return $this->_timeline_class->get_int_unit_array();
		}


// utility

		function sanitize( $str ) {
			return htmlspecialchars( $str, ENT_QUOTES );
		}

		function is_image_ext( $ext ) {
			return $this->is_ext_in_array( $ext, $this->_IMAGE_EXTS );
		}

		function is_ext_in_array( $ext, $arr ) {
			if ( in_array( strtolower( $ext ), $arr ) ) {
				return true;
			}

			return false;
		}


// set param

		function set_show_onload( $val ) {
			$this->_show_onload = (bool) $val;
		}

		function set_show_onresize( $val ) {
			$this->_show_onresize = (bool) $val;
		}

		function set_show_timeout( $val ) {
			$this->_show_timeout = (bool) $val;
		}

		function set_timeout( $val ) {
			$this->_timeout = (int) $val;
		}

	}

}

