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


class webphoto_show_photo extends webphoto_base_this {

	public $_tag_build_class;
	public $_highlight_class;
	public $_image_class;
	public $_multibyte_class;

// config
	public $_cfg_newdays;
	public $_cfg_popular;
	public $_cfg_nameoruname;
	public $_cfg_thumb_width;
	public $_cfg_middle_width;
	public $_cfg_item_summary;
	public $_cfg_cat_summary;
	public $_cfg_newphotos;
	public $_cfg_gmap_photos;
	public $_cfg_tags;
	public $_cfg_viewcattype;
	public $_cfg_sort;
	public $_cfg_use_popbox;
	public $_cfg_perm_cat_read;
	public $_cfg_perm_item_read;
	public $_cfg_gmap_apikey;
	public $_cfg_cat_main_width;
	public $_cfg_cat_sub_width;
	public $_cfg_timeline_dirname;

// ini
	public $_ini_misc_array;
	public $_ini_window_mergin;
	public $_ini_content_length;
	public $_ini_exif_length;
	public $_ini_rating_decimals;
	public $_ini_filesize_precision;

	public $_item_text_type_array;
	public $_time_newdays;
	public $_usereal;

	public $_flag_highlight = false;
	public $_keyword_array = null;

	public $_URL_DEFAULT_IMAGE;
	public $_URL_PIXEL_IMAGE;
	public $_URL_CATEGORY_IMAGE;


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_image_class =& webphoto_show_image::getInstance( $dirname, $trust_dirname );
		$this->_tag_build_class =& webphoto_tag_build::getInstance( $dirname, $trust_dirname );

		$this->_multibyte_class =& webphoto_multibyte::getInstance();

		$this->_tag_build_class->set_is_japanese( $this->_is_japanese );

		$this->_highlight_class =& webphoto_lib_highlight::getInstance();
		$this->_highlight_class->set_replace_callback( 'webphoto_highlighter_by_class' );
		$this->_highlight_class->set_class( 'webphoto_highlight' );

		$this->_cfg_newdays      = $this->get_config_by_name( 'newdays' );
		$this->_cfg_popular      = $this->get_config_by_name( 'popular' );
		$this->_cfg_thumb_width  = $this->get_config_by_name( 'thumb_width' );
		$this->_cfg_middle_width = $this->get_config_by_name( 'middle_width' );
		$this->_cfg_item_summary = $this->get_config_by_name( 'item_summary' );

// show_main.php
		$this->_cfg_newphotos        = $this->get_config_by_name( 'newphotos' );
		$this->_cfg_gmap_photos      = $this->get_config_by_name( 'gmap_photos' );
		$this->_cfg_tags             = $this->get_config_by_name( 'tags' );
		$this->_cfg_viewcattype      = $this->get_config_by_name( 'viewcattype' );
		$this->_cfg_sort             = $this->get_config_by_name( 'sort' );
		$this->_cfg_use_popbox       = $this->get_config_by_name( 'use_popbox' );
		$this->_cfg_perm_cat_read    = $this->get_config_by_name( 'perm_cat_read' );
		$this->_cfg_perm_item_read   = $this->get_config_by_name( 'perm_item_read' );
		$this->_cfg_gmap_apikey      = $this->get_config_by_name( 'gmap_apikey' );
		$this->_cfg_cat_main_width   = $this->get_config_by_name( 'cat_main_width' );
		$this->_cfg_cat_sub_width    = $this->get_config_by_name( 'cat_sub_width' );
		$this->_cfg_timeline_dirname = $this->get_config_by_name( 'timeline_dirname' );

// category.php
		$this->_cfg_cat_summary      = $this->get_config_by_name( 'cat_summary' );

// ini
		$this->_ini_misc_array         = $this->explode_ini( 'view_photo_misc_list' );
		$this->_ini_window_mergin      = $this->get_ini( 'view_photo_window_margin' );
		$this->_ini_content_length     = $this->get_ini( 'view_photo_content_length' );
		$this->_ini_exif_length        = $this->get_ini( 'view_photo_exif_length' );
		$this->_ini_rating_decimals    = $this->get_ini( 'view_photo_rating_decimals' );
		$this->_ini_filesize_precision = $this->get_ini( 'view_photo_filesize_precision' );

		$this->_item_text_type_array = $this->_item_handler->get_text_type_array();

		$this->_time_newdays = time() - 86400 * $this->_cfg_newdays;

		$this->_URL_DEFAULT_IMAGE  = $this->_MODULE_URL . '/images/exts/default.png';
		$this->_URL_PIXEL_IMAGE    = $this->_MODULE_URL . '/images/icons/pixel_trans.png';
		$this->_URL_CATEGORY_IMAGE = $this->_MODULE_URL . '/images/icons/category.png';

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_show_photo( $dirname, $trust_dirname );
		}

		return $instance;
	}


// photo show

// Get photo's array to assign into template (light version)
	public function build_photo_show_basic( $row, $tag_name_array = null ) {
//	if ( !is_array($row) ) {
//		debug_print_backtrace();
//	}

		extract( $row );

		$show_arr = array();
		foreach ( $row as $k => $v ) {
			$name              = str_replace( 'item_', '', $k );
			$show_arr[ $name ] = $v;
			if ( in_array( $k, $this->_item_text_type_array ) ) {
				$show_arr[ $name . '_s' ] = $this->sanitize( $v );
			}
		}

		list( $desc_disp, $summary ) = $this->build_show_desc_summary(
			$row, $this->_flag_highlight, $this->_keyword_array );

		$cont_disp = $this->build_show_content(
			$row, $this->_flag_highlight, $this->_keyword_array );

		$exif_disp = $this->build_show_exif( $row );

		$datetime_disp = $this->mysql_datetime_to_str( $item_datetime );

		$show_arr['photo_id']            = $item_id;
		$show_arr['uname_s']             = $this->build_show_uname( $item_uid );
		$show_arr['time_update_m']       = $this->format_timestamp( $item_time_update, 'm' );
		$show_arr['datetime']            = $item_datetime;
		$show_arr['datetime_disp']       = $datetime_disp;
		$show_arr['datetime_urlencode']  = $this->rawurlencode_uri_encode_str( $datetime_disp );
		$show_arr['place_urlencode']     = $this->rawurlencode_uri_encode_str( $item_place );
		$show_arr['equipment_urlencode'] = $this->rawurlencode_uri_encode_str( $item_equipment );
		$show_arr['description_disp']    = $desc_disp;
		$show_arr['content_disp']        = $cont_disp;
		$show_arr['summary']             = $summary;
		$show_arr['exif_disp']           = $exif_disp;
		$show_arr['tags']                = $this->build_show_tags_from_tag_name_array( $tag_name_array );
		$show_arr['is_owner']            = $this->is_photo_owner( $item_uid );
		$show_arr['is_video']            = $this->is_video_kind( $item_kind );
		$show_arr['perm_download']       = $this->perm_download( $row );
		$show_arr['can_download']        = $this->can_download( $row );
		$show_arr['duration_disp']       = $this->format_time( $item_duration );
		$show_arr['photo_uri']           = $this->build_uri_photo( $item_id, false );

		$show_misc = false;
		foreach ( $this->_ini_misc_array as $key ) {
			if ( $show_arr[ $key ] ) {
				$show_misc = true;
			}
		}

		$arr2 = array();
		for ( $i = 1; $i <= _C_WEBPHOTO_MAX_ITEM_TEXT; $i ++ ) {
			$name_i      = 'text_' . $i;
			$item_name_i = 'item_' . $name_i;
			$text_i      = $row[ $item_name_i ];
			$text_i_s    = $this->sanitize( $text_i );

			if ( $text_i ) {
				$show_misc = true;
			}

			$show_arr[ $name_i ]        = $text_i;
			$show_arr[ $name_i . '_s' ] = $text_i_s;

			$arr2[ $i ] = array(
				'lang'   => $this->get_constant( $item_name_i ),
				'text'   => $text_i,
				'text_s' => $text_i_s,
			);
		}

		if ( is_array( $arr2 ) && count( $arr2 ) ) {
			$show_arr['texts'] = $arr2;
		}

		$show_arr['show_misc'] = $show_misc;

		for ( $i = 1; $i <= _C_WEBPHOTO_MAX_ITEM_FILE_ID; $i ++ ) {
			$name_i              = 'file_row_' . $i;
			$show_arr[ $name_i ] = $this->get_cached_file_extend_row_by_kind( $row, $i );
		}

		list( $cont_size, $cont_duration ) =
			$this->get_show_file_size_duration( $show_arr, _C_WEBPHOTO_FILE_KIND_CONT );

		$show_arr['cont_size']          = $cont_size;
		$show_arr['cont_duration']      = $cont_duration;
		$show_arr['cont_size_disp']     = $this->build_show_filesize( $cont_size );
		$show_arr['cont_duration_disp'] = $this->format_time( $cont_duration );

		$pdf_url               = $this->get_show_file_url( $show_arr, _C_WEBPHOTO_FILE_KIND_PDF );
		$show_arr['pdf_url_s'] = $this->sanitize( $pdf_url );

		return $show_arr;
	}

// Get photo's array to assign into template (light version)
	public function build_photo_show_light( $row, $tag_name_array = null ) {
		$arr1 = $this->build_photo_show_basic( $row, $tag_name_array );
		$arr2 = $this->build_show_imgsrc( $row, $arr1 );

		return array_merge( $arr1, $arr2 );
	}

// Get photo's array to assign into template (heavy version)
	public function build_photo_show( $row ) {
		$tag_name_array = $this->get_tag_name_array_by_photoid( $row['item_id'] );
		$arr1           = $this->build_photo_show_light( $row, $tag_name_array );

		extract( $row );

		list( $is_newphoto, $is_updatedphoto )
			= $this->build_show_is_new_updated( $item_time_update, $item_status );

		$cat_title = null;
		$cat_text1 = null;
		$cat_text2 = null;
		$cat_text3 = null;
		$cat_text4 = null;
		$cat_text5 = null;

		$cat_row = $this->_cat_handler->get_cached_row_by_id( $item_cat_id );
		if ( is_array( $cat_row ) ) {
			$cat_title = $cat_row['cat_title'];
			$cat_text1 = $cat_row['cat_text1'];
			$cat_text2 = $cat_row['cat_text2'];
			$cat_text3 = $cat_row['cat_text3'];
			$cat_text4 = $cat_row['cat_text4'];
			$cat_text5 = $cat_row['cat_text5'];
		}

		$arr2 = array(
			'cat_title'   => $cat_title,
			'cat_text1'   => $cat_text1,
			'cat_text2'   => $cat_text2,
			'cat_text3'   => $cat_text3,
			'cat_text4'   => $cat_text4,
			'cat_text5'   => $cat_text5,
			'cat_title_s' => $this->sanitize( $cat_title ),
			'cat_text1_s' => $this->sanitize( $cat_text1 ),
			'cat_text2_s' => $this->sanitize( $cat_text2 ),
			'cat_text3_s' => $this->sanitize( $cat_text3 ),
			'cat_text4_s' => $this->sanitize( $cat_text4 ),
			'cat_text5_s' => $this->sanitize( $cat_text5 ),

			'info_votes' => $this->build_show_info_vote( $item_rating, $item_votes ),
			'rank'       => $this->build_show_rank( $item_rating ),
			'can_edit'   => $this->has_editable_by_uid( $item_uid ),
			'is_public'  => $this->is_public( $row ),

			'is_newphoto'     => $is_newphoto,
			'is_updatedphoto' => $is_updatedphoto,
			'is_popularphoto' => $this->build_show_is_popularphoto( $item_hits ),
			'taf_target_uri'  => $this->build_show_taf_target_uri( $item_id ),
			'taf_mailto'      => $this->build_show_taf_mailto( $item_id ),
			'info_morephotos' => $this->build_show_info_morephotos( $item_uid ),

			'window_x' => $arr1['img_photo_width'] + $this->_ini_window_mergin,
			'window_y' => $arr1['img_photo_height'] + $this->_ini_window_mergin,

		);

		return array_merge( $arr1, $arr2 );
	}

	public function build_show_filesize( $size ) {
		if ( $size > 0 ) {
			return $this->_utility_class->format_filesize(
				$size, $this->_ini_filesize_precision );
		}

		return null;
	}

	public function build_show_desc_summary( $row, $flag_highlight = false, $keyword_array = null ) {
		$desc = $this->_item_handler->build_show_description_disp( $row );

// search 
		if ( is_array( $keyword_array ) ) {
			$summary = $this->_multibyte_class->build_plane_text( $desc );
			$summary = $this->_multibyte_class->build_summary_with_search(
				$summary, $keyword_array, $this->_cfg_item_summary );

// more than limit
		} elseif ( $this->_multibyte_class->str_len( $desc ) > $this->_cfg_item_summary ) {
			$summary = $this->_multibyte_class->build_summary(
				$desc, $this->_cfg_item_summary );

// full text
		} else {
			$summary = $desc;
		}

		if ( $flag_highlight ) {
			$desc    = $this->_highlight_class->build_highlight_keyword_array( $desc, $keyword_array );
			$summary = $this->_highlight_class->build_highlight_keyword_array( $summary, $keyword_array );
		}

		return array( $desc, $summary );
	}

	public function build_show_content( $row, $flag_highlight = false, $keyword_array = null ) {
		$str = $this->_multibyte_class->build_summary_with_search(
			$row['item_content'], $keyword_array, $this->_ini_content_length );

		if ( $flag_highlight ) {
			$str = $this->_highlight_class->build_highlight_keyword_array( $str, $keyword_array );
		}

		return $str;
	}

	public function build_show_exif( $row ) {
		$str = $row['item_exif'];
		if ( strlen( $str ) > $this->_ini_exif_length ) {
			$str = $this->_multibyte_class->shorten( $row['item_exif'], $this->_ini_exif_length, '' );
			$str .= "\n ... ";
		}

		return nl2br( $str );
	}

	public function build_show_rank( $rating ) {
		return floor( $rating - 0.001 );
	}

	public function build_show_info_vote( $rating, $votes ) {
		if ( $rating > 0 ) {
			if ( $votes == 1 ) {
				$votestring = $this->get_constant( 'ONEVOTE' );
			} else {
				$votestring = sprintf( $this->get_constant( 'S_NUMVOTES' ), $votes );
			}
			$info_votes = $this->build_show_rating( $rating );
			$info_votes .= ' (' . $votestring . ')';
		} else {
			$info_votes = $this->build_show_rating( 0 );
			$info_votes .= ' (' . sprintf( $this->get_constant( 'S_NUMVOTES' ), 0 ) . ')';
		}

		return $info_votes;
	}

	public function build_show_rating( $rating ) {
		return number_format( $rating, $this->_ini_rating_decimals );
	}

	public function build_show_is_new_updated( $time_update, $status ) {
		$is_newphoto     = false;
		$is_updatedphoto = false;

		if ( $this->_cfg_newdays && ( $time_update > $this->_time_newdays ) ) {
			if ( $status == 1 ) {
				$is_newphoto = true;
			}
			if ( $status == 2 ) {
				$is_updatedphoto = true;
			}
		}

		return array( $is_newphoto, $is_updatedphoto );
	}

	public function build_show_is_popularphoto( $hits ) {
		return $this->_cfg_popular && ( $hits >= $this->_cfg_popular );
	}

	public function build_show_taf_target_uri( $photo_id ) {
		$str = $this->_INDEX_PHP . '/photo/' . $photo_id . '/subject=' . $this->get_constant( 'SUBJECT4TAF' );

		return urlencode( $str );
	}

	public function build_show_taf_mailto( $photo_id ) {
		$subject = $this->get_constant( 'SUBJECT4TAF' );
		$body    = $this->get_constant( 'SUBJECT4TAF' );
		$body    .= $this->_INDEX_PHP . '/photo/' . $photo_id . '/';

// --- effective only in Japanese environment ---
// convert EUC-JP to SJIS
//	$subject = $this->_lang->convert_telafriend_subject($subject);
//	$body    = $this->_lang->convert_telafriend_body($body);

		$subject = rawurlencode( $subject );
		$body    = rawurlencode( $body );

		$str = 'subject=' . $subject . '&amp;body=' . $body;

		return $str;
	}

	public function format_time( $time ) {
		return $this->_utility_class->format_time( $time,
			$this->get_constant( 'HOUR' ), $this->get_constant( 'MINUTE' ), $this->get_constant( 'SECOND' ) );
	}

	public function perm_download( $row ) {
		return $this->_item_handler->check_perm_down_by_row(
			$row, $this->_xoops_groups );
	}

	public function is_public( $row ) {
		return $this->is_public_cats( $row ) && $this->is_public_item( $row );
	}

	public function is_public_cats( $row ) {
		if ( $this->_cfg_perm_cat_read == 0 ) {
			return true;
		}

		return $this->_cat_handler->is_cached_public_read_in_all_parents_by_id(
			$row['item_cat_id'] );
	}

	public function is_public_item( $row ) {
		if ( $this->_cfg_perm_item_read == 0 ) {
			return true;
		}

		return $this->_item_handler->is_public_read_by_row( $row );
	}

	public function can_download( $row ) {
		$kind = $row['item_kind'];

		switch ( $kind ) {
			case _C_WEBPHOTO_ITEM_KIND_GENERAL :
			case _C_WEBPHOTO_ITEM_KIND_IMAGE :
			case _C_WEBPHOTO_ITEM_KIND_VIDEO :
			case _C_WEBPHOTO_ITEM_KIND_AUDIO :
				return true;
				break;

			case _C_WEBPHOTO_ITEM_KIND_UNDEFINED :
			case _C_WEBPHOTO_ITEM_KIND_NONE :
			case _C_WEBPHOTO_ITEM_KIND_EMBED :
			case _C_WEBPHOTO_ITEM_KIND_EXTERNAL_GENERAL :
			case _C_WEBPHOTO_ITEM_KIND_EXTERNAL_IMAGE :
			case _C_WEBPHOTO_ITEM_KIND_PLAYLIST_FEED :
			case _C_WEBPHOTO_ITEM_KIND_PLAYLIST_DIR :
			default :
				break;
		}

		return false;
	}


// image

	public function build_show_imgsrc( $item_row, $show_arr ) {
		$cont_row   = $this->get_show_file_row(
			$show_arr, _C_WEBPHOTO_FILE_KIND_CONT );
		$thumb_row  = $this->get_show_file_row(
			$show_arr, _C_WEBPHOTO_FILE_KIND_THUMB );
		$large_row  = $this->get_show_file_row(
			$show_arr, _C_WEBPHOTO_FILE_KIND_LARGE );
		$middle_row = $this->get_show_file_row(
			$show_arr, _C_WEBPHOTO_FILE_KIND_MIDDLE );
		$small_row  = $this->get_show_file_row(
			$show_arr, _C_WEBPHOTO_FILE_KIND_SMALL );

		$param = array(
			'item_row'       => $item_row,
			'cont_row'       => $cont_row,
			'thumb_row'      => $thumb_row,
			'large_row'      => $large_row,
			'middle_row'     => $middle_row,
			'small_row'      => $small_row,
			'photo_default'  => true,
			'thumb_default'  => true,
			'large_default'  => true,
			'middle_default' => true,
			'small_default'  => true,
		);

		$param_image = $this->_image_class->build_image_by_param( $param );
		if ( ! is_array( $param_image ) ) {
			return array();
		}

		$arr                     = $param_image;
		$arr['cont_url_s']       = $this->sanitize( $param_image['cont_url'] );
		$arr['thumb_url_s']      = $this->sanitize( $param_image['thumb_url'] );
		$arr['large_url_s']      = $this->sanitize( $param_image['large_url'] );
		$arr['middle_url_s']     = $this->sanitize( $param_image['middle_url'] );
		$arr['small_url_s']      = $this->sanitize( $param_image['small_url'] );
		$arr['media_url_s']      = $this->sanitize( $param_image['media_url'] );
		$arr['img_photo_src_s']  = $this->sanitize( $param_image['img_photo_src'] );
		$arr['img_large_src_s']  = $this->sanitize( $param_image['img_large_src'] );
		$arr['img_middle_src_s'] = $this->sanitize( $param_image['img_middle_src'] );
		$arr['img_thumb_src_s']  = $this->sanitize( $param_image['img_thumb_src'] );

		return $arr;
	}


// file utility

	public function get_show_file_row( $show_arr, $kind ) {
		return $show_arr[ 'file_row_' . $kind ];
	}

	public function get_show_file_url( $show_arr, $kind ) {
		$url = null;

		$file_row = $this->get_show_file_row( $show_arr, $kind );
		if ( is_array( $file_row ) ) {
			$url = $file_row['file_url'];
		}

		return $url;
	}

	public function get_show_file_size_duration( $show_arr, $kind ) {
		$size     = 0;
		$duration = 0;

		$file_row = $this->get_show_file_row( $show_arr, $kind );
		if ( is_array( $file_row ) ) {
			$size     = $file_row['file_size'];
			$duration = $file_row['file_duration'];
		}

		return array( $size, $duration );
	}

	public function has_file_url( $url ) {
		if ( $url ) {
			return true;
		}

		return false;
	}


// tag class

	public function build_show_tags_from_tag_name_array( $tag_name_array ) {
		return $this->_tag_build_class->build_show_tags_from_tag_name_array( $tag_name_array );
	}

	public function get_tag_name_array_by_photoid( $photo_id ) {
		return $this->_tag_build_class->get_tag_name_array_by_photoid( $photo_id );
	}


// set

	public function set_flag_highlight( $val ) {
		$this->_flag_highlight = (bool) $val;
	}

	public function set_keyword_array( $arr ) {
		if ( is_array( $arr ) ) {
			$this->_keyword_array = $arr;
		}
	}

}
