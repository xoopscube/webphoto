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


class webphoto_edit_misc_form extends webphoto_edit_form {
	public $_editor_class;
	public $_ffmpeg_class;
	public $_icon_build_class;
	public $_kind_class;

	public $_ini_kind_list_video = null;

	public $_VIDEO_THUMB_WIDTH = 120;
	public $_VIDEO_THUMB_MAX = _C_WEBPHOTO_VIDEO_THUMB_PLURAL_MAX;


// constructor

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_editor_class
			               =& webphoto_editor::getInstance( $dirname, $trust_dirname );
		$this->_ffmpeg_class
			               =& webphoto_ffmpeg::getInstance( $dirname, $trust_dirname );
		$this->_icon_build_class
			               =& webphoto_edit_icon_build::getInstance( $dirname );
		$this->_kind_class =& webphoto_kind::getInstance();

		$this->_ini_kind_list_video = $this->explode_ini( 'item_kind_list_video' );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_misc_form( $dirname, $trust_dirname );
		}

		return $instance;
	}


// editor

	public function build_form_editor_with_template( $mode, $item_row ) {
		$template = 'db:' . $this->_DIRNAME . '_form_editor.html';

		[ $show_editor, $param_editor ] =
			$this->build_form_editor( $item_row, $mode );

		if ( ! $show_editor ) {
			return '';
		}

		$arr = array_merge(
			$this->build_form_select_param( $mode ),
			$this->build_form_base_param(),
			$this->build_item_row( $item_row ),
			$param_editor
		);

		$tpl = new XoopsTpl();
		$tpl->assign( $arr );

		return $tpl->fetch( $template );
	}

	public function build_form_editor( $item_row, $mode = null ) {
		$options = $this->_editor_class->build_list_options( true );

		if ( ! $this->is_show_form_editor_option( $options ) ) {
			return array( false, array() );
		}

		$param = array(
			'mode'    => $this->get_form_mode_default( $mode ),
			'options' => $options
		);

		$arr = array(
			true,
			$this->build_form_editor_with_param( $item_row, $param )
		);

		return $arr;
	}

	public function build_form_editor_with_param( $row, $param ) {
		$mode    = $param['mode'];
		$options = $param['options'];

		switch ( $mode ) {
			case 'bulk':
				$op = 'bulk_form';
				break;

			case 'file':
				$op = 'file_form';
				break;

			case 'admin_modify':
				$op = 'modify_form';
				break;

			case 'user_submit':
			case 'admin_submit':
			case 'admin_batch':
			default:
				$op = 'submit_form';
				break;
		}

		$this->set_row( $row );

		$arr = array(
			'op_editor'                  => $op,
			'item_editor_select_options' => $this->item_editor_select_options( $options ),
		);

		return $arr;
	}

	public function item_editor_select_options( $options ) {
		$value = $this->get_item_editor( true );

		return $this->build_form_options( $value, $options );
	}


// embed

	public function build_form_embed_with_template( $mode, $item_row ) {
		$template = 'db:' . $this->_DIRNAME . '_form_embed.html';

		if ( ! $this->is_show_form_admin( $item_row ) ) {
			return '';
		}

		$arr = array_merge(
			$this->build_form_select_param( $mode ),
			$this->build_form_base_param(),
			$this->build_form_embed_with_row( $item_row ),
			$this->build_item_row( $item_row )
		);

		$tpl = new XoopsTpl();
		$tpl->assign( $arr );

		return $tpl->fetch( $template );
	}

	public function build_form_embed( $item_row ) {
		if ( ! $this->is_show_form_embed() ) {
			return array( false, array() );
		}

		return array(
			true,
			$this->build_form_embed_with_row( $item_row )
		);
	}

	public function build_form_embed_with_row( $item_row ) {
		$this->set_row( $item_row );

		return array(
			'item_embed_type_select_options' => $this->item_embed_type_select_options()
		);
	}


// video thumb

	public function build_form_video_thumb_with_template( $mode, $row ) {
		$template = 'db:' . $this->_DIRNAME . '_form_video_thumb.html';

		$arr = array_merge(
			$this->build_form_mode_param( $mode ),
			$this->build_form_base_param(),
			$this->build_form_video_thumb( $row, true )
		);

		$tpl = new XoopsTpl();
		$tpl->assign( $arr );

		return $tpl->fetch( $template );
	}

	public function build_form_video_thumb( $row, $flag_row ) {
		$param = array(
			'video_thumb_array'    => $this->build_video_thumb_array( $row ),
			'colspan_video_submit' => $this->_VIDEO_THUMB_MAX + 1,
		);

		if ( $flag_row ) {
			$arr = array_merge( $param, $this->build_item_row( $row ) );
		} else {
			$arr = $param;
		}

		return $arr;
	}

	public function build_video_thumb_array( $row ) {
		$item_id = $row['item_id'];
		$ext     = $row['item_ext'];

		$arr = array();
		for ( $i = 0; $i <= $this->_VIDEO_THUMB_MAX; $i ++ ) {
			$src   = null;
			$width = 0;

// default icon
			if ( $i == 0 ) {
				list( $name, $width, $height ) =
					$this->_icon_build_class->build_icon_image( $ext );
				if ( $name ) {
					$src = $this->_ROOT_EXTS_URL . '/' . $name;
				}

// created thumbs
			} else {
				$name  = $this->_ffmpeg_class->build_thumb_name( $item_id, $i );
				$file  = $this->_TMP_DIR . '/' . $name;
				$width = $this->_VIDEO_THUMB_WIDTH;

				if ( is_file( $file ) ) {
					$name_encode = rawurlencode( $name );
					$src         = $this->_MODULE_URL . '/index.php?fct=image_tmp&name=' . $name_encode;
				}
			}

			$arr[] = array(
				'src_s' => $this->sanitize( $src ),
				'width' => $width,
				'num'   => $i,
			);
		}

		return $arr;
	}


// redo

	public function build_form_redo_with_template( $mode, $item_row, $flash_row ) {
		$template = 'db:' . $this->_DIRNAME . '_form_redo.html';

		if ( ! $this->is_show_form_redo( $item_row ) ) {
			return '';
		}

		$arr = array_merge(
			$this->build_form_mode_param( $mode ),
			$this->build_form_base_param(),
			$this->build_form_redo_by_flash_row( $flash_row ),
			$this->build_item_row( $item_row )
		);

		$tpl = new XoopsTpl();
		$tpl->assign( $arr );

		return $tpl->fetch( $template );
	}

	public function build_form_redo_by_item_row( $item_row ) {
		if ( ! $this->is_show_form_redo( $item_row ) ) {
			return array( false, array() );
		}

// Fatal error: Call to undefined method get_cached_file_row_by_kind()
		$flash_row = $this->get_cached_file_extend_row_by_kind(
			$item_row, _C_WEBPHOTO_FILE_KIND_VIDEO_FLASH );

		return array(
			true,
			$this->build_form_redo_by_flash_row( $flash_row )
		);
	}

	public function build_form_redo_by_flash_row( $flash_row ) {
		return array(
			'flash_url_s' => $this->build_flash_url_s( $flash_row )
		);
	}

	public function build_flash_url_s( $flash_row ) {
		return $this->sanitize(
			$this->build_file_url_by_file_row( $flash_row ) );
	}

	public function is_show_form_redo( $item_row ) {
		if ( $this->is_video_kind( $item_row['item_kind'] ) ) {
			return true;
		}

		return false;
	}

	public function is_video_kind( $kind ) {
		if ( in_array( $kind, $this->_ini_kind_list_video ) ) {
			return true;
		}

		return false;
	}

}
