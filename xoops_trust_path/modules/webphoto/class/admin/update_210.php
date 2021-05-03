<?php
/**
 * WebPhoto module for XCL
 * @package    Webphoto
 * @version    2.3
 * @author     Gigamaster, 2021-04-02 XCL PHP7
 * @author     K. OHWADA, 2008-04-02
 * @copyright  Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube/legacy>
 * @license    https://github.com/xoopscube/legacy/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_admin_update_210 extends webphoto_base_this {

	public $_form_class;

	public $_THIS_FCT = 'update_210';

	public $_THIS_URL = null;


	public function __construct( $dirname, $trust_dirname ) {

		parent::__construct( $dirname, $trust_dirname );

		$this->_form_class =& webphoto_lib_form::getInstance( $dirname, $trust_dirname );

		$this->_item_handler->set_debug_error( true );

		$this->_ADMIN_URL = $this->_MODULE_URL . '/admin/index.php';
		$this->_THIS_URL  = $this->_ADMIN_URL . '?fct=' . $this->_THIS_FCT;

		$this->preload_init();
		$this->preload_constant();
	}

	public static function &getInstance( $dirname = null, $trust_dirname = null ) {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_admin_update_210( $dirname, $trust_dirname );
		}

		return $instance;
	}


	function main() {
		xoops_cp_header();

		$op = $this->_post_class->get_post_text( 'op' );

// when form
		if ( empty( $op ) ) {
			echo $this->build_admin_menu();
			echo $this->build_admin_title( 'UPDATE' );

			$item_count    = $this->_item_handler->get_count_all();
			$photo_count   = $this->_item_handler->get_count_photo();
			$onclick_count = $this->_item_handler->get_count_photo_detail_onclick();

			echo 'There are ' . $item_count . ' items and ' . $photo_count . ' photo images';
			echo "<br><br>\n";
			if ( ( $item_count == 0 ) || ( $photo_count == 0 ) ) {
				$msg = 'You dont need update.';
			} elseif ( $onclick_count > 0 ) {
				$msg = 'Probably, you dont need to update.';
			} else {
				$msg = _AM_WEBPHOTO_MUST_UPDATE;
			}
			echo $this->build_error_msg( $msg, '', false );
			echo "<br>\n";

		} else {
			echo $this->build_admin_bread_crumb( $this->get_admin_title( 'UPDATE' ), $this->_THIS_URL );
		}

		echo '<h4><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
		<path  fill="currentColor" d="M12 16.5l4-4h-3v-9h-2v9H8l4 4zm9-13h-6v1.99h6v14.03H3V5.49h6V3.5H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2v-14c0-1.1-.9-2-2-2z"/>
		</svg> Update to v2.1.x </h4>';

		switch ( $op ) {
			case 'update_item':
				if ( $this->check_token() ) {
					$this->_update_item();
				}
				break;

			case 'form':
			default:
				$this->_form_item();
				break;
		}

		xoops_cp_footer();
		exit();
	}

// update_item

	public function _update_item() {
		$item_detail_onclick = $this->_post_class->get_post_get( 'item_detail_onclick' );

		$ret = $this->_update_item_detail_onclick( $item_detail_onclick );
		if ( $ret ) {
			echo '<div class="success"> OK </div>';
		} else {
			echo '<div class="error"> failed to update item table </div>>';
			echo $this->_item_handler->get_format_error();
		}

		$this->_print_finish();
	}

	public function _update_item_detail_onclick( $item_detail_onclick ) {
		$sql = 'UPDATE ' . $this->_item_handler->get_table();
		$sql .= ' SET item_detail_onclick=' . (int) $item_detail_onclick;
		$sql .= ' WHERE ' . $this->_item_handler->build_where_ext_photo();

		return $this->_item_handler->query( $sql );
	}

// form

	public function _print_finish() {
		echo '<hr>';
		echo '<div class="tips"> <h4>FINISHED</h4>';
		echo '<p><a href="index.php" class="ui-btn">Admin Menu</a></p></div>';
	}

	public function _form_item() {
		$title = 'Update detail_onclick of item table';

		$form = $this->_form_class->build_form_style(
			$title, null, $this->_build_form() );
		echo '<div class="ui-card-full">';
		echo "<h4>" . $title . "</h4>\n";
		echo $form;
		echo '</div>';
	}

	public function _build_form() {
		$c_image    = _C_WEBPHOTO_DETAIL_ONCLICK_IMAGE;
		$c_lightbox = _C_WEBPHOTO_DETAIL_ONCLICK_LIGHTBOX;
		$l_image    = $this->get_constant( 'ITEM_DETAIL_ONCLICK_IMAGE' );
		$l_lightbox = $this->get_constant( 'ITEM_DETAIL_ONCLICK_LIGHTBOX' );
		$token      = $this->_form_class->get_token();

		return <<<EOF
<form name="webphoto_form_update_210" action="{$this->_ADMIN_URL}" method="post">
<input type="hidden" name="XOOPS_G_TICKET" value="$token" />
<input type="hidden" name="fct" value="{$this->_THIS_FCT}" />
<input type="hidden" name="op" value="update_item" />
<input type="radio" name="item_detail_onclick" value="$c_image" checked="checked" />
 $l_image <br>
<input type="radio" name="item_detail_onclick" value="$c_lightbox" />
 $l_lightbox <br><br>
<input type="submit" name="submit" value="Update" />
</form>
EOF;
	}
}
