<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_edit_import extends webphoto_edit_base {
	public $_vote_handler;
	public $_myalbum_handler;
	public $_xoops_comments_handler;
	public $_factory_create_class;

// post
	public $_post_op;
	public $_post_offset;
	public $_next;

	public $_cfg_makethumb;
	public $_cfg_use_ffmpeg;
	public $_cfg_cat_width;
	public $_cfg_csub_width;

	public $_myalbum_dirname;
	public $_myalbum_mid;
	public $_myalbum_photos_dir;
	public $_myalbum_thumbs_dir;

	public $_video_param = null;

	public $_FLAG_RESIZE = false;

	public $_LIMIT = 100;

	public $_CONST_DEBUG_SQL;

	public $_EXT_GIF = 'gif';


	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_cat_handler->set_debug_error( 1 );
		$this->_item_create_class->set_debug_error( 1 );

		$this->_vote_handler =& webphoto_vote_handler::getInstance(
			$dirname, $trust_dirname );
		$this->_vote_handler->set_debug_error( 1 );

		$this->_xoops_comments_handler =& webphoto_xoops_comments_handler::getInstance();
		$this->_xoops_comments_handler->set_debug_error( 1 );

		$this->_myalbum_handler =& webphoto_myalbum_handler::getInstance();
		$this->_myalbum_handler->set_debug_error( 1 );

		$this->_factory_create_class =& webphoto_edit_factory_create::getInstance(
			$dirname, $trust_dirname );
		$this->_factory_create_class->set_msg_level( _C_WEBPHOTO_MSG_LEVEL_ADMIN );
		$this->_factory_create_class->set_flag_print_first_msg( true );

		$this->_ICON_EXT_DIR = $this->_MODULE_DIR . '/images/exts';
		$this->_ICON_EXT_URL = $this->_MODULE_URL . '/images/exts';

		$this->_cfg_makethumb  = $this->get_config_by_name( 'makethumb' );
		$this->_cfg_use_ffmpeg = $this->get_config_by_name( 'use_ffmpeg' );
		$this->_cfg_cat_width  = $this->_config_class->get_by_name( 'cat_width' );
		$this->_cfg_csub_width = $this->_config_class->get_by_name( 'csub_width' );

		$val = $this->get_ini( _C_WEBPHOTO_NAME_DEBUG_SQL );
		if ( $val ) {
			$this->_cat_handler->set_debug_sql( $val );
			$this->_item_create_class->set_debug_sql( $val );
			$this->_vote_handler->set_debug_sql( $val );
			$this->_xoops_comments_handler->set_debug_sql( $val );
			$this->_myalbum_handler->set_debug_sql( $val );
		}

	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_edit_import( $dirname, $trust_dirname );
		}

		return $instance;
	}


	public function init_myalbum( $dirname ) {
		$mid = $this->_myalbum_handler->init( $dirname );
		if ( ! $mid ) {
			return false;
		}

		$this->_myalbum_dirname = $dirname;
		$this->_myalbum_mid     = $mid;
		list ( $this->_myalbum_photos_dir, $this->_myalbum_thumbs_dir )
			= $this->_myalbum_handler->get_photos_thumbs_dir();

		return $mid;
	}


// POST

	public function get_post_op() {
		$this->_post_op = $this->_post_class->get_post_get( 'op' );

		return $this->_post_op;
	}

	public function get_post_offset() {
		$this->_post_offset = $this->_post_class->get_post_get( 'offset' );
		$this->_next        = $this->_post_offset + $this->_LIMIT;

		return $this->_post_offset;
	}


// category

	public function insert_category_from_myalbum( $cid, $myalbum_row ) {
		$param = $this->build_category_img_path( $myalbum_row['imgurl'] );

		$row                    = $this->_cat_handler->create( true );
		$row['cat_id']          = $cid;
		$row['cat_title']       = $myalbum_row['title'];
		$row['cat_pid']         = $myalbum_row['pid'];
		$row['cat_weight']      = $myalbum_row['weight'] + 1;
		$row['cat_depth']       = $myalbum_row['depth'];
		$row['cat_description'] = $myalbum_row['description'];
		$row['cat_allowed_ext'] = $myalbum_row['allowed_ext'];

		$row['cat_img_path']    = $param['img_path'];
		$row['cat_orig_width']  = $param['orig_width'];
		$row['cat_orig_height'] = $param['orig_height'];
		$row['cat_main_width']  = $param['main_width'];
		$row['cat_main_height'] = $param['main_height'];
		$row['cat_sub_width']   = $param['sub_width'];
		$row['cat_sub_height']  = $param['sub_height'];

		return $this->_cat_handler->insert( $row );
	}

	public function build_category_img_path( $imgurl ) {
		$img_path    = '';
		$orig_width  = 0;
		$orig_height = 0;
		$main_width  = 0;
		$main_height = 0;
		$sub_width   = 0;
		$sub_height  = 0;

		if ( $imgurl ) {
			$tmp_path  = str_replace( XOOPS_URL, '', $imgurl );
			$full_path = $this->build_file_full_path( $tmp_path );

// in this site
			if ( file_exists( $full_path ) ) {
				$img_path = $tmp_path;

				$image_size = GetImageSize( $full_path );
				if ( is_array( $image_size ) ) {
					$orig_width  = $image_size[0];
					$orig_height = $image_size[1];

					list( $main_width, $main_height )
						= $this->adjust_image_size(
						$orig_width, $orig_height, $this->_cfg_cat_width, $this->_cfg_cat_width );

					list( $sub_width, $sub_height )
						= $this->adjust_image_size(
						$orig_width, $orig_height, $this->_cfg_csub_width, $this->_cfg_csub_width );
				}

// in other site
			} else {
				$img_path = $imgurl;
			}
		}

		return array(
			'img_path'    => $img_path,
			'orig_width'  => $orig_width,
			'orig_height' => $orig_height,
			'main_width'  => $main_width,
			'main_height' => $main_height,
			'sub_width'   => $sub_width,
			'sub_height'  => $sub_height,
		);
	}


// photo

	public function add_photo_from_myalbum( $myalbum_id, $new_cid, $myalbum_row ) {
// Fatal error: Call to undefined method create_image_ext()

		$item_row = $this->create_photo_row_from_myalbum( $myalbum_id, $new_cid, $myalbum_row );
		$param    = $this->build_param_from_myalbum( $myalbum_row );

		$src_file = $param['src_file'];
		if ( ! $this->is_readable_file( $src_file ) ) {
			echo $this->highlight( ' fail to read file : ' . $src_file );
			echo "<br>\n";

			return false;
		}

		$this->_factory_create_class->create_item_from_param( $item_row, $param );
		echo $this->_factory_create_class->get_main_msg();
		echo "<br>\n";

		return false;
	}

	public function build_param_from_myalbum( $myalbum_row ) {
		[ $src_id, $src_ext, $src_file ]
			= $this->build_myalbum_filename( $myalbum_row );

		$param = array(
			'flag_video_single' => true,
			'src_file'          => $src_file,
		);

		return $param;
	}

	public function create_photo_row_from_myalbum( $photo_id, $cat_id, $myalbum_row ) {
		[ $src_id, $src_ext, $src_file ]
			= $this->build_myalbum_filename( $myalbum_row );

		$row                     = $this->_item_create_class->create();
		$row['item_id']          = $photo_id;
		$row['item_cat_id']      = $cat_id;
		$row['item_title']       = $myalbum_row['title'];
		$row['item_time_create'] = $myalbum_row['date'];
		$row['item_time_update'] = $myalbum_row['date'];
		$row['item_uid']         = $myalbum_row['submitter'];
//	$row['item_status']        = $myalbum_row['status'];
		$row['item_hits']        = $myalbum_row['hits'];
		$row['item_rating']      = $myalbum_row['rating'];
		$row['item_votes']       = $myalbum_row['votes'];
		$row['item_comments']    = $myalbum_row['comments'];
		$row['item_description'] = $this->get_myambum_description( $src_id );

		$row = $this->_factory_create_class->build_item_row_from_file( $row, $src_file );

		return $row;
	}

	public function get_myambum_description( $id ) {
		$row = $this->_myalbum_handler->get_text_row_by_id( $id );

		return $row['description'] ?? null;
	}

	public function build_myalbum_filename( $myalbum_row ) {
		$src_id   = $myalbum_row['lid'];
		$src_ext  = $myalbum_row['ext'];
		$src_name = $src_id . '.' . $src_ext;
		$src_file = $this->_myalbum_photos_dir . '/' . $src_name;

		return array( $src_id, $src_ext, $src_file );
	}

	public function is_readable_file( $file ) {
		return is_readable( $file ) && filesize( $file );
	}


// vote

	public function insert_vote_from_myalbum( $vote_id, $photo_id, $myalbum_row ) {
		if ( ! is_array( $myalbum_row ) || ! count( $myalbum_row ) ) {
			return true;    //no action
		}

		$ratingtimestamp = $myalbum_row['ratingtimestamp'];

		$row                     = $this->_vote_handler->create();
		$row['vote_id']          = $vote_id;
		$row['vote_photo_id']    = $photo_id;
		$row['vote_time_create'] = $ratingtimestamp;
		$row['vote_time_update'] = $ratingtimestamp;
		$row['vote_uid']         = $myalbum_row['ratinguser'];
		$row['vote_rating']      = $myalbum_row['rating'];
		$row['vote_hostname']    = $myalbum_row['ratinghostname'];

		$this->_vote_handler->insert( $row );
	}


// comment

	public function add_comments_from_src( $src_mid, $src_id, $dst_id ) {
		$rows = $this->_xoops_comments_handler->get_rows_by_modid_itemid( $src_mid, $src_id );
		$this->insert_comments_from_src( $dst_id, $rows );
	}

	public function insert_comments_from_src( $itemid, $src_rows ) {
		if ( ! is_array( $src_rows ) || ! count( $src_rows ) ) {
			return true;    //no action
		}

		$com_id_arr = array();

		foreach ( $src_rows as $src_row ) {
			$com_id      = $src_row['com_id'];
			$com_pid     = $src_row['com_pid'];
			$com_title_s = $this->sanitize( $src_row['com_title'] );

			echo "comment: $com_id $com_title_s <br>\n";

			$row              = $src_row;
			$row['com_modid'] = $this->_MODULE_ID;

			if ( $itemid ) {
				$row['com_itemid'] = $itemid;
			}

			$newid = $this->_xoops_comments_handler->insert( $row );

			$com_id_new     = $newid;
			$com_rootid_new = $newid;
			$com_pid_new    = 0;

			if ( $com_pid ) {
				if ( isset( $com_id_arr[ $com_pid ] ) ) {
					$com_rootid_new = $com_id_arr[ $com_pid ]['com_rootid_new'];
					$com_pid_new    = $com_id_arr[ $com_pid ]['com_id_new'];
				} else {
					echo $this->highlight( "pid convert error: $com_id" ) . "<br>\n";
				}
			}

			$this->_xoops_comments_handler->update_rootid_pid(
				$com_id_new, $com_rootid_new, $com_pid_new );

			$com_id_arr[ $com_id ]['com_id_new']     = $com_id_new;
			$com_id_arr[ $com_id ]['com_rootid_new'] = $com_rootid_new;
		}
	}


// form

	public function print_import_count( $count ) {
		echo "<br>\n";
		echo "<b>";
		echo sprintf( _AM_WEBPHOTO_FMT_IMPORTSUCCESS, $count );
		echo "</b><br>\n";
	}

	public function print_finish() {
		echo "<br><hr />\n";
		echo "<h4>FINISHED</h4>\n";
		echo '<a href="index.php">GOTO Admin Menu</a>' . "<br>\n";
	}

}
