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


class webphoto_admin_rss_manager extends webphoto_base_this {
	public $_form_class;

	public $_template;

	public $_THIS_FCT = 'rss_manager';
	public $_THIS_URL;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_rss_class  =& webphoto_rss::getInstance(
			$dirname, $trust_dirname );
		$this->_form_class =& webphoto_admin_rss_form::getInstance(
			$dirname, $trust_dirname );

		$this->_template = 'db:' . $dirname . '_main_rss.html';

		$this->_THIS_URL = $this->_MODULE_URL . '/admin/index.php?fct=' . $this->_THIS_FCT;
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_rss_manager( $dirname, $trust_dirname );
		}

		return $instance;
	}


	function main() {
		$op = $this->_post_class->get_post_text( 'op' );

		if ( $op == 'clear_cache' ) {
			if ( $this->check_token() ) {
				$this->_rss_class->clear_compiled_tpl();
				redirect_header( $this->_THIS_URL, 1, _AM_WEBPHOTO_RSS_CLEARED );
			}
		}

		xoops_cp_header();

		echo $this->build_admin_menu();
		echo $this->build_admin_title( 'RSS_MANAGER' );

		if ( $this->_token_error_flag ) {
			echo $this->build_error_msg( "Token Error" );
		}

		echo '<a href="' . $this->_MODULE_URL . '/admin/index.php?fct=rss_view" target="_blank">';
		echo '<img src="' . $this->_MODULE_URL . '/images/icons/rss.png" border="0" /> ';
		echo _AM_WEBPHOTO_RSS_DEBUG;
		echo '</a>';
		echo "<br><br>\n";

		$this->_form_class->print_form_clear_cache();

		xoops_cp_footer();
		exit();
	}


}


