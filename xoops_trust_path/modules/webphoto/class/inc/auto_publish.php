<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief      class webphoto_inc_auto_publish
 * caller webphoto_show_main webphoto_inc_public
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_inc_auto_publish extends webphoto_inc_base_ini {
	public $_table_item;

	public $_ini_safe_mode;

	public $_FILE_AUTO_PUBLISH;
	public $_TIME_AUTO_PUBLISH = 3600; // 1 hour
	public $_FLAG_AUTO_PUBLISH_CHMOD = true;
	public $_CHMOD_MODE = 0777;

	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct();

		$this->init_base_ini( $dirname, $trust_dirname );
		$this->init_handler( $dirname );

		$this->_table_item = $this->prefix_dirname( 'item' );

		$this->_ini_safe_mode = ini_get( 'safe_mode' );
	}

	public static function &getSingleton( $dirname, $trust_dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] = new webphoto_inc_auto_publish( $dirname, $trust_dirname );
		}

		return $singletons[ $dirname ];
	}

	public function set_workdir( $workdir ) {
		$this->_FILE_AUTO_PUBLISH = $workdir . '/log/auto_publish';
	}

// public
	public function auto_publish() {
		if ( $this->check_auto_publish_time() ) {
			$this->item_auto_publish( true );
			$this->item_auto_expire( true );
		}

// set time before execute
		$this->renew_auto_publish_time();
	}


// private
	private function check_auto_publish_time() {
		return $this->check_file_time(
			$this->_FILE_AUTO_PUBLISH, $this->_TIME_AUTO_PUBLISH );
	}

	private function renew_auto_publish_time() {
		$this->write_file(
			$this->_FILE_AUTO_PUBLISH, time(), 'w', $this->_FLAG_AUTO_PUBLISH_CHMOD );
	}

	private function check_file_time( $file, $interval ) {
// if passing interval time
		if ( file_exists( $file ) ) {
			$time = (int) trim( file_get_contents( $file ) );
			if ( ( $time > 0 ) &&
			     ( time() > ( $time + $interval ) ) ) {
				return true;
			}

// if not exists file ( at first time )
		} else {
			return true;
		}

		return false;
	}

	private function write_file( $file, $data, $mode = 'w', $flag_chmod = false ) {
		$fp = fopen( $file, $mode );
		if ( ! $fp ) {
			return false;
		}

		$byte = fwrite( $fp, $data );
		fclose( $fp );

// the user can delete this file which apache made.
		if ( ( $byte > 0 ) && $flag_chmod ) {
			$this->chmod_file( $file );
		}

		return $byte;
	}

	private function chmod_file( $file ) {
// Warning: chmod()
		if ( ! $this->_ini_safe_mode ) {
			chmod( $file, $this->_CHMOD_MODE );
		}
	}


// item handler
	public function item_auto_publish( $force = false ) {
		$rows = $this->get_item_rows_coming_publish();
		if ( is_array( $rows ) && count( $rows ) ) {
			foreach ( $rows as $row ) {
				$this->update_item_status(
					$row['item_id'], _C_WEBPHOTO_STATUS_UPDATED, $force );
			}
		}
	}

	public function item_auto_expire( $force = false ) {
		$rows = $this->get_item_rows_coming_expire();
		if ( is_array( $rows ) && count( $rows ) ) {
			foreach ( $rows as $row ) {
				$this->update_item_status(
					$row['item_id'], _C_WEBPHOTO_STATUS_EXPIRED, $force );
			}
		}
	}

	public function get_item_rows_coming_publish( $limit = 0, $offset = 0 ) {
		$sql = 'SELECT * FROM ' . $this->_table_item;
		$sql .= ' WHERE item_status = ' . _C_WEBPHOTO_STATUS_OFFLINE;
		$sql .= ' AND item_time_publish > 0 ';
		$sql .= ' AND item_time_publish < ' . time();
		$sql .= ' ORDER BY item_id';

		return $this->get_rows_by_sql( $sql, $limit, $offset );
	}

	public function get_item_rows_coming_expire( $limit = 0, $offset = 0 ) {
		$sql = 'SELECT * FROM ' . $this->_table_item;
		$sql .= ' WHERE item_status > 0 ';
		$sql .= ' AND item_time_expire > 0 ';
		$sql .= ' AND item_time_expire < ' . time();
		$sql .= ' ORDER BY item_id';

		return $this->get_rows_by_sql( $sql, $limit, $offset );
	}

	function update_item_status( $item_id, $status, $force = false ) {
		$sql = 'UPDATE ' . $this->_table_item . ' SET ';
		$sql .= ' item_status = ' . (int) $status;
		$sql .= ' WHERE item_id=' . (int) $item_id;

		return $this->query( $sql, 0, 0, $force );
	}

}

