<?php

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) {
	die( 'not permit' );
}

webphoto_include_once( 'admin/header.php' );
webphoto_include_once( 'include/version.php' );
webphoto_include_once( 'class/inc/workdir.php' );
webphoto_include_once( 'class/lib/server_info.php' );
webphoto_include_once( 'class/lib/gd.php' );
webphoto_include_once( 'class/lib/imagemagick.php' );
webphoto_include_once( 'class/lib/netpbm.php' );
webphoto_include_once( 'class/lib/ffmpeg.php' );
webphoto_include_once( 'class/lib/lame.php' );
webphoto_include_once( 'class/lib/timidity.php' );
webphoto_include_once( 'class/lib/xpdf.php' );
webphoto_include_once( 'class/lib/jodconverter.php' );
webphoto_include_once( 'class/lib/dir.php' );
webphoto_include_once( 'class/handler/player_handler.php' );
webphoto_include_once( 'class/handler/photo_handler.php' );
webphoto_include_once( 'class/webphoto/cmd_base.php' );
webphoto_include_once( 'class/webphoto/jodconverter.php' );
webphoto_include_once( 'class/admin/checkconfigs.php' );
webphoto_include_once( 'class/admin/update_check.php' );
webphoto_include_once( 'class/admin/index.php' );

$manager =& webphoto_admin_index::getInstance(
	WEBPHOTO_DIRNAME, WEBPHOTO_TRUST_DIRNAME );
$manager->main();
exit();
