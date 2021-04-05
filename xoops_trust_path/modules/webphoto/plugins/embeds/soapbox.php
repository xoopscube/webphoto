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
// class webphoto_embed_soapbox
//
// http://video.msn.com/video.aspx?vid=0ba39053-48f2-4a2c-99eb-cb1b5bc9b263
//
// <embed src="http://images.video.msn.com/flash/soapbox1_1.swf" width="432" height="364" id="je4ro1qv" type="application/x-shockwave-flash" allowFullScreen="true" allowScriptAccess="always" pluginspage="http://macromedia.com/go/getflashplayer" flashvars="c=v&v=0ba39053-48f2-4a2c-99eb-cb1b5bc9b263&ifs=true&fr=msnvideo&mkt=ja-JP"></embed>

//=========================================================
class webphoto_embed_soapbox extends webphoto_embed_base {

	public function __construct() {
		parent::__construct( 'soapbox' );
		$this->set_url( 'http://video.msn.com/video.aspx?vid=' );
		$this->set_sample( '0ba39053-48f2-4a2c-99eb-cb1b5bc9b263' );
	}

	public function embed( $src, $width, $height, $extra = null ) {
		$movie      = 'http://images.video.msn.com/flash/soapbox1_1.swf';
		$flash_vars = 'c=v&amp;v=' . $src . '&amp;ifs=true&amp;fr=msnvideo';

		$embed = '<embed src="http://images.video.msn.com/flash/soapbox1_1.swf" quality="high" width="' . $width . '" height="' . $height . '" type="application/x-shockwave-flash" allowFullScreen="true" allowScriptAccess="always" pluginspage="http://macromedia.com/go/getflashplayer" flashvars="' . $flash_vars . '" />';

		return $embed;
	}

	public function link( $src ) {
		return $this->build_link( $src );
	}

	public function desc() {
		return $this->build_desc();
	}

}

