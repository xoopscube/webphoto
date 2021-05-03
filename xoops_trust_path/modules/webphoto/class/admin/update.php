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


class webphoto_admin_update extends webphoto_base_this {

	public $_update_check_class;

	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_update_check_class =& webphoto_admin_update_check::getInstance( $dirname, $trust_dirname );

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_update( $dirname, $trust_dirname );
		}

		return $instance;
	}


	public function main() {

		xoops_cp_header();

		echo $this->build_admin_menu();
		echo $this->build_admin_title( 'UPDATE' );

		$op = $this->_post_class->get_post_text( 'op' );

		$url_210  = $this->_update_check_class->get_url( '210' );
		$url_file = $this->_MODULE_URL . '/admin/index.php?fct=create_file_list';

		echo $this->_update_check_class->build_msg( '' );
		// Download XCL Package from GitHub
		echo '<div class="tips"><p>Download XCL packages from 
			<a href="https://github.com/xoopscube/webphoto" target="_blank">
  			<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
  			<g fill="none"><path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385c.6.105.825-.255.825-.57c0-.285-.015-1.23-.015-2.235c-3.015.555-3.795-.735-4.035-1.41c-.135-.345-.72-1.41-1.23-1.695c-.42-.225-1.02-.78-.015-.795c.945-.015 1.62.87 1.845 1.23c1.08 1.815 2.805 1.305 3.495.99c.105-.78.42-1.305.765-1.605c-2.67-.3-5.46-1.335-5.46-5.925c0-1.305.465-2.385 1.23-3.225c-.12-.3-.54-1.53.12-3.18c0 0 1.005-.315 3.3 1.23c.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23c.66 1.65.24 2.88.12 3.18c.765.84 1.23 1.905 1.23 3.225c0 4.605-2.805 5.625-5.475 5.925c.435.375.81 1.095.81 2.22c0 1.605-.015 2.895-.015 3.3c0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/>
  			</g></svg> <strong>GitHub</strong></a></p>';
		echo '<p>To help ensure that you complete all the tasks for a successful upgrade, follow the step-by-step instructions in the upgrade process.</p> </div>';
		echo '<div class="ui-card-full">';

		$this->_print_file_check();


		echo '<h4><a href="' . $url_210 . '">
		<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
		<path  fill="currentColor" d="M12 16.5l4-4h-3v-9h-2v9H8l4 4zm9-13h-6v1.99h6v14.03H3V5.49h6V3.5H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2v-14c0-1.1-.9-2-2-2z"/>
		</svg> Update to v2.1.x</a></h4>';

		echo '<h4><a href="' . $url_file . '">
		<svg xmlns="http://www.w3.org/2000/svg" class="i-tool-list" width="1em" height="1em" viewBox="0 0 24 24">
		<path  fill="currentColor" d="M2 18h7v2H2v-2zm0-7h9v2H2v-2zm0-7h20v2H2V4zm18.674 9.025l1.156-.391l1 1.732l-.916.805a4.017 4.017 0 0 1 0 1.658l.916.805l-1 1.732l-1.156-.391c-.41.37-.898.655-1.435.83L19 21h-2l-.24-1.196a3.996 3.996 0 0 1-1.434-.83l-1.156.392l-1-1.732l.916-.805a4.017 4.017 0 0 1 0-1.658l-.916-.805l1-1.732l1.156.391c.41-.37.898-.655 1.435-.83L17 11h2l.24 1.196c.536.174 1.024.46 1.434.83zM18 18a2 2 0 1 0 0-4a2 2 0 0 0 0 4z"/>
		</svg> Create file check list</a></h4>';
		echo '</div>';
		xoops_cp_footer();
		exit();
	}


	public function _print_file_check() {
		$url = $this->_MODULE_URL . '/admin/index.php?fct=check_file';
		echo '<h4><a href="' . $url . '">
		<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
		<path fill-rule="evenodd" fill="currentColor" d="M20 3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM10 17H5v-2h5v2zm0-4H5v-2h5v2zm0-4H5V7h5v2zm4.82 6L12 12.16l1.41-1.41l1.41 1.42L17.99 9l1.42 1.42L14.82 15z"/>
		</svg> ' . _AM_WEBPHOTO_FILE_CHECK . '</a></h4>
		<p>This should reflect the changes made to XCL version.</p>';
	}

}


