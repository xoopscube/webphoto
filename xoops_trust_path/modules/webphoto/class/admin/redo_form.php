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


class webphoto_admin_redo_form extends webphoto_edit_form {


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_redo_form( $dirname, $trust_dirname );
		}

		return $instance;
	}


// redothumbs

	function print_form_redothumbs( $param ) {
		$cfg_width  = $this->_config_class->get_by_name( 'width' );
		$cfg_height = $this->_config_class->get_by_name( 'height' );

		$this->set_row( $param );

		$cap_size   = _AM_WEBPHOTO_TEXT_NUMBERATATIME . "<br><br><span style='font-weight:normal'>" . _AM_WEBPHOTO_LABEL_DESCNUMBERATATIME . "</span>";
		$cap_resize = _AM_WEBPHOTO_RADIO_RESIZE . ' ( ' . $cfg_width . ' x ' . $cfg_width . ' )';

		if ( $param['counter'] && ( $param['counter'] < $param['size'] ) ) {
			$submit_button = _AM_WEBPHOTO_FINISHED . ' &nbsp; ';
			$submit_button .= '<a href="' . $this->_THIS_FCT_URL . '">';
			$submit_button .= _AM_WEBPHOTO_LINK_RESTART . "</a>\n";
		} else {
			$submit_button = $this->build_input_submit( 'submit', _AM_WEBPHOTO_SUBMIT_NEXT );
		}

		echo $this->build_form_begin();
		echo $this->build_input_hidden( 'fct', 'redothumbs' );
		echo $this->build_table_begin();

		echo $this->build_line_title( _AM_WEBPHOTO_FORM_RECORDMAINTENANCE );
		echo $this->build_row_text( _AM_WEBPHOTO_TEXT_RECORDFORSTARTING, 'start' );
		echo $this->build_row_text( $cap_size, 'size' );
		echo $this->build_row_radio_yesno( _AM_WEBPHOTO_RADIO_FORCEREDO, 'forceredo' );
		echo $this->build_row_radio_yesno( _AM_WEBPHOTO_RADIO_REMOVEREC, 'removerec' );
		echo $this->build_row_radio_yesno( $cap_resize, 'resize' );
		echo $this->build_line_ele( _AM_WEBPHOTO_CAP_REDO_EXIF, $this->_build_ele_exif() );

		echo $this->build_line_ele( '', $submit_button );

		echo $this->build_table_end();
		echo $this->build_form_end();
	}

	function _build_ele_exif() {
		$value   = $this->get_row_by_key( 'exif' );
		$options = array(
			_NO                                 => 0,
			_AM_WEBPHOTO_RADIO_REDO_EXIF_TRY    => 1,
			_AM_WEBPHOTO_RADIO_REDO_EXIF_ALWAYS => 2,
		);

		return $this->build_form_radio( 'exif', $value, $options );
	}


}


