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


class webphoto_d3_language {
	public $_DIRNAME;
	public $_TRUST_DIRNAME;
	public $_MODULE_DIR;
	public $_TRUST_DIR;

	public $_DEBUG_ERROR = false;


	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_d3_language();
		}

		return $instance;
	}

	public function init( $dirname, $trust_dirname ) {
		$this->_DIRNAME       = $dirname;
		$this->_TRUST_DIRNAME = $trust_dirname;

		$this->_MODULE_DIR = XOOPS_ROOT_PATH . '/modules/' . $dirname;
		$this->_TRUST_DIR  = XOOPS_TRUST_PATH . '/modules/' . $trust_dirname;

		$this->set_debug_error_by_const_name( $dirname . '_C_DEBUG_ERROR' );

	}


// public

	public function get_lang_array() {
		$arr1 = array();
		$arr2 = array();

		$needle1      = strtoupper( '_' . $this->_TRUST_DIRNAME . '_' );
		$needle2      = strtolower( $this->_DIRNAME . '_' );
		$constant_arr = get_defined_constants();

		foreach ( $constant_arr as $k => $v ) {
			if ( strpos( $k, $needle1 ) !== 0 ) {
				continue;
			}

			$key          = strtolower( str_replace( $needle1, '', $k ) );
			$arr1[ $key ] = $v;
		}

		foreach ( $arr1 as $k => $v ) {
			if ( strpos( $k, $needle2 ) !== 0 ) {
				continue;
			}

// overwrite
			$key          = str_replace( $needle2, '', $k );
			$arr1[ $key ] = $v;
		}

		foreach ( $arr1 as $k => $v ) {
			$arr2[ 'lang_' . $k ] = $v;
		}

		return $arr2;
	}

	public function get_constant( $name ) {
		$cont_name_1 = $this->_build_constant_name_1( $name );
		$cont_name_2 = $this->_build_constant_name_2( $name );
		$cont_name_3 = $this->_build_constant_name_3( $name );

// typo
		$cont_name_4 = $this->_build_constant_name_4( $name );

		if ( defined( $cont_name_1 ) ) {
			return constant( $cont_name_1 );

		} elseif ( defined( $cont_name_2 ) ) {
			return constant( $cont_name_2 );

		} elseif ( defined( $cont_name_3 ) ) {
			return constant( $cont_name_3 );
		}

		if ( $this->_DEBUG_ERROR ) {
			echo $this->_highlight( 'CANNOT get constant ' . $name ) . "<br>\n";
		}

		return $cont_name_4;
	}

	public function set_debug_error( $val ) {
		$this->_DEBUG_ERROR = (bool) $val;
	}

	public function set_debug_error_by_const_name( $name ) {
		$name = strtoupper( $name );
		if ( defined( $name ) ) {
			$this->set_debug_error( constant( $name ) );
		}
	}


// private

	private function _build_constant_name_1( $name ) {
		return strtoupper( '_' . $this->_TRUST_DIRNAME . '_' . $this->_DIRNAME . '_' . $name );
	}

	private function _build_constant_name_2( $name ) {
		return strtoupper( '_' . $this->_DIRNAME . '_' . $name );
	}

	private function _build_constant_name_3( $name ) {
		return strtoupper( '_' . $this->_TRUST_DIRNAME . '_' . $name );
	}

	private function _build_constant_name_4( $name ) {
		return strtoupper( '_' . $name );
	}

	private function _highlight( $str ) {
		$val = '<span style="color:#ff0000;">' . $str . '</span>';

		return $val;
	}

}
