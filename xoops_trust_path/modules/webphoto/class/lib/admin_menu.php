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

	/**
	 * Render nav-bar with UL dropdown menu (line 260)
	 * $menu_array as $menuitem customized by
	 * /webphoto/include/main.ini
	 * @param bool $flag_sub
	 *
	 * @return string
	 */
	public function build_menu_with_sub( $flag_sub = true ) {

		$str ='<nav class="webphoto-menu" style="display: inline-flex;justify-content: space-between">';
		$str .='<ul class="nav"><li><a href="#">Module</a>';

		$str .= $this->build_menu( ! $flag_sub );

		$str .= '</li></ul>';
		$str .= '<ul class="nav"><li><a href="#">Table</a>';

		if ( $flag_sub ) {
			$str .= $this->build_sub_table();
			$str .= '</li></ul><ul class="nav"><li><a href="#">Check</a>';
			$str .= $this->build_sub_check();
			$str .= '</li></ul><ul class="nav"><li><a href="#">Tools</a>';
			$str .= $this->build_sub_tools();
		}
		$str .= "</li></ul></nav>";

		return $str;
	}

	public function build_menu( $flag_default = true ) {

		$admin_menu_class =& webphoto_inc_admin_menu::getSingleton( $this->_DIRNAME, $this->_TRUST_DIRNAME );

		$admin_menu = $admin_menu_class->build_menu();

		$add_menu = $this->_build_additional_menu();

		$menu_array = null;
		if ( is_array( $admin_menu ) && count( $admin_menu ) && is_array( $add_menu ) && count( $add_menu ) ) {
			$menu_array = array_merge( $admin_menu, $add_menu );
		} elseif ( is_array( $admin_menu ) && count( $admin_menu ) ) {
			$menu_array = $admin_menu;
		} elseif ( is_array( $add_menu ) && count( $add_menu ) ) {
			$menu_array = $add_menu;
		}

		if ( is_array( $menu_array ) && count( $menu_array ) ) {

			return $this->_build_highlight( $menu_array, $flag_default );
		}

		return null;
	}


	/**
	 * Customize admin_sub_table
	 * /webphoto/include/main.ini
	 * @param bool $flag_default
	 *
	 * @return string|null
	 */
	public function build_sub_table( $flag_default = true ) {
		$admin_menu_class =& webphoto_inc_admin_menu::getSingleton( $this->_DIRNAME, $this->_TRUST_DIRNAME );
		$menu_array = $admin_menu_class->build_sub_table();

		if ( is_array( $menu_array ) && count( $menu_array ) ) {
			return $this->_build_highlight( $menu_array, $flag_default );
		}

		return null;
	}


	/**
	 * Customize admin_sub_table
	 * /webphoto/include/main.ini
	 * @param bool $flag_default
	 *
	 * @return string|null
	 */
	public function build_sub_check( $flag_default = true ) {
		$admin_menu_class =& webphoto_inc_admin_menu::getSingleton( $this->_DIRNAME, $this->_TRUST_DIRNAME );

		$menu_array = $admin_menu_class->build_sub_check();

		if ( is_array( $menu_array ) && count( $menu_array ) ) {

			return $this->_build_highlight( $menu_array, $flag_default );
		}

		return null;
	}

	/**
	 * Customize admin_sub_table
	 * /webphoto/include/main.ini
	 * @param bool $flag_default
	 *
	 * @return string|null
	 */
	public function build_sub_tools( $flag_default = true ) {
		$admin_menu_class =& webphoto_inc_admin_menu::getSingleton(
			$this->_DIRNAME, $this->_TRUST_DIRNAME );

		$menu_array = $admin_menu_class->build_sub_tools();

		if ( is_array( $menu_array ) && count( $menu_array ) ) {

			return $this->_build_highlight( $menu_array, $flag_default );
		}

		return null;
	}

	/* Altsys admin links */
	public function _build_additional_menu() {
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


	public function _build_highlight( $menu_array, $flag_default = true ) {

		$mymenu_uri  = $_SERVER['REQUEST_URI'];
		$mymenu_link = substr( strstr( $mymenu_uri, '/admin/' ), 1 );

		$flag_highlight = false;

// set gray all
		foreach ( array_keys( $menu_array ) as $i ) {
			//$menu_array[$i]['color'] = '#DDDDDD' ;
			$menu_array[ $i ]['color'] = 'green';
		}

		$post_fct = $_POST['fct'] ?? null;
		$fct      = preg_replace( '/[^a-zA-Z0-9_-]/', '', $post_fct );

// highlight
		if ( $fct ) {
			$uri_fct = $mymenu_link . '?fct=' . $fct;
			foreach ( array_keys( $menu_array ) as $i ) {
				if ( $uri_fct == $menu_array[ $i ]['link'] ) {
					//$menu_array[$i]['color'] = '#FFCCCC' ;
					$menu_array[ $i ]['color'] = 'red';
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

		/**
		 * Render an ul dropdown menu within nav-bar
		 * Customized by function build_menu_with_sub, line 52
		*/
		$text ='<ul class="dropdown">';

		foreach ( $menu_array as $menuitem ) {
			$text .= "<li>";
			$text .= "<a href='" . $this->sanitize( $menuitem['link'] ) . "' style='border-bottom:1px solid " . $menuitem['color'] . "; color:" . $menuitem['color'] . "'>";
			$text .= $this->sanitize( $menuitem['title'] );
			$text .= '</a></li>';
		}

		$text .= "</ul>\n";

		return $text;
	}


// utility

	public function sanitize( $str ) {
		return htmlspecialchars( $str, ENT_QUOTES );
	}


// language

	public function get_title( $name ) {
		$const_name = strtoupper( '_AM_' . $this->_TRUST_DIRNAME . '_MYMENU_' . $name );

		return defined( $const_name ) ? constant( $const_name ) : $name;
	}


// xoops param

	public function _init_xoops_param() {
		global $xoopsModule;
		if ( is_object( $xoopsModule ) ) {
			$this->_MODULE_ID = $xoopsModule->mid();
		}
	}

	public function has_xoops_config_this_module() {
		$config_handler =& xoops_gethandler( 'config' );

		return count( $config_handler->getConfigs( new Criteria( 'conf_modid', $this->_MODULE_ID ) ) );
	}

	public function get_xoops_module_by_dirname( $dirname ) {
		$module_handler =& xoops_gethandler( 'module' );

		return $module_handler->getByDirname( $dirname );
	}

	public function is_installed_altsys() {
		$module = $this->get_xoops_module_by_dirname( 'altsys' );
		if ( is_object( $module ) ) {
			return true;
		}

		return false;
	}

}
