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

class webphoto_lib_dir {
	public $_MKDIR_MODE = 0777;

	public $_EXCEPT_FILES = array( '.', '..', 'CVS', 'Thumbs.db' );

	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_dir();
		}

		return $instance;
	}

	public function get_files_in_deep_dir( $dir ) {
		return $this->array_fullpath_recursive( '', $this->array_dirlist_recursive( $dir ) );
	}

	public function get_files_in_dir( $path, $ext = null, $flag_dir = false, $flag_sort = false, $id_as_key = false ) {
		$arr = array();

		$lists = $this->get_lists_in_dir( $path );
		if ( ! is_array( $lists ) ) {
			return false;
		}

		$pattern = "/\." . preg_quote( $ext ) . "$/";

		foreach ( $lists as $list ) {
			$path_list = $path . '/' . $list;

// check is file
			if ( is_dir( $path_list ) || ! is_file( $path_list ) ) {
				continue;
			}

// check ext
			if ( $ext && ! preg_match( $pattern, $list ) ) {
				continue;
			}

			$list_out = $list;
			if ( $flag_dir ) {
				$list_out = $path_list;
			}
			if ( $id_as_key ) {
				$arr[ $list ] = $list_out;
			} else {
				$arr[] = $list_out;
			}
		}

		if ( $flag_sort ) {
			asort( $arr );
			reset( $arr );
		}

		return $arr;
	}

	public function get_dirs_in_dir( $path, $flag_dir = false, $flag_sort = false, $id_as_key = false ) {
		$arr = array();

		$lists = $this->get_lists_in_dir( $path );
		if ( ! is_array( $lists ) ) {
			return false;
		}

		foreach ( $lists as $list ) {
			$path_list = $path . '/' . $list;

// check is dir
			if ( ! is_dir( $path_list ) ) {
				continue;
			}

// myself
			if ( $list == '.' ) {
				continue;
			}

// parent
			if ( $list == '..' ) {
				continue;
			}

			$list_out = $list;
			if ( $flag_dir ) {
				$list_out = $path_list;
			}
			if ( $id_as_key ) {
				$arr[ $list ] = $list_out;
			} else {
				$arr[] = $list_out;
			}
		}

		if ( $flag_sort ) {
			asort( $arr );
			reset( $arr );
		}

		return $arr;
	}

	public function get_lists_in_dir( $path ) {
		$arr = array();

		$path = $this->strip_slash_from_tail( $path );

// check is dir
		if ( ! is_dir( $path ) ) {
			return false;
		}

// open
		$dh = opendir( $path );
		if ( ! $dh ) {
			return false;
		}

// read
		while ( false !== ( $list = readdir( $dh ) ) ) {
			$arr[] = $list;
		}

// close
		closedir( $dh );

		return $arr;
	}


// make dir

	public function make_dir( $dir, $check_writable = true ) {
		$not_dir = true;
		if ( is_dir( $dir ) ) {
			$not_dir = false;
			if ( $check_writable && is_writable( $dir ) ) {
				return '';
			} elseif ( ! $check_writable ) {
				return '';
			}
		}

		if ( ini_get( 'safe_mode' ) ) {
			return $this->highlight( 'At first create & chmod 777 "' . $dir . '" by ftp or shell.' ) . "<br>\n";
		}

		if ( $not_dir ) {
			$ret = mkdir( $dir, $this->_MKDIR_MODE );
			if ( ! $ret ) {
				return $this->highlight( 'can not create directory : <b>' . $dir . '</b>' ) . "<br>\n";
			}
		}

		$ret = chmod( $dir, $this->_MKDIR_MODE );
		if ( ! $ret ) {
			return $this->highlight( 'can not change mode directory : <b>' . $dir . '</b> ', $this->_MKDIR_MODE ) . "<br>\n";
		}

		$msg = 'create directory: <b>' . $dir . '</b>' . "<br>\n";

		return $msg;
	}

	public function check_dir( $dir ) {
		return $dir && is_dir( $dir ) && is_writable( $dir ) && is_readable( $dir );
	}


// recursive function

	public function array_fullpath_recursive( $dir, $dirlist ) {
		$fullpath = array();
		foreach ( $dirlist as $id => $filename ) {
			if ( is_array( $filename ) ) {
				$fullpath = array_merge(
					$fullpath,
					$this->array_fullpath_recursive( $dir . '/' . $id, $filename )
				);
			} else {
				$fullpath[] = $dir . '/' . $filename;
			}
		}

		return $fullpath;
	}


	public function array_dirlist_recursive( $dir ) {
		$arr = array();
		if ( ! is_dir( $dir ) ) {
			return $arr;
		}

		$files = $this->get_lists_in_dir( $dir );
		foreach ( $files as $file ) {
			$new_file = $dir . '/' . $file;
			if ( in_array( $file, $this->_EXCEPT_FILES ) ) {
				continue;
			}
			if ( is_link( $new_file ) ) {
				continue;
			}
			if ( is_file( $new_file ) ) {
				$arr[] = $file;
			} elseif ( is_dir( $new_file ) ) {
				$arr[]        = $file;
				$arr[ $file ] = $this->array_dirlist_recursive( $new_file );
			}
		}

		return $arr;
	}


// utility

	public function strip_slash_from_tail( $str ) {
		if ( substr( $str, - 1, 1 ) == '/' ) {
			$str = substr( $str, 0, - 1 );
		}

		return $str;
	}

	public function highlight( $str ) {
		return '<span style="color:#ff0000;">' . $str . '</span>';
	}

}
