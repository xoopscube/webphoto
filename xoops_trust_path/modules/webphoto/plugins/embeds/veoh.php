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
// class webphoto_embed_veoh
//
// http://www.veoh.com/videos/v1688234qJjc3gNG?source=featured&cmpTag=featured&rank=3
//
// <embed src="http://www.veoh.com/videodetails2.swf?permalinkId=v1688234qJjc3gNG&id=anonymous&player=videodetailsembedded&videoAutoPlay=0" allowFullScreen="true" width="540" height="438" bgcolor="#000000" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>
//=========================================================
class webphoto_embed_veoh extends webphoto_embed_base {

	public function __construct() {
		parent::__construct( 'veoh' );
		$this->set_url( 'http://www.veoh.com/videos/' );
	}

	public function embed( $src, $width, $height, $extra = null, $backcolor = '000000' ) {
		$movie = 'http://www.veoh.com/videodetails2.swf?permalinkId=' . $src . '&amp;id=anonymous&amp;player=videodetailsembedded&amp;videoAutoPlay=0';

		$embed = '<embed src="' . $movie . '" allowFullScreen="true" width="' . $width . '" height="' . $height . '" bgcolor=#"' . $backcolor . '" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />';

		return $embed;
	}

	public function link( $src ) {
		return $this->build_link( $src );
	}

	public function desc() {
		return $this->build_desc_span( $this->_url_head, 'v1688234qJjc3gNG', '?source=featured' );
	}

}
