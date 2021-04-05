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
// class webphoto_embed_livevideo
//
// http://www.livevideo.com/video/SillyLeslie/75A082A560464FAEB411D06417E495C4/lvo-ii-10-thank-you-all.aspx
//
// <embed src="http://www.livevideo.com/flvplayer/embed/75A082A560464FAEB411D06417E495C4" type="application/x-shockwave-flash" quality="high" WIDTH="445" HEIGHT="369" wmode="transparent"></embed>
//=========================================================
class webphoto_embed_livevideo extends webphoto_embed_base {

	public function __construct() {

		parent::__construct( 'livevideo' );
	}

	public function embed( $src, $width, $height, $extra = null ) {
		$movie = 'http://www.livevideo.com/flvplayer/embed/' . $src;
		$embed = '<embed src="' . $movie . '" type="application/x-shockwave-flash" quality="high" WIDTH="' . $width . '" HEIGHT="' . $height . '" wmode="transparent" />';

		return $embed;
	}

	public function desc() {
		return $this->build_desc_span( 'http://www.livevideo.com/video/mrmercedesman/', 'F6D925B31BAB4DF080B176AABD5AFD17', '/surrounding-your-internets-.aspx' );
	}

}
