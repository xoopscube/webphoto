<?php
//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

if( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

$GLOBALS['MY_DIRNAME'] = $MY_DIRNAME;

$MY_TRUST_DIRNAME = 'webphoto' ;

if ( !defined("WEBPHOTO_TIME_START") ) {
	[ $usec, $sec ] = explode( " ", microtime() );
	$time = (float) $sec + (float) $usec;
	define("WEBPHOTO_TIME_START", $time );
}
if ( !defined("WEBPHOTO_TRUST_DIRNAME") ) {
	define("WEBPHOTO_TRUST_DIRNAME", $MY_TRUST_DIRNAME );
}
if ( !defined("WEBPHOTO_TRUST_PATH") ) {
	define("WEBPHOTO_TRUST_PATH", XOOPS_TRUST_PATH.'/modules/'.WEBPHOTO_TRUST_DIRNAME );
}
