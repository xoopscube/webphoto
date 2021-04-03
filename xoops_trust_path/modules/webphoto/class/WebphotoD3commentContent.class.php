<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * WebphotoD3commentContent
 * a class for d3forum comment integration
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class WebphotoD3commentContent extends D3commentAbstract {

	public function fetchSummary( $link_id ) {
		$mydirname = $this->mydirname;
		if ( preg_match( '/[^0-9a-zA-Z_-]/', $mydirname ) ) {
			die( 'Invalid mydirname' );
		}

		$db =& Database::getInstance();
		( method_exists( 'MyTextSanitizer', 'sGetInstance' ) and $myts =& MyTextSanitizer::sGetInstance() ) || $myts =& MyTextsanitizer::getInstance();

		$module_handler =& xoops_gethandler( 'module' );
		$module         =& $module_handler->getByDirname( $mydirname );

		// query
		$sql      = 'SELECT * FROM ' . $db->prefix( $mydirname . '_item' );
		$sql      .= ' WHERE item_id=' . (int) $link_id;
		$sql      .= ' AND item_status > 0 ';
		$item_row = $db->fetchArray( $db->query( $sql ) );
		if ( empty( $item_row ) ) {
			return '';
		}

		// dare to convert it irregularly
		$summary = str_replace( '&amp;', '&', htmlspecialchars( xoops_substr( strip_tags( $item_row['item_description'] ), 0, 191 ), ENT_QUOTES ) );

		$ret = array(
			'dirname'     => $mydirname,
			'module_name' => $module->getVar( 'name' ),
			'subject'     => $myts->makeTboxData4Show( $item_row['item_title'] ),
			'uri'         => XOOPS_URL . '/modules/' . $mydirname . '/index.php?fct=photo&photo_id=' . (int) $link_id,
			'summary'     => $summary,
		);

		return $ret;
	}

	public function validate_id( $link_id ) {
		$db =& Database::getInstance();

		// query
		$sql = 'SELECT COUNT(*) FROM ' . $db->prefix( $this->mydirname . '_item' );
		$sql .= ' WHERE item_id=' . (int) $link_id;
		$sql .= ' AND item_status > 0 ';

		list( $count ) = $db->fetchRow( $db->query( $sql ) );
		if ( $count <= 0 ) {
			return false;
		}

		return $link_id;
	}

	public function onUpdate( $mode, $link_id, $forum_id, $topic_id, $post_id = 0 ) {
		$db =& Database::getInstance();

		$sql1 = 'SELECT COUNT(*) FROM ';
		$sql1 .= $db->prefix( $this->d3forum_dirname . '_posts' ) . ' p ';
		$sql1 .= ' LEFT JOIN ';
		$sql1 .= $db->prefix( $this->d3forum_dirname . '_topics' ) . ' t ';
		$sql1 .= ' ON t.topic_id=p.topic_id ';
		$sql1 .= ' WHERE t.forum_id=' . (int) $forum_id;
		$sql1 .= ' AND t.topic_external_link_id=' . (int) $link_id;

		list( $count ) = $db->fetchRow( $db->query( $sql1 ) );

		$sql2 = 'UPDATE ' . $db->prefix( $this->mydirname . '_item' );
		$sql2 .= ' SET item_comments=' . (int) $count;
		$sql2 .= ' WHERE item_id=' . (int) $link_id;

		return $db->queryF( $sql2 );
	}
}
