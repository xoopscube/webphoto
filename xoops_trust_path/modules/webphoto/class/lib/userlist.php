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


class webphoto_lib_userlist {

	public $_member_handler;

	public function __construct() {
		$this->_member_handler =& xoops_gethandler( 'member' );
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_userlist();
		}

		return $instance;
	}

	public function build_param_by_groupid( $group_id, $limit = 0, $start = 0 ) {
		$arr = array(
			'group_id'  => $group_id,
			'total'     => $this->get_user_count_by_groupid( $group_id ),
			'user_list' => $this->get_users_by_groupid( $group_id, $limit, $start ),
		);
		if ( defined( 'XOOPS_CUBE_LEGACY' ) ) {
			$arr['xoops_cube_legacy'] = XOOPS_CUBE_LEGACY;
		}

		return $arr;
	}

	public function get_user_count_by_groupid( $group_id ) {
		return $this->_member_handler->getUserCountByGroup( $group_id );
	}

	public function get_users_by_groupid( $group_id, $limit = 0, $start = 0 ) {
		$users = $this->_member_handler->getUsersByGroup( $group_id, true, $limit, $start );

		$arr = array();
		foreach ( $users as $user ) {
			$uid          = $user->getVar( 'uid', 'n' );
			$uname        = $user->getVar( 'uname', 'n' );
			$name         = $user->getVar( 'name', 'n' );
			$user_regdate = $user->getVar( 'user_regdate', 'n' );
			$last_login   = $user->getVar( 'last_login', 'n' );
			$posts        = $user->getVar( 'posts', 'n' );
			$level        = $user->getVar( 'level', 'n' );

			$arr[] = array(
				'uid'               => $uid,
				'uname'             => $uname,
				'name'              => $name,
				'user_regdate'      => $user_regdate,
				'last_login'        => $last_login,
				'posts'             => $posts,
				'level'             => $level,
				'uname_s'           => $this->sanitize( $uname ),
				'name_s'            => $this->sanitize( $name ),
				'user_regdate_disp' => formatTimestamp( $user_regdate, 's' ),
				'last_login_disp'   => formatTimestamp( $last_login, 'l' ),
			);
		}

		return $arr;
	}

	public function sanitize( $str ) {
		return htmlspecialchars( $str, ENT_QUOTES );
	}

}

