<?php
// php cmd_retrieve.php -path=XOOPS_ROOT_PATH -dirname=DIRNAME -pass=PASSWORD
// user option
$FLAG_XOOPS_CHECK_PATH = false;
// start here
$path    = null;
$dirname = null;

// parse arg
if ( $_SERVER['argc'] > 1 ) {
	for ( $i = 1; $i < $_SERVER['argc']; $i ++ ) {
		if ( preg_match( '/\-(.*)=(.*)/', $_SERVER['argv'][ $i ], $matches ) ) {
			if ( $matches[1] == 'path' ) {
				$path = $matches[2];
			} elseif ( $matches[1] == 'dirname' ) {
				$dirname = $matches[2];
			}
		}
	}
}

$XOOPS_ROOT_PATH  = $path;
$MY_DIRNAME       = $dirname;
$MY_TRUST_DIRNAME = basename( dirname( __FILE__, 2 ) );

if ( $FLAG_XOOPS_CHECK_PATH ) {
	define( 'XOOPS_CHECK_PATH', 0 );
}

$xoopsOption['nocommon'] = 1;
require $XOOPS_ROOT_PATH . '/mainfile.php';

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

if ( ! defined( "WEBPHOTO_TRUST_DIRNAME" ) ) {
	define( "WEBPHOTO_TRUST_DIRNAME", $MY_TRUST_DIRNAME );
}
if ( ! defined( "WEBPHOTO_TRUST_PATH" ) ) {
	define( "WEBPHOTO_TRUST_PATH", XOOPS_TRUST_PATH . '/modules/' . WEBPHOTO_TRUST_DIRNAME );
}

require XOOPS_TRUST_PATH . '/modules/' . $MY_TRUST_DIRNAME . '/bin/retrieve.php';
