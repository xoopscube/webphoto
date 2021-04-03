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


class webphoto_lib_element extends webphoto_lib_error {

	public $_alternate_class = '';
	public $_line_count = 0;
	public $_row = array();
	public $_hidden_buffers = array();

	public $_cached_token = null;
	public $_token_errors = null;
	public $_token_error_flag = false;

// set parameter
	public $_FORM_NAME = 'form';
	public $_TITLE_HEADER = 'title';
	public $_KEYWORD_MIN = 5;
	public $_path_color_pickup = null;

// local constant
	public $_TABLE_SELECT_WIDTH = '200px';
	public $_TD_SELECT_WIDTH = '100px';

	public $_TD_LEFT_CLASS = 'head';
	public $_TD_RIGHT_CLASS = 'odd';
	public $_TD_BOTTOM_CLASS = 'head';
	public $_TD_LEFT_WIDTH = '';

	public $_DIV_STYLE = 'background-color: transparent; border: 1px solid #808080; margin: 5px; padding: 10px 10px 5px 10px; width: 95%; text-align: center; ';
	public $_DIV_ERROR_STYLE = 'background-color: transparent; color: #ff0000; border: #808080 1px dotted; margin:  3px; padding: 3px;';
	public $_SPAN_STYLE = 'font-size: 120%; font-weight: bold; color: #000000; ';
	public $_SPAN_TITLE_STYLE = 'font-size: 120%; font-weight: bold; color: #000000; ';

	public $_CAPTION_DESC_STYLE = 'font-size: 90%; font-weight: 500;';

	public $_SELECTED = 'selected="selected"';
	public $_CHECKED = 'checked="checked"';
	public $_DISABLED = 'disabled="disabled"';

	public $_TIME_FORMAT = 'Y/m/d H:i';
	public $_TEXT_EMPTY_SUBSUTITUTE = '---';

	public $_SIZE_PERPAGE = 10;

	public $_C_YES = 1;
	public $_C_NO = 0;

	public $_THIS_URL;

	public $_PERM_ALLOW_ALL = '*';
	public $_PERM_DENOY_ALL = 'x';
	public $_PERM_SEPARATOR = '&';

// base on style sheet of default theme
	public $_STYLE_CONFIRM_MSG = 'background-color: transparent; color: #136C99; text-align: center; border-top: 1px solid #DDDDFF; border-left: 1px solid #DDDDFF; border-right: 1px solid #AAAAAA; border-bottom: 1px solid #AAAAAA; font-weight: bold; padding: 10px; ';


// constructor

	public function __construct() {

		parent::__construct();

		$this->_THIS_URL = xoops_getenv( 'PHP_SELF' );
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_element();
		}

		return $instance;
	}


// header
	public function build_html_header( $title = null ) {
		if ( empty( $title ) ) {
			$title = $this->_TITLE_HEADER;    // todo
		}

		$text = '<html><head>' . "\n";
		$text .= '<meta http-equiv="Content-Type" content="text/html; charset=' . _CHARSET . '" />' . "\n";
		$text .= '<title>' . $this->sanitize( $title ) . '</title>' . "\n";
		$text .= '</head><body>' . "\n";

		return $text;
	}

	public function build_html_footer( $close = null ) {
		if ( empty( $close ) ) {
			$close = _CLOSE;
		}

		$text = '<hr>' . "\n";
		$text .= '<div style="text-align:center;">';
		$text .= '<input value="' . $close . '" type="button" onclick="javascript:window.close();" />';
		$text .= '</div>' . "\n";
		$text .= '</body></html>' . "\n";

		return $text;
	}


// form box

	public function build_form_box_with_style( $param, $hidden_array ) {
		$title = $param['title'] ?? null;
		$desc  = $param['desc'] ?? null;

		$val  = $this->build_form_box( $param, $hidden_array );
		$text = $this->build_form_style( $title, $desc, $val );

		return $text;
	}

	public function build_form_box( $param, $hidden_array ) {
		$form_name    = $param['form_name'] ?? null;
		$action       = $param['action'] ?? null;
		$submit_name  = $param['submit_name'] ?? null;
		$submit_value = $param['submit_value'] ?? null;

		if ( empty( $form_name ) ) {
			$form_name = $this->build_form_name_rand();
		}

		if ( empty( $action ) ) {
			$action = $this->_THIS_URL;
		}

		if ( empty( $submit_name ) ) {
			$submit_name = 'submit';
		}

		if ( empty( $submit_value ) ) {
			$submit_value = _SUBMIT;
		}

		$text = $this->build_form_tag( $form_name, $action );
		$text .= $this->build_html_token() . "\n";

		if ( is_array( $hidden_array ) && count( $hidden_array ) ) {
			foreach ( $hidden_array as $k => $v ) {
				$text .= $this->build_input_hidden( $k, $v );
			}
		}

		$text .= $this->build_input_submit( $submit_name, $submit_value );

		$text .= $this->build_form_end();

		return $text;
	}

	public function build_form_style( $title, $desc, $value, $style_div = '', $style_span = '' ) {
		if ( empty( $style_div ) ) {
			$style_div = $this->_DIV_STYLE;
		}

		if ( empty( $style_span ) ) {
			$style_span = $this->_SPAN_TITLE_STYLE;
		}

		$text = '<div style="' . $style_div . '">' . "\n";

		if ( $title ) {
			$text .= '<span style="' . $style_span . '">';
			$text .= $title;
			$text .= "</span><br><br>\n";
		}

		if ( $desc ) {
			$text .= $desc . "<br><br>\n";
		}

		$text .= $value;
		$text .= "</div><br>\n";

		return $text;
	}


// form

	public function build_form_begin( $name = null, $action = null, $method = 'post', $extra = null ) {
		if ( empty( $name ) ) {
			$name = $this->_FORM_NAME;
		}
		if ( empty( $action ) ) {
			$action = $this->_THIS_URL;
		}
		$text = $this->build_form_tag( $name, $action, $method, $extra );
		$text .= $this->build_html_token() . "\n";

		return $text;
	}

	public function build_form_end() {
		$text = "</form>\n";

		return $text;
	}

	public function build_js_checkall() {
		$name     = $this->_FORM_NAME . '_checkall';
		$checkall = "xoopsCheckAll('" . $this->_FORM_NAME . "', '" . $name . "')";
		$extra    = ' onclick="' . $checkall . '" ';
		$text     = '<input type="checkbox" name="' . $name . '" id="' . $name . '" ' . $extra . ' />' . "\n";

		return $text;
	}

	public function build_js_checkbox( $value ) {
		$name = $this->_FORM_NAME . '_id[]';
		$text = '<input type="checkbox" name="' . $name . '" id="' . $name . '" value="' . $value . '"  />' . "\n";

		return $text;
	}

	public function substitute_empty( $str, $substitute = '---' ) {
		if ( empty( $str ) ) {
			$str = $substitute;
		}

		return $str;
	}

	public function build_form_dhtml( $name, $value, $rows = 5, $cols = 50, $hiddentext = 'xoopsHiddenText' ) {
		$ele = new XoopsFormDhtmlTextArea( '', $name, $value, $rows, $cols, $hiddentext );
		if ( defined( 'LEGACY_BASE_VERSION' ) && version_compare( LEGACY_BASE_VERSION, '2.2.2.1', '>=' ) ) {
			$ele->setEditor( 'bbcode' );
		}
		$text = $ele->render();

		return $text;
	}

	public function build_form_select( $name, $value, $options, $size = 5, $extra = null ) {
		if ( ! is_array( $options ) || ! count( $options ) ) {
			return null;
		}

		$text = $this->build_form_select_tag( $name, $name, $size, $extra );
		$text .= $this->build_form_options( $value, $options );
		$text .= $this->build_form_select_end();

		return $text;
	}

	public function build_form_select_multiple( $id, $values, $options, $size = 5, $extra_in = null ) {
		if ( ! is_array( $values ) ) {
			return null;
		}
		if ( ! is_array( $options ) || ! count( $options ) ) {
			return null;
		}

		$name  = $id . '[]';
		$extra = 'multiple ' . $extra_in;

		$text = $this->build_form_select_tag( $id, $name, $size, $extra );
		$text .= $this->build_form_options_multi( $values, $options );
		$text .= $this->build_form_select_end();

		return $text;
	}

	public function build_form_select_tag( $id, $name, $size = 5, $extra = null ) {
		$str = '<select id="' . $id . '" name="' . $name . '" size="' . $size . '" ' . $extra . ' >' . "\n";

		return $str;
	}

	function build_form_select_end() {
		$str = '</select>' . "\n";

		return $str;
	}

	public function build_form_hiddens_select_multi( $name, $values ) {
		if ( ! is_array( $values ) ) {
			return null;
		}

		$text = '';
		foreach ( $values as $v ) {
			$text .= $this->build_input_hidden_without_id( $name, $v );
			$text .= ' ';
		}

		return $text;
	}

	public function build_form_options_multi( $values, $options ) {
		if ( ! is_array( $values ) ) {
			return null;
		}
		if ( ! is_array( $options ) || ! count( $options ) ) {
			return null;
		}

		$text = '';
		$list = $this->build_form_option_list_multi( $values, $options );
		foreach ( $list as $opt ) {
			$text .= $this->build_form_option( $opt['value'], $opt['caption'], $opt['selected'] );
		}

		return $text;
	}

	public function build_form_options( $value, $options, $disabled_list = null ) {
		if ( ! is_array( $options ) || ! count( $options ) ) {
			return null;
		}

		$text = '';
		$list = $this->build_form_option_list( $value, $options, $disabled_list );
		foreach ( $list as $opt ) {
			$text .= $this->build_form_option( $opt['value'], $opt['caption'], $opt['extra'] );
		}

		return $text;
	}

	public function build_form_option_list_multi( $values, $options ) {
		if ( ! is_array( $values ) ) {
			return null;
		}
		if ( ! is_array( $options ) || ! count( $options ) ) {
			return null;
		}

		$arr = array();
		foreach ( $options as $k => $v ) {
			$arr[] = array(
				'value'    => $k,
				'caption'  => $v,
				'selected' => $this->build_form_selected_multi( $values, $k ),
			);
		}

		return $arr;
	}

	public function build_form_option_list( $value, $options, $disabled_list = null ) {
		if ( ! is_array( $options ) || ! count( $options ) ) {
			return null;
		}

		$arr = array();
		foreach ( $options as $k => $v ) {
			$arr[] = array(
				'value'   => $k,
				'caption' => $v,
				'extra'   => $this->build_form_select_extra( $k, $value, $disabled_list ),
			);
		}

		return $arr;
	}

	public function build_form_option( $value, $caption, $extra = null ) {
		$str = '<option value="' . $value . '" ' . $extra . ' >';
		$str .= $caption;
		$str .= '</option >' . "\n";

		return $str;
	}

	public function build_form_selected_multi( $values, $val2 ) {
		$flag = false;
		foreach ( $values as $val1 ) {
			if ( $val1 == $val2 ) {
				$flag = true;
				break;
			}
		}

		if ( $flag ) {
			return $this->_SELECTED;
		}

		return '';
	}

	public function build_form_selected( $val1, $val2 ) {
		if ( $val1 == $val2 ) {
			return $this->_SELECTED;
		}

		return '';
	}

	public function build_form_select_extra( $key, $value, $disabled_list = null ) {
		if ( is_array( $disabled_list ) && in_array( $key, $disabled_list ) ) {
			return $this->_DISABLED;
		} elseif ( $key == $value ) {
			return $this->_SELECTED;
		}

		return '';
	}

	public function build_form_radio_yesno( $name, $value ) {
		$options = array(
			_YES => $this->_C_YES,
			_NO  => $this->_C_NO,
		);

		return $this->build_form_radio( $name, $value, $options );
	}

	public function build_form_radio( $name, $value, $options, $del = '' ) {
		if ( ! is_array( $options ) || ! count( $options ) ) {
			return null;
		}

		$text = '';
		foreach ( $options as $k => $v ) {
			$text .= $this->build_input_radio(
				$name, $v, $this->build_form_checked( $v, $value ) );

			$text .= ' ';
			$text .= $k;
			$text .= ' ';
			$text .= $del;
		}

		return $text;
	}

	public function build_form_checkbox( $name, $value, $options, $del = '' ) {
		if ( ! is_array( $options ) || ! count( $options ) ) {
			return null;
		}

		$text = '';
		foreach ( $options as $k => $v ) {
			$text .= $this->build_input_checkbox(
				$name, $v, $this->build_form_checked( $v, $value ) );

			$text .= ' ';
			$text .= $k;
			$text .= ' ';
			$text .= $del;
		}

		return $text;
	}

	public function build_input_checkbox_yes( $name, $value, $extra = '' ) {
		$checked = $this->build_form_checked( $value, $this->_C_YES );
		$text    = $this->build_input_checkbox( $name, $this->_C_YES, $checked, $extra );

		return $text;
	}

	public function build_form_checked( $val1, $val2 ) {
		if ( $val1 == $val2 ) {
			return $this->_CHECKED;
		}

		return '';
	}

	public function build_form_file( $name, $size = 50, $extra = null ) {
		$text = $this->build_input_hidden( 'xoops_upload_file[]', $name );
		$text .= $this->build_input_file( $name, $size, $extra );

		return $text;
	}

	public function build_form_name_rand() {
		$name = $this->_FORM_NAME . '_' . rand();

		return $name;
	}


// group perms

	public function build_form_checkboxs_group_perms( $id_name, $groups, $perms, $all_yes = false, $del = '' ) {
		$options = $this->build_options_group_perms( $id_name, $groups, $perms, $all_yes );

		return $this->build_form_checkboxs_yes( $options, $del );
	}

	public function build_form_checkbox_hiddens_group_perms( $id_name, $groups, $perms, $all_yes = false ) {
		$options = $this->build_options_group_perms( $id_name, $groups, $perms, $all_yes );

		return $this->build_form_hiddens_yes( $options );
	}

	public function build_form_checkboxs_yes( $options, $del = '' ) {
		if ( ! is_array( $options ) || ! count( $options ) ) {
			return null;
		}

		$str = '';
		foreach ( $options as $opt ) {
			[ $name, $val, $cap ] = $opt;
			$str .= $this->build_input_checkbox_yes( $name, $val );
			$str .= ' ';
			$str .= $cap;
			$str .= ' ';
			$str .= $del;
		}

		return $str;
	}

	public function build_form_hiddens_yes( $options ) {
		if ( ! is_array( $options ) || ! count( $options ) ) {
			return null;
		}

		$text = '';
		foreach ( $options as $opt ) {
			[ $name, $val, $cap ] = $opt;
			if ( $val == $this->_C_YES ) {
				$text .= $this->build_input_hidden( $name, $val );
				$text .= ' ';
			}
		}

		return $text;
	}

	public function build_options_group_perms( $id_name, $groups, $perms, $all_yes = false ) {
		$arr = array();
		foreach ( $groups as $id => $cap ) {
			$name = $id_name . '[' . $id . ']';
			if ( $all_yes ) {
				$val = $this->_C_YES;
			} else {
				$val = (int) in_array( $id, $perms );
			}
			$arr[ $id ] = array( $name, $val, $this->sanitize( $cap ) );
		}

		return $arr;
	}

	public function get_all_yes_group_perms_by_key( $name ) {
		$all_yes = false;
		$value   = $this->get_row_by_key( $name, null, false );

		if ( $value == $this->_PERM_ALLOW_ALL ) {
			$all_yes = true;
		}

		return $all_yes;
	}


// color_pickup

	public function set_path_color_pickup( $path ) {
		$this->_path_color_pickup = $path;
	}

	public function build_script_color_pickup() {
		$str = '<script type="text/javascript" src="' . $this->_path_color_pickup . '/color-picker.js"></script>' . "\n";

		return $str;
	}

	public function build_form_color_pickup( $name, $value, $select_value = '...', $size = 50 ) {
		$select_name = $name . '_select';
		$text        = $this->build_form_color_pickup_input( $name, $value, $size );
		$text        .= $this->build_form_color_pickup_select( $select_name, $select_value, $name );

		return $text;
	}

	public function build_form_color_pickup_input( $name, $value, $size = 50 ) {
		$extra = 'style="background-color:' . $value . ';"';
		$text  = $this->build_input_text( $name, $value, $size, $extra );

		return $text;
	}

	public function build_form_color_pickup_select( $name, $value, $popup_name ) {
		$popup_path  = $this->_path_color_pickup . '/';
		$popup_value = "document.getElementById('" . $popup_name . "')";
		$onclick     = "return TCP.popup('" . $popup_path . "', " . $popup_value . " )";
		$extra       = 'onClick="' . $onclick . '"';

		$text = $this->build_input_reset( $name, $value, $extra );

		return $text;
	}


// table form

	public function build_table_begin() {
		$text = '<table class="outer" width="100%" cellpadding="4" cellspacing="1">' . "\n";

		return $text;
	}

	public function build_table_end() {
		$text = "</table>\n";

		return $text;
	}

	public function build_line_title( $title, $colspan = '2' ) {
		$text = '<tr align="center">';
		$text .= '<th colspan="' . $colspan . '">';
		$text .= $title;
		$text .= '</th></tr>' . "\n";

		return $text;
	}

	public function build_line_cap_ele( $cap, $desc, $ele, $flag_sanitaize = false ) {
		$title = $this->build_caption( $cap, $desc );

		return $this->build_line_ele( $title, $ele, $flag_sanitaize );
	}

	public function build_line_ele( $title, $ele, $flag_sanitaize = false ) {
		$extra = null;
		if ( $this->_TD_LEFT_WIDTH ) {
			$extra = 'width="' . $this->_TD_LEFT_WIDTH . '"';
		}

		if ( $flag_sanitaize ) {
			$ele = $this->sanitize( $ele );
		}

		$str = '<tr><td class="' . $this->_TD_LEFT_CLASS . '" ' . $extra . ' >';
		$str .= $title;
		$str .= '</td><td class="' . $this->_TD_RIGHT_CLASS . '">';
		$str .= $ele;
		$str .= "</td></tr>\n";

		return $str;
	}

	public function build_line_buttom( $val ) {
		$text = '<tr><td class="' . $this->_TD_BOTTOM_CLASS . '"></td>';
		$text .= '<td class="' . $this->_TD_BOTTOM_CLASS . '">';
		$text .= $val;
		$text .= "</td></tr>\n";

		return $text;
	}

	public function set_row( $row ) {
		if ( is_array( $row ) ) {
			$this->_row = $row;
		}
	}

	public function get_row() {
		return $this->_row;
	}

	public function get_row_by_key( $name, $default = null, $flag_sanitaize = true ) {
		if ( isset( $this->_row[ $name ] ) ) {
			$ret = $this->_row[ $name ];
			if ( $flag_sanitaize ) {
				$ret = $this->sanitize( $ret );
			}

			return $ret;
		}

		return $default;
	}

	public function set_row_hidden_buffer( $name ) {
		$value = $this->get_row_by_key( $name );
		$this->set_hidden_buffer( $name, $value );
	}

	public function build_row_hidden( $name ) {
		$value = $this->get_row_by_key( $name );

		return $this->build_input_hidden( $name, $value );
	}

	public function build_row_label( $title, $name, $flag_sanitaize = true ) {
		return $this->build_line_ele(
			$title,
			$this->get_row_label( $name, $flag_sanitaize ) );
	}

	public function build_row_label_time( $title, $name ) {
		return $this->build_line_ele(
			$title,
			$this->get_row_time( $name ) );
	}

	public function build_row_text( $title, $name, $size = 50 ) {
		$value = $this->get_row_by_key( $name );
		$ele   = $this->build_input_text( $name, $value, $size );

		return $this->build_line_ele( $title, $ele );
	}

	public function build_row_url( $title, $name, $size = 50, $flag_link = false ) {
		$value = $this->get_row_by_key( $name );

		if ( $value ) {
			$value_show = $value;
		} else {
			$value_show = 'http://';
		}

		$ele = $this->build_input_text( $name, $value_show, $size );

		if ( $flag_link && $value ) {
			$ele .= "<br>\n";
			$ele .= $this->build_a_link( $value, $value, '_blank' );
		}

		return $this->build_line_ele( $title, $ele );
	}

	public function build_row_text_id( $title, $name, $id, $size = 50 ) {
		$value = $this->get_row_by_key( $name );
		$ele   = $this->build_input_text_id( $id, $name, $value, $size );

		return $this->build_line_ele( $title, $ele );
	}

	public function build_row_textarea( $title, $name, $rows = 5, $cols = 50 ) {
		$value = $this->get_row_by_key( $name );
		$ele   = $this->build_textarea( $name, $value, $rows, $cols );

		return $this->build_line_ele( $title, $ele );
	}

	public function build_row_dhtml( $title, $name, $rows = 5, $cols = 50 ) {
		$value = $this->get_row_by_key( $name );
		$ele   = $this->build_form_dhtml( $name, $value, $rows, $cols );

		return $this->build_line_ele( $title, $ele );
	}

	public function build_row_radio_yesno( $title, $name ) {
		$value = $this->get_row_by_key( $name );
		$ele   = $this->build_form_radio_yesno( $name, $value );

		return $this->build_line_ele( $title, $ele );
	}

	public function build_row_checked( $name, $compare = 1 ) {
		$val = $this->get_row_by_key( $name, null, false );

		return $this->build_form_checked( $val, $compare );
	}

	public function build_line_add() {
		$text = $this->build_input_submit( 'add', _ADD );

		return $this->build_line_buttom( $text );
	}

	public function build_line_edit() {
		$text = $this->build_input_submit( 'edit', _EDIT );
		$text .= $this->build_input_submit( 'delete', _DELETE );

		return $this->build_line_buttom( $text );
	}

	public function build_line_submit( $name = 'submit', $value = _SUBMIT ) {
		$text = $this->build_input_submit( $name, $value );

		return $this->build_line_buttom( $text );
	}

	public function get_alternate_class() {
		if ( $this->_line_count % 2 != 0 ) {
			$class = 'odd';
		} else {
			$class = 'even';
		}
		$this->_alternate_class = $class;
		$this->_line_count ++;

		return $class;
	}


// row value

	public function get_row_label( $name, $flag_sanitaize = true ) {
		$value = $this->get_row_by_key( $name, $flag_sanitaize );
		$value = $this->substitute_empty( $value );

		return $value;
	}

	public function get_row_time( $name ) {
		$value = $this->get_row_by_key( $name );
		$value = date( $this->_TIME_FORMAT, $value );

		return $value;
	}


// element

	public function build_form_tag( $name, $action = '', $method = 'post', $extra = null ) {
		$text = '<form name="' . $name . '" action="' . $action . '" method="' . $method . '" ' . $extra . ' >' . "\n";

		return $text;
	}

	public function build_form_upload( $name, $action = '', $method = 'post', $extra = null ) {
		$text = '<form name="' . $name . '" action="' . $action . '" method="' . $method . '" enctype="multipart/form-data" ' . $extra . ' >' . "\n";

		return $text;
	}

	public function build_input_hidden( $name, $value, $flag_sanitaize = false ) {
		if ( $flag_sanitaize ) {
			$value = $this->sanitize( $value );
		}

		$text = '<input type="hidden" id="' . $name . '" name="' . $name . '"  value="' . $value . '" />' . "\n";

		return $text;
	}

	public function build_input_hidden_without_id( $name, $value, $flag_sanitaize = false ) {
		if ( $flag_sanitaize ) {
			$value = $this->sanitize( $value );
		}
		$text = '<input type="hidden" name="' . $name . '"  value="' . $value . '" />' . "\n";

		return $text;
	}

	public function build_input_text( $name, $value, $size = 50, $extra = null ) {
		return $this->build_input_text_id( $name, $name, $value, $size, $extra );
	}

	public function build_input_text_id( $id, $name, $value, $size = 50, $extra = null ) {
// typo
		$text = '<input type="text" id="' . $id . '"  name="' . $name . '" value="' . $value . '" size="' . $size . '" ' . $extra . ' />' . "\n";

		return $text;
	}

	public function build_input_submit( $name, $value, $extra = null ) {
		$text = '<input type="submit" id="' . $name . '" name="' . $name . '" value="' . $value . '" ' . $extra . ' />' . "\n";

		return $text;
	}

	public function build_input_reset( $name, $value, $extra = null ) {
		$text = '<input type="reset" id="' . $name . '" name="' . $name . '" value="' . $value . '" ' . $extra . ' />' . "\n";

		return $text;
	}

	public function build_input_button( $name, $value, $extra = null ) {
		$text = '<input type="button" id="' . $name . '" name="' . $name . '" value="' . $value . '" ' . $extra . ' />' . "\n";

		return $text;
	}

	public function build_input_file( $name, $size = 50, $extra = null ) {
		$text = '<input type="file" id="' . $name . '" name="' . $name . '" size="' . $size . '" ' . $extra . ' />' . "\n";

		return $text;
	}

	public function build_input_checkbox( $name, $value, $checked = '', $extra = '' ) {
		$text = '<input type="checkbox" name="' . $name . '" id="' . $name . '" value="' . $value . '" ' . $checked . ' ' . $extra . ' />' . "\n";

		return $text;
	}

	public function build_input_radio( $name, $value, $checked = '', $extra = '' ) {
		$text = '<input type="radio" name="' . $name . '" value="' . $value . '" ' . $checked . ' ' . $extra . ' />' . "\n";

		return $text;
	}

	public function build_textarea( $name, $value, $rows = 5, $cols = 80 ) {
		$text = $this->build_textarea_tag( $name, $rows, $cols );
		$text .= $value;
		$text .= '</textarea>';

		return $text;
	}

	public function build_textarea_tag( $name, $rows = 5, $cols = 80 ) {
		$text = '<textarea id="' . $name . '" name="' . $name . '" rows="' . $rows . '" cols="' . $cols . '">';

		return $text;
	}

	public function build_span_tag( $styel = null ) {
		if ( empty( $style ) ) {
			$style = $this->_SPAN_STYLE;
		}
		$text = '<span style="' . $style . '">';

		return $text;
	}

	public function build_span_end() {
		$text = "</span>\n";

		return $text;
	}

	public function build_div_tag( $styel = null ) {
		if ( empty( $style ) ) {
			$style = $this->_DIV_STYLE;
		}
		$text = '<div style="' . $style . '">';

		return $text;
	}

	public function build_div_end() {
		$text = "</div>\n";

		return $text;
	}

	public function build_div_box( $str, $style = null ) {
		$text = $this->build_div_tag( $style );
		$text .= $str;
		$text .= $this->build_div_end();

		return $text;
	}

	public function build_input_button_cancel( $name, $value = null ) {
		if ( empty( $value ) ) {
			$value = _CANCEL;
		}
		$extra = ' onclick="javascript:history.go(-1);" ';

		return $this->build_input_button( $name, $value, $extra );
	}

	public function build_a_link( $name, $href, $target = null, $flag_sanitize = false ) {
		if ( $flag_sanitize ) {
			$href = $this->sanitize( $href );
			$name = $this->sanitize( $name );
		}
		$text = $this->build_a_tag( $href, $target );
		$text .= $name;
		$text .= $this->build_a_end();

		return $text;
	}

	public function build_a_tag( $href, $target = null ) {
		$target_s = 'target="' . $target . '"';
		if ( $target ) {
			$target_s = 'target="' . $target . '"';
		}
		$text = '<a href="' . $href . '" ' . $target_s . ' ">';

		return $text;
	}

	public function build_a_end() {
		$text = "</a>\n";

		return $text;
	}


// caption

	public function build_caption( $cap, $desc = null ) {
		$str = $cap;
		if ( $desc ) {
			$str .= "<br><br>\n";
			$str .= $this->build_caption_desc( $desc );
		}

		return $str;
	}

	public function build_caption_desc( $desc ) {
		$str = '<span style="' . $this->_CAPTION_DESC_STYLE . '">';
		$str .= $desc;
		$str .= '</span>' . "\n";

		return $str;
	}


// hidden buffer

	public function clear_hidden_buffers() {
		$this->_hidden_buffers = array();
	}

	public function get_hidden_buffers() {
		return $this->_hidden_buffers;
	}

	public function render_hidden_buffers() {
		return implode( '', $this->_hidden_buffers );
	}

	public function set_hidden_buffer( $name, $value ) {
		$this->_hidden_buffers[] = $this->build_input_hidden( $name, $value );
	}


// keyword

	public function parse_keywords( $keywords, $andor = 'AND' ) {
		$keyword_array = array();
		$ignore_array  = array();

		if ( $keywords == '' ) {
			$arr = array( $keyword_array, $ignore_array );

			return $arr;
		}

		if ( $andor == 'exact' ) {
			$keyword_array = array( $keywords );

		} else {
			$temp_arr = preg_split( '/[\s,]+/', $keywords );

			foreach ( $temp_arr as $q ) {
				$q = trim( $q );
				if ( strlen( $q ) >= $this->_KEYWORD_MIN ) {
					$keyword_array[] = $q;
				} else {
					$ignore_array[] = $q;
				}
			}
		}

		$arr = array( $keyword_array, $ignore_array );

		return $arr;
	}


// token

	public function get_token_name() {
		return 'XOOPS_G_TICKET';
	}

	public function get_token() {
		global $xoopsGTicket;
		if ( is_object( $xoopsGTicket ) ) {
			return $xoopsGTicket->issue();
		}

		return null;
	}

	public function build_html_token() {
// get same token on one page, becuase max ticket is 10
		if ( $this->_cached_token ) {
			return $this->_cached_token;
		}

		global $xoopsGTicket;
		$text = '';
		if ( is_object( $xoopsGTicket ) ) {
			$text                = $xoopsGTicket->getTicketHtml() . "\n";
			$this->_cached_token = $text;
		}

		return $text;
	}

	public function check_token( $allow_repost = false ) {
		global $xoopsGTicket;
		if ( is_object( $xoopsGTicket ) ) {
			if ( ! $xoopsGTicket->check( true, '', $allow_repost ) ) {
				$this->_token_error_flag = true;
				$this->_token_errors     = $xoopsGTicket->getErrors();

				return false;
			}
		}
		$this->_token_error_flag = false;

		return true;
	}

	public function get_token_errors() {
		return $this->_token_errors;
	}


// set param

	public function set_time_start_name( $val ) {
		$this->_TIME_START_NAME = $val;
	}

	public function set_form_name( $val ) {
		$this->_FORM_NAME = $val;
	}

	public function set_title_header( $val ) {
		$this->_TITLE_HEADER = $val;
	}

	public function set_keyword_min( $val ) {
		$this->_KEYWORD_MIN = (int) $val;
	}

	public function set_td_left_width( $val ) {
		$this->_TD_LEFT_WIDTH = $val;
	}


// base on core's xoops_confirm
// XLC do not support 'confirmMsg' style class in admin cp

	public function build_form_confirm( $hiddens, $action, $msg, $submit = '', $cancel = '', $addToken = true ) {
		$submit = ( $submit != '' ) ? trim( $submit ) : _SUBMIT;
		$cancel = ( $cancel != '' ) ? trim( $cancel ) : _CANCEL;

		$text = '<div style="' . $this->_STYLE_CONFIRM_MSG . '">' . "\n";
		$text .= '<h4>' . $msg . '</h4>' . "\n";

		$text .= $this->build_form_tag( 'confirmMsg', $action );

		foreach ( $hiddens as $name => $value ) {
			if ( is_array( $value ) ) {
				foreach ( $value as $caption => $newvalue ) {
					$text .= $this->build_input_radio( $name, $this->sanitize( $newvalue ) );
					$text .= $caption;
				}
				$text .= "<br>\n";

			} else {
				$text .= $this->build_input_hidden( $name, $this->sanitize( $value ) );
			}
		}

		if ( $addToken ) {
			$text .= $this->build_html_token() . "\n";
		}

// button
		$text .= $this->build_input_submit( 'confirm_submit', $submit );
		$text .= ' ';
		$text .= $this->build_input_button_cancel( 'confirm_cancel', $cancel );

		$text .= $this->build_form_end();
		$text .= "</div>\n";

		return $text;
	}
}
