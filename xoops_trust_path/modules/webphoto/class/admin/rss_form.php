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


class webphoto_admin_rss_form extends webphoto_lib_form {
	public $_THIS_FCT = 'rss_manager';
	public $_THIS_URL;
	public $_URL_ADMIN_INDEX;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_THIS_URL        = $this->_MODULE_URL . '/admin/index.php?fct=' . $this->_THIS_FCT;
		$this->_URL_ADMIN_INDEX = $this->_MODULE_URL . '/admin/index.php';
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_rss_form( $dirname, $trust_dirname );
		}

		return $instance;
	}


// refresh playlist cache

	function print_form_clear_cache() {
		echo $this->build_form_tag( 'rss_clear', $this->_URL_ADMIN_INDEX );
		echo $this->build_html_token();

		echo $this->build_input_hidden( 'fct', $this->_THIS_FCT );
		echo $this->build_input_hidden( 'op', 'clear_cache' );
		echo $this->build_input_submit( 'submit', _AM_WEBPHOTO_RSS_CLEAR );

		echo $this->build_form_end();
	}

}
