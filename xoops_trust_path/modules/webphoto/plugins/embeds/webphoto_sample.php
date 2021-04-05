<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @deprecated UPDATE PLUGIN / API / JSON
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

//=========================================================
// class webphoto_embed_webphoto
//
// http://localhost/modules/webphoto/index.php?fct=photo&photo_id=1
// http://localhost/modules/webphoto/index.php?fct=image&item_id=1&file_kind=2
//
// <object codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="320" height="240" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
// <param name="movie" value="http://localhost/modules/webphoto/libs/mediaplayer.swf" ></param>
// <param name="flashvars" value="config=http%3A%2F%2Flocalhost%2Fmodules%2Fwebphoto%2Findex.php%3Ffct%3Dconfig%26item_id%3D1" ></param>
// <embed src="http://localhost/modules/webphoto/libs/mediaplayer.swf" width="320" height="240" flashvars="config=http%3A%2F%2Flocalhost%2Fxoops_jpex_13%2Fmodules%2Fwebphoto%2Findex.php%3Ffct%3Dflash_config%26item_id%3D1" type="application/x-shockwave-flash" ></embed>
// </object>
//
//=========================================================
class webphoto_embed_webphoto_sample extends webphoto_embed_base {
	public $_SITE = '';

	public function __construct() {
		parent::__construct( 'webphoto' );
		// you can rewrite
		//	$this->_SITE = XOOPS_URL.'/modules/webphoto/';
		//	$this->_SITE = 'http://sitename.com/modules/webphoto/';
		$this->_SITE = XOOPS_URL . '/modules/webphoto/';
		$this->set_url( $this->_SITE . 'index.php/photo/' );
		$this->set_sample( '123' );
	}

	public function embed( $src, $width, $height, $extra = null ) {
		$movie     = $this->_SITE . 'libs/mediaplayer.swf';
		$config    = $this->_SITE . 'index.php?fct=flash_config&item_id=' . $src;
		$flashvars = 'config=' . urlencode( $config );

		$object_extra = 'classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ';
		$object_extra .= 'codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,115,0" ';

		$embed_extra = 'flashvars="' . $flashvars . '" ';
		$embed_extra .= 'type="application/x-shockwave-flash"';

		$str = $this->build_object_begin( $width, $height, $object_extra );
		$str .= $this->build_param( 'movie', $movie );
		$str .= $this->build_param( 'flashvars', $flashvars );
		$str .= $this->build_embed_flash( $movie, $width, $height, $embed_extra );
		$str .= $this->build_object_end();

		return $str;
	}

	public function link( $src ) {
		return $this->build_link( $src );
	}

	public function thumb( $src ) {
		$str = $this->_SITE . 'index.php?fct=image&item_id=' . $src . '&file_kind=2';

		return $str;
	}

	public function desc() {
		return $this->build_desc();
	}
}
