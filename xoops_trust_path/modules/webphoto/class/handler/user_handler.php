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


class webphoto_user_handler extends webphoto_handler_base_ini {
	public $_cached_email_array = array();

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->set_table_prefix_dirname( 'user' );
		$this->set_id_name( 'user_id' );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_user_handler( $dirname, $trust_dirname );
		}

		return $instance;
	}

	public function create( $flag_new = false ) {
		$time_create = 0;
		$time_update = 0;

		if ( $flag_new ) {
			$time        = time();
			$time_create = $time;
			$time_update = $time;
		}

		$arr = array(
			'user_id'          => 0,
			'user_time_create' => $time_create,
			'user_time_update' => $time_update,
			'user_uid'         => 0,
			'user_cat_id'      => 0,
			'user_email'       => '',
		);

		for ( $i = 1; $i <= _C_WEBPHOTO_MAX_USER_TEXT; $i ++ ) {
			$arr[ 'user_text' . $i ] = '';
		}

		return $arr;
	}

	public function insert( $row, $force = false ) {
		extract( $row );

		$sql = 'INSERT INTO ' . $this->_table . ' (';

		$sql .= 'user_time_create, ';
		$sql .= 'user_time_update, ';
		$sql .= 'user_uid, ';
		$sql .= 'user_cat_id, ';

		for ( $i = 1; $i <= _C_WEBPHOTO_MAX_USER_TEXT; $i ++ ) {
			$sql .= 'user_text' . $i . ', ';
		}

		$sql .= 'user_email ';

		$sql .= ') VALUES ( ';

		$sql .= (int) $user_time_create . ', ';
		$sql .= (int) $user_time_update . ', ';
		$sql .= (int) $user_uid . ', ';
		$sql .= (int) $user_cat_id . ', ';

		for ( $i = 1; $i <= _C_WEBPHOTO_MAX_USER_TEXT; $i ++ ) {
			$sql .= $this->quote( $row[ 'user_text' . $i ] ) . ', ';
		}

		$sql .= $this->quote( $user_email ) . ' ';

		$sql .= ')';

		$ret = $this->query( $sql );
		if ( ! $ret ) {
			return false;
		}

		return $this->_db->getInsertId();
	}

	public function update( $row, $force = false ) {
		extract( $row );

		$sql = 'UPDATE ' . $this->_table . ' SET ';

		$sql .= 'user_time_create=' . (int) $user_time_create . ', ';
		$sql .= 'user_time_update=' . (int) $user_time_update . ', ';
		$sql .= 'user_uid=' . (int) $user_uid . ', ';
		$sql .= 'user_cat_id=' . (int) $user_cat_id . ', ';

		for ( $i = 1; $i <= _C_WEBPHOTO_MAX_USER_TEXT; $i ++ ) {
			$name = 'user_text' . $i;
			$sql  .= $name . '=' . $this->quote( $row[ $name ] ) . ', ';
		}

		$sql .= 'user_email=' . $this->quote( $user_email ) . ' ';

		$sql .= 'WHERE user_id=' . (int) $user_id;

		return $this->query( $sql );
	}

	public function get_row_by_uid( $uid ) {
		$sql = 'SELECT * FROM ' . $this->_table;
		$sql .= ' WHERE user_uid=' . (int) $uid;

		return $this->get_row_by_sql( $sql );
	}

	public function get_row_by_email( $email ) {
		$email = $this->quote( $email );

		$sql = 'SELECT * FROM ' . $this->_table;
		$sql .= ' WHERE user_email=' . $email;
		$sql .= ' OR user_text2=' . $email;
		$sql .= ' OR user_text3=' . $email;
		$sql .= ' OR user_text4=' . $email;
		$sql .= ' OR user_text5=' . $email;

		return $this->get_row_by_sql( $sql );
	}

	public function get_cached_row_by_email( $email ) {
		if ( isset( $this->_cached_email_array[ $email ] ) ) {
			return $this->_cached_email_array[ $email ];
		}

		$row = $this->get_row_by_email( $email );
		if ( ! is_array( $row ) ) {
			return false;
		}

		$this->_cached_email_array[ $email ] = $row;

		return $row;
	}

}

