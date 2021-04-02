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


class webphoto_admin_text extends webphoto_base_this {
	public $_readfile_class;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_readfile_class =& webphoto_lib_readfile::getInstance();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_text( $dirname, $trust_dirname );
		}

		return $instance;
	}


	function main() {
		$name = $this->_post_class->get_get_text( 'name' );
		$file = $this->_MAIL_DIR . '/' . $name;

		if ( empty( $name ) || ! is_file( $file ) ) {
			exit();
		}

		$this->_readfile_class->readfile_view( $file, 'text/plain' );
		exit();
	}


}


