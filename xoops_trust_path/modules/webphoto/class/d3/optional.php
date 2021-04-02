<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief class webphoto_d3_optional
 * DO NOT replace this file
 */
if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_d3_optional {
	public $_DIRNAME;
	public $_TRUST_DIRNAME;
	public $_MODULE_DIR;
	public $_TRUST_DIR;

	public $_xoops_language = null;

	public $_DEBUG_INCLUDE = false;
	public $_DEBUG_ERROR = false;


	public function __construct() {
		// dummy;
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_d3_optional();
		}

		return $instance;
	}

	public function init( $dirname, $trust_dirname ) {
		$this->init_trust( $trust_dirname );

		$this->_DIRNAME    = $dirname;
		$this->_MODULE_DIR = XOOPS_ROOT_PATH . '/modules/' . $dirname;

		$constpref = strtoupper( '_P_' . $dirname . '_' );
		$this->set_debug_include_by_const_name( $constpref . 'DEBUG_INCLUDE' );
		$this->set_debug_error_by_const_name( $constpref . 'DEBUG_ERROR' );
	}

	public function init_trust( $trust_dirname ) {
		$this->_TRUST_DIRNAME = $trust_dirname;
		$this->_TRUST_DIR     = XOOPS_TRUST_PATH . '/modules/' . $trust_dirname;
	}


// public
	public function get_fct( $page_array ) {
		$fct = preg_replace( '/[^a-zA-Z0-9_-]/', '', $this->_try_to_get_fct( $page_array ) );

		return $fct;
	}

	public function _try_to_get_fct( $page_array ) {
// POST
		$fct = $_POST['fct'] ?? null;
		if ( $fct ) {
			return $fct;
		}

// GET
		$fct = $_GET['fct'] ?? null;
		if ( $fct ) {
			return $fct;
		}

// PATH_INFO
		$fct       = null;
		$path_info = $_SERVER['PATH_INFO'] ?? null;
		if ( $path_info ) {
			$path_arr = explode( '/', $path_info );
			if ( is_array( $path_arr ) && count( $path_arr ) ) {
				foreach ( $path_arr as $path ) {
// first valid string
					if ( $path ) {
						$fct = $path;
						break;
					}
				}
			}
		}
		if ( $fct ) {
			return $fct;
		}

// for xoops comment & notification
		$fct = null;
		if ( is_array( $page_array ) && count( $page_array ) ) {
			foreach ( $page_array as $item => $page ) {
				$val = isset( $_GET[ $item ] ) ? (int) $_GET[ $item ] : 0;
				if ( $val > 0 ) {
					$fct = $page;
					break;
				}
			}
		}

		return $fct;
	}

	public function include_once_trust_file( $file ) {
		$file_trust = $this->_TRUST_DIR . '/' . $file;

		if ( file_exists( $file_trust ) ) {
			$this->debug_msg_include_file( $file_trust );
			include_once $file_trust;

			return true;
		}

		$this->debug_msg_error( 'CANNOT include ' . $file_trust );

		return false;
	}

	public function include_once_file( $file ) {
		$file_trust = $this->_TRUST_DIR . '/' . $file;
		$file_root  = $this->_MODULE_DIR . '/' . $file;

		if ( file_exists( $file_root ) ) {
			$this->debug_msg_include_file( $file_root );
			include_once $file_root;

			return true;

		} elseif ( file_exists( $file_trust ) ) {
			$this->debug_msg_include_file( $file_trust );
			include_once $file_trust;

			return true;
		}

		$this->debug_msg_error( 'CANNOT include ' . $file . ' in ' . $this->_DIRNAME );

		return false;
	}

	public function include_once_language( $file, $debug ) {
		$MY_DIRNAME = $this->_DIRNAME;

		$file_trust_lang = $this->_TRUST_DIR . '/language/' . $this->_xoops_language . '/' . $file;
		$file_trust_eng  = $this->_TRUST_DIR . '/language/english/' . $file;
		$file_root_lang  = $this->_MODULE_DIR . '/language/' . $this->_xoops_language . '/' . $file;
		$file_root_eng   = $this->_MODULE_DIR . '/language/english/' . $file;

		if ( file_exists( $file_root_lang ) ) {
			$this->debug_msg_include_file( $file_root_lang, $debug );
			include_once $file_root_lang;

			return true;

		} elseif ( file_exists( $file_trust_lang ) ) {
			$this->debug_msg_include_file( $file_trust_lang, $debug );
			include_once $file_trust_lang;

			return true;

		} elseif ( file_exists( $file_root_eng ) ) {
			$this->debug_msg_include_file( $file_root_eng, $debug );
			include_once $file_root_eng;

			return true;

		} elseif ( file_exists( $file_trust_eng ) ) {
			$this->debug_msg_include_file( $file_trust_eng, $debug );
			include_once $file_trust_eng;

			return true;
		}

		$this->debug_msg_error( 'CANNOT include ' . $file . ' in ' . $this->_DIRNAME );

		return false;
	}

	public function include_language( $file ) {
		$MY_DIRNAME = $this->_DIRNAME;

		$file_trust_lang = $this->_TRUST_DIR . '/language/' . $this->_xoops_language . '/' . $file;
		$file_trust_eng  = $this->_TRUST_DIR . '/language/english/' . $file;
		$file_root_lang  = $this->_MODULE_DIR . '/language/' . $this->_xoops_language . '/' . $file;
		$file_root_eng   = $this->_MODULE_DIR . '/language/english/' . $file;

		if ( file_exists( $file_root_lang ) ) {
			$this->debug_msg_include_file( $file_root_lang );
			include $file_root_lang;
			$this->include_language_compatible( $file );

			return true;

		} elseif ( file_exists( $file_trust_lang ) ) {
			$this->debug_msg_include_file( $file_trust_lang );
			include $file_trust_lang;
			$this->include_language_compatible( $file );

			return true;

		} elseif ( file_exists( $file_root_eng ) ) {
			$this->debug_msg_include_file( $file_root_eng );
			include $file_root_eng;

			return true;

		} elseif ( file_exists( $file_trust_eng ) ) {
			$this->debug_msg_include_file( $file_trust_eng );
			include $file_trust_eng;

			return true;
		}

		$this->debug_msg_error( 'CANNOT include ' . $file . ' in ' . $this->_DIRNAME );

		return false;
	}

	public function include_language_compatible( $file ) {
		$file_trust_comp = $this->_TRUST_DIR . '/language/compatible/' . $file;
		$file_root_comp  = $this->_MODULE_DIR . '/language/compatible/' . $file;

		if ( file_exists( $file_root_comp ) ) {
			$this->debug_msg_include_file( $file_root_comp );
			include $file_root_comp;

		} elseif ( file_exists( $file_trust_comp ) ) {
			$this->debug_msg_include_file( $file_trust_comp );
			include $file_trust_comp;
		}

		return true;
	}

	public function debug_msg_include_file( $file, $debug = true ) {
		$file_win = str_replace( '/', '\\', $file );

		if ( $this->_DEBUG_INCLUDE && $debug &&
		     ! in_array( $file, get_included_files() ) &&
		     ! in_array( $file_win, get_included_files() ) ) {
			echo 'include ' . $file . "<br>\n";
		}
	}

	public function debug_msg_error( $str ) {
		if ( $this->_DEBUG_ERROR ) {
			echo $this->_highlight( $str ) . "<br>\n";
		}
	}

	public function set_debug_error( $val ) {
		$this->_DEBUG_ERROR = (bool) $val;
	}

	public function set_debug_include( $val ) {
		$this->_DEBUG_INCLUDE = (bool) $val;
	}

	public function set_debug_error_by_const_name( $name ) {
		$name = strtoupper( $name );
		if ( defined( $name ) ) {
			$this->set_debug_error( constant( $name ) );
		}
	}

	public function set_debug_include_by_const_name( $name ) {
		$name = strtoupper( $name );
		if ( defined( $name ) ) {
			$this->set_debug_include( constant( $name ) );
		}
	}


// private
	private function _highlight( $str ) {
		$val = '<span style="color:#ff0000;">' . $str . '</span>';

		return $val;
	}


// xoops param
	public function set_language( $val ) {
		$this->_xoops_language = $val;
	}

}
