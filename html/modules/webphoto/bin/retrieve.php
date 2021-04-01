<?php

$xoopsOption['nocommon'] = 1 ;

require '../../../mainfile.php' ;

if( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'set XOOPS_TRUST_PATH in mainfile.php' );
}

$MY_DIRNAME = basename( dirname( __FILE__, 2 ) ) ;

require XOOPS_ROOT_PATH.'/modules/'.$MY_DIRNAME.'/include/mytrustdirname.php' ;
require XOOPS_TRUST_PATH.'/modules/'.$MY_TRUST_DIRNAME.'/bin/retrieve.php' ;
