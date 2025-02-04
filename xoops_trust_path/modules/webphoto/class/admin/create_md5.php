<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_admin_create_md5 extends webphoto_base_this {
	public $_file_md5_class;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_file_md5_class =& webphoto_lib_file_md5::getInstance(
			$dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_create_md5( $dirname, $trust_dirname );
		}

		return $instance;
	}


// function

	function main() {
		xoops_cp_header();

		echo "<h3>create md5</h3>\n";

		$this->create_md5( 'trust' );
		$this->create_md5( 'root' );

		xoops_cp_footer();
		exit();
	}

	function create_md5( $name ) {
		echo "<h4>" . $name . "</h4>\n";
		$data = $this->_file_md5_class->create_md5( $name );
		echo $data . '<br>';
	}

	function write_file( $name, $data ) {
		$file = XOOPS_TRUST_PATH . '/tmp/' . $this->_TRUST_DIRNAME . '_md5_' . $name . '.txt';
		$this->_utility_class->write_file( $file, $data );
	}

}
