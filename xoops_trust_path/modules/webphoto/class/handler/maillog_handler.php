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


class webphoto_maillog_handler extends webphoto_handler_base_ini {

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->set_table_prefix_dirname( 'maillog' );
		$this->set_id_name( 'maillog_id' );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_maillog_handler( $dirname, $trust_dirname );
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

		return array(
			'maillog_id'          => 0,
			'maillog_time_create' => $time_create,
			'maillog_time_update' => $time_update,
			'maillog_photo_ids'   => '',
			'maillog_status'      => '',
			'maillog_from'        => '',
			'maillog_subject'     => '',
			'maillog_body'        => '',
			'maillog_file'        => '',
			'maillog_attach'      => '',
			'maillog_comment'     => '',
		);
	}

	public function insert( $row, $force = false ) {
		extract( $row );

		$sql = 'INSERT INTO ' . $this->_table . ' (';

		$sql .= 'maillog_time_create, ';
		$sql .= 'maillog_time_update, ';
		$sql .= 'maillog_photo_ids, ';
		$sql .= 'maillog_status, ';
		$sql .= 'maillog_subject, ';
		$sql .= 'maillog_from, ';
		$sql .= 'maillog_body, ';
		$sql .= 'maillog_file, ';
		$sql .= 'maillog_attach, ';
		$sql .= 'maillog_comment ';

		$sql .= ') VALUES ( ';

		$sql .= (int) $maillog_time_create . ', ';
		$sql .= (int) $maillog_time_update . ', ';
		$sql .= $this->quote( $maillog_photo_ids ) . ', ';
		$sql .= (int) $maillog_status . ', ';
		$sql .= $this->quote( $maillog_subject ) . ', ';
		$sql .= $this->quote( $maillog_from ) . ', ';
		$sql .= $this->quote( $maillog_body ) . ', ';
		$sql .= $this->quote( $maillog_file ) . ', ';
		$sql .= $this->quote( $maillog_attach ) . ', ';
		$sql .= $this->quote( $maillog_comment ) . ' ';

		$sql .= ')';

		$ret = $this->query( $sql, 0, 0, $force );
		if ( ! $ret ) {
			return false;
		}

		return $this->_db->getInsertId();
	}

	public function update( $row, $force = false ) {
		extract( $row );

		$sql = 'UPDATE ' . $this->_table . ' SET ';

		$sql .= 'maillog_time_create=' . (int) $maillog_time_create . ', ';
		$sql .= 'maillog_time_update=' . (int) $maillog_time_update . ', ';
		$sql .= 'maillog_photo_ids=' . $this->quote( $maillog_photo_ids ) . ', ';
		$sql .= 'maillog_status=' . (int) $maillog_status . ', ';
		$sql .= 'maillog_subject=' . $this->quote( $maillog_subject ) . ', ';
		$sql .= 'maillog_from=' . $this->quote( $maillog_from ) . ', ';
		$sql .= 'maillog_body=' . $this->quote( $maillog_body ) . ', ';
		$sql .= 'maillog_file=' . $this->quote( $maillog_file ) . ', ';
		$sql .= 'maillog_attach=' . $this->quote( $maillog_attach ) . ', ';
		$sql .= 'maillog_comment=' . $this->quote( $maillog_comment ) . ' ';

		$sql .= ' WHERE maillog_id=' . (int) $maillog_id;

		return $this->query( $sql, 0, 0, $force );
	}

	public function get_count_by_status( $status ) {
		$sql = 'SELECT COUNT(*) FROM ' . $this->_table;
		$sql .= ' WHERE maillog_status=' . (int) $status;

		return $this->get_count_by_sql( $sql );
	}


	public function get_rows_desc_by_status( $status, $limit = 0, $start = 0 ) {
		$sql = 'SELECT * FROM ' . $this->_table;
		$sql .= ' WHERE maillog_status=' . (int) $status;
		$sql .= ' ORDER BY maillog_id DESC';

		return $this->get_rows_by_sql( $sql, $limit, $start );
	}

	public function get_rows_by_photoid( $photo_id, $limit = 0, $start = 0 ) {
// %|123|%
		$like = $this->build_like_separetor( $photo_id );
		$sql  = 'SELECT * FROM ' . $this->_table;
		$sql  .= ' WHERE maillog_photo_ids LIKE ' . $this->quote( $like );
		$sql  .= ' ORDER BY maillog_id DESC';

		return $this->get_rows_by_sql( $sql, $limit, $start );
	}

	public function build_like_separetor( $id ) {
// %|123|%
		$like = '%' . _C_WEBPHOTO_INFO_SEPARATOR;
		$like .= (int) $id;
		$like .= _C_WEBPHOTO_INFO_SEPARATOR . '%';

		return $like;
	}


// get id array
	public function get_id_array_older( $limit = 0, $offset = 0 ) {
		$sql = 'SELECT maillog_id FROM ' . $this->_table;
		$sql .= ' ORDER BY maillog_id ASC';

		return $this->get_first_rows_by_sql( $sql, $limit, $offset );
	}


// build
	public function build_photo_ids_array_to_str( $arr ) {
		if ( ! is_array( $arr ) || ! count( $arr ) ) {
			return null;
		}

// array -> |1|2|3|
		$str = $this->info_array_to_str( $arr );
		$ret = $this->build_photo_ids_with_separetor( $str );

		return $ret;
	}

	public function build_photo_ids_with_separetor( $str ) {
// str -> |1|
		$ret = _C_WEBPHOTO_INFO_SEPARATOR . $str . _C_WEBPHOTO_INFO_SEPARATOR;

		return $ret;
	}

	public function build_photo_ids_row_to_array( $row ) {
		return $this->info_str_to_array( $row['maillog_photo_ids'] );
	}

	public function build_attach_array_to_str( $arr ) {
		if ( ! is_array( $arr ) || ! count( $arr ) ) {
			return null;
		}

		return $this->info_array_to_str( $arr );
	}

	public function build_attach_row_to_array( $row ) {
		return $this->info_str_to_array( $row['maillog_attach'] );
	}

	public function info_str_to_array( $str ) {
		$utility_class =& webphoto_lib_utility::getInstance();

		return $utility_class->str_to_array( $str, _C_WEBPHOTO_INFO_SEPARATOR );
	}

	public function info_array_to_str( $arr ) {
		$utility_class =& webphoto_lib_utility::getInstance();

		return $utility_class->array_to_str( $arr, _C_WEBPHOTO_INFO_SEPARATOR );
	}


// show
	public function build_show_comment( $row ) {
		return nl2br( $row['maillog_comment'] );
	}

}
