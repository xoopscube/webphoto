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
// class webphoto_embed_pandora
//
// http://channel.pandora.tv/channel/video.ptv?ref=main_recent&ch_userid=kichel&prgid=33571093
//
// http://www.pandora.tv/my.kichel/33571093
//
// <object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,115,0' width='448' height='385' id='movie' align='middle'>
// <param name='quality' value='high' />
// <param name='movie' value='http://flvr.pandora.tv/flv2pan/flvmovie.dll/userid=kichel&prgid=33571093&lang=jp'></param>
// <param name='wmode' value='window'></param>
// <param name='allowFullScreen' value='true' />
// <param name='allowScriptAccess' value='always' />
// <embed src='http://flvr.pandora.tv/flv2pan/flvmovie.dll/userid=kichel&prgid=33571093&lang=jp' type='application/x-shockwave-flash' wmode='window'  allowScriptAccess='always' allowFullScreen='true' pluginspage='http://www.macromedia.com/go/getflashplayer' width='448' height='385'></embed>
// </object>
//=========================================================
class webphoto_embed_pandora extends webphoto_embed_base {

	public function __construct() {
		parent::__construct( 'pandora' );
		$this->set_url( 'http://www.pandora.tv/' );
		$this->set_sample( 'my.kichel/33571093' );
	}

	public function embed( $src, $width, $height, $extra = null ) {
		//!Fix This split was removed in PHP 7
		$src_array = split( '/', $src );
		$src1      = str_replace( 'my.', '', $src_array[0] );
		$src2      = $src_array[1];
		$param     = 'userid=' . $src1 . '&prgid=' . $src2;
		$movie     = 'http://flvr.pandora.tv/flv2pan/flvmovie.dll/' . $param;

		$wmode   = 'window';
		$quality = 'high';
		$access  = 'true';
		$screen  = 'always';

		$object_extra = 'id="movie" ';
		$object_extra .= 'classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ';
		$object_extra .= 'codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,115,0" ';

		$embed_extra = 'wmode="' . $wmode . '" ';
		$embed_extra .= 'allowScriptAccess="' . $access . '" ';
		$embed_extra .= 'allowFullScreen="' . $screen . '" ';
		$embed_extra .= 'pluginspage="http://www.macromedia.com/go/getflashplayer" ';

		$str = $this->build_object_begin( $width, $height, $object_extra );
		$str .= $this->build_param( 'movie', $movie );
		$str .= $this->build_param( 'quality', $quality );
		$str .= $this->build_param( 'wmode', $wmode );
		$str .= $this->build_param( 'allowFullScreen', $access );
		$str .= $this->build_param( 'allowScriptAccess', $screen );
		$str .= $this->build_embed_flash( $movie, $width, $height, $embed_extra );
		$str .= $this->build_object_end();

		return $str;
	}

	public function link( $src ) {
		return $this->build_link( $src );
	}

	public function width() {
		return 448;
	}

	public function height() {
		return 385;
	}

	public function desc() {
		return $this->build_desc();
	}

	public function lang_desc() {
		return 'Enter the video id from the shortcut url.';
	}

}
