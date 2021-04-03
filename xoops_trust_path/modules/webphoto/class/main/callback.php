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

// http://code.jeroenwijering.com/trac/wiki/Flashvars3


if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_main_callback extends webphoto_flash_log {


// constructor

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname );
		//$this->webphoto_flash_log( $dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_main_callback( $dirname, $trust_dirname );
		}

		return $instance;
	}


// main

	function main() {
		$this->callback_log();
	}

}

