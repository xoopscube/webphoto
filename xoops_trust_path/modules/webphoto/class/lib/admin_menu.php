<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * class webphoto_lib_admin_menu
 * base on myalbum's mymenu.php
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_lib_admin_menu {

	public $_menu_class;

	public $_DIRNAME;
	public $_MODULE_URL;
	public $_MODULE_DIR;
	public $_TRUST_DIRNAME;
	public $_TRUST_DIR;
	public $_MODULE_ID = 0;

	public function __construct( $dirname, $trust_dirname ) {
		$this->_DIRNAME    = $dirname;
		$this->_MODULE_URL = XOOPS_URL . '/modules/' . $dirname;
		$this->_MODULE_DIR = XOOPS_ROOT_PATH . '/modules/' . $dirname;

		$this->_TRUST_DIRNAME = $trust_dirname;
		$this->_TRUST_DIR     = XOOPS_TRUST_PATH . '/modules/' . $trust_dirname;

		$this->_init_xoops_param();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_admin_menu( $dirname, $trust_dirname );
		}

		return $instance;
	}

	function build_menu_with_sub( $flag_sub = true ) {
		$str = $this->build_menu( ! $flag_sub, false );

		if ( $flag_sub ) {
			$str .= "<br>\n";
			$str .= $this->build_sub_menu( true, false );
		}

		$str .= $this->build_hr( true );

		return $str;
	}

	function build_menu( $flag_default = true, $flag_hr = true ) {


		$admin_menu_class
			        =& webphoto_inc_admin_menu::getSingleton(
			$this->_DIRNAME, $this->_TRUST_DIRNAME );
		$admin_menu = $admin_menu_class->build_menu();

		$add_menu = $this->_build_additinal_menu();

		$menu_array = null;
		if ( is_array( $admin_menu ) && count( $admin_menu ) &&
		     is_array( $add_menu ) && count( $add_menu ) ) {
			$menu_array = array_merge( $admin_menu, $add_menu );
		} elseif ( is_array( $admin_menu ) && count( $admin_menu ) ) {
			$menu_array = $admin_menu;
		} elseif ( is_array( $add_menu ) && count( $add_menu ) ) {
			$menu_array = $add_menu;
		}

		if ( is_array( $menu_array ) && count( $menu_array ) ) {
			$str = $this->_build_highlight( $menu_array, $flag_default );
			$str .= $this->build_hr( $flag_hr );

			return $str;
		}

		return null;
	}

	function build_sub_menu( $flag_default = true, $flag_hr = true ) {
		$admin_menu_class
			        =& webphoto_inc_admin_menu::getSingleton(
			$this->_DIRNAME, $this->_TRUST_DIRNAME );
		$menu_array = $admin_menu_class->build_sub_menu();

		if ( is_array( $menu_array ) && count( $menu_array ) ) {
			$str = $this->_build_highlight( $menu_array, $flag_default );
			$str .= $this->build_hr( $flag_hr );

			return $str;
		}

		return null;
	}

	function build_hr( $flag_hr = true ) {
		if ( $flag_hr ) {
			$str = "<hr>\n";

			return $str;
		}

		return null;
	}

	function _build_additinal_menu() {
		// with XOOPS_TRUST_PATH and altsys

		$flag_preferences = false;

		$menu_array = array();

		if ( $this->is_installed_altsys() ) {

// mytplsadmin (TODO check if this module has tplfile)
			if ( file_exists( XOOPS_TRUST_PATH . '/libs/altsys/mytplsadmin.php' ) ) {
				$menu_array[] = array(
					'title' => $this->get_title( 'tplsadmin' ),
					'link'  => 'admin/index.php?mode=admin&lib=altsys&page=mytplsadmin'
				);
			}

			// myblocksadmin
			if ( file_exists( XOOPS_TRUST_PATH . '/libs/altsys/myblocksadmin.php' ) ) {
				$menu_array[] = array(
					'title' => $this->get_title( 'blocksadmin' ),
					'link'  => 'admin/index.php?mode=admin&lib=altsys&page=myblocksadmin'
				);
			}

			// mypreferences
			if ( $this->has_xoops_config_this_module() ) {
				if ( file_exists( XOOPS_TRUST_PATH . '/libs/altsys/mypreferences.php' ) ) {
					$flag_preferences = true;
					$menu_array[]     = array(
						'title' => _PREFERENCES,
						'link'  => 'admin/index.php?mode=admin&lib=altsys&page=mypreferences'
					);
				}
			}
		}

		// preferences
		if ( ! $flag_preferences && $this->has_xoops_config_this_module() ) {

			// XOOPS Cube 2.1
			if ( defined( 'XOOPS_CUBE_LEGACY' ) ) {
				$link = XOOPS_URL . '/modules/legacy/admin/index.php?action=PreferenceEdit&confmod_id=' . $this->_MODULE_ID;

				// XOOPS 2.0
			} else {
				$link = XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $this->_MODULE_ID;
			}

			$menu_array[] = array(
				'title' => _PREFERENCES,
				'link'  => $link
			);
		}

		$menu_array[] = array(
			'title' => $this->get_title( 'goto_module' ),
			'link'  => 'index.php',
		);

		return $menu_array;
	}

	function _build_highlight( $menu_array, $flag_default = true ) {
		$mymenu_uri  = $_SERVER['REQUEST_URI'];
		$mymenu_link = substr( strstr( $mymenu_uri, '/admin/' ), 1 );

		$flag_highlight = false;

// set gray all
		foreach ( array_keys( $menu_array ) as $i ) {
			//$menu_array[$i]['color'] = '#DDDDDD' ;
			$menu_array[ $i ]['color'] = '';
		}

		$post_fct = $_POST['fct'] ?? null;
		$fct      = preg_replace( '/[^a-zA-Z0-9_-]/', '', $post_fct );

// highlight
		if ( $fct ) {
			$uri_fct = $mymenu_link . '?fct=' . $fct;
			foreach ( array_keys( $menu_array ) as $i ) {
				if ( $uri_fct == $menu_array[ $i ]['link'] ) {
					//$menu_array[$i]['color'] = '#FFCCCC' ;
					$menu_array[ $i ]['color'] = '';
					$flag_highlight            = true;
					break;
				}
			}
		}

		if ( $fct && ! $flag_highlight ) {
			$uri_fct = $mymenu_uri . '?fct=' . $fct;
			foreach ( array_keys( $menu_array ) as $i ) {
				if ( false !== stripos( $uri_fct, $menu_array[ $i ]['link'] ) ) {
					$menu_array[ $i ]['color'] = '#face74';
					$flag_highlight            = true;
					break;
				}
			}
		}

		if ( ! $flag_highlight ) {
			foreach ( array_keys( $menu_array ) as $i ) {
				if ( $mymenu_link == $menu_array[ $i ]['link'] ) {
					$menu_array[ $i ]['color'] = '#face74';
					$flag_highlight            = true;
					break;
				}
			}
		}

		if ( ! $flag_highlight ) {
			foreach ( array_keys( $menu_array ) as $i ) {
				$link = $menu_array[ $i ]['link'];
				if ( $link != 'admin/index.php' &&
				     strpos( $mymenu_link, $link ) === 0 ) {

					$menu_array[ $i ]['color'] = '#face74';
					$flag_highlight            = true;
					break;
				}
			}
		}

		if ( ! $flag_highlight && $flag_default ) {
			foreach ( array_keys( $menu_array ) as $i ) {
				if ( false !== stripos( $mymenu_uri, $menu_array[ $i ]['link'] ) ) {
					$menu_array[ $i ]['color'] = '#FFCCCC';
					break;
				}
			}
		}

		// link conversion from relative to absolute
		foreach ( array_keys( $menu_array ) as $i ) {
			if ( false === stripos( $menu_array[ $i ]['link'], XOOPS_URL ) ) {
				$menu_array[ $i ]['link'] = $this->_MODULE_URL . '/' . $menu_array[ $i ]['link'];
			}
		}

		// display
		$text = "<div style='text-align:left;width:98%;'>\n";

		foreach ( $menu_array as $menuitem ) {
			//$text .= "<div style='float:left;height:1.5em;'>";
			$text .= "<a href='" . $this->sanitize( $menuitem['link'] ) . "' style='border-bottom:2px solid; border-bottom-color:" . $menuitem['color'] . "; color:" . $menuitem['color'] . ";margin:0 .25em'>";
			$text .= $this->sanitize( $menuitem['title'] );
			$text .= "</a>";
			//| </div>\n";
		}

		$text .= "</div>\n";
		$text .= "<br>\n";

		return $text;
	}


// utility

	function sanitize( $str ) {
		return htmlspecialchars( $str, ENT_QUOTES );
	}


// language

	function get_title( $name ) {
		$const_name = strtoupper( '_AM_' . $this->_TRUST_DIRNAME . '_MYMENU_' . $name );
		$title      = defined( $const_name ) ? constant( $const_name ) : $name;

		return $title;
	}


// xoops param

	function _init_xoops_param() {
		global $xoopsModule;
		if ( is_object( $xoopsModule ) ) {
			$this->_MODULE_ID = $xoopsModule->mid();
		}
	}

	function has_xoops_config_this_module() {
		$config_handler =& xoops_gethandler( 'config' );

		return count( $config_handler->getConfigs( new Criteria( 'conf_modid', $this->_MODULE_ID ) ) );
	}

	function get_xoops_module_by_dirname( $dirname ) {
		$module_handler =& xoops_gethandler( 'module' );

		return $module_handler->getByDirname( $dirname );
	}

	function is_installed_altsys() {
		$module = $this->get_xoops_module_by_dirname( 'altsys' );
		if ( is_object( $module ) ) {
			return true;
		}

		return false;
	}

}
