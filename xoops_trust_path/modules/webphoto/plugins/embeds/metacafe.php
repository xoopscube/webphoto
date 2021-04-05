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
// class webphoto_embed_metacafe
//
// http://www.metacafe.com/watch/714487/amazing_crash_and_crazy_tractor/
//
// <embed src="http://www.metacafe.com/fplayer/877529/incredible_paper.swf" width="400" height="345" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"> </embed>
//=========================================================
class webphoto_embed_metacafe extends webphoto_embed_base {

	public function __construct() {
		parent::__construct( 'metacafe' );
		$this->set_url( 'http://www.metacafe.com/watch/' );
	}

	public function embed( $src, $width, $height, $extra = null ) {
		$movie = 'http://www.metacafe.com/fplayer/' . $src . '.swf';
		$embed = '<embed src="' . $movie . '" width="' . $width . '" height="' . $height . '" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" />';

		return $embed;
	}

	public function link( $src ) {
		return $this->build_link( $src );
	}

	public function thumb( $src ) {
// '714487/amazing_crash_and_crazy_tractor/' -> '714487'
		$thumb = substr( $src, 0, strpos( $src, '/' ) );

		return 'http://www.metacafe.com/thumb/' . $thumb . '.jpg';
	}

	public function desc() {
		return $this->build_desc_span( $this->_url_head, '714487' . '/amazing_crash_and_crazy_tractor/' );
	}
}
