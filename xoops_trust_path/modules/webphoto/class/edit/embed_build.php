<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief class webphoto_d3_notification_select
 * subsitute for core's notification_select.php
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_edit_embed_build extends webphoto_edit_base {

	public $_embed_class;

	public $_item_row = null;
	public $_title = null;
	public $_description = null;
	public $_url = null;
	public $_thumb = null;
	public $_duration = null;
	public $_tags = null;
	public $_script = null;

	public $_THUMB_EXT_DEFAULT = 'embed';


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_embed_class =& webphoto_embed::getInstance( $dirname, $trust_dirname );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_embed_build( $dirname, $trust_dirname );
		}

		return $instance;
	}


// public
	public function is_type( $row ) {
		if ( $row['item_embed_type'] ) {
			return true;
		}

		return false;
	}

	public function build( $row ) {
		$this->_item_row = $row;

		$item_title          = $row['item_title'];
		$item_description    = $row['item_description'];
		$item_duration       = $row['item_duration'];
		$item_embed_type     = $row['item_embed_type'];
		$item_embed_src      = $row['item_embed_src'];
		$item_embed_text     = $row['item_embed_text'];
		$item_external_thumb = $row['item_external_thumb'];
		$item_siteurl        = $row['item_siteurl'];

		if ( ! $this->is_type( $row ) ) {
			return 1;    // no action
		}

		if ( $item_embed_src || $item_embed_text ) {
			$row['item_kind'] = _C_WEBPHOTO_ITEM_KIND_EMBED;

		} else {
			return _C_WEBPHOTO_ERR_EMBED;
		}

		$row['item_displaytype'] = _C_WEBPHOTO_DISPLAYTYPE_EMBED;

		$this->clear_params();
		$this->set_params( $this->get_xml_params( $row ) );

// title
		if ( empty( $item_title ) ) {
			$row['item_title'] = $this->build_title( $row );
		}

// duration
		if ( empty( $item_duration ) ) {
			$row['item_duration'] = $this->build_duration( $row );
		}

// external thumb
		if ( empty( $item_external_thumb ) ) {
			$row['item_external_thumb'] = $this->build_thumb( $row );
		}

// embed text
		if ( empty( $item_embed_text ) ) {
			$row['item_embed_text'] = $this->build_script( $row );
		}

// siteurl
		if ( empty( $item_siteurl ) ) {
			$row['item_siteurl'] = $this->build_url( $row );
		}

// description
		$description = $this->build_description( $row );
		if ( $item_description && $description ) {
			$row['item_description'] .= "\n\n" . $description;
		} elseif ( empty( $item_description ) ) {
			$row['item_description'] = $description;
		}

		$row = $this->build_item_row_icon_if_empty( $row, $this->_THUMB_EXT_DEFAULT );

		$this->_item_row = $row;

		return 0;    // OK
	}

	public function clear_params() {
		$this->_title       = null;
		$this->_description = null;
		$this->_url         = null;
		$this->_thumb       = null;
		$this->_duration    = null;
		$this->_tags        = null;
		$this->_script      = null;
	}

	public function set_params( $params ) {
		if ( isset( $params['title'] ) ) {
			$this->_title = $params['title'];
		}
		if ( isset( $params['description'] ) ) {
			$this->_description = $params['description'];
		}
		if ( isset( $params['url'] ) ) {
			$this->_url = $params['url'];
		}
		if ( isset( $params['thumb'] ) ) {
			$this->_thumb = $params['thumb'];
		}
		if ( isset( $params['duration'] ) ) {
			$this->_duration = $params['duration'];
		}
		if ( isset( $params['tags'] ) ) {
			$this->_tags = $params['tags'];
		}
		if ( isset( $params['script'] ) ) {
			$this->_script = $params['script'];
		}
	}

	public function get_xml_params( $row ) {
		$embed_type = $row['item_embed_type'];
		$embed_src  = $row['item_embed_src'];

		return $this->_embed_class->get_xml_params( $embed_type, $embed_src );
	}

	public function build_title( $row ) {
		if ( $this->_title ) {
			return $this->_title;
		}

		$embed_type = $row['item_embed_type'];
		$embed_src  = $row['item_embed_src'];

		if ( empty( $embed_type ) ) {
			return null;
		}
		if ( empty( $embed_src ) ) {
			return null;
		}

		$title = $embed_type;
		$title .= ' : ';
		$title .= $embed_src;

		return $title;
	}

	public function build_thumb( $row ) {
		if ( $this->_thumb ) {
			return $this->_thumb;
		}

		$embed_type = $row['item_embed_type'];
		$embed_src  = $row['item_embed_src'];

		return $this->_embed_class->build_thumb( $embed_type, $embed_src );
	}

	public function build_description( $row ) {
		if ( $this->_description ) {
			return $this->_description;
		}

		return null;
	}

	public function build_url( $row ) {
		if ( $this->_url ) {
			return $this->_url;
		}

		return null;
	}

	public function build_duration( $row ) {
		if ( $this->_duration ) {
			return $this->_duration;
		}

		return null;
	}

	public function build_script( $row ) {
		if ( $this->_script ) {
			return $this->_script;
		}

		return null;
	}

	public function get_tags() {
		return $this->_tags;
	}

	public function get_item_row() {
		return $this->_item_row;
	}

}
