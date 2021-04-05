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
// class webphoto_embed_google
//
// http://video.google.com/videoplay?docid=-8290192083117426204
//
// <embed style="width:400px; height:326px;" id="VideoPlayback" type="application/x-shockwave-flash" src="http://video.google.com/googleplayer.swf?docId=-8290192083117426204&hl=en" flashvars=""> </embed>
//=========================================================
class webphoto_embed_google extends webphoto_embed_base {

	public function __construct() {

		parent::__construct( 'google' );

		$this->set_url( 'http://video.google.com/videoplay?docid=' );
		$this->set_sample( '-8290192083117426204' );
	}

	public function embed( $src, $width, $height, $extra = null ) {
		$movie = 'http://video.google.com/googleplayer.swf?docId=' . $src;
		$style = 'width:' . $width . 'px; height:' . $height . 'px;';
		$embed = '<embed style="' . $style . '" id="VideoPlayback" type="application/x-shockwave-flash" src="' . $movie . '" flashvars="" />';

		return $embed;
	}

	public function link( $src ) {
		return $this->build_link( $src );
	}

	public function desc() {
		return $this->build_desc();
	}

}
