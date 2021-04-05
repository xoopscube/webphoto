<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief class mysql_database
 * substitute for class XOOPS XoopsMySQLDatabase
 * base on happy_linux/class/xoops_mysql_database.php
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class mysql_database extends Database {

// Database connection
	public $conn;

	public $prefix;

// debug
	public $flag_print_error = 1;


	public function __construct() {
		parent::__construct();
		$this->setPrefix( XOOPS_DB_PREFIX );
	}


// function

	public function connect() {
		$this->conn = mysqli_connect( XOOPS_DB_HOST, XOOPS_DB_USER, XOOPS_DB_PASS );

		if ( ! $this->conn ) {
			$this->_print_error();

			return false;
		}

		if ( ! mysqli_select_db( $this->conn, XOOPS_DB_NAME ) ) {
			$this->_print_error();

			return false;
		}

		return true;
	}

	public function set_charset() {
		if ( defined( '_WEBPHOTO_MYSQL_CHARSET' ) ) {
			$sql = '/*!40101 SET NAMES ' . _WEBPHOTO_MYSQL_CHARSET . ' */';
			$ret = $this->query( $sql );
			if ( ! $ret ) {
				$this->_print_error();

				return false;
			}
		}

		return true;
	}

	public function fetchRow( $result ) {
		return @mysqli_fetch_row( $result );
	}

	public function fetchArray( $result ) {
		return @mysqli_fetch_assoc( $result );
	}

	public function fetchBoth( $result ) {
		return @mysqli_fetch_array( $result, MYSQLI_BOTH );
	}

	public function getInsertId() {
		return mysqli_insert_id( $this->conn );
	}

	public function getRowsNum( $result ) {
		return @mysqli_num_rows( $result );
	}

	public function getAffectedRows() {
		return mysqli_affected_rows( $this->conn );
	}

	public function close() {
		mysqli_close( $this->conn );
	}

	public function freeRecordSet( $result ) {
		return mysqli_free_result( $result );
	}

	public function error() {
		return @mysqli_error( $this->conn );
	}

	public function errno() {
		return @mysqli_errno( $this->conn );
	}

	public function quoteString( $str ) {
		$str = "'" . str_replace( '\\"', '"', addslashes( $str ) ) . "'";

		return $str;
	}

	public function &queryF( $sql, $limit = 0, $start = 0 ) {
		if ( ! empty( $limit ) ) {
			if ( empty( $start ) ) {
				$start = 0;
			}
			$sql = $sql . ' LIMIT ' . (int) $start . ', ' . (int) $limit;
		}

		$result = mysqli_query( $this->conn, $sql );

		if ( ! $result ) {
			$this->_print_error( $sql );
			$false = false;

			return $false;
		}

		return $result;
	}

	public function &query( $sql, $limit = 0, $start = 0 ) {
		return $this->queryF( $sql, $limit, $start );
	}

	public function setPrefix( $value ) {
		$this->prefix = $value;
	}

	public function prefix( $tablename = '' ) {
		if ( $tablename != '' ) {
			return $this->prefix . '_' . $tablename;
		} else {
			return $this->prefix;
		}
	}


// debug

	public function _print_error( $sql = '' ) {
		if ( ! $this->flag_print_error ) {
			return;
		}

		if ( $sql ) {
			echo "sql: $sql <br>\n";
		}

		echo "<div class='error'><span style='color:red'>" . $this->error() . "</span></div><br>\n";
	}
}
