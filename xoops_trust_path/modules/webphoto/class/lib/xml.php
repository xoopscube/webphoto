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


class webphoto_lib_xml {


	function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_xml();
		}

		return $instance;
	}

// --------------------------------------------------------
// htmlspecialchars
// http://www.w3.org/TR/REC-xml/#dt-markup
// http://www.fxis.co.jp/xmlcafe/tmp/rec-xml.html#dt-markup
//   &  -> &amp;	// without html entity
//   <  -> &lt;
//   >  -> &gt;
//   "  -> &quot;
//   '  -> &apos;
// --------------------------------------------------------
	public function xml_text( $str ) {
		return $this->xml_htmlspecialchars_strict( $str );
	}

	public function xml_url( $str ) {
		return $this->xml_htmlspecialchars_url( $str );
	}

	public function xml_htmlspecialchars( $str ) {
		$str = $this->replace_control_code( $str, '' );
		$str = $this->replace_return_code( $str );
		$str = htmlspecialchars( $str );
		$str = preg_replace( "/'/", '&apos;', $str );

		return $str;
	}

	public function xml_htmlspecialchars_strict( $str ) {
		$str = $this->xml_strip_html_entity_char( $str );
		$str = $this->xml_htmlspecialchars( $str );
		$str = str_replace( '?', '&#063;', $str );

		return $str;
	}

	public function xml_htmlspecialchars_url( $str ) {
		$str = preg_replace( "/&amp;/sU", '&', $str );
		$str = $this->xml_strip_html_entity_char( $str );
		$str = $this->xml_htmlspecialchars( $str );

		return $str;
	}

	public function xml_cdata( $str, $flag_control = true, $flag_undo = true ) {
		$str = $this->replace_control_code( $str, '' );
		$str = $this->xml_undo_html_special_chars( $str );

// not sanitize
		$str = $this->xml_convert_cdata( $str );

		return $str;
	}

	public function xml_convert_cdata( $str ) {
		return preg_replace( "/]]>/", ']]&gt;', $str );
	}

// --------------------------------------------------------
// strip html entities
//   &abc; -> ' '
// --------------------------------------------------------
	public function xml_strip_html_entity_char( $str ) {
		return preg_replace( "/&[0-9a-zA-z]+;/sU", ' ', $str );
	}

// --------------------------------------------------------
// undo XOOPS HtmlSpecialChars
//   &lt;   -> <
//   &gt;   -> >
//   &quot; -> "
//   &#039; -> '
//   &amp;  -> &
//   &amp;nbsp; -> &nbsp;
// --------------------------------------------------------
	public function xml_undo_html_special_chars( $str ) {
		$str = preg_replace( "/&gt;/i", '>', $str );
		$str = preg_replace( "/&lt;/i", '<', $str );
		$str = preg_replace( "/&quot;/i", '"', $str );
		$str = preg_replace( "/&#039;/i", "'", $str );
		$str = preg_replace( "/&amp;nbsp;/i", '&nbsp;', $str );

		return $str;
	}


// TAB \x09 \t
// LF  \xOA \n
// CR  \xOD \r

	public function replace_control_code( $str, $replace = ' ' ) {
		$str = preg_replace( '/[\x00-\x08]/', $replace, $str );
		$str = preg_replace( '/[\x0B-\x0C]/', $replace, $str );
		$str = preg_replace( '/[\x0E-\x1F]/', $replace, $str );
		$str = preg_replace( '/[\x7F]/', $replace, $str );

		return $str;
	}

	public function replace_return_code( $str, $replace = ' ' ) {
		$str = preg_replace( "/\n/", $replace, $str );
		$str = preg_replace( "/\r/", $replace, $str );

		return $str;
	}


// sanitize

	public function sanitize( $str ) {
		return htmlspecialchars( $str, ENT_QUOTES );
	}

}
