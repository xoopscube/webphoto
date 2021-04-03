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


class webphoto_syno_handler extends webphoto_handler_base_ini {

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->set_table_prefix_dirname( 'syno' );
		$this->set_id_name( 'syno_id' );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_syno_handler( $dirname, $trust_dirname );
		}

		return $instance;
	}

	function create( $flag_new = false ) {
		$time_create = 0;
		$time_update = 0;

		if ( $flag_new ) {
			$time        = time();
			$time_create = $time;
			$time_update = $time;
		}

		return array(
			'syno_id'          => 0,
			'syno_time_create' => $time_create,
			'syno_time_update' => $time_update,
			'syno_weight'      => 0,
			'syno_key'         => '',
			'syno_value'       => '',
		);
	}

	function insert( $row, $force = false ) {
		extract( $row );

		$sql = 'INSERT INTO ' . $this->_table . ' (';

		$sql .= 'syno_time_create, ';
		$sql .= 'syno_time_update, ';
		$sql .= 'syno_weight, ';
		$sql .= 'syno_key, ';
		$sql .= 'syno_value ';

		$sql .= ') VALUES ( ';

		$sql .= (int) $syno_time_create . ', ';
		$sql .= (int) $syno_time_update . ', ';
		$sql .= (int) $syno_weight . ', ';
		$sql .= $this->quote( $syno_key ) . ', ';
		$sql .= $this->quote( $syno_value ) . ' ';

		$sql .= ')';

		$ret = $this->query( $sql );
		if ( ! $ret ) {
			return false;
		}

		return $this->_db->getInsertId();
	}

	function update( $row, $force = false ) {
		extract( $row );

		$sql = 'UPDATE ' . $this->_table . ' SET ';

		$sql .= 'syno_time_create=' . (int) $syno_time_create . ', ';
		$sql .= 'syno_time_update=' . (int) $syno_time_update . ', ';
		$sql .= 'syno_weight=' . (int) $syno_weight . ', ';
		$sql .= 'syno_key=' . $this->quote( $syno_key ) . ', ';
		$sql .= 'syno_value=' . $this->quote( $syno_value ) . ' ';

		$sql .= 'WHERE syno_id=' . (int) $syno_id;

		return $this->query( $sql );
	}


// rows
	function get_rows_orderby_weight_asc( $limit = 0, $offset = 0 ) {
		$orderby = 'syno_weight ASC, syno_id ASC';

		return $this->get_rows_by_orderby( $orderby, $limit = 0, $offset = 0 );
	}

	function get_rows_orderby_weight_desc( $limit = 0, $offset = 0 ) {
		$orderby = 'syno_weight DESC, syno_id DESC';

		return $this->get_rows_by_orderby( $orderby, $limit = 0, $offset = 0 );
	}

}
