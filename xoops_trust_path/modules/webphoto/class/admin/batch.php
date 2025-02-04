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


class webphoto_admin_batch extends webphoto_edit_submit {
	public $_TIME_SUCCESS = 1;
	public $_TIME_FAIL = 5;

	public $_SHOW_FORM_ADMIN_EDITOR = true;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->set_flag_admin( true );
		$this->set_fct( 'batch' );
		$this->set_form_mode( 'admin_batch' );

		$this->_factory_create_class->set_msg_level( _C_WEBPHOTO_MSG_LEVEL_ADMIN );
		$this->_factory_create_class->set_flag_print_first_msg( true );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_batch( $dirname, $trust_dirname );
		}

		return $instance;
	}


	public function main() {
		$this->_check_cat();

		if ( ! $this->_check_cat() ) {
			$msg = '<a href="' . $this->_MODULE_URL . '/admin/index.php?fct=catmanager">';
			$msg .= _WEBPHOTO_ERR_MUSTADDCATFIRST;
			$msg .= '</a>';

			xoops_cp_header();
			$this->_print_title();
			echo $this->build_error_msg( $msg, '', false );
			xoops_cp_footer();
			exit();
		}

		$op = $this->get_post_text( 'op' );
		if ( $op == 'submit' ) {
			$this->_submit();
			exit();
		}

		xoops_cp_header();

		$this->_print_title();
		$this->_print_form();

		xoops_cp_footer();

	}

	public function _check_cat() {
// check Categories exist
		$count = $this->_cat_handler->get_count_all();

		return $count > 0;
	}

	public function _print_title() {

		$title = $this->get_admin_title( 'BATCH' );

		echo $this->build_admin_bread_crumb( $title, $this->_THIS_URL );

		echo "<h2>" . $title . "</h2>\n";
	}

// submit
	public function _submit() {

		xoops_cp_header();

		$this->_print_title();

		$this->_exec_submit();

		if ( $this->has_error() ) {
			echo $this->get_format_error( false, true );
			echo "<hr>\n";
		}

		echo "<h4>" . _AM_WEBPHOTO_FINISHED . "</h4>\n";
		echo '<a class="ui-btn" href="index.php">GOTO Admin Menu</a>' . "<br>\n";

		xoops_cp_footer();
	}

	public function _exec_submit() {
		$post_dir    = $this->_post_class->get_post_text( 'batch_dir' );
		$post_update = $this->_post_class->get_post_time( 'item_time_update_disp' );
		$post_uid    = $this->_post_class->get_post_int( 'item_uid', $this->_xoops_uid );

		if ( $post_update > 0 ) {
			$item_time_update = $post_update;
		} else {
			$item_time_update = time();
		}

		if ( ! $this->check_token() ) {
			$this->set_error( 'Token Error' );
			$this->set_error( $this->get_token_errors() );

			return false;
		}

		$dir = $post_dir;

		if ( empty( $dir ) ) {
			$this->set_error( _AM_WEBPHOTO_MES_INVALIDDIRECTORY );
			$this->set_error( $post_dir );

			return false;
		}

		if ( ! is_dir( $dir ) ) {
			$dir    = $this->add_slash_to_head( $dir );
			$prefix = XOOPS_ROOT_PATH;
			while ( strlen( $prefix ) > 0 ) {
				if ( is_dir( $prefix . $dir ) ) {
					$dir = $prefix . $dir;
					break;
				}
				$prefix = substr( $prefix, 0, strrpos( $prefix, '/' ) );
			}

		}

		if ( ! is_dir( $dir ) ) {
			$this->set_error( _AM_WEBPHOTO_MES_INVALIDDIRECTORY );
			$this->set_error( $post_dir );

			return false;
		}

		$dir = $this->strip_slash_from_tail( $dir );

		$dh = opendir( $dir );
		if ( $dh === false ) {
			$this->set_error( _AM_WEBPHOTO_MES_INVALIDDIRECTORY );
			$this->set_error( $post_dir );

			return false;
		}

		// get all file_names from the directory.
		$file_names = array();
		while ( $file_name = readdir( $dh ) ) {
			$file_names[] = $file_name;
		}
		sort( $file_names );
		closedir( $dh );

		$item_row                     = $this->create_item_row_by_post();
		$item_row['item_time_update'] = $item_time_update;
		$item_row['item_uid']         = $post_uid;
		$item_row['item_status']      = _C_WEBPHOTO_STATUS_APPROVED;

		$post_title = $item_row['item_title'];

		$param = array(
			'flag_video_single' => true,
		);

		$filecount = 1;
		foreach ( $file_names as $file_name ) {
			// Skip '.' , '..' and hidden file
			if ( substr( $file_name, 0, 1 ) == '.' ) {
				continue;
			}

			$ext      = $this->parse_ext( $file_name );
			$node     = substr( $file_name, 0, - strlen( $ext ) - 1 );
			$src_file = $dir . '/' . $file_name;

			if ( ! is_readable( $src_file ) ) {
				echo ' Skip : can not read : ' . $this->sanitize( $file_name ) . "<br>\n";
				continue;
			}

			if ( ! $this->is_my_allow_ext( $ext ) ) {
				echo ' Skip : not allow ext : ' . $this->sanitize( $file_name ) . "<br>\n";
				continue;
			}

			$item_row['item_title'] = $this->build_bulk_title( $post_title, $filecount, $node );

			$param['src_file'] = $src_file;

			$this->_factory_create_class->create_item_from_param( $item_row, $param );
			echo $this->_factory_create_class->get_main_msg();
			echo "<br>\n";

			$filecount ++;
		}

		if ( $filecount <= 1 ) {
			$msg = $this->sanitize( $post_dir ) . ' : ' . _AM_WEBPHOTO_MES_BATCHNONE;
		} else {
			$msg = sprintf( _AM_WEBPHOTO_MES_BATCHDONE, $filecount - 1 );
		}

		echo "<br>\n";
		echo "<b>" . $msg . "</b><br>\n";

		return $this->return_code();
	}

// print form
	public function _print_form() {
		$item_row = $this->create_item_row_default();
		$this->init_form();

		if ( $this->_SHOW_FORM_ADMIN_EDITOR ) {
			echo $this->_misc_form_class->build_form_editor_with_template( $this->_FORM_MODE, $item_row );
		}

		echo $this->_photo_form_class->build_form_photo_with_template( $item_row );
	}

}
