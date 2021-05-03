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


class webphoto_gicon_handler extends webphoto_handler_base_ini {

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->set_table_prefix_dirname( 'gicon' );
		$this->set_id_name( 'gicon_id' );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_gicon_handler( $dirname, $trust_dirname );
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
			'gicon_id'            => 0,
			'gicon_time_create'   => $time_create,
			'gicon_time_update'   => $time_update,
			'gicon_title'         => '',
			'gicon_image_path'    => '',
			'gicon_image_name'    => '',
			'gicon_image_ext'     => '',
			'gicon_shadow_path'   => '',
			'gicon_shadow_name'   => '',
			'gicon_shadow_ext'    => '',
			'gicon_image_width'   => 0,
			'gicon_image_height'  => 0,
			'gicon_shadow_width'  => 0,
			'gicon_shadow_height' => 0,
			'gicon_anchor_x'      => 0,
			'gicon_anchor_y'      => 0,
			'gicon_info_x'        => 0,
			'gicon_info_y'        => 0,
		);
	}


// insert

	public function insert( $row, $force = false ) {
		extract( $row );

		$sql = 'INSERT INTO ' . $this->_table . ' (';

		$sql .= 'gicon_time_create, ';
		$sql .= 'gicon_time_update, ';
		$sql .= 'gicon_title, ';
		$sql .= 'gicon_image_path, ';
		$sql .= 'gicon_image_name, ';
		$sql .= 'gicon_image_ext, ';
		$sql .= 'gicon_shadow_path, ';
		$sql .= 'gicon_shadow_name, ';
		$sql .= 'gicon_shadow_ext, ';
		$sql .= 'gicon_image_width, ';
		$sql .= 'gicon_image_height, ';
		$sql .= 'gicon_shadow_width, ';
		$sql .= 'gicon_shadow_height, ';
		$sql .= 'gicon_anchor_x, ';
		$sql .= 'gicon_anchor_y, ';
		$sql .= 'gicon_info_x, ';
		$sql .= 'gicon_info_y ';

		$sql .= ') VALUES ( ';

		$sql .= (int) $gicon_time_create . ', ';
		$sql .= (int) $gicon_time_update . ', ';
		$sql .= $this->quote( $gicon_title ) . ', ';
		$sql .= $this->quote( $gicon_image_path ) . ', ';
		$sql .= $this->quote( $gicon_image_name ) . ', ';
		$sql .= $this->quote( $gicon_image_ext ) . ', ';
		$sql .= $this->quote( $gicon_shadow_path ) . ', ';
		$sql .= $this->quote( $gicon_shadow_name ) . ', ';
		$sql .= $this->quote( $gicon_shadow_ext ) . ', ';
		$sql .= (int) $gicon_image_width . ', ';
		$sql .= (int) $gicon_image_height . ', ';
		$sql .= (int) $gicon_shadow_width . ', ';
		$sql .= (int) $gicon_shadow_height . ', ';
		$sql .= (int) $gicon_anchor_x . ', ';
		$sql .= (int) $gicon_anchor_y . ', ';
		$sql .= (int) $gicon_info_x . ', ';
		$sql .= (int) $gicon_info_y . ' ';

		$sql .= ')';

		$ret = $this->query( $sql );
		if ( ! $ret ) {
			return false;
		}

		return $this->_db->getInsertId();
	}


// update

	public function update( $row, $force = false ) {
		extract( $row );

		$sql = 'UPDATE ' . $this->_table . ' SET ';

		$sql .= 'gicon_time_create=' . (int) $gicon_time_create . ', ';
		$sql .= 'gicon_time_update=' . (int) $gicon_time_update . ', ';
		$sql .= 'gicon_title=' . $this->quote( $gicon_title ) . ', ';
		$sql .= 'gicon_image_path=' . $this->quote( $gicon_image_path ) . ', ';
		$sql .= 'gicon_image_name=' . $this->quote( $gicon_image_name ) . ', ';
		$sql .= 'gicon_image_ext=' . $this->quote( $gicon_image_ext ) . ', ';
		$sql .= 'gicon_shadow_path=' . $this->quote( $gicon_shadow_path ) . ', ';
		$sql .= 'gicon_shadow_name=' . $this->quote( $gicon_shadow_name ) . ', ';
		$sql .= 'gicon_shadow_ext=' . $this->quote( $gicon_shadow_ext ) . ', ';
		$sql .= 'gicon_image_width=' . (int) $gicon_image_width . ', ';
		$sql .= 'gicon_image_height=' . (int) $gicon_image_height . ', ';
		$sql .= 'gicon_shadow_width=' . (int) $gicon_shadow_width . ', ';
		$sql .= 'gicon_shadow_height=' . (int) $gicon_shadow_height . ', ';
		$sql .= 'gicon_anchor_x=' . (int) $gicon_anchor_x . ', ';
		$sql .= 'gicon_anchor_y=' . (int) $gicon_anchor_y . ', ';
		$sql .= 'gicon_info_x=' . (int) $gicon_info_x . ', ';
		$sql .= 'gicon_info_y=' . (int) $gicon_info_y . ' ';

		$sql .= 'WHERE gicon_id=' . (int) $gicon_id;

		return $this->query( $sql );
	}

	public function get_sel_options( $none = false, $none_name = '---' ) {
		$rows = $this->get_rows_all_asc();

		$arr = array();
		if ( $none ) {
			$arr[0] = $none_name;
		}
		foreach ( $rows as $row ) {
			$arr[ $row['gicon_id'] ] = $row['gicon_title'];
		}

		return $arr;
	}

}
