<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * class webphoto_inc_xoops_header
 * caller inc_blocks show_main
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_inc_xoops_header {
	public $_DIRNAME;
	public $_MODULE_URL;
	public $_LIBS_URL;
	public $_POPBOX_URL;

	public $_XOOPS_MODULE_HADER = 'xoops_module_header';
	public $_BLOCK_POPBOX_JS = false;
	public $_LANG_POPBOX_REVERT = 'Click the image to shrink it.';

	public function __construct( $dirname ) {
		$this->_DIRNAME    = $dirname;
		$this->_MODULE_URL = XOOPS_URL . '/modules/' . $dirname;
		$this->_LIBS_URL   = $this->_MODULE_URL . '/libs';
		$this->_POPBOX_URL = $this->_MODULE_URL . '/images/popbox';

// preload
		if ( defined( "_C_WEBPHOTO_PRELOAD_XOOPS_MODULE_HEADER" ) ) {
			$this->_XOOPS_MODULE_HADER = _C_WEBPHOTO_PRELOAD_XOOPS_MODULE_HEADER;
		}

		if ( defined( "_C_WEBPHOTO_PRELOAD_BLOCK_POPBOX_JS" ) ) {
			$this->_BLOCK_POPBOX_JS = (bool) _C_WEBPHOTO_PRELOAD_BLOCK_POPBOX_JS;
		}
	}

	public static function &getSingleton( $dirname ) {
		static $singletons;
		if ( ! isset( $singletons[ $dirname ] ) ) {
			$singletons[ $dirname ] = new webphoto_inc_xoops_header( $dirname );
		}

		return $singletons[ $dirname ];
	}

// for block
	public function assign_or_get_popbox_js( $lang_popbox_revert ) {
		if ( ! $this->check_popbox_js() ) {
			return null;
		}

		$popbox_js = $this->build_popbox_js( $lang_popbox_revert );

		if ( $this->_BLOCK_POPBOX_JS ) {
			return $popbox_js;
		}

		$this->assign_xoops_module_header( $popbox_js );

		return null;
	}

	public function assign_or_get_gmap_api_js( $apikey ) {
		if ( ! $this->check_gmap_api() ) {
			return null;
		}

		$api_js = $this->build_gmap_api( $apikey );
		if ( $this->_BLOCK_POPBOX_JS ) {
			return $api_js;
		}

		$this->assign_xoops_module_header( $api_js );

		return null;
	}

	public function assign_or_get_gmap_block_js() {
		if ( ! $this->check_gmap_block_js() ) {
			return null;
		}

		$block_js = $this->build_gmap_block_js();
		if ( $this->_BLOCK_POPBOX_JS ) {
			return $block_js;
		}

		$this->assign_xoops_module_header( $block_js );

		return null;
	}

// for main
	public function build_once_popbox_js( $lang_popbox_revert ) {
		if ( $this->check_popbox_js() ) {
			return $this->build_popbox_js( $lang_popbox_revert );
		}

		return null;
	}

	public function build_once_gmap_js() {
		if ( $this->check_gmap_js() ) {
			return $this->build_gmap_js();
		}

		return null;
	}

	public function check_gmap_js() {
		return $this->check_once( $this->build_const_name( 'gmap_js' ) );
	}

	public function check_gmap_block_js() {
		return $this->check_once( $this->build_const_name( 'gmap_block_js' ) );
	}

	public function check_popbox_js() {
		return $this->check_once( $this->build_const_name( 'popbox_js' ) );
	}

	public function build_gmap_js() {
		return $this->build_script_js_libs( 'gmap.js' );
	}

	public function build_gmap_block_js() {
		return $this->build_script_js_libs( 'gmap_block.js' );
	}

	public function build_popbox_js( $lang_popbox_revert = null ) {
		if ( empty( $lang_popbox_revert ) ) {
			$lang_popbox_revert = $this->_LANG_POPBOX_REVERT;
		}

		$text = '  popBoxRevertText    = "' . $lang_popbox_revert . '" ' . "\n";
		$text .= '  popBoxWaitImage.src = "' . $this->_POPBOX_URL . '/spinner40.gif" ' . "\n";
		$text .= '  popBoxRevertImage   = "' . $this->_POPBOX_URL . '/magminus.gif" ' . "\n";
		$text .= '  popBoxPopImage      = "' . $this->_POPBOX_URL . '/magplus.gif" ' . "\n";

		$str = $this->build_link_css_libs( 'popbox/Styles.css' );
		$str .= $this->build_script_js_libs( 'popbox/PopBox.js' );
		$str .= $this->build_envelop_js( $text );

		return $str;
	}

// utility
	public function build_const_name( $name ) {
		return strtoupper( '_C_WEBPHOTO_HEADER_LOADED_' . $name );
	}

	public function check_once( $const_name ) {
		if ( ! defined( $const_name ) ) {
			define( $const_name, 1 );

			return true;
		}

		return false;
	}

	public function build_link_css_libs( $css ) {
		return $this->build_link_css( $this->_LIBS_URL . '/' . $css );
	}

	public function build_link_css( $herf ) {
		return '<link rel="stylesheet" type="text/css" href="' . $herf . '" />' . "\n";
	}

	public function build_script_js_libs( $js ) {
		return $this->build_script_js( $this->_LIBS_URL . '/' . $js );
	}

	public function build_script_js( $src ) {
		return '<script src="' . $src . '" type="text/javascript"></script>' . "\n";
	}

	public function build_link_rss( $url ) {
		return '<link rel="alternate" type="application/rss+xml" title="RSS" href="' . $url . '" />' . "\n";
	}

	public function build_envelop_js( $text ) {
		return <<< EOF
<script type="text/javascript">
//<![CDATA[
$text 
//]]>
</script> 
EOF;
	}

	function build_envelop_css( $text ) {
		return <<< EOF
<style type="text/css">
$text 
</style> 
EOF;
	}

// template
// some block use xoops_module_header
	public function assign_xoops_module_header( $var ) {
		global $xoopsTpl;
		if ( $var ) {
			$xoopsTpl->assign(
				$this->_XOOPS_MODULE_HADER,
				$var . "\n" . $this->get_xoops_module_header()
			);
		}
	}

	public function get_xoops_module_header() {
		global $xoopsTpl;

		return $xoopsTpl->get_template_vars( $this->_XOOPS_MODULE_HADER );
	}

// common with weblinks
	public function build_once_gmap_api( $apikey ) {
		return happy_linux_build_once_gmap_api( $apikey );
	}

	public function check_gmap_api() {
		return happy_linux_check_once_gmap_api();
	}

	public function build_gmap_api( $apikey ) {
		return happy_linux_build_gmap_api( $apikey );
	}

}
