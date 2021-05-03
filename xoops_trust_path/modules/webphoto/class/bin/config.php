<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief class webphoto_bin_config
 * when command mode, use instead of class/xoops/config.php
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_bin_config extends webphoto_lib_handler {

	public function __construct() {
		parent::__construct();
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_bin_config();
		}

		return $instance;
	}


// xoops class

	function get_config_by_dirname( $dirname ) {
		$modid = $this->get_modid_by_dirname( $dirname );

		return $this->get_config_by_modid( $modid );
	}

	function get_modid_by_dirname( $dirname ) {
		$sql = 'SELECT * FROM ' . $this->db_prefix( 'modules' );
		$sql .= ' WHERE dirname = ' . $this->quote( $dirname );
		$row = $this->get_row_by_sql( $sql );

		return $row['mid'];
	}

	function get_config_by_modid( $modid ) {
		return $this->get_config_by_modid_catid( $modid, 0 );
	}

	function get_config_by_modid_catid( $modid, $catid ) {
		$sql = 'SELECT * FROM ' . $this->db_prefix( 'config' );
		$sql .= ' WHERE (conf_modid = ' . (int) $modid;
		$sql .= ' AND conf_catid = ' . (int) $catid;
		$sql .= ' ) ';
		$sql .= ' ORDER BY conf_order ASC';

		$rows = $this->get_rows_by_sql( $sql );

		$arr = array();
		foreach ( $rows as $row ) {
			$arr[ $row['conf_name'] ] = $row['conf_value'];
		}

		return $arr;
	}
}
