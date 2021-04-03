<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief class Database
 * substitute for class XOOPS Database
 * base on happy_linux/class/xoops_database.php
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class Database {

	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
// Assigning the return value of new by reference is deprecated
			$instance = new mysql_database();
			if ( ! $instance->connect() ) {
				echo "<div class='error'><span style='color:red'>Unable to connect to database.</span></div>\n";
				die();
			}
		}

		return $instance;
	}


// function

	public function prefix( $tablename = '' ) {
		if ( $tablename != '' ) {
			return XOOPS_DB_PREFIX . '_' . $tablename;
		} else {
			return XOOPS_DB_PREFIX;
		}
	}

}
