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


class webphoto_edit_use_item extends webphoto_base_this {
	public $_cfg_gmap_apikey;
	public $_cfg_perm_item_read;

	public $_item_array;
	public $_show_array;
	public $_edit_array;

	public $_flag_admin = false;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_cfg_gmap_apikey    = $this->get_config_by_name( 'gmap_apikey' );
		$this->_cfg_perm_item_read = $this->get_config_by_name( 'perm_item_read' );

		$this->_item_array = $this->explode_ini( 'submit_item_list' );
		$this->_show_array = $this->explode_ini( 'submit_show_list' );
		$this->_edit_array = $this->explode_ini( 'edit_list' );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_use_item( $dirname, $trust_dirname );
		}

		return $instance;
	}


// set param

	public function set_flag_admin( $val ) {
		$this->_flag_admin = (bool) $val;
	}


// submit edit form

	public function use_item_perm_read() {
		return ( $this->_cfg_perm_item_read > 0 ) &&
		       $this->use_item_or_admin( 'perm_read' );
	}

	public function use_item_perm_level() {
		return ( $this->_cfg_perm_item_read > 0 ) &&
		       $this->use_item( 'perm_level' );
	}

	public function editable_item_perm_level() {
		return $this->use_item_perm_level() &&
		       $this->check_edit_or_admin( 'perm_level' );
	}

	public function use_gmap() {
		return $this->_cfg_gmap_apikey && $this->check_show_or_admin( 'gmap' );
	}

	function use_item_or_admin( $key ): bool {
		return $this->_flag_admin || $this->use_item( $key );
	}

	public function check_show_or_admin( $key ) {
		return $this->_flag_admin || $this->check_show( $key );
	}

	public function check_edit_or_admin( $key ) {
		return $this->_flag_admin || $this->check_edit( $key );
	}

	public function use_item( $key ) {
		return in_array( $key, $this->_item_array );
	}

	public function check_show( $key ) {
		return in_array( $key, $this->_show_array );
	}

	public function check_edit( $key ) {
		return in_array( $key, $this->_edit_array );
	}

}
