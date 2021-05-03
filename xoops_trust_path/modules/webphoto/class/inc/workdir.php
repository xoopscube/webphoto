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

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_inc_workdir {
	public $_ini_safe_mode;

	public $_DIRNAME;
	public $_TRUST_DIRNAME;
	public $_DIR_TRUST_UPLOADS;
	public $_FILE_WORKDIR;

	public $_CHMOD_MODE = 0777;


	public function __construct( $dirname, $trust_dirname ) {
		$this->_DIRNAME       = $dirname;
		$this->_TRUST_DIRNAME = $trust_dirname;

		$this->_DIR_TRUST_UPLOADS =
			XOOPS_TRUST_PATH . '/modules/' . $trust_dirname . '/uploads';

		$this->_FILE_WORKDIR = $this->_DIR_TRUST_UPLOADS . '/workdir.txt';

		$this->_ini_safe_mode = ini_get( 'safe_mode' );
	}

	public static function &getSingleton( $dirname, $trust_dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] =
				new webphoto_inc_workdir( $dirname, $trust_dirname );
		}

		return $singletons[ $dirname ];
	}


// main

	public function get_config_workdir() {
		$name = $this->_DIRNAME;

		for ( $i = 0; $i < 10; $i ++ ) {
			$workdir = $this->_DIR_TRUST_UPLOADS . '/' . $name;
			$match   = $this->read_workdir( $workdir );
			if ( $match == 0 ) {
				break;
			}
			if ( $match == 2 ) {
				break;
			}
			$name = uniqid( 'work_' );
		}

		return $workdir;
	}

	public function read_workdir( $workdir ) {
		$match = 0;

		if ( ! file_exists( $this->_FILE_WORKDIR ) ) {
			return $match;
		}

		$lines = $this->read_file_cvs( $this->_FILE_WORKDIR );

		if ( ! is_array( $lines ) ) {
			return $match;
		}

		foreach ( $lines as $line ) {
			if ( trim( $line[0] ) == $workdir ) {
				$match = 1;

				if ( ( trim( $line[1] ) == XOOPS_DB_NAME ) &&
				     ( trim( $line[2] ) == XOOPS_DB_PREFIX ) &&
				     ( trim( $line[3] ) == XOOPS_URL ) &&
				     ( trim( $line[4] ) == $this->_DIRNAME ) ) {
					$match = 2;
				}

				break;
			}
		}

		return $match;
	}

	public function write_workdir( $workdir ) {
		$data = $workdir;
		$data .= ', ';
		$data .= XOOPS_DB_NAME;
		$data .= ', ';
		$data .= XOOPS_DB_PREFIX;
		$data .= ', ';
		$data .= XOOPS_URL;
		$data .= ', ';
		$data .= $this->_DIRNAME;
		$data .= "\n";

		return $this->write_file( $this->_FILE_WORKDIR, $data, 'a', true );
	}

	public function read_file_cvs( $file, $mode = 'r' ) {
		$lines = array();

		$fp = fopen( $file, $mode );
		if ( ! $fp ) {
			return false;
		}

		while ( ! feof( $fp ) ) {
			$lines[] = fgetcsv( $fp, 1024 );
		}

		fclose( $fp );

		return $lines;
	}

	public function write_file( $file, $data, $mode = 'w', $flag_chmod = false ) {
		$fp = fopen( $file, $mode );
		if ( ! $fp ) {
			return false;
		}

		$byte = fwrite( $fp, $data );
		fclose( $fp );

// the user can delete this file which apache made.
		if ( ( $byte > 0 ) && $flag_chmod ) {
			$this->chmod_file( $file, $this->_CHMOD_MODE );
		}

		return $byte;
	}

	public function chmod_file( $file, $mode ) {
		if ( ! $this->_ini_safe_mode ) {
			chmod( $file, $mode );
		}
	}

	public function get_filename() {
		return $this->_FILE_WORKDIR;
	}

}
