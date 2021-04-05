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
// class webphoto_embed_aoluncut
//
// http://uncutvideo.aol.com/videos/80d646d2bf149c6d04aa5989fcc85d6d
//
// <object width="415" height="347">
// <param name="wmode" value="opaque" />
// <param name="movie" value="http://uncutvideo.aol.com/v6.334/en-US/uc_videoplayer.swf" />
// <param name="FlashVars" value="aID=180d646d2bf149c6d04aa5989fcc85d6d&site=http://uncutvideo.aol.com/" />
// <embed src="http://uncutvideo.aol.com/v6.334/en-US/uc_videoplayer.swf" wmode="opaque" FlashVars="aID=180d646d2bf149c6d04aa5989fcc85d6d&site=http://uncutvideo.aol.com/" width="415" height="347" type="application/x-shockwave-flash"></embed>
// </object>
//=========================================================
class webphoto_embed_aoluncut extends webphoto_embed_base {

	public function __construct() {
		parent::__construct( 'aoluncut' );
		$this->set_url( 'http://uncutvideo.aol.com/videos/' );
		$this->set_sample( '180d646d2bf149c6d04aa5989fcc85d6d' );
	}

	public function embed( $src, $width, $height, $extra = null ) {
		$movie      = 'http://uncutvideo.aol.com/v6.334/en-US/uc_videoplayer.swf';
		$flash_vars = 'aID=' . $src . '&amp;site=http://uncutvideo.aol.com/';
		$wmode      = 'opaque';
		$extra      = 'wmode="' . $wmode . '" FlashVars="' . $flash_vars . '"';

		$str = $this->build_object_begin( $width, $height );
		$str .= $this->build_param( 'movie', $movie );
		$str .= $this->build_param( 'wmode', $wmode );
		$str .= $this->build_param( 'FlashVars', $flash_vars );
		$str .= $this->build_embed_flash( $movie, $width, $height, $extra );
		$str .= $this->build_object_end();

		return $str;
	}

	public function link( $src ) {
		return $this->build_link( $src );
	}

	public function desc() {
		return $this->build_desc();
	}

}
