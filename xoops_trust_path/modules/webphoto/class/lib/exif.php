<?php
/**
 * WebPhoto module for XCL
 * @package Webphoto
 * @version 2.31 (XCL)
 * @author Gigamaster, 2021-04-02 XCL PHP7
 * @author K. OHWADA, 2008-04-02
 * @copyright Copyright 2005-2021 XOOPS Cube Project  <https://github.com/xoopscube>
 * @license https://github.com/xoopscube/xcl/blob/master/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @brief (PHP 4 >= 4.2.0, PHP 5, PHP 7, PHP 8)
 * https://www.php.net/manual/en/function.exif-read-data.php
 */

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) {
	die( 'not permit' );
}


class webphoto_lib_exif {

	public function __construct() {
		// dummy
	}

	public static function &getInstance() {
		static $instance;
		if ( ! isset( $instance ) ) {
			$instance = new webphoto_lib_exif();
		}

		return $instance;
	}


// encoding

	public function read_file( $filename ) {
		if ( ! function_exists( 'exif_imagetype' ) ||
		     ! function_exists( 'exif_read_data' ) ) {
			return false;
		}

// only JPEG
		if ( exif_imagetype( $filename ) != IMAGETYPE_JPEG ) {
			return false;
		}

		$exif = exif_read_data( $filename, 0, true );
		if ( ! is_array( $exif ) || ! count( $exif ) ) {
			return false;
		}

		list( $datetime, $datetime_gnu ) = $this->parse_datetime( $exif );
		list( $maker, $model, $equipment ) = $this->parse_model( $exif );
		list( $gps_docomo, $lat, $lon ) = $this->parse_gps_docomo( $exif );
		$all_data = $this->parse_all_data( $exif );

		return array(
			'datetime'     => $datetime,
			'maker'        => $maker,
			'model'        => $model,
			'datetime_gnu' => $datetime_gnu,
			'equipment'    => $equipment,
			'latitude'     => $lat,
			'longitude'    => $lon,
			'gps_docomo'   => $gps_docomo,
			'all_data'     => $all_data,
		);
	}

	public function parse_datetime( $exif ) {
		$datetime     = '';
		$datetime_gnu = '';

		if ( isset( $exif['EXIF']['DateTimeOriginal'] ) && $exif['EXIF']['DateTimeOriginal'] ) {
			$datetime = $exif['EXIF']['DateTimeOriginal'];
		} elseif ( isset( $exif['IFD0']['DateTime'] ) ) {
			$datetime = $exif['IFD0']['DateTime'];
		}

		if ( $datetime ) {
			// yyyy:mm:dd -> yyy-mm-dd
			// http://www.gnu.org/software/tar/manual/html_node/General-date-syntax.html
			$datetime_gnu = preg_replace( '/(\d{4}):(\d{2}):(\d{2})(.*)/', '$1-$2-$3$4', $datetime );
		}

		return array( $datetime, $datetime_gnu );
	}

	public function parse_model( $exif ) {
		$maker     = '';
		$model     = '';
		$equipment = '';

		if ( isset( $exif['IFD0']['Make'] ) ) {
			$maker = $exif['IFD0']['Make'];
		}

		if ( isset( $exif['IFD0']['Model'] ) ) {
			$model = $exif['IFD0']['Model'];
		}

		if ( $maker && $model ) {
			if ( strpos( $model, $maker ) === false ) {
				$equipment = $maker . ' ' . $model;
			} else {
				$equipment = $model;
			}
		} elseif ( $maker ) {
			$equipment = $maker;
		} elseif ( $model ) {
			$equipment = $model;
		}

		return array( $maker, $model, $equipment );
	}

	public function parse_all_data( $exif ) {
// set all data when has IFD0
		if ( isset( $exif['IFD0'] ) ) {
			return $this->parse_array( $exif );
		}

		return '';
	}

	public function parse_array( $arr, $parent = null, $ret = null ) {
		$str = $ret;
		foreach ( $arr as $k => $v ) {
			if ( is_array( $v ) ) {
				if ( $parent ) {
					$new_parent = $parent . '.' . $k;
				} else {
					$new_parent = $k;
				}
				$str .= $this->parse_array( $v, $new_parent, $ret );
			} else {
				if ( $parent ) {
					$str .= $parent . '.';
				}
				$str .= $k . ': ';
				$str .= $this->str_replace_control_code( $v ) . "\n";
			}
		}

		return $str;
	}

	public function print_info( $filename ) {
		if ( ! function_exists( 'exif_read_data' ) ) {
			return false;
		}

		$exif = exif_read_data( $filename, 0, true );

		echo $this->parse_array( $exif );
	}


// GPSLatitudeRef: N
// GPSLatitude.0: 35/1
// GPSLatitude.1: 00/1
// GPSLatitude.2: 35600/1000
// GPSLongitudeRef: E
// GPSLongitude.0: 135/1
// GPSLongitude.1: 41/1
// GPSLongitude.2: 35600/1000

	public function parse_gps_docomo( $exif ) {
		$gps      = null;
		$lat      = null;
		$lon      = null;
		$lat_sign = + 1;
		$lon_sign = + 1;

		if ( isset( $exif['GPS'] ) ) {
			$gps = $exif['GPS'];
			if ( isset( $gps['GPSLatitudeRef'] ) ) {
				if ( $gps['GPSLatitudeRef'] == 'S' ) {
					$lat_sign = - 1;
				}
			}
			if ( isset( $gps['GPSLongitudeRef'] ) ) {
				if ( $gps['GPSLongitudeRef'] == 'W' ) {
					$lon_sign = - 1;
				}
			}
			if ( isset( $gps['GPSLatitude'] ) ) {
				$lat = $this->parse_gps_docomo_array( $lat_sign, $gps['GPSLatitude'] );
			}
			if ( isset( $gps['GPSLongitude'] ) ) {
				$lon = $this->parse_gps_docomo_array( $lon_sign, $gps['GPSLongitude'] );
			}
		}

		return array( $gps, $lat, $lon );
	}

	public function parse_gps_docomo_array( $sign, $arr ) {
		$fig = 0;
		if ( isset( $arr[0] ) ) {
			$fig += $this->calc_fraction( $arr[0] );
		}
		if ( isset( $arr[1] ) ) {
			$fig += $this->calc_fraction( $arr[1] ) / 60;
		}
		if ( isset( $arr[2] ) ) {
			$fig += $this->calc_fraction( $arr[2] ) / 3600;
		}
		$fig = $sign * $fig;

		return $fig;
	}

	public function calc_fraction( $val ) {
		$arr = explode( '/', $val );
		$fig = 0;
		if ( isset( $arr[0] ) ) {
			$numerator = (int) $arr[0];
			if ( isset( $arr[1] ) ) {
				$denominator = (int) $arr[1];
				if ( $denominator > 0 ) {
					$fig = $numerator / $denominator;
				} else {
					$fig = $numerator;
				}
			} else {
				$fig = $numerator;
			}
		}

		return $fig;
	}


// TAB \x09 \t
// LF  \xOA \n
// CR  \xOD \r

	public function str_replace_control_code( $str, $replace = ' ' ) {
		$str = preg_replace( '/[\x00-\x08]/', $replace, $str );
		$str = preg_replace( '/[\x0B-\x0C]/', $replace, $str );
		$str = preg_replace( '/[\x0E-\x1F]/', $replace, $str );
		$str = preg_replace( '/[\x7F]/', $replace, $str );

		return $str;
	}

}
