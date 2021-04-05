<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @deprecated UPDATE PLUGIN / API / JSON
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

// class webphoto_ext_mid
class webphoto_ext_mid extends webphoto_ext_base {
	public $_timidity_class;
	public $_lame_class;
	public $_ffmpeg_class;

	public function __construct( $dirname, $trust_dirname ) {
		parent::__construct( $dirname, $trust_dirname );

		$this->_timidity_class =& webphoto_timidity::getInstance( $dirname, $trust_dirname );
		$this->_lame_class     =& webphoto_lame::getInstance( $dirname, $trust_dirname );
		$this->_ffmpeg_class   =& webphoto_ffmpeg::getInstance( $dirname, $trust_dirname );

		$this->set_debug_by_name( 'MID' );
	}

// check ext
	public function is_ext( $ext ) {
		return $this->is_audio_mid_ext( $ext );
	}

	public function is_audio_mid_ext( $ext ) {
		return $this->match_ext_kind( $ext, _C_WEBPHOTO_MIME_KIND_AUDIO_MID );
	}

// create wav
	public function create_wav( $param ) {
		$item_id  = $param['item_id'];
		$src_file = $param['src_file'];
		$wav_file = $param['wav_file'];

		return $this->_timidity_class->create_wav( $src_file, $wav_file );
	}

// duration
	public function get_video_info( $param ) {
		$src_file = $param['src_file'];

		return $this->_ffmpeg_class->get_video_info( $src_file );
	}
}
