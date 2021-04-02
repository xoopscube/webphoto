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


class webphoto_admin_gicon_form extends webphoto_edit_form {
	public $_gicon_handler;

	public $_cfg_fsize = 0;
	public $_cfg_gicon_width = 0;

	public $_THIS_FCT = 'giconmanager';
	public $_THIS_URL;

	public $_URL_SIZE = 80;

	public $_IMAGE_FIELD_NAME = _C_WEBPHOTO_UPLOAD_FIELD_GICON;
	public $_SHADOW_FIELD_NAME = _C_WEBPHOTO_UPLOAD_FIELD_GSHADOW;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_gicon_handler
			=& webphoto_gicon_handler::getInstance( $dirname, $trust_dirname );

		$this->_cfg_fsize       = $this->_config_class->get_by_name( 'fsize' );
		$this->_cfg_gicon_width = $this->_config_class->get_by_name( 'gicon_width' );

		$this->_THIS_URL = $this->_MODULE_URL . '/admin/index.php?fct=giconmanager';
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_gicon_form( $dirname, $trust_dirname );
		}

		return $instance;
	}


// print form

	function print_form( $mode, $row ) {
		switch ( $mode ) {
			case 'edit':
				$title  = _AM_WEBPHOTO_GICON_MENU_EDIT;
				$action = 'update';
				break;

			case 'new':
			default:
				$title  = _AM_WEBPHOTO_GICON_MENU_NEW;
				$action = 'insert';
				break;
		}

		$this->set_row( $row );

		echo $this->build_form_upload( 'upload_gicon' );
		echo $this->build_html_token();

		echo $this->build_input_hidden( 'fct', 'giconmanager' );
		echo $this->build_input_hidden( 'action', $action );
		echo $this->build_row_hidden( 'gicon_id' );

		echo $this->build_input_hidden( 'max_file_size', $this->_cfg_fsize );
		echo $this->build_input_hidden( 'fieldCounter', $this->_FILED_COUNTER_2 );

		echo $this->build_table_begin();
		echo $this->build_line_title( $title );

		echo $this->build_row_text( _WEBPHOTO_GICON_TITLE, 'gicon_title' );

		echo $this->_build_line_image_file();
		echo $this->_build_line_shadow_file();

		echo $this->build_row_text( _WEBPHOTO_GICON_ANCHOR_X, 'gicon_anchor_x' );
		echo $this->build_row_text( _WEBPHOTO_GICON_ANCHOR_Y, 'gicon_anchor_y' );
		echo $this->build_row_text( _WEBPHOTO_GICON_INFO_X, 'gicon_info_x' );
		echo $this->build_row_text( _WEBPHOTO_GICON_INFO_Y, 'gicon_info_y' );

		echo $this->build_line_ele( '', $this->_build_ele_button() );

		echo $this->build_table_end();
		echo $this->build_form_end();
	}

	function _build_line_image_file() {
		$desc = $this->get_constant( 'CAP_MAXPIXEL' ) . ' ';
		$desc .= $this->_cfg_gicon_width . ' x ';
		$desc .= $this->_cfg_gicon_width . ' px';
		$desc .= "<br>\n";
		$desc .= $this->get_constant( 'DSC_PIXCEL_RESIZE' ) . ' ';

		$ele = $this->_build_ele_image_file();

		return $this->build_line_cap_ele(
			_AM_WEBPHOTO_GICON_IMAGE_SEL, $desc, $ele );
	}

	function _build_ele_image_file() {
		$path = $this->get_row_by_key( 'gicon_image_path' );

		$text = $this->build_form_file( $this->_IMAGE_FIELD_NAME );
		$text .= "<br>\n";

		if ( $path ) {
			$text .= $this->_build_image_link( $path );
		}

		return $text;
	}

	function _build_line_shadow_file() {
		return $this->build_line_ele(
			_AM_WEBPHOTO_GICON_SHADOW_SEL, $this->_build_ele_shadow_file() );
	}

	function _build_ele_shadow_file() {
		$path = $this->get_row_by_key( 'gicon_shadow_path' );

		$text = $this->build_form_file( $this->_SHADOW_FIELD_NAME );
		$text .= "<br>\n";

		if ( $path ) {
			$del_name  = 'shadow_del';
			$del_value = $this->_post_class->get_post_int( $del_name );
			$del_opts  = array( _AM_WEBPHOTO_GICON_SHADOW_DEL => _C_WEBPHOTO_YES );

			$text .= $this->build_form_checkbox( $del_name, $del_value, $del_opts );
			$text .= "<br>\n";
			$text .= $this->_build_image_link( $path );
		}

		return $text;

	}

	function _build_image_link( $path ) {
		$url_s = $this->sanitize( XOOPS_URL . $path );
		$text  = '<a href="' . $url_s . '" target="_blank">';
		$text  .= $url_s;
		$text  .= "<br>\n";
		$text  .= '<img src="' . $url_s . '" border="0" />';
		$text  .= "</a><br>\n";

		return $text;
	}

	function _build_ele_button() {
		$str = $this->build_input_submit( 'submit', _SUBMIT );
		$str .= ' ';
		$str .= $this->build_input_reset( 'reset', _CANCEL );

		return $str;
	}


// list

	function print_list( $rows ) {

// --- form ---
		echo "<form name='MainForm' action='' method='post' style='margin:10px;'>\n";
		echo $this->build_html_token();
		echo $this->build_input_hidden( 'delgicon', '' );

// --- table ---
		echo "<table width='100%' class='outer' cellpadding='4' cellspacing='1'>\n";

		echo "<tr valign='middle'>";
		echo "<th>" . _WEBPHOTO_GICON_ID . "</th>";
		echo "<th>" . _WEBPHOTO_GICON_TITLE . "</th>";
		echo "<th>" . _AM_WEBPHOTO_GICON_LIST_IMAGE . "</th>";
		echo "<th>" . _AM_WEBPHOTO_GICON_LIST_SHADOW . "</th>";
		echo "<th>" . _AM_WEBPHOTO_GICON_ANCHOR . "</th>";
		echo "<th>" . _AM_WEBPHOTO_GICON_WINANC . "</th>";
		echo "<th>" . _AM_WEBPHOTO_GICON_LIST_EDIT . "</th>";
		echo "</tr>\n";

		foreach ( $rows as $row ) {
			$this->_print_line( $row );
		}

		echo "</table></form>\n";
// --- table form end ---

	}

	function _print_line( $row ) {
		$oddeven = $this->get_alternate_class();

		$gicon_id      = (int) $row['gicon_id'];
		$title_s       = $this->sanitize( $row['gicon_title'] );
		$del_confirm   = 'confirm("' . sprintf( _AM_WEBPHOTO_GICON_DELCONFIRM, $title_s ) . '")';
		$onclick       = 'if (' . $del_confirm . ') { document.MainForm.delgicon.value="' . $gicon_id . '"; submit(); }';
		$button_delete = "<input type='button' value='" . _DELETE . "' onclick='" . $onclick . "' />";

		echo '<tr>';

		echo '<td class="' . $oddeven . '">';
		echo $gicon_id;
		echo "</td>\n";

		echo '<td class="' . $oddeven . '">';
		echo $title_s;
		echo "</td>\n";

		echo '<td class="' . $oddeven . '">';
		if ( $row['gicon_image_path'] ) {
			echo '<img src="' . XOOPS_URL . $this->sanitize( $row['gicon_image_path'] ) . '" valign="middle" />';
			echo ' ( ' . (int) $row['gicon_image_width'] . ' x ' . (int) $row['gicon_image_height'] . ' )';
		}
		echo "</td>\n";

		echo '<td class="' . $oddeven . '">';
		if ( $row['gicon_shadow_path'] ) {
			echo '<img src="' . XOOPS_URL . $this->sanitize( $row['gicon_shadow_path'] ) . '" valign="middle" />';
			echo ' ( ' . (int) $row['gicon_shadow_width'] . ' x ' . (int) $row['gicon_shadow_height'] . ' )';
		}
		echo "</td>\n";

		echo '<td class="' . $oddeven . '"> ';
		echo (int) $row['gicon_anchor_x'] . ' x ' . (int) $row['gicon_anchor_y'];
		echo " </td>\n";

		echo '<td class="' . $oddeven . '"> ';
		echo (int) $row['gicon_info_x'] . ' x ' . (int) $row['gicon_info_y'];
		echo " </td>\n";

		echo '<td class="' . $oddeven . '" nowrap="nowrap" align="center">';
		echo '[<a href="' . $this->_THIS_URL . '&amp;disp=edit&amp;gicon_id=' . $gicon_id . '">';
		echo _EDIT;
		echo '</a>] &nbsp; ';
		echo $button_delete . "\n";
		echo "</td>\n";

		echo "</tr>\n";

	}

}
