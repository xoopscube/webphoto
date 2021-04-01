<?php
//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

require '../../mainfile.php' ;
if( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'set XOOPS_TRUST_PATH in mainfile.php' );
}

$MY_DIRNAME = basename( __DIR__ ) ;

require XOOPS_ROOT_PATH.'/modules/'.$MY_DIRNAME.'/include/mytrustdirname.php' ;
require XOOPS_TRUST_PATH.'/modules/'.$MY_TRUST_DIRNAME.'/main.php' ;
