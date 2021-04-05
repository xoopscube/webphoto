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
// class webphoto_embed_vimeo
//
// http://www.vimeo.com/192696
//
// <object width="400" height="300">
// <param name="allowfullscreen" value="true" />
// <param name="allowscriptaccess" value="always" />
// <param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=192696&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" />
// <embed src="http://vimeo.com/moogaloop.swf?clip_id=192696&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="400" height="300"></embed>
// </object>
//=========================================================
class webphoto_embed_vimeo extends webphoto_embed_base {

	public function __construct() {
		parent::__construct( 'vimeo' );
		$this->set_url( 'http://www.vimeo.com/' );
		$this->set_sample( '192696' );
	}

	public function embed( $src, $width, $height, $extra = null ) {
		$movie = 'http://www.vimeo.com/moogaloop.swf?clip_id=' . $src . '&amp;server=www.vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1';
		$extra = 'allowfullscreen="true" allowscriptaccess="always"';

		$str = $this->build_object_begin( $width, $height );
		$str .= $this->build_param( 'allowfullscreen', 'true' );
		$str .= $this->build_param( 'allowscriptaccess', 'always' );
		$str .= $this->build_param( 'movie', $movie );
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
