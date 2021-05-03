<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

class webphoto_xoops_module {
	public $_module_handler;


	public function __construct() {
		$this->_module_handler =& xoops_gethandler( 'module' );
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_xoops_module();
		}

		return $instance;
	}

// my module
	public function get_my_mid( $format = 's' ) {
		return $this->get_my_value_by_name( 'mid', $format );
	}

	public function get_my_name( $format = 's' ) {
		return $this->get_my_value_by_name( 'name', $format );
	}

	public function get_my_value_by_name( $name, $format = 's' ) {
		global $xoopsModule;
		if ( is_object( $xoopsModule ) ) {
			return $xoopsModule->getVar( $name, $format );
		}

		return false;
	}

// xoops module
	public function get_mid_by_dirname( $dirname, $format = 's' ) {
		return $this->get_value_by_dirname( $dirname, 'mid', $format );
	}

	public function get_name_by_dirname( $dirname, $format = 's' ) {
		return $this->get_value_by_dirname( $dirname, 'name', $format );
	}

	public function is_active_by_dirname( $dirname ) {
		return $this->get_value_by_dirname( $dirname, 'isactive', $format );
	}

	public function get_value_by_dirname( $dirname, $name, $format = 's' ) {
		$module_handler =& xoops_gethandler( 'module' );
		$module         = $this->_module_handler->getByDirname( $dirname );
		if ( is_object( $module ) ) {
			return $module->getVar( $name, $format = 's' );
		}

		return false;
	}

	public function get_module_by_dirname( $dirname ) {
		return $this->_module_handler->getByDirname( $dirname );
	}

	public function get_module_by_mid( $mid ) {
		return $this->_module_handler->get( $mid );
	}

	public function get_module_objects( $criteria = null, $id_as_key = false ) {
		return $this->_module_handler->getObjects( $criteria, $id_as_key );
	}

	public function get_module_list( $param = null ) {
		$isactive = $param['isactive'] ?? true;
		$file     = $param['file'] ?? null;
		$except   = $param['except'] ?? null;

		$criteria = new CriteriaCompo();

		if ( $isactive ) {
			$criteria->add( new Criteria( 'isactive', '1', '=' ) );
		}

		$arr = array();

		$objs = $this->_module_handler->getObjects( $criteria );
		foreach ( $objs as $obj ) {
			$mod_id      = $obj->getVar( 'mid' );
			$mod_dirname = $obj->getVar( 'dirname' );
			$mod_file    = XOOPS_ROOT_PATH . '/modules/' . $mod_dirname . '/' . $file;

			if ( $file && ! file_exists( $mod_file ) ) {
				continue;
			}

			if ( $except && ( $mod_dirname == $except ) ) {
				continue;
			}

			$arr[ $mod_id ] = $obj;
		}

		return $arr;
	}

	public function get_dirname_list( $mod_objs, $param = null ) {
// none_key must be string, not integer 0
// 0 match any stings

		$none_flag       = $param['none_flag'] ?? false;
		$none_key        = $param['none_key'] ?? '-';
		$none_value      = $param['none_value'] ?? '---';
		$dirname_default = $param['dirname_default'] ?? null;
		$flag_dirname    = $param['flag_dirname'] ?? true;
		$flag_name       = $param['flag_name'] ?? true;
		$flag_sanitize   = $param['flag_sanitize'] ?? true;
		$sort_asort      = $param['sort_asort'] ?? true;
		$sort_flip       = $param['sort_flip'] ?? true;

		$arr = array();

		if ( $none_flag ) {
			$arr[ $none_key ] = $none_value;
		}

		foreach ( $mod_objs as $obj ) {
			$mod_dirname = $obj->getVar( 'dirname' );
			$mod_name    = $obj->getVar( 'name' );

			$str = '';
			if ( $flag_dirname ) {
				$str .= $mod_dirname;
			}
			if ( $flag_name ) {
				if ( $str ) {
					$str .= ': ';
				}
				$str .= $mod_name;
			}

			if ( $flag_sanitize ) {
				$str = $this->sanitize( $str );
			}

			$arr[ $mod_dirname ] = $str;
		}

		if ( $dirname_default && ! isset( $arr[ $dirname_default ] ) ) {
			$str = '';
			if ( $flag_dirname ) {
				$str .= $dirname_default;
			}
			if ( $flag_name ) {
				if ( $str ) {
					$str .= ' : ';
				}
				$str .= $dirname_default . ' module';
			}

			if ( $flag_sanitize ) {
				$str = $this->sanitize( $str );
			}
			$arr[ $dirname_default ] = $str;
		}

		if ( $sort_asort ) {
			asort( $arr );
			reset( $arr );
		}

		if ( $sort_flip ) {
			$arr = array_flip( $arr );
		}

		return $arr;
	}

// utility
	public function sanitize( $str ) {
		return htmlspecialchars( $str, ENT_QUOTES );
	}

}
