<?php
// $Id: imagemanager_form.php,v 1.1 2009/01/06 09:42:30 ohwada Exp $

//=========================================================
// webphoto module
// 2009-01-04 K.OHWADA
//=========================================================

if( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

//=========================================================
// class webphoto_imagemanager_form
//=========================================================
class webphoto_imagemanager_form extends webphoto_form_this
{

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
public function __construct( $dirname, $trust_dirname )
{
	parent::__construct( $dirname, $trust_dirname);
	//$this->webphoto_form_this( $dirname, $trust_dirname );
	$this->init_preload();
}

public static function &getInstance( $dirname = null, $trust_dirname = null )
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_imagemanager_form( $dirname, $trust_dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// imagemanager
//---------------------------------------------------------
public function print_form_imagemanager( $row, $param )
{
	$has_resize    = $param['has_resize'];
	$allowed_exts  = $param['allowed_exts'];

	$this->set_row( $row );

	echo $this->build_form_upload( 'uploadphoto', $this->_THIS_URL );
	echo $this->build_html_token();

	echo $this->build_input_hidden( 'op',           'submit' );
	echo $this->build_input_hidden( 'fct',          $this->_THIS_IMAGEMANEGER_FCT );
	echo $this->build_input_hidden( 'fieldCounter', $this->_FILED_COUNTER_1 );

	echo $this->build_input_hidden_max_file_size();

	echo $this->build_table_begin();
	echo $this->build_line_title( $this->get_constant('TITLE_PHOTOUPLOAD') );

	echo $this->build_line_maxpixel( $has_resize ) ;
	echo $this->build_line_maxsize() ;
	echo $this->build_line_allowed_exts( $allowed_exts ) ;
	echo $this->build_line_category() ;
	echo $this->build_line_item_title() ;
	echo $this->build_line_photo_file( null ) ;

	echo $this->build_line_ele( '', $this->build_input_submit( 'submit', _ADD ) );

	echo $this->build_table_end();
	echo $this->build_form_end();
}

// --- class end ---
}

?>
