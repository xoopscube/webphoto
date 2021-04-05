<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * class webphoto_lib_cloud
 * same as Sabai_Cloud except change class name
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}

/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Cloud
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id: cloud.php,v 1.1 2008/06/21 12:22:27 ohwada Exp $
 * @link
 * @since      File available since Release 0.1.1
 */

//define('SABAI_CLOUD_SORT_NAME_ASC', 1);
//define('SABAI_CLOUD_SORT_NAME_DESC', 2);
//define('SABAI_CLOUD_SORT_COUNT_ASC', 3);
//define('SABAI_CLOUD_SORT_COUNT_DESC', 4);

define( 'WEBPHOTO_CLOUD_SORT_NAME_ASC', 1 );
define( 'WEBPHOTO_CLOUD_SORT_NAME_DESC', 2 );
define( 'WEBPHOTO_CLOUD_SORT_COUNT_ASC', 3 );
define( 'WEBPHOTO_CLOUD_SORT_COUNT_DESC', 4 );

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Cloud
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id: cloud.php,v 1.1 2008/06/21 12:22:27 ohwada Exp $
 * @link
 * @since      Class available since Release 0.1.1
 */
//class Sabai_Cloud
class webphoto_lib_cloud {
	/**
	 * @array
	 * @access protected
	 */
	protected $_elements = array();
	/**
	 * @array
	 * @access protected
	 */
	protected $_elementLinks = array();
	/**
	 * @int
	 * @access protected
	 */
	protected $_sort = WEBPHOTO_CLOUD_SORT_NAME_ASC;
	/**
	 * @int
	 * @access protected
	 */
	protected $_sizeMin;
	/**
	 * @int
	 * @access protected
	 */
	protected $_sizeRange;
	/**
	 * @float
	 * @access protected
	 */
	protected $_logMin;
	/**
	 * @float
	 * @access protected
	 */
	protected $_logRange;

	/**
	 * Constructor
	 *
	 * @param int $sizeMin
	 * @param int $sizeRange
	 *
	 * @return Sabai_Cloud
	 */

	//  public function Sabai_Cloud($sizeMin = 10, $sizeRange = 12)
	public function __construct( $sizeMin = 10, $sizeRange = 12 ) {
		$this->_sizeMin   = (int) $sizeMin;
		$this->_sizeRange = (int) $sizeRange;
	}

	/**
	 * Sets the sort order
	 *
	 * @param bool $asc
	 */
	public function sortByName( $asc = true ) {
		if ( ! $asc ) {
			$this->_sort = WEBPHOTO_CLOUD_SORT_NAME_DESC;
		} else {
			$this->_sort = WEBPHOTO_CLOUD_SORT_NAME_ASC;
		}
	}

	/**
	 * Sets the sort order
	 *
	 * @param bool $asc
	 */
	public function sortByCount( $asc = true ) {
		if ( ! $asc ) {
			$this->_sort = WEBPHOTO_CLOUD_SORT_COUNT_DESC;
		} else {
			$this->_sort = WEBPHOTO_CLOUD_SORT_COUNT_ASC;
		}
	}

	/**
	 * Adds an element in the cloud
	 *
	 * @param string $name
	 * @param string $link
	 * @param int $count
	 */
	public function addElement( $name, $link = '', $count = 0 ) {
		$this->_elements[ $name ]     = (int) $count;
		$this->_elementLinks[ $name ] = $link;
	}

	/**
	 * Creates the cloud
	 *
	 * @return array
	 */
	public function build() {
		if ( empty( $this->_elements ) ) {
			return array();
		}
		$this->_init();
		switch ( $this->_sort ) {
			case WEBPHOTO_CLOUD_SORT_NAME_ASC:

				$this->_ksort_locate_string( $this->_elements );

				break;
			case WEBPHOTO_CLOUD_SORT_NAME_DESC:

// changed for PHP 4.3 or previous
//              krsort($this->_elements, SORT_LOCALE_STRING);
				$this->_ksort_locate_string( $this->_elements );

				break;
			case WEBPHOTO_CLOUD_SORT_COUNT_ASC:
				asort( $this->_elements, SORT_NUMERIC );
				break;
			case WEBPHOTO_CLOUD_SORT_COUNT_DESC:
				arsort( $this->_elements, SORT_NUMERIC );
				break;
		}
		$elements = array();
		foreach ( $this->_elements as $name => $count ) {
			$elements[] = array(
				'name'  => $name,
				'count' => $count,
				'link'  => $this->_elementLinks[ $name ],
				'size'  => $this->_getSize( $count )
			);
		}

		return $elements;
	}

	/**
	 * Initializes cloud parameters
	 *
	 * @access protected
	 */
	public function _init() {
		$counts = array_values( $this->_elements );
		sort( $counts, SORT_NUMERIC );
		if ( 0 >= $count_min = array_shift( $counts ) ) {
			$count_min = 1;
		}
		$this->_logMin = $log_max = log( $count_min );
		if ( $count_max = array_pop( $counts ) ) {
			$log_max = log( $count_max );
		}
		if ( $this->_logMin == $log_max ) {
			$this->_logRange = 1;
		} else {
			$this->_logRange = $log_max - $this->_logMin;
		}
	}

	/**
	 * Calculates the size of an element by its count
	 *
	 * @access protected
	 *
	 * @param int $count
	 *
	 * @return int
	 */
	public function _getSize( $count ) {
		$count = (int) $count <= 0 ? 1 : $count;
		$size  = $this->_sizeMin + $this->_sizeRange * ( log( $count ) - $this->_logMin ) / $this->_logRange;

		return (int) $size;
	}

// added for PHP 4.3 or previous
	public function _ksort_locate_string( &$arr ) {
		if ( defined( 'SORT_LOCALE_STRING' ) ) {
			ksort( $arr, SORT_LOCALE_STRING );
		} else {
			ksort( $arr );
		}
	}
}
