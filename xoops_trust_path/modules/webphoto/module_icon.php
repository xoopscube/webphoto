<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

include_once WEBPHOTO_TRUST_PATH . '/class/d3/optional.php';
include_once WEBPHOTO_TRUST_PATH . '/include/optional.php';
webphoto_include_once( 'class/d3/module_icon.php', $MY_DIRNAME, false );

// main
$webphoto_d3_module_icon =& webphoto_d3_module_icon::getInstance();
$webphoto_d3_module_icon->init( $MY_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$webphoto_d3_module_icon->output_image();
