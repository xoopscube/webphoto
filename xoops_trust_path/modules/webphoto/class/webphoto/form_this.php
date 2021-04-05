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


class webphoto_form_this extends webphoto_lib_form {
	public $_cat_handler;
	public $_item_handler;
	public $_gicon_handler;
	public $_config_class;
	public $_preload_class;
	public $_perm_class;

	public $_cfg_gmap_apikey;
	public $_cfg_width;
	public $_cfg_height;
	public $_cfg_fsize;
	public $_cfg_makethumb;
	public $_cfg_file_size;
	public $_cfg_perm_item_read;

	public $_has_deletable;

	public $_is_japanese = false;
	public $_checkbox_array = array();

	public $_FILED_COUNTER_1 = 1;
	public $_FILED_COUNTER_2 = 2;

	public $_UPLOADS_PATH;
	public $_MEDIAS_PATH;
	public $_WORK_DIR;
	public $_FILE_DIR;
	public $_PHOTOS_PATH;
	public $_PHOTOS_DIR;
	public $_PHOTOS_URL;
	public $_THUMBS_PATH;
	public $_THUMBS_DIR;
	public $_THUMBS_URL;
	public $_CATS_PATH;
	public $_CATS_DIR;
	public $_CATS_URL;
	public $_MEDIAS_DIR;
	public $_MEDIAS_URL;
	public $_PLAYLISTS_DIR;
	public $_PLAYLISTS_URL;
	public $_TMP_DIR;
	public $_MAIL_DIR;
	public $_LOG_DIR;

	public $_ICONS_URL;
	public $_ICON_ROTATE_URL;
	public $_ROOT_EXTS_DIR;
	public $_ROOT_EXTS_URL;

	public $_TAGS_SIZE = 80;

	public $_EMBED_TYPE_DEFAULT = _C_WEBPHOTO_EMBED_TYPE_DEFAULT;
	public $_EDITOR_DEFAULT = _C_WEBPHOTO_EDITOR_DEFAULT;
	public $_PHOTO_FIELD_NAME = _C_WEBPHOTO_UPLOAD_FIELD_PHOTO;
	public $_THUMB_FIELD_NAME = _C_WEBPHOTO_UPLOAD_FIELD_THUMB;
	public $_MIDDLE_FIELD_NAME = _C_WEBPHOTO_UPLOAD_FIELD_MIDDLE;

	public $_THIS_IMAGEMANEGER_FCT = 'submit_imagemanager';
	public $_THIS_SUBMIT_FCT = 'submit';
	public $_THIS_EDIT_FCT = 'edit';
	public $_THIS_ADMIN_FCT = 'item_manager';
	public $_THIS_FILE_FCT = 'submit_file';


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_config_class =& webphoto_config::getInstance( $dirname );
		$this->_item_handler =& webphoto_item_handler::getInstance( $dirname );
		$this->_file_handler =& webphoto_file_handler::getInstance( $dirname );
		$this->_cat_handler  =& webphoto_cat_handler::getInstance( $dirname );
		$this->_perm_class   =& webphoto_permission::getInstance( $dirname );

		$this->_cfg_gmap_apikey    = $this->_config_class->get_by_name( 'gmap_apikey' );
		$this->_cfg_width          = $this->_config_class->get_by_name( 'width' );
		$this->_cfg_height         = $this->_config_class->get_by_name( 'height' );
		$this->_cfg_fsize          = $this->_config_class->get_by_name( 'fsize' );
		$this->_cfg_makethumb      = $this->_config_class->get_by_name( 'makethumb' );
		$this->_cfg_file_size      = $this->_config_class->get_by_name( 'file_size' );
		$this->_cfg_perm_item_read = $this->_config_class->get_by_name( 'perm_item_read' );

		$this->_has_deletable = $this->_perm_class->has_deletable();

		$this->_UPLOADS_PATH = $this->_config_class->get_uploads_path();
		$this->_MEDIAS_PATH  = $this->_config_class->get_medias_path();
		$this->_WORK_DIR     = $this->_config_class->get_by_name( 'workdir' );
		$this->_FILE_DIR     = $this->_config_class->get_by_name( 'file_dir' );

		$this->_PHOTOS_PATH = $this->_UPLOADS_PATH . '/photos';
		$this->_THUMBS_PATH = $this->_UPLOADS_PATH . '/thumbs';
		$this->_CATS_PATH   = $this->_UPLOADS_PATH . '/categories';
		$playlists_path     = $this->_UPLOADS_PATH . '/playlists';

		$this->_PHOTOS_DIR    = XOOPS_ROOT_PATH . $this->_PHOTOS_PATH;
		$this->_THUMBS_DIR    = XOOPS_ROOT_PATH . $this->_THUMBS_PATH;
		$this->_CATS_DIR      = XOOPS_ROOT_PATH . $this->_CATS_PATH;
		$this->_MEDIAS_DIR    = XOOPS_ROOT_PATH . $this->_MEDIAS_PATH;
		$this->_PLAYLISTS_DIR = XOOPS_ROOT_PATH . $playlists_path;

		$this->_PHOTOS_URL    = XOOPS_URL . $this->_PHOTOS_PATH;
		$this->_THUMBS_URL    = XOOPS_URL . $this->_THUMBS_PATH;
		$this->_CATS_URL      = XOOPS_URL . $this->_CATS_PATH;
		$this->_MEDIAS_URL    = XOOPS_URL . $this->_MEDIAS_PATH;
		$this->_PLAYLISTS_URL = XOOPS_URL . $playlists_path;

		$this->_TMP_DIR  = $this->_WORK_DIR . '/tmp';
		$this->_MAIL_DIR = $this->_WORK_DIR . '/mail';
		$this->_LOG_DIR  = $this->_WORK_DIR . '/log';

		$this->_ICONS_URL       = $this->_MODULE_URL . '/images/icons';
		$this->_ICON_ROTATE_URL = $this->_MODULE_URL . '/images/uploader';
		$this->_ROOT_EXTS_URL   = $this->_MODULE_URL . '/images/exts';
		$this->_ROOT_EXTS_DIR   = $this->_MODULE_DIR . '/images/exts';

		$this->_is_japanese = $this->_xoops_class->is_japanese( _C_WEBPHOTO_JPAPANESE );
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_form_this( $dirname, $trust_dirname );
		}

		return $instance;
	}


// config

	public function get_config_by_name( $name ) {
		return $this->_config_class->get_by_name( $name );
	}


// photo form

	public function build_input_hidden_max_file_size() {
		return $this->build_input_hidden( 'max_file_size', $this->_cfg_fsize );
	}

	public function build_line_maxpixel( $has_resize ) {
		return $this->build_line_ele(
			$this->get_constant( 'CAP_MAXPIXEL' ),
			$this->_build_ele_maxpixel( $has_resize ) );
	}

	public function _build_ele_maxpixel( $has_resize ) {
		$text = $this->_cfg_width . ' x ' . $this->_cfg_height . "<br>\n";

		if ( $has_resize ) {
			$text .= $this->get_constant( 'DSC_PIXCEL_RESIZE' );
		} else {
			$text .= $this->get_constant( 'DSC_PIXCEL_REJECT' );
		}

		return $text;
	}

	public function build_line_maxsize() {
		return $this->build_line_ele(
			$this->get_constant( 'CAP_MAXSIZE' ),
			$this->_build_ele_maxsize() );
	}

	public function _build_ele_maxsize() {
		$size_desc = '';
		if ( ! ini_get( 'file_uploads' ) ) {
			$size_desc = ' &nbsp; <b>"file_uploads" off</b>';
		}

		$text = $this->format_filesize( $this->_cfg_fsize );
		$text .= $size_desc;

		return $text;
	}

	public function build_line_allowed_exts( $allowed_exts ) {
		return $this->build_line_ele(
			$this->get_constant( 'CAP_ALLOWED_EXTS' ),
			$this->_build_ele_allowed_exts( $allowed_exts ) );
	}

	public function _build_ele_allowed_exts( $allowed_exts ) {
		$text = implode( ' ', $allowed_exts );

		return $text;
	}

	public function build_line_category() {
		return $this->build_line_ele(
			$this->get_constant( 'CATEGORY' ),
			$this->_build_ele_category() );
	}

	public function _build_ele_category() {
		$name  = 'item_cat_id';
		$value = $this->get_row_by_key( $name );

		return $this->_cat_handler->build_selbox_with_perm_post( $value, $name );
	}

	public function build_line_item_title() {
		return $this->build_line_ele(
			$this->get_constant( 'ITEM_TITLE' ),
			$this->_build_ele_title() );
	}

	public function _build_ele_title( $size = 50 ) {
		$value = $this->get_row_by_key( 'item_title' );
		$ele   = $this->build_input_text( 'item_title', $value, $size );
		$ele   .= "<br>\n";
		$ele   .= $this->get_constant( 'DSC_TITLE_BLANK' );

		return $ele;
	}

	public function build_line_photo_file( $cont_row ) {
		return $this->build_line_ele(
			$this->get_constant( 'CAP_PHOTO_SELECT' ),
			$this->_build_ele_photo_file( $cont_row ) );
	}

	public function _build_ele_photo_file( $cont_row ) {
		$url = $this->build_file_url_size( $cont_row );

		$ele = $this->build_form_file( $this->_PHOTO_FIELD_NAME );
		$ele .= "<br>\n";

		if ( $url ) {
			$ele .= $this->build_link_blank( $url );
		}

		return $ele;
	}

	public function build_file_url_size( $file_row ) {
		list( $url, $width, $height ) =
			$this->_file_handler->build_show_file_image( $file_row, true );

		return $url;
	}

	public function build_link_blank( $url ) {
		if ( empty( $url ) ) {
			return '';
		}

		$url_s = $this->sanitize( $url );
		$str   = '<a href="' . $url_s . '" target="_blank">' . $url_s . '</a>' . "<br>\n";

		return $str;
	}

	public function build_photo_delete_button( $name ) {
		if ( $this->_has_deletable ) {
			return $this->build_input_submit( $name, _DELETE );
		}

		return null;
	}

	public function get_item_editor( $flag = true ) {
		$value = $this->get_row_by_key( 'item_editor' );
		if ( $flag && empty( $value ) ) {
			$value = $this->_EDITOR_DEFAULT;
		}

		return $value;
	}

	public function get_item_embed_type( $flag ) {
		$value = $this->get_row_by_key( 'item_embed_type' );
		if ( $flag && empty( $value ) ) {
			$value = $this->_EMBED_TYPE_DEFAULT;
		}

		return $value;
	}


// build image

	public function build_img_pictadd() {
		return '<img src="' . $this->_ICONS_URL . '/pictadd.png" width="18" height="15" border="0" alt="' . _WEBPHOTO_TITLE_ADDPHOTO . '" title="' . _WEBPHOTO_TITLE_ADDPHOTO . '" />' . "\n";
	}

	public function build_img_edit() {
		return '<img src="' . $this->_ICONS_URL . '/edit.png" width="18" height="15" border="0" alt="' . _WEBPHOTO_TITLE_EDIT . '" title="' . _WEBPHOTO_TITLE_EDIT . '" />' . "\n";
	}

	public function build_img_deadlink() {
		return '<img src="' . $this->_ICONS_URL . '/deadlink.png"  width="16" height="16" border="0" alt="' . _AM_WEBPHOTO_DEADLINKMAINPHOTO . '" title="' . _AM_WEBPHOTO_DEADLINKMAINPHOTO . '" />' . "\n";
	}

	public function build_img_pixel( $width, $height ) {
		return '<img src="' . $this->_ICONS_URL . '/pixel_trans.png" width="' . $width . '" height="' . $height . '" border="0" alt="" />';
	}

	public function build_img_catadd() {
		return '<img src="' . $this->_ICONS_URL . '/cat_add.png" width="18" height="15"  border="0" alt="' . _AM_WEBPHOTO_CAT_LINK_MAKESUBCAT . '" title="' . _AM_WEBPHOTO_CAT_LINK_MAKESUBCAT . '" />' . "\n";
	}

	public function build_img_catedit() {
		return '<img src="' . $this->_ICONS_URL . '/cat_edit.png" width="18" height="15"  border="0" alt="' . _AM_WEBPHOTO_CAT_LINK_EDIT . '" title="' . _AM_WEBPHOTO_CAT_LINK_EDIT . '" />' . "\n";
	}

	function exists_photo( $item_row ) {
		$cont_row = $this->get_cached_file_row_by_kind( $item_row, _C_WEBPHOTO_FILE_KIND_CONT );
		if ( is_array( $cont_row ) ) {
			$cont_path = $cont_row['file_path'];
		} else {
			return false;
		}

		if ( $cont_path && is_readable( XOOPS_ROOT_PATH . $cont_path ) ) {
			return true;
		}

		return false;
	}

	function get_cached_file_row_by_kind( $item_row, $kind ) {
		$file_id = $this->_item_handler->build_value_fileid_by_kind( $item_row, $kind );
		if ( $file_id > 0 ) {
			return $this->_file_handler->get_cached_row_by_id( $file_id );
		}

		return null;
	}


// group perms

	function build_ele_group_perms_by_key( $name ) {
		$all_name = $name . '_all';
		$id_name  = $name . '_ids';

		$groups  = $this->get_cached_xoops_db_groups();
		$perms   = $this->get_group_perms_array_by_row_name( $this->get_row(), $name );
		$all_yes = $this->get_all_yes_group_perms_by_key( $name );

		$text = '';
		$text .= $this->build_input_checkbox_js_check_all( $all_name, $id_name );
		$text .= $this->get_constant( 'GROUP_PERM_ALL' );
		$text .= "<br>\n";
		$text .= $this->build_form_checkbox_group_perms( $id_name, $groups, $perms, $all_yes );

		return $text;
	}

	function get_group_perms_array_by_row_name( $row, $name ) {
		if ( isset( $row[ $name ] ) ) {
			return $this->get_group_perms_array( $row[ $name ] );
		} else {
			return array();
		}
	}

	function get_group_perms_array( $val ) {
		return $this->str_to_array( $val, $this->_PERM_SEPARATOR );
	}


// java script

	function build_input_checkbox_js_check_all( $name, $id_name ) {
		$onclick = "webphoto_check_all(this, '" . $id_name . "')";
		$extra   = 'onclick="' . $onclick . '"';

		return $this->build_input_checkbox_yes( $name, 0, $extra );
	}

	function build_js_check_all() {
		$text = <<< END_OF_TEXT
/* edit form */
function webphoto_check_all(cbox, prefix) 
{
	var regexp = new RegExp("^" + prefix );
	var inputs = document.getElementsByTagName("input");
	for (i=0; i<inputs.length; i++) {
		var ele = inputs[i];
        if (ele.type == "checkbox" && ele.name.match(regexp)) {
			ele.checked = cbox.checked;
		}
	}
}
END_OF_TEXT;

		return $text . "\n";
	}

	function build_js_envelop( $content ) {
		$text = <<< END_OF_TEXT
<script type="text/javascript">
//<![CDATA[
$content
//]]>
</script>
END_OF_TEXT;

		return $text . "\n";
	}


// preload class

	function init_preload() {
		$this->preload_init();
		$this->preload_constant();
	}

	function preload_init() {
		$this->_preload_class =& webphoto_d3_preload::getInstance();
		$this->_preload_class->init( $this->_DIRNAME, $this->_TRUST_DIRNAME );
	}

	function preload_constant() {
		$arr = $this->_preload_class->get_preload_const_array();

		if ( ! is_array( $arr ) || ! count( $arr ) ) {
			return true;    // no action
		}

		foreach ( $arr as $k => $v ) {
			$local_name = strtoupper( '_' . $k );

// array type
			if ( strpos( $k, 'array_' ) === 0 ) {
				$temp = $this->str_to_array( $v, '|' );
				if ( is_array( $temp ) && count( $temp ) ) {
					$this->$local_name = $temp;
				}

// string type
			} else {
				$this->$local_name = $v;
			}
		}

	}


// xoops param

	function build_form_user_select( $sel_name, $sel_value, $none = false ) {
		$list = $this->get_xoops_user_list();

		$opt = '';

		if ( $none ) {
			$opt .= '<option value="0">';
			$opt .= _AM_WEBPHOTO_OPT_NOCHANGE;
			$opt .= "</option>\n";
		}

		foreach ( $list as $uid => $uname_s ) {
			$selected = $this->build_form_selected( $uid, $sel_value );
			$opt      .= '<option value="' . $uid . '" ' . $selected . ' ">';
			$opt      .= $uname_s;
			$opt      .= "</option>\n";
		}

		$text = '<select name="' . $sel_name . '">';
		$text .= $opt;
		$text .= "</select>\n";

		return $text;

	}

}
