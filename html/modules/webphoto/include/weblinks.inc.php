<?php
//=========================================================
// webphoto module
// 2009-01-25 K.OHWADA
//=========================================================

if( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'set XOOPS_TRUST_PATH into mainfile.php' );
}

$MY_DIRNAME = basename( dirname( __FILE__, 2 ) );

require XOOPS_ROOT_PATH.'/modules/'.$MY_DIRNAME.'/include/mytrustdirname.php' ;
require XOOPS_TRUST_PATH.'/modules/'.$MY_TRUST_DIRNAME.'/include/weblinks.inc.php' ;
