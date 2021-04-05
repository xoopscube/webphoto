<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_multibyte extends webphoto_lib_multibyte {


	public function __construct() {

		parent::__construct();

		$xoops_class =& webphoto_xoops_base::getInstance();
		$is_japanese = $xoops_class->is_japanese( _C_WEBPHOTO_JPAPANESE );

		$this->set_is_japanese( $is_japanese );
		$this->set_ja_kuten( _WEBPHOTO_JA_KUTEN );
		$this->set_ja_dokuten( _WEBPHOTO_JA_DOKUTEN );
		$this->set_ja_period( _WEBPHOTO_JA_PERIOD );
		$this->set_ja_comma( _WEBPHOTO_JA_COMMA );
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_multibyte();
		}

		return $instance;
	}

}
