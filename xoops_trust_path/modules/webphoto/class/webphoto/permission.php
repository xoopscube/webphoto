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


class webphoto_permission extends webphoto_inc_group_permission {
	public $_has_insertable;
	public $_has_superinsert;
	public $_has_editable;
	public $_has_supereditable;
	public $_has_deletable;
	public $_has_superdeletable;
	public $_has_touchothers;
	public $_has_supertouchothers;
	public $_has_rateview;
	public $_has_ratevote;
	public $_has_tellafriend;
	public $_has_tagedit;
	public $_has_mail;
	public $_has_file;
	public $_has_html;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_has_insertable       = $this->has_perm( 'insertable' );
		$this->_has_superinsert      = $this->has_perm( 'superinsert' );
		$this->_has_editable         = $this->has_perm( 'editable' );
		$this->_has_superedit        = $this->has_perm( 'superedit' );
		$this->_has_deletable        = $this->has_perm( 'deletable' );
		$this->_has_superdelete      = $this->has_perm( 'superdelete' );
		$this->_has_touchothers      = $this->has_perm( 'touchothers' );
		$this->_has_supertouchothers = $this->has_perm( 'supertouchothers' );
		$this->_has_rateview         = $this->has_perm( 'rateview' );
		$this->_has_ratevote         = $this->has_perm( 'ratevote' );
		$this->_has_tellafriend      = $this->has_perm( 'tellafriend' );
		$this->_has_tagedit          = $this->has_perm( 'tagedit' );
		$this->_has_mail             = $this->has_perm( 'mail' );
		$this->_has_file             = $this->has_perm( 'file' );
		$this->_has_html             = $this->has_perm( 'html' );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_permission( $dirname, $trust_dirname );
		}

		return $instance;
	}


// has permit

	public function has_insertable() {
		return $this->_has_insertable;
	}

	public function has_superinsert() {
		return $this->_has_superinsert;
	}

	public function has_editable() {
		return $this->_has_editable;
	}

	public function has_superedit() {
		return $this->_has_superedit;
	}

	public function has_deletable() {
		return $this->_has_deletable;
	}

	public function has_superdelete() {
		return $this->_has_superdelete;
	}

	public function has_touchothers() {
		return $this->_has_touchothers;
	}

	public function has_supertouchothers() {
		return $this->_has_supertouchothers;
	}

	public function has_rateview() {
		return $this->_has_rateview;
	}

	public function has_ratevote() {
		return $this->_has_ratevote;
	}

	public function has_tellafriend() {
		return $this->_has_tellafriend;
	}

	public function has_tagedit() {
		return $this->_has_tagedit;
	}

	public function has_mail() {
		return $this->_has_mail;
	}

	public function has_file() {
		return $this->_has_file;
	}

	public function has_html() {
		return $this->_has_html;
	}

}
