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


class webphoto_editor_xoopsdhtml extends webphoto_editor_base {
	public $_caption = '';
	public $_hiddentext = 'xoopsHiddenText';
	private $isXCL22;

	public function __construct() {

		parent::__construct();

		$this->set_allow_in_not_has_html( true );
		$this->set_show_display_options( true );
		$this->set_display_html( 1 );
		$this->set_display_smiley( 1 );
		$this->set_display_xcode( 1 );
		$this->set_display_image( 1 );
		$this->set_display_br( 1 );

		$this->isXCL22 = ( defined( 'LEGACY_BASE_VERSION' ) && version_compare( LEGACY_BASE_VERSION, '2.2', '>=' ) );
	}

	public function display_options( $has_html ) {
		if ( $this->isXCL22 ) {
			return array(
				'html'   => $has_html ? 1 : 0,
				'smiley' => $has_html ? 0 : 1,
				'xcode'  => $has_html ? 0 : 1,
				'image'  => $has_html ? 0 : 1,
				'br'     => $has_html ? 0 : 1
			);
		}

		return parent::display_options( $has_html );
	}

	public function exists() {
		return true;
	}

	public function build_textarea( $id, $name, $value, $rows, $cols, $item_row ) {
		$ele = new XoopsFormDhtmlTextArea(
			$this->_caption, $name, $value, $rows, $cols, $this->_hiddentext );
		if ( $this->isXCL22 ) {
			$ele->setEditor( $item_row['item_description_html'] ? 'HTML' : 'BBCode' );
		}

		return $ele->render();
	}

}
