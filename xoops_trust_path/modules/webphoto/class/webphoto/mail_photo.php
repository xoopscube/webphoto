<?php
// $Id: mail_photo.php,v 1.7 2008/11/20 11:15:46 ohwada Exp $

//=========================================================
// webphoto module
// 2008-08-01 K.OHWADA
//=========================================================

//---------------------------------------------------------
// change log
// 2008-11-16 K.OHWADA
// set now to time_update
// 2008-11-08 K.OHWADA
// TMP_DIR -> MAIL_DIR
// 2008-08-24 K.OHWADA
// supported gps
//---------------------------------------------------------

if( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

//=========================================================
// class webphoto_mail_photo
//=========================================================
class webphoto_mail_photo extends webphoto_photo_create
{
	public $_user_handler ;
	public $_maillog_handler ;
	public $_parse_class ;
	public $_check_class ;
	public $_unlink_class ;

	public $_cfg_allownoimage = false;
	public $_flag_mail_chmod  = false;

	public $_SUBJECT_DEFAULT = 'No Subject';
	public $_TIME_FORMAT = 'Y/m/d H:i';
	public $_MAX_BODY    = 250;

	public $_FLAG_STRICT = true;
	public $_FLAG_UNLINK_FILE = true;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
public function __construct( $dirname , $trust_dirname )
{
	parent::__construct( $dirname, $trust_dirname);
	//$this->webphoto_photo_create( $dirname , $trust_dirname );

	$this->_user_handler    =& webphoto_user_handler::getInstance( $dirname );
	$this->_maillog_handler =& webphoto_maillog_handler::getInstance( $dirname );
	$this->_parse_class     =& webphoto_lib_mail_parse::getInstance();
	$this->_check_class     =& webphoto_mail_check::getInstance( $dirname );
	$this->_unlink_class    =& webphoto_mail_unlink::getInstance( $dirname );

	$this->_parse_class->set_charset_local( _CHARSET );
	$this->_parse_class->set_internal_encoding();

	$this->_cfg_allownoimage = $this->get_config_by_name( 'allownoimage' );

}

public static function &getInstance( $dirname = null, $trust_dirname = null )
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_mail_photo( $dirname , $trust_dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// parse mail
//---------------------------------------------------------
function set_flag_strict( $val )
{
	$this->_FLAG_STRICT = (bool)$val;
	$this->_check_class->set_flag_strict( $val );
}

function set_mail_groups( $val )
{
	$this->_check_class->set_mail_groups( $val );
}

function set_flag_mail_chmod( $val )
{
	$this->_flag_mail_chmod = (bool)$val ;
}

function parse_mails( $file_arr )
{
	$param_arr = array() ;
	foreach ($file_arr as $data )
	{
		$param = $this->parse_single_mail( $data['maillog_id'], $data['file'] );
		if ( is_array($param) ) {
			$param_arr[] = $param ;
		}
	}
	return $param_arr;
}

function parse_single_mail( $maillog_id, $filename, $specified_array=null )
{
	if ( empty($filename) ) {
		$this->print_msg_level_admin( 'filename is empty', false, true );
		return false;
	}

	$file_path = $this->_MAIL_DIR.'/'.$filename ;

	if ( ! file_exists($file_path) ) {
		$msg = 'not exists : '.$file_path;
		$this->print_msg_level_admin( $msg, false, true );
		return false;
	}

	$mail = file_get_contents( $file_path );

	$this->_parse_class->parse_mail( $mail );
	$result = $this->_parse_class->get_result();

	$ret = $this->_check_class->check_mail( $result );
	$param = $this->_check_class->get_result();

	$param['maillog_id'] = $maillog_id;
	$param['filename']   = $filename;

	$param_maillog = $param;

	if ( !$ret ) {
		$reject_msgs = $this->_check_class->get_reject_msgs();
		$msg = $this->array_to_str( $reject_msgs, "\n" );
		$msg = nl2br( $this->sanitize($msg) );
		$this->print_msg_level_admin( 'Reject mail', true, true );
		$this->print_msg_level_admin( $msg, false, true  );

		if ( $this->_FLAG_STRICT ) {
			$param_maillog['status']  = _C_WEBPHOTO_MAILLOG_STATUS_REJECT;
			$param_maillog['comment'] = $msg;
			$this->update_maillog( $param_maillog );
			return false;
		}
	}

	$mail_from = $param['mail_from']; 
	$subject   = $param['subject']; 
	$attaches  = $param['attaches'];

	$msg = " $subject < $mail_from > ";
	$this->print_msg_level_admin( $msg, false, true );

	$attaches_new = $this->parse_attaches( $filename, $attaches, $specified_array );
	if ( is_array($attaches_new) && count($attaches_new) ) {
// rewrite attaches
		$param['attaches'] = $attaches_new;	

	} else {
		$msg = 'no attach file';
		$this->print_msg_level_admin( $msg, true, true );

		if ( ! $this->_cfg_allownoimage ) {
			$param_maillog['status']  = _C_WEBPHOTO_MAILLOG_STATUS_REJECT;
			$param_maillog['comment'] = $msg;
			$this->update_maillog( $param_maillog );
			return false;
		}
	}

	return $param ;
}

function parse_attaches( $mail_filename, $attaches_in, $specified_array=null )
{

	$attaches_new = array();

	if ( !is_array( $attaches_in ) ) {
		return null;
	}

	foreach ( $attaches_in as $attach )
	{
		$temp     = $attach;
		$filename = $attach['filename'];
		$content  = $attach['content'];
		$charset  = $attach['charset'] ;
		$type     = $attach['type'] ;
		$reject   = $attach['reject'] ;

		$file_save = null;
		$skip      = false;

		$this->print_msg_level_admin( $filename, false, true );

// specified or no reject
		if (( is_array($specified_array) && in_array( $filename, $specified_array ) ) ||
		    ( empty($specified_array) && empty($reject) )) { 

			$file_save = $this->_utility_class->strip_ext( $mail_filename ).'-'.$filename ;
			$file_path = $this->_MAIL_DIR.'/'.$file_save ;
			
			$this->_utility_class->write_file(
				$file_path, $content, 'wb', $this->_flag_mail_chmod );
			$reject = null;	// clear reject

// with reject
		} elseif ( $reject )  {
			$this->print_msg_level_admin( $reject, true, true );

// skip
		} else {
			$skip = true;
			$this->print_msg_level_admin( 'Skip', false, true );
		}

		$temp['file_save'] = $file_save;
		$temp['reject']    = $reject;
		$temp['skip']      = $skip;
		$remp['content']   = null;	// crear content

		$attaches_new[] = $temp;
	}

	return $attaches_new ;
}

//---------------------------------------------------------
// add photos
//---------------------------------------------------------
function add_photos_from_mail( $param_arr )
{
	$count = 0;
	foreach ( $param_arr as $param )
	{
		$num = $this->add_photos_from_single_mail( $param );
		$count += $num;
	}
	return $count;
}

function add_photos_from_single_mail( $param_in )
{
	if ( !is_array($param_in) || !count($param_in) ) {
		return 0;
	}

	$status  = null ;
	$comment = null ;
	$num     = 0 ;

	$mail_from     = $param_in['mail_from']; 
	$param_attach  = $param_in;
	$param_maillog = $param_in;

	$uid    = isset($param_in['uid'])    ? intval($param_in['uid'])    : -1;
	$cat_id = isset($param_in['cat_id']) ? intval($param_in['cat_id']) : -1;

	if ( $uid == -1 ) {
		$uid = $this->get_uid_from_mail( $mail_from );
		if ( empty($uid) ) {
			$msg = 'reject from : '.$from;
			$this->print_msg_level_admin( $msg, true, true );

			$param_maillog['status']  = _C_WEBPHOTO_MAILLOG_STATUS_REJECT;
			$param_maillog['comment'] = $msg;
			$this->update_maillog( $param_maillog );
			return 0;
		}
	}

	if ( $cat_id == -1 ) {
		$cat_id = $this->get_catid_from_mail( $mail_from );
	}

	$param_attach['uid']    = $uid ;
	$param_attach['cat_id'] = $cat_id ;

	list(  $id_array, $reject_files )
		= $this->add_photo_from_attaches( $param_attach );

// submit files
	if ( is_array($id_array) && count($id_array) ) {
		$num = count($id_array);

// partial files
		if ( is_array($reject_files) && count($reject_files) ) {
			$status  = _C_WEBPHOTO_MAILLOG_STATUS_PARTIAL ;
			$comment = $this->array_to_str( $reject_files, "\n" );

// all files
		} else {
			$status = _C_WEBPHOTO_MAILLOG_STATUS_SUBMIT ;
		}

// no file
	} else {
		$msg = 'no valid attached files';
		$this->print_msg_level_admin( $msg, true, true );

		$status  = _C_WEBPHOTO_MAILLOG_STATUS_REJECT;
		if ( is_array($reject_files) && count($reject_files) ) {
			$comment = $this->array_to_str( $reject_files, "\n" );
		} else {
			$comment = $msg;
		}
		$num =  0;
	}

	$param_maillog['status']   = $status ;
	$param_maillog['comment']  = $comment ;
	$param_maillog['id_array'] = $id_array ;
	$this->update_maillog( $param_maillog );

	return $num;
}

function add_photo_from_attaches( $param_in )
{
	$i = 0;
	$id_array     = array();
	$reject_files = array();

	$gmap_latitude  = 0 ;
	$gmap_longitude = 0 ;
	$gmap_zoom      = 0 ;

	$attaches   = $param_in['attaches'];
	$subject_in = $param_in['subject']; 
	$body       = $param_in['body'];
	$datetime   = $param_in['datetime'];
	$gps        = $param_in['gps'];

	$time = time();

	if ( $subject_in ) {
		$subject = $subject_in ;
	} else {
		$subject = $this->_SUBJECT_DEFAULT ;
	}

	if ( isset($gps['flag']) && $gps['flag'] ) {
		$gmap_latitude  = $gps['gmap_latitude'] ;
		$gmap_longitude = $gps['gmap_longitude'] ;
		$gmap_zoom      = $this->_GMAP_ZOOM ;
	}

	$param_photo = array(
		'time_create'      => $time ,
		'time_update'      => $time ,
		'title'            => $subject ,
		'cat_id'           => $param_in['cat_id'] ,
		'uid'              => $param_in['uid'] ,
		'description'      => $param_in['body'] ,
		'rotate'           => $param_in['rotate'] ,
		'rotate'           => $param_in['rotate'] ,
		'latitude'         => $gmap_latitude ,
		'longitude'        => $gmap_longitude ,
		'zoom'             => $gmap_zoom ,
		'status'           => _C_WEBPHOTO_STATUS_APPROVED ,
		'mode_video_thumb' => _C_WEBPHOTO_VIDEO_THUMB_SINGLE ,
	);

// without attach
	if ( !is_array($attaches) || !count($attaches) ) {

// has body
		if ( $this->_cfg_allownoimage && ( $subject_in || $body ) ) {
			$newid = $this->create_from_param( $param_photo ) ;
			$this->print_msg_level_user( null, false, true );
			if ( $newid > 0 ) {
				$id_array[] = $newid;
			}
		}

		return array( $id_array, $reject_files );
	}

// with atach
	foreach ( $attaches as $attach )
	{
		$filename  = $attach['filename'];
		$file_save = $attach['file_save'];
		$reject    = $attach['reject'] ;
		$skip      = $attach['skip'] ;

		if ( $skip ) {
			continue;
		}

		if ( $reject ) {
			$reject_files[] = $filename.' : '.$reject;
			continue;
		}

		$src_file = $this->_MAIL_DIR .'/'. $file_save ;

		if ( $i > 0 ) {
			$title = $subject .' - '. $i;
		} else {
			$title = $subject ;
		}

		$param_photo['src_file'] = $src_file ;
		$param_photo['title']    = $title ;

		$this->create_from_file( $param_photo );
		$this->print_msg_level_user( null, false, true );

		$newid = $this->get_newid();
		if ( $newid > 0 ) {
			$id_array[] = $newid;
		}

		if ( $this->_FLAG_UNLINK_FILE ) {
			$this->unlink_file( $src_file );
		}

		$i ++;
	}

	return array( $id_array, $reject_files );
}

//---------------------------------------------------------
// maillog handler
//---------------------------------------------------------
function clear_maillog( $max )
{
	if ( $max <= 0 ) {
		return 0;	// no action
	}

	$num = $this->_maillog_handler->get_count_all() - $max;
	if ( $num <= 0 ) {
		return 0;	// no action
	}

	$id_array = $this->_maillog_handler->get_id_array_older( $num ) ;
	if ( !is_array($id_array) || !count($id_array) ) {
		return 0;	// no action
	}

	foreach ( $id_array as $id ) 
	{
		$row = $this->_maillog_handler->get_row_by_id( $id );
		if ( !is_array($row) ) {
			continue;
		}

		$this->_unlink_class->unlink_by_maillog_row( $row );
		$this->_maillog_handler->delete_by_id( $id, $this->_flag_force_db ) ;
	}

	$this->print_msg_level_admin( 'Clear maillog : '.$num , false, true );
	return $num;
}

function add_maillog( $file )
{
// insert
	$row = $this->_maillog_handler->create( true );
	$row['maillog_file'] = $file ;

	$newid = $this->_maillog_handler->insert( $row, $this->_flag_force_db );
	if ( !$newid ) {
		$this->print_msg_level_admin( 'DB error', true, true );
		$this->print_msg_level_admin( $this->_maillog_handler->get_format_error() );
		return false;
	}

	return $newid;
}

function update_maillog( $param )
{

// update
	$row = $this->_maillog_handler->get_row_by_id( $param['maillog_id'] );

	$row['maillog_time_update'] = time() ;
	$row['maillog_from']        = $param['mail_from'] ;
	$row['maillog_subject']     = $param['subject'] ;
	$row['maillog_status']      = $param['status'] ;
	$row['maillog_photo_ids']   = $this->build_maillog_photo_ids( $row, $param ) ;
	$row['maillog_body']        = $this->build_maillog_body( $param ) ;
	$row['maillog_attach']      = $this->build_maillog_attach( $param ) ;
	$row['maillog_comment']     = $this->build_maillog_comment( $row, $param ) ;

	$ret = $this->_maillog_handler->update( $row, $this->_flag_force_db );
	if ( !$ret ) {
		$this->print_msg_level_admin( 'DB error', true, true );
		$this->print_msg_level_admin( $this->_maillog_handler->get_format_error() );
		return false;
	}

	return true;
}

function build_maillog_body( $param )
{
	$body = isset($param['body']) ? $param['body'] : null;

	if ( strlen($body) > $this->_MAX_BODY ) {
		return $substr( $body, 0, $this->_MAX_BODY ) ;
	}
	return $body;
}

function build_maillog_attach( $param )
{
	$attaches = isset($param['attaches']) ? $param['attaches'] : null;

	if ( !is_array($attaches) || !count($attaches) ) {
		return null;
	}

	$arr = array();
	foreach ( $attaches as $attach ) {
		if ( $attach['filename'] ) {
			$arr[] = $attach['filename'];
		}
	}
	$str = $this->_maillog_handler->build_attach_array_to_str( $arr );
	return $str ;
}

function build_maillog_photo_ids( $row, $param )
{
	$id_array = isset($param['id_array']) ? $param['id_array'] : null;

	$current_id_array = $this->_maillog_handler->build_photo_ids_row_to_array( $row );

	if ( is_array($current_id_array) && count($current_id_array) &&
	     is_array($id_array) && count($id_array) ) {
		$update_id_array = array_unique( array_merge( $current_id_array, $id_array ) );
	} elseif ( is_array($current_id_array) && count($current_id_array) ) {
		$update_id_array = $current_id_array ;
	} elseif ( is_array($id_array) && count($id_array) ) {
		$update_id_array = $id_array ;
	} else {
		$update_id_array = null;
	}

	return $this->_maillog_handler->build_photo_ids_array_to_str( $update_id_array );
}

function build_maillog_comment( $row, $param )
{
	$comment = isset($param['comment'])  ? $param['comment']  : null;

	$update = $row['maillog_comment'];
	if ( $comment ) {
		$update .= date( $this->_TIME_FORMAT ). "\n" ;
		$update .= $comment . "\n";
	}
	return $update;
}

//---------------------------------------------------------
// user handler
//---------------------------------------------------------
function get_uid_from_mail( $from )
{
	$row = $this->_user_handler->get_cached_row_by_email( $from );
	if ( is_array($row) ) {
		return $row['user_uid'];
	}
	return false;
}

function get_catid_from_mail( $from )
{
	$cat_id = 0;

	$user_row = $this->_user_handler->get_cached_row_by_email( $from );
	if ( is_array($user_row) ) {
		$cat_id = $user_row['user_cat_id'];
	}

	$cat_row = $this->_cat_handler->get_cached_row_by_id( $cat_id );
	if ( is_array($cat_row) ) {
		return $cat_id;
	}

	$cat_rows = $this->_cat_handler->get_rows_all_asc( 1 );
	if ( is_array($cat_rows) ) {
		return $cat_rows[0]['cat_id'];
	}

	return false;
}

// --- class end ---
}

?>
