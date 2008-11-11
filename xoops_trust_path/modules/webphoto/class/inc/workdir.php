<?php
// $Id: workdir.php,v 1.3 2008/11/11 14:20:45 ohwada Exp $

//=========================================================
// webphoto module
// 2008-11-08 K.OHWADA
//=========================================================

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'not permit' ) ;

//=========================================================
// class webphoto_inc_workdir
//=========================================================
class webphoto_inc_workdir
{
	var $_DIRNAME ;
	var $_TRUST_DIRNAME ;
	var $_DIR_TRUST_UPLOADS ;
	var $_FILE_WORKDIR ;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function webphoto_inc_workdir( $dirname, $trust_dirname )
{
	$this->_DIRNAME       = $dirname ;
	$this->_TRUST_DIRNAME = $trust_dirname ;

	$this->_DIR_TRUST_UPLOADS =
		XOOPS_TRUST_PATH .'/modules/'. $trust_dirname .'/uploads' ;

	$this->_FILE_WORKDIR = $this->_DIR_TRUST_UPLOADS .'/workdir.txt' ;
}

function &getInstance( $dirname, $trust_dirname )
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_inc_workdir( $dirname, $trust_dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// main
//---------------------------------------------------------
function get_config_workdir()
{
	$name = $this->_DIRNAME ;

	for ( $i=0; $i<10; $i++ )
	{
		$workdir = $this->_DIR_TRUST_UPLOADS .'/'. $name ;
		$match   = $this->read_workdir( $workdir );
		if ( $match == 0 ) {
			break;
		}
		if ( $match == 2 ) {
			break;
		}
		$name = uniqid( 'work_' );
	}

	return $workdir ;
}

function read_workdir( $workdir )
{
	$match = 0 ;

	if ( ! file_exists( $this->_FILE_WORKDIR ) ) {
		return $match ;
	}

	$lines = $this->read_file_cvs( $this->_FILE_WORKDIR );

	if ( ! is_array($lines) ) {
		return $match;
	}

	foreach ( $lines as $line )
	{
		if ( trim($line[0]) == $workdir ) {
			$match = 1 ;

			if (( trim($line[1]) == XOOPS_DB_NAME ) &&
			    ( trim($line[2]) == XOOPS_DB_PREFIX ) &&
			    ( trim($line[3]) == XOOPS_URL ) &&
			    ( trim($line[4]) == $this->_DIRNAME )) {
				$match = 2 ;
			}

			break;
		}
	}

	return $match;
}

function write_workdir( $workdir )
{
	$data  = $workdir ;
	$data .= ', ';
	$data .= XOOPS_DB_NAME ;
	$data .= ', ';
	$data .= XOOPS_DB_PREFIX ;
	$data .= ', ';
	$data .= XOOPS_URL ;
	$data .= ', ';
	$data .= $this->_DIRNAME ;
	$data .= "\n";

	return $this->write_file( $this->_FILE_WORKDIR, $data, 'a', true ) ;
}

function read_file_cvs( $file, $mode='r' )
{
	$lines = array();

	$fp = fopen( $file , $mode ) ;
	if ( !$fp ) { return false ; }

	while (!feof($fp) ) {        
		$lines[] = fgetcsv($fp, 1024);   
	}

	fclose($fp);
	return $lines;
}

function write_file( $file, $data, $mode='w', $flag_chmod=false )
{
	$fp = fopen( $file , $mode ) ;
	if ( !$fp ) { return false ; }

	$byte = fwrite( $fp , $data ) ;
	fclose( $fp ) ;

// the user can delete this file which apache made.
	if (( $byte > 0 )&& $flag_chmod ) {
		chmod( $file, 0777 );
	}

	return $byte;
}

function get_filename()
{
	return $this->_FILE_WORKDIR ;
}

// --- class end ---
}

?>