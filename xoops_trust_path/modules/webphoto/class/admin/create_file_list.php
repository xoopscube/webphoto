<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief $MY_DIRNAME WEBPHOTO_TRUST_PATH are set by calle
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_admin_create_file_list extends webphoto_base_this {
	public $_file_class;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_file_class =& webphoto_lib_file_check::getInstance(
			$dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_create_file_list( $dirname, $trust_dirname );
		}

		return $instance;
	}


// function

	public function main() {
		xoops_cp_header();

		echo "<h3>create file check list</h3>\n";

		$this->create_list( 'trust' );
		$this->create_list( 'root' );

		xoops_cp_footer();
		exit();
	}

	public function create_list( $name ) {
		echo "<h4>" . $name . "</h4>\n";
		$data = $this->_file_class->create_list( $name );
		echo nl2br( $data ) . '<br>';
	}

	public function write_file( $name, $data ) {
		$file = XOOPS_TRUST_PATH . '/tmp/' . $this->_TRUST_DIRNAME . '_check_' . $name . '.txt';
		$this->_utility_class->write_file( $file, $data );
	}
}
