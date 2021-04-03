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


class webphoto_inc_handler {
	public $_db;
	public $_db_error;

	public $_xoops_groups = null;

	public $_DIRNAME;
	public $_MODULE_URL;
	public $_MODULE_DIR;

	public $_ROOT_EXTS_URL;
	public $_DEFAULT_ICON_SRC;
	public $_PIXEL_ICON_SRC;

	public $_NORMAL_EXTS;

	public $_PERM_ALLOW_ALL = '*';
	public $_PERM_DENOY_ALL = 'x';
	public $_PERM_SEPARATOR = '&';

	public $_DEBUG_SQL = false;
	public $_DEBUG_ERROR = 0;


	public function __construct() {
		$this->_db =& Database::getInstance();

		$this->_init_xoops_groups();
	}

	public function init_handler( $dirname ) {
		$this->_DIRNAME    = $dirname;
		$this->_MODULE_URL = XOOPS_URL . '/modules/' . $dirname;
		$this->_MODULE_DIR = XOOPS_ROOT_PATH . '/modules/' . $dirname;

		$this->_ROOT_EXTS_URL    = $this->_MODULE_URL . '/images/exts';
		$this->_DEFAULT_ICON_SRC = $this->_MODULE_URL . '/images/exts/default.png';
		$this->_PIXEL_ICON_SRC   = $this->_MODULE_URL . '/images/icons/pixel_trans.png';

		$constpref = strtoupper( '_P_' . $dirname . '_' );
		$this->set_debug_sql_by_const_name( $constpref . 'DEBUG_INC_SQL' );
		$this->set_debug_error_by_const_name( $constpref . 'DEBUG_INC_ERROR' );
	}


// xoops config table
	public function update_xoops_config() {
		// configs (Though I know it is not a recommended way...)
		$table_config = $this->_db->prefix( "config" );

		$check_sql = "SHOW COLUMNS FROM " . $table_config . " LIKE 'conf_title'";
		$row       = $this->get_row_by_sql( $check_sql );
		if ( ! is_array( $row ) ) {
			return false;
		}

// default: varchar(30)
		if ( preg_match( '/varchar\((\d+)\)/i', $row['Type'], $matches ) ) {
			if ( $matches[1] > 30 ) {
				return true;
			}
		}

		$sql = "ALTER TABLE " . $table_config;
		$sql .= " MODIFY `conf_title` varchar(191) NOT NULL default '', ";
		$sql .= " MODIFY `conf_desc`  varchar(191) NOT NULL default '' ";

		return $this->query( $sql );
	}


// xoops config item table
	public function get_xoops_config_mod_objs( $mid ) {
		$config_item_handler =& xoops_gethandler( 'ConfigItem' );
		$criteria            = new CriteriaCompo( new Criteria( 'conf_modid', $mid ) );

		return $config_item_handler->getObjects( $criteria );
	}

	public function get_xoops_config_mod_obj( $mid, $name ) {
		$objs = $this->get_xoops_config_mod_objs( $mid );

		return $objs[ $name ] ?? false;
	}

	public function get_xoops_config_mod_val( $mid, $name ) {
		$obj = $this->get_xoops_config_mod_obj( $mid, $name );
		if ( is_object( $obj ) ) {
			return $obj->getVar( 'conf_value' );
		}

		return false;
	}

	public function save_xoops_config_mod( $mid, $name, $val ) {
		$config_item_handler =& xoops_gethandler( 'ConfigItem' );
		$obj                 = (int) $this->get_xoops_config_mod_obj( $mid, $name );
		if ( is_object( $obj ) ) {
			$obj->setVar( 'conf_value', $val );

			return $config_item_handler->update( $obj );
		}

		return false;
	}

	public function get_cat_row_by_id( $cat_id ) {
		$sql = 'SELECT * FROM ' . $this->prefix_dirname( 'cat' );
		$sql .= ' WHERE cat_id=' . (int) $cat_id;

		return $this->get_row_by_sql( $sql );
	}

	public function get_item_row_by_id( $item_id ) {
		$sql = 'SELECT * FROM ' . $this->prefix_dirname( 'item' );
		$sql .= ' WHERE item_id=' . (int) $item_id;

		return $this->get_row_by_sql( $sql );
	}

	function build_show_icon_image( $item_row ) {
		$url    = null;
		$name   = $item_row['item_icon_name'];
		$width  = $item_row['item_icon_width'];
		$height = $item_row['item_icon_height'];
		if ( $name ) {
			$url = $this->_ROOT_EXTS_URL . '/' . $name;
		}

		return array( $url, $width, $height );
	}


// file handler
	function get_file_extend_row_by_kind( $item_row, $kind ) {
		$id = $this->get_file_id_by_kind( $item_row, $kind );
		if ( $id > 0 ) {
			$row = $this->get_file_row_by_id( $id );
			if ( is_array( $row ) ) {
				$row['file_full'] = $this->build_full_path( $row['file_path'] );

				return $row;
			}
		}

		return false;
	}

	function get_file_row_by_kind( $item_row, $kind ) {
		$id = $this->get_file_id_by_kind( $item_row, $kind );
		if ( $id > 0 ) {
			return $this->get_file_row_by_id( $id );
		}

		return false;
	}

	function get_file_id_by_kind( $item_row, $kind ) {
		$name = $this->file_kind_to_item_name( $kind );

		return $item_row[ $name ] ?? false;
	}

	function file_kind_to_item_name( $kind ) {
		return 'item_file_id_' . $kind;
	}

	function get_file_row_by_id( $file_id ) {
		$sql = 'SELECT * FROM ' . $this->prefix_dirname( 'file' );
		$sql .= ' WHERE file_id=' . (int) $file_id;

		return $this->get_row_by_sql( $sql );
	}

	function build_show_file_image( $file_row ) {
		$url    = null;
		$width  = 0;
		$height = 0;

		if ( is_array( $file_row ) ) {
			$url    = $file_row['file_url'];
			$path   = $file_row['file_path'];
			$width  = $file_row['file_width'];
			$height = $file_row['file_height'];
			$url    = $this->build_full_url( $path );
		}

		return array( $url, $width, $height );
	}

	function build_full_path( $path ) {
		if ( $path ) {
			$str = XOOPS_ROOT_PATH . $path;

			return $str;
		}

		return null;
	}

	function build_full_url( $path ) {
		if ( $path ) {
			$str = XOOPS_URL . $path;

			return $str;
		}

		return null;
	}

	function get_count_by_sql( $sql ) {
		return (int) $this->get_first_row_by_sql( $sql );
	}

	function get_first_row_by_sql( $sql ) {
		$res = $this->query( $sql );
		if ( ! $res ) {
			return false;
		}

		$row = $this->_db->fetchRow( $res );

		return $row[0] ?? false;
	}

	function get_row_by_sql( $sql ) {
		$res = $this->query( $sql );
		if ( ! $res ) {
			return false;
		}

		return $this->_db->fetchArray( $res );
	}

	function get_rows_by_sql( $sql, $limit = 0, $offset = 0, $key = null ) {
		$arr = array();

		$res = $this->query( $sql, $limit, $offset );
		if ( ! $res ) {
			return false;
		}

		while ( $row = $this->_db->fetchArray( $res ) ) {
			if ( $key && isset( $row[ $key ] ) ) {
				$arr[ $row[ $key ] ] = $row;
			} else {
				$arr[] = $row;
			}
		}

		return $arr;
	}

	function get_first_rows_by_sql( $sql, $limit = 0, $offset = 0 ) {
		$res = $this->query( $sql, $limit, $offset );
		if ( ! $res ) {
			return false;
		}

		$arr = array();

		while ( $row = $this->_db->fetchRow( $res ) ) {
			$arr[] = $row[0];
		}

		return $arr;
	}


// update
	function exists_table( $table ) {
		$sql = "SHOW TABLES LIKE " . $this->quote( $table );

		$res = $this->query( $sql );
		if ( ! $res ) {
			return false;
		}

		while ( $row = $this->_db->fetchRow( $res ) ) {
			if ( strtolower( $row[0] ) == strtolower( $table ) ) {
				return true;
			}
		}

		return false;
	}


// handler
	function query( $sql, $limit = 0, $offset = 0, $force = false ) {
// BUG: echo sql always if error
		$flag_echo_sql = false;

		if ( $force ) {
			return $this->queryF( $sql, $limit, $offset );
		}

		$sql_full = $sql . ': limit=' . $limit . ' :offset=' . $offset;

		if ( $this->_DEBUG_SQL ) {
			$flag_echo_sql = true;
			echo $this->sanitize( $sql_full ) . "<br>\n";
		}

		$res = $this->_db->query( $sql, (int) $limit, (int) $offset );
		if ( ! $res ) {
			$this->_db_error = $this->_db->error();
			if ( empty( $error ) ) {
				$error = 'Database update not allowed during processing of a GET request';
			}
			if ( $this->_DEBUG_SQL && ! $flag_echo_sql ) {
				echo $this->sanitize( $sql_full ) . "<br>\n";
			}
			if ( $this->_DEBUG_ERROR ) {
				echo $this->highlight( $this->_db_error ) . "<br>\n";
			}
			if ( $this->_DEBUG_ERROR > 1 ) {
				debug_print_backtrace();
			}
		}

		return $res;
	}

	function queryF( $sql, $limit = 0, $offset = 0 ) {
		if ( $this->_DEBUG_SQL ) {
			echo $this->sanitize( $sql ) . ': limit=' . $limit . ' :offset=' . $offset . "<br>\n";
		}

		$res = $this->_db->queryF( $sql, (int) $limit, (int) $offset );
		if ( ! $res ) {
			$this->_db_error = $this->_db->error();
			if ( $this->_DEBUG_ERROR ) {
				echo $this->highlight( $this->_db_error ) . "<br>\n";
			}
		}

		return $res;
	}

	function prefix_dirname( $name ) {
		return $this->_db->prefix( $this->_DIRNAME . '_' . $name );
	}

	function quote( $str ) {
		$str = "'" . addslashes( $str ) . "'";

		return $str;
	}


// column
	function preg_match_column_type( $table, $column, $type ) {
		$pattern = '/' . preg_quote( $type ) . '/i';
		$subject = $this->get_column_type( $table, $column );
		if ( preg_match( $pattern, $subject ) ) {
			return true;
		}

		return false;
	}

	function preg_match_column_type_array( $table, $column, $type_array ) {
		$subject = $this->get_column_type( $table, $column );
		foreach ( $type_array as $type ) {
			$pattern = '/' . preg_quote( $type ) . '/i';
			if ( preg_match( $pattern, $subject ) ) {
				return true;
			}
		}

		return false;
	}

	function get_column_type( $table, $column ) {
		$row = $this->get_column_row( $table, $column );

		return $row['Type'] ?? false;
	}

	function exists_column( $table, $column ) {
		$row = $this->get_column_row( $table, $column );
		if ( is_array( $row ) ) {
			return true;
		}

		return false;
	}

	function get_column_row( $table, $column ) {
		$false = false;

		$sql = "SHOW COLUMNS FROM " . $table . " LIKE " . $this->quote( $column );

		$res = $this->query( $sql );
		if ( ! $res ) {
			return $false;
		}

		while ( $row = $this->_db->fetchArray( $res ) ) {
			if ( $row['Field'] == $column ) {
				return $row;
			}
		}

		return $false;
	}


// item cat handler
// require $_xoops_groups $_cfg_perm_item_read

	function build_where_public_with_item_cat( $groups = null ) {
		$where = $this->convert_item_field(
			$this->build_where_public_with_item() );
		$where .= ' AND ';
		$where .= $this->build_where_cat_perm_read( $groups );

		return $where;
	}

	function build_where_public_with_item( $groups = null ) {
		$where = ' item_status > 0 ';
		if ( $this->_cfg_perm_item_read != _C_WEBPHOTO_OPT_PERM_READ_ALL ) {
			$where .= ' AND ';
			$where .= $this->build_where_item_perm_read( $groups );
		}

		return $where;
	}

	function build_where_cat_perm_read( $groups = null ) {
		return $this->build_where_perm_groups( 'c.cat_perm_read', $groups );
	}

	function build_where_item_perm_read( $groups = null ) {
		return $this->build_where_perm_groups( 'item_perm_read', $groups );
	}

	function get_item_count_by_where_with_cat( $where ) {
		$sql = 'SELECT COUNT(*) FROM ';
		$sql .= $this->prefix_dirname( 'item' ) . ' i ';
		$sql .= ' INNER JOIN ';
		$sql .= $this->prefix_dirname( 'cat' ) . ' c ';
		$sql .= ' ON i.item_cat_id = c.cat_id ';
		$sql .= ' WHERE ' . $where;

		return $this->get_count_by_sql( $sql );
	}

	function get_item_count_by_where( $where ) {
		$sql = 'SELECT COUNT(*) FROM ';
		$sql .= $this->prefix_dirname( 'item' );
		$sql .= ' WHERE ' . $where;

		return $this->get_count_by_sql( $sql );
	}

	function get_item_rows_by_where_orderby_with_cat(
		$where, $orderby, $limit = 0, $offset = 0, $key = null
	) {
		$sql = 'SELECT i.* FROM ';
		$sql .= $this->prefix_dirname( 'item' ) . ' i ';
		$sql .= ' INNER JOIN ';
		$sql .= $this->prefix_dirname( 'cat' ) . ' c ';
		$sql .= ' ON i.item_cat_id = c.cat_id ';
		$sql .= ' WHERE ' . $where;
		$sql .= ' ORDER BY ' . $orderby;

		return $this->get_rows_by_sql( $sql, $limit, $offset, $key );
	}

	function get_item_rows_by_where_orderby(
		$where, $orderby, $limit = 0, $offset = 0, $key = null
	) {
		$sql = 'SELECT * FROM ';
		$sql .= $this->prefix_dirname( 'item' );
		$sql .= ' WHERE ' . $where;
		$sql .= ' ORDER BY ' . $orderby;

		return $this->get_rows_by_sql( $sql, $limit, $offset, $key );
	}

	function convert_item_field( $str ) {
		return str_replace( 'item_', 'i.item_', $str );
	}


// permission
	function build_where_perm_groups( $name, $groups = null ) {
		if ( empty( $groups ) ) {
			$groups = $this->_xoops_groups;
		}

		$pre  = '%' . $this->_PERM_SEPARATOR;
		$post = $this->_PERM_SEPARATOR . '%';

		$where = $name . '=' . $this->quote( $this->_PERM_ALLOW_ALL );

		if ( is_array( $groups ) && count( $groups ) ) {
			foreach ( $groups as $group ) {
				$where .= ' OR ' . $name . ' LIKE ';
				$where .= $this->quote( $pre . (int) $group . $post );
			}
		}

		return ' ( ' . $where . ' ) ';
	}

	function check_perm_by_row_name_groups( $row, $name, $groups = null ) {
		if ( ! isset( $row[ $name ] ) ) {
			return false;
		}

		$val = $row[ $name ];

		if ( $this->_PERM_ALLOW_ALL && ( $val == $this->_PERM_ALLOW_ALL ) ) {
			return true;
		}

		if ( $this->_PERM_DENOY_ALL && ( $val == $this->_PERM_DENOY_ALL ) ) {
			return false;
		}

		$perms = $this->str_to_array( $val, $this->_PERM_SEPARATOR );

		return $this->check_perms_in_groups( $perms, $groups );
	}

	function check_perms_in_groups( $perms, $groups = null ) {
		if ( ! is_array( $perms ) || ! count( $perms ) ) {
			return false;
		}

		if ( empty( $groups ) ) {
			$groups = $this->_xoops_groups;
		}

		$arr = array_intersect( $groups, $perms );
		if ( is_array( $arr ) && count( $arr ) ) {
			return true;
		}

		return false;
	}


// utility
	function str_to_array( $str, $pattern ) {
		$arr1 = explode( $pattern, $str );
		$arr2 = array();
		foreach ( $arr1 as $v ) {
			$v = trim( $v );
			if ( $v == '' ) {
				continue;
			}
			$arr2[] = $v;
		}

		return $arr2;
	}

	function array_to_str( $arr, $glue ) {
		$val = false;
		if ( is_array( $arr ) && count( $arr ) ) {
			$val = implode( $glue, $arr );
		}

		return $val;
	}

	function is_normal_ext( $ext ) {
		if ( in_array( strtolower( $ext ), $this->_NORMAL_EXTS ) ) {
			return true;
		}

		return false;
	}

	function set_normal_exts( $val ) {
		if ( is_array( $val ) ) {
			$this->_NORMAL_EXTS = $val;
		} else {
			$this->_NORMAL_EXTS = explode( '|', $val );
		}
	}

	function is_video_mime( $mime ) {
		if ( preg_match( '/^video/', $mime ) ) {
			return true;
		}

		return false;
	}

	function is_image_kind( $kind ) {
		return $kind == _C_WEBPHOTO_ITEM_KIND_IMAGE;
	}

	function is_video_kind( $kind ) {
		return $kind == _C_WEBPHOTO_ITEM_KIND_VIDEO;
	}

	function is_embed_kind( $kind ) {
		return $kind == _C_WEBPHOTO_ITEM_KIND_EMBED;
	}

	function is_external_image_kind( $kind ) {
		return $kind == _C_WEBPHOTO_ITEM_KIND_EXTERNAL_IMAGE;
	}

	function check_http_null( $str ) {
		return ( $str == '' ) || ( $str == 'http://' ) || ( $str == 'https://' );
	}

	function check_http_start( $str ) {
		if ( preg_match( "|^https?://|", $str ) ) {
			return true;    // include HTTP
		}

		return false;
	}

	function add_slash_to_head( $str ) {
// ord : the ASCII value of the first character of string
// 0x2f slash

		if ( ord( $str ) != 0x2f ) {
			$str = "/" . $str;
		}

		return $str;
	}


// error
	function get_db_error( $flag_sanitize = true, $flag_highlight = true ) {
		$str = $this->_db_error;
		if ( $flag_sanitize ) {
			$str = $this->sanitize( $str );
		}
		if ( $flag_highlight ) {
			$str = $this->highlight( $str );
		}

		return $str;
	}

	function sanitize( $str ) {
		return htmlspecialchars( $str, ENT_QUOTES );
	}

	function highlight( $str ) {
		return '<span style="color:#ff0000;">' . $str . '</span>';
	}


// debug
	function set_debug_sql_by_const_name( $name ) {
		$name = strtoupper( $name );
		if ( defined( $name ) ) {
			$this->set_debug_sql( constant( $name ) );
		}
	}

	function set_debug_error_by_const_name( $name ) {
		$name = strtoupper( $name );
		if ( defined( $name ) ) {
			$this->set_debug_error( constant( $name ) );
		}
	}

	function set_debug_sql( $val ) {
		echo " set_debug_sql( $val ) ";

		$this->_DEBUG_SQL = (bool) $val;
	}

	function set_debug_error( $val ) {
		$this->_DEBUG_ERROR = (int) $val;
	}


// xoops groups

	function _init_xoops_groups() {
		global $xoopsUser;
		if ( is_object( $xoopsUser ) ) {
			$this->_xoops_groups = $xoopsUser->getGroups();
		} else {
			$this->_xoops_groups = array( XOOPS_GROUP_ANONYMOUS );
		}
	}

}

