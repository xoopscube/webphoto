<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief class webphoto_d3_notification_select
 * subsitute for core's notification_select.php
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_edit_docomo_create extends webphoto_edit_base_create {


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_docomo_create( $dirname, $trust_dirname );
		}

		return $instance;
	}


// create docomo

	public function create_param( $param ) {
		$this->clear_msg_array();

		if ( ! $this->is_video_docomo_ext( $param['src_ext'] ) ) {
			return null;
		}

// same file as cont
		$docomo_param         = $param;
		$docomo_param['path'] = '';    // null
		$docomo_param['kind'] = _C_WEBPHOTO_FILE_KIND_VIDEO_DOCOMO;
		$this->set_msg( 'create docomo' );

		return $docomo_param;
	}

}
