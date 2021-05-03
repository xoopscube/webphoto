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


class webphoto_admin_export_form extends webphoto_edit_form {
	public $_SUBMIT_EXTRA;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_SUBMIT_EXTRA = ' onclick="return confirm(' . _AM_WEBPHOTO_EXPORTCONFIRM . ');" ';

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_export_form( $dirname, $trust_dirname );
		}

		return $instance;
	}


// export image

	public function print_form_image( $src_selbox, $dst_selbox ) {
		$this->print_form_common( 'ImageManager', 'image', $src_selbox, $dst_selbox, null, true );
	}


// common

	public function print_form_common( $form, $op, $src_selbox, $dst_selbox, $dst_dirname = null, $flag_thumb = false ) {
		echo $this->build_div_tag();
		echo $this->build_form_begin( $form );
		echo $this->build_input_hidden( 'fct', 'export' );
		echo $this->build_input_hidden( 'op', $op );
		echo $this->build_input_hidden( 'dst_dirname', $dst_dirname );

		echo $src_selbox;
		echo _AM_WEBPHOTO_FMT_EXPORTIMSRCCAT;
		echo ' &nbsp; -> &nbsp; ';

		echo $dst_selbox;
		echo _AM_WEBPHOTO_FMT_EXPORTIMDSTCAT;
		echo "<br><br>\n";

		if ( $flag_thumb ) {
			echo $this->build_input_checkbox( 'use_thumb', '1', $this->_CHECKED );
			echo _AM_WEBPHOTO_CB_EXPORTTHUMB;
			echo "<br><br>\n";
		}

		echo $this->build_input_submit( 'submit', _GO, $this->_SUBMIT_EXTRA );
		echo $this->build_form_end();
		echo $this->build_div_end();

	}


}


