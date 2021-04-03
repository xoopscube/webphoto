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


class webphoto_vote_handler extends webphoto_handler_base_ini {
	public $_ONE_DAY_SEC = 86400;    // 1 day ( 86400 sec )
	public $_WAIT_DAYS = 1;    // 1 day

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->set_table_prefix_dirname( 'vote' );
		$this->set_id_name( 'vote_id' );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_vote_handler( $dirname, $trust_dirname );
		}

		return $instance;
	}


// create

	public function create( $flag_new = false ) {
		$time_create = 0;
		$time_update = 0;

		if ( $flag_new ) {
			$time        = time();
			$time_create = $time;
			$time_update = $time;
		}

		return array(
			'vote_id'          => 0,
			'vote_time_create' => $time_create,
			'vote_time_update' => $time_update,
			'vote_photo_id'    => 0,
			'vote_uid'         => 0,
			'vote_rating'      => 0,
			'vote_hostname'    => '',

		);
	}


// insert

	public function insert( $row, $force = false ) {
		extract( $row );

		$sql = 'INSERT INTO ' . $this->_table . ' (';

		if ( $vote_id > 0 ) {
			$sql .= 'vote_id, ';
		}

		$sql .= 'vote_time_create, ';
		$sql .= 'vote_time_update, ';
		$sql .= 'vote_photo_id, ';
		$sql .= 'vote_uid, ';
		$sql .= 'vote_rating, ';
		$sql .= 'vote_hostname ';

		$sql .= ') VALUES ( ';

		if ( $vote_id > 0 ) {
			$sql .= (int) $vote_id . ', ';
		}

		$sql .= (int) $vote_time_create . ', ';
		$sql .= (int) $vote_time_update . ', ';
		$sql .= (int) $vote_photo_id . ', ';
		$sql .= (int) $vote_uid . ', ';
		$sql .= (int) $vote_rating . ', ';
		$sql .= $this->quote( $vote_hostname ) . ' ';

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

		$sql .= 'vote_time_create=' . (int) $vote_time_create . ', ';
		$sql .= 'vote_time_update=' . (int) $vote_time_update . ', ';
		$sql .= 'vote_photo_id=' . (int) $vote_photo_id . ', ';
		$sql .= 'vote_uid=' . (int) $vote_uid . ', ';
		$sql .= 'vote_rating=' . (int) $vote_rating . ', ';
		$sql .= 'vote_hostname=' . $this->quote( $vote_hostname ) . ' ';
		$sql .= 'WHERE vote_id=' . (int) $vote_id;

		return $this->query( $sql );
	}

	public function delete_by_photoid( $photo_id ) {
		$sql = 'DELETE FROM ' . $this->_table;
		$sql .= ' WHERE vote_photo_id=' . (int) $photo_id;

		return $this->query( $sql );
	}

	public function get_count_by_photoid( $photo_id ) {
		$where = 'vote_photo_id=' . (int) $photo_id;

		return $this->get_count_by_where( $where );
	}

	public function get_count_by_photoid_uid( $photo_id, $uid ) {
		$where = 'vote_photo_id=' . (int) $photo_id;
		$where .= ' AND vote_uid=' . (int) $uid;

		return $this->get_count_by_where( $where );
	}

	public function get_count_anonymous_by_photoid_hostname( $photo_id, $hostname ) {
		$yesterday = time() - $this->get_ini( 'vote_anonymous_interval' );

		$where = 'vote_uid=0 ';
		$where .= ' AND vote_photo_id=' . (int) $photo_id;
		$where .= ' AND vote_hostname=' . $this->quote( $hostname );
		$where .= ' AND vote_time_update > ' . (int) $yesterday;

		return $this->get_count_by_where( $where );
	}

	public function get_rows_by_photoid( $photo_id ) {
		$where = 'vote_photo_id=' . (int) $photo_id;

		return $this->get_rows_by_where( $where );
	}

	public function get_rows_by_uid( $uid ) {
		$where = 'vote_uid=' . (int) $uid;

		return $this->get_rows_by_where( $where );
	}

	public function get_rows_user() {
		$where = 'vote_uid>0';

		return $this->get_rows_by_where( $where );
	}

	public function get_rows_guest() {
		$where = 'vote_uid=0';

		return $this->get_rows_by_where( $where );
	}

	public function get_rows_user_by_photoid( $photo_id ) {
		$where = 'vote_uid>0 ';
		$where .= 'AND vote_photo_id=' . (int) $photo_id;

		return $this->get_rows_by_where( $where );
	}

	public function get_rows_guest_by_photoid( $photo_id ) {
		$where = 'vote_uid=0 ';
		$where .= 'AND vote_photo_id=' . (int) $photo_id;

		return $this->get_rows_by_where( $where );
	}

	public function calc_rating_by_photoid( $photo_id, $decimals = 4 ) {
		return $this->calc_rating_by_rows(
			$this->get_rows_by_photoid( $photo_id ) );
	}

	public function calc_rating_by_uid( $uid, $decimals = 1 ) {
		return $this->calc_rating_by_rows(
			$this->get_rows_by_uid( $uid ) );
	}

	public function calc_rating_by_rows( $rows, $decimals = 0 ) {
		$votes  = 0;
		$total  = 0;
		$rating = 0;

		if ( is_array( $rows ) ) {
			$votes = count( $rows );
			if ( $votes > 0 ) {
				foreach ( $rows as $row ) {
					$total += $row['vote_rating'];
				}
				$rating = $total / $votes;
				if ( $decimals > 0 ) {
					$rating = $this->format_rating( $rating, $decimals );
				}
			}
		}

		return array( $votes, $total, $rating );
	}

	public function format_rating( $rating, $decimals = 1 ) {
		return number_format( $rating, $decimals );
	}

}
