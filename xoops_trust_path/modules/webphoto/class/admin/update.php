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


	function main() {
		xoops_cp_header();

		echo $this->build_admin_menu();
		echo $this->build_admin_title( 'UPDATE' );

		$op = $this->_post_class->get_post_text( 'op' );

		$url_210  = $this->_update_check_class->get_url( '210' );
		$url_file = $this->_MODULE_URL . '/admin/index.php?fct=create_file_list';

		echo $this->_update_check_class->build_msg( '' );
		echo "<br>\n";

		$this->_print_file_check();

		echo ' - <a href="' . $url_210 . '">';
		echo "Update v2.00 to v2.10";
		echo "</a><br><br>\n";

		echo ' - <a href="' . $url_file . '">';
		echo "Create file check list";
		echo "</a><br><br>\n";

		echo '- Older than v2.00 <br>';
		echo '  Please download packages from <a href="https://github.com/XoopsX/webphoto" target="_blank"><span style="font-size: 120%; font-weight: bold;">GitHub</span></a> <br>';
		echo '  and version up step by step, <br>';
		echo '  if you use the version older than v2.00. <br>';

		xoops_cp_footer();
		exit();
	}


	function _print_file_check() {
		$url = $this->_MODULE_URL . '/admin/index.php?fct=check_file';

		echo '- <a href="' . $url . '">';
		echo _AM_WEBPHOTO_FILE_CHECK;
		echo "</a><br><br>\n";
	}


}


