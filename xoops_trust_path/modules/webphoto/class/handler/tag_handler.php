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


class webphoto_tag_handler extends webphoto_handler_base_ini {

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->set_table_prefix_dirname( 'tag' );
		$this->set_id_name( 'tag_id' );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_tag_handler( $dirname, $trust_dirname );
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
			'tag_id'          => 0,
			'tag_time_create' => $time_create,
			'tag_time_update' => $time_update,
			'tag_name'        => '',
		);
	}


// insert

	public function insert( $row, $force = false ) {
		extract( $row );

		$sql = 'INSERT INTO ' . $this->_table . ' (';

		$sql .= 'tag_time_create, ';
		$sql .= 'tag_time_update, ';
		$sql .= 'tag_name ';

		$sql .= ') VALUES ( ';

		$sql .= (int) $tag_time_create . ', ';
		$sql .= (int) $tag_time_update . ', ';
		$sql .= $this->quote( $tag_name ) . ' ';

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

		$sql .= 'tag_time_create=' . (int) $tag_time_create . ', ';
		$sql .= 'tag_time_update=' . (int) $tag_time_update . ', ';
		$sql .= 'tag_name=' . $this->quote( $tag_name ) . ' ';

		$sql .= 'WHERE tag_id=' . (int) $tag_id;

		return $this->query( $sql );
	}

	public function get_row_by_name( $name ) {
		$sql = 'SELECT * FROM ' . $this->_table;
		$sql .= ' WHERE tag_name=' . $this->quote( $name );

		return $this->get_row_by_sql( $sql );
	}

}
