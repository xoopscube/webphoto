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


class webphoto_embed extends webphoto_lib_plugin {
	public $_config_class;

	public $_param = null;

	public $_WIDTH_DEFAULT = _C_WEBPHOTO_EMBED_WIDTH_DEFAULT;
	public $_HEIGHT_DEFAULT = _C_WEBPHOTO_EMBED_HEIGHT_DEFAULT;

	public $_WORK_DIR;
	public $_TMP_DIR;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->set_dirname( 'embeds' );
		$this->set_prefix( 'webphoto_embed_' );

		$this->_config_class =& webphoto_config::getInstance( $dirname );
		$this->_WORK_DIR     = $this->_config_class->get_by_name( 'workdir' );
		$this->_TMP_DIR      = $this->_WORK_DIR . '/tmp';

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_embed( $dirname, $trust_dirname );
		}

		return $instance;
	}


// embed

	public function set_param( $val ) {
		if ( is_array( $val ) ) {
			$this->_param = $val;
		}
	}

	public function get_xml_params( $type, $src ) {
		if ( empty( $type ) ) {
			return false;
		}

		if ( empty( $src ) ) {
			return false;
		}

		$class =& $this->get_class_object( $type );
		if ( ! is_object( $class ) ) {
			return false;
		}

		$class->set_tmp_dir( $this->_TMP_DIR );

		return $class->get_xml_params( $src );
	}

	public function build_embed_link( $type, $src, $width, $height ) {
		if ( empty( $type ) ) {
			return false;
		}

		if ( empty( $src ) ) {
			return false;
		}

		$class =& $this->get_class_object( $type );
		if ( ! is_object( $class ) ) {
			return false;
		}

		if ( is_array( $this->_param ) ) {
			$class->set_param( $this->_param );
		}

// plugin if empty
		if ( empty( $width ) ) {
			$width = $class->width();
		}
		if ( empty( $height ) ) {
			$height = $class->height();
		}

// default if empty
		if ( empty( $width ) ) {
			$width = $this->_WIDTH_DEFAULT;
		}
		if ( empty( $height ) ) {
			$height = $this->_HEIGHT_DEFAULT;
		}

		$embed = $class->embed( $src, $width, $height );
		$link  = $class->link( $src );

		return array( $embed, $link );
	}

	public function build_link( $type, $src ) {
		if ( empty( $type ) ) {
			return false;
		}

		if ( empty( $src ) ) {
			return false;
		}

		$class =& $this->get_class_object( $type );
		if ( ! is_object( $class ) ) {
			return false;
		}

		return $class->link( $src );
	}

	public function build_type_options( $flag_general ) {
		$list = $this->build_list();

		$arr = array();
		foreach ( $list as $type ) {
			if ( ( $type == _C_WEBPHOTO_EMBED_NAME_GENERAL ) && ! $flag_general ) {
				continue;
			}
			$arr[ $type ] = $type;
		}

		return $arr;
	}

	public function build_src_desc( $type, $src ) {
		if ( empty( $type ) ) {
			return false;
		}

		$class =& $this->get_class_object( $type );
		if ( ! is_object( $class ) ) {
			return false;
		}

		$lang = $class->lang_desc();
		if ( empty( $lang ) ) {
			$lang = _WEBPHOTO_EMBED_ENTER;
		}

// typo
		$str = $lang . "<br>\n";
		$str .= _WEBPHOTO_EMBED_EXAMPLE . "<br>\n";
		$str .= $class->desc() . "<br>\n";

		if ( $src ) {
			$str .= '<img src="' . $class->thumb( $src ) . ' border="0" />';
			$str .= "<br>\n";
		}

		return $str;
	}

	public function build_thumb( $type, $src ) {
		if ( empty( $type ) ) {
			return false;
		}

		if ( empty( $src ) ) {
			return false;
		}

		$class =& $this->get_class_object( $type );
		if ( ! is_object( $class ) ) {
			return false;
		}

		return $class->thumb( $src );
	}

	public function build_support_params( $type ) {
		if ( empty( $type ) ) {
			return false;
		}

		$class =& $this->get_class_object( $type );
		if ( ! is_object( $class ) ) {
			return false;
		}

		$arr = $class->support_params();
		if ( is_array( $arr ) ) {
			return $arr;
		}

		$ret = $class->thumb( 'example' );
		if ( $ret ) {
			$arr = array(
				'thumb' => true,
			);
		}

		return false;
	}

}
