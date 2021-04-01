<?php
// $Id: mail_unlink.php,v 1.3 2008/11/11 06:53:16 ohwada Exp $

//=========================================================
// webphoto module
// 2008-08-01 K.OHWADA
//=========================================================

//---------------------------------------------------------
// change log
// 2008-11-08 K.OHWADA
// TMP_DIR -> MAIL_DIR
// 2008-08-24 K.OHWADA
// added unlink_attaches()
//---------------------------------------------------------

if( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

//=========================================================
// class webphoto_mail_delete
//=========================================================
class webphoto_mail_unlink
{
	public $_config_class;
	public $_utility_class;

	public $_WORK_DIR;
	public $_MAIL_DIR;
	public $_SEPARATOR = '|';

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
public function __construct( $dirname )
{
	$this->_config_class  =& webphoto_config::getInstance( $dirname );
	$this->_utility_class =& webphoto_lib_utility::getInstance();

	$this->_WORK_DIR  = $this->_config_class->get_by_name( 'workdir' );
	$this->_MAIL_DIR  = $this->_WORK_DIR .'/mail' ;

}

public static function &getInstance( $dirname = null, $trust_dirname = null )
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_mail_unlink( $dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// unlink
//---------------------------------------------------------
public function unlink_by_maillog_row( $row )
{
	$this->unlink_file( $row );
	$this->unlink_attaches( $row );
}

public function unlink_file( $row )
{
	$this->unlink_by_filename( $row['maillog_file'] );
}

public function unlink_attaches( $row )
{
	$attach_array = $this->_utility_class->str_to_array( $row['maillog_attach'], $this->_SEPARATOR );
	if ( !is_array($attach_array) ) {
		return;	// no action
	}
	foreach( $attach_array as $attach ) {
		$this->unlink_by_filename( $attach );
	}
}

public function unlink_by_filename( $file )
{
	if ( $file ) {
		$this->_utility_class->unlink_file( $this->_MAIL_DIR.'/'.$file );
	}
}

// --- class end ---
}

?>
