<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

if ( ! defined( "_C_WEBPHOTO_JODCONVERTER_LOADED" ) ) {

	define( "_C_WEBPHOTO_JODCONVERTER_LOADED", 1 );

//=========================================================
// Constant
//=========================================================

	define( "_C_WEBPHOTO_JAVA_PATH", "/usr/bin/" );
	define( "_C_WEBPHOTO_JODCONVERTER_JAR", "/usr/local/java/jodconverter-2.2.1/lib/jodconverter-cli-2.2.1.jar" );

}
