<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief class webphoto_d3_notification_select
 * subsitute for core's notification_select.php
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_edit_cont_create extends webphoto_edit_base_create {

	public $_cont_param = null;

	public $_SUB_DIR_PHOTOS = 'photos';


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_cont_create( $dirname, $trust_dirname );
		}

		return $instance;
	}


	public function create_param( $p ) {
		$this->clear_msg_array();

		$item_id  = $p['item_id'];
		$src_file = $p['src_file'];
		$src_ext  = $p['src_ext'];
		$mime     = isset( $p['src_mime'] ) ? $p['src_mime'] : null;
		$duration = isset( $p['item_duration'] ) ? (int) $p['item_duration'] : 0;
		$width    = isset( $p['item_width'] ) ? (int) $p['item_width'] : 0;
		$height   = isset( $p['item_height'] ) ? (int) $p['item_height'] : 0;

		$name_param = $this->build_random_name_param( $item_id, $src_ext, $this->_SUB_DIR_PHOTOS );
		$name       = $name_param['name'];
		$path       = $name_param['path'];
		$file       = $name_param['file'];
		$url        = $name_param['url'];

// set width if image
		if ( $this->is_image_ext( $src_ext ) ) {
			$image_size = GetImageSize( $src_file );
			if ( is_array( $image_size ) ) {
				$width  = $image_size[0];
				$height = $image_size[1];
				if ( empty( $mime ) ) {
					$mime = $image_size['mime'];
				}
			}
		}

// set mime if not
		if ( empty( $mime ) ) {
			$mime = $this->ext_to_mime( $src_ext );
		}

		$medium = $this->mime_to_medium( $mime );

		copy( $src_file, $file );

		$arr = array(
			'url'      => XOOPS_URL . $path,
			'path'     => $path,
			'name'     => $name,
			'ext'      => $src_ext,
			'mime'     => $mime,
			'medium'   => $medium,
			'width'    => $width,
			'height'   => $height,
			'duration' => $duration,
			'size'     => filesize( $src_file ),
			'kind'     => _C_WEBPHOTO_FILE_KIND_CONT
		);

		$this->_cont_param = $arr;

		return 0;
	}


// get param

	public function get_param() {
		return $this->_cont_param;
	}
}
