<?php
// test
if ( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) {
	$MY_DIRNAME = 'webphoto';
}

if ( ! isset( $MY_DIRNAME ) ) {
// call by altsys D3LanguageManager
	if ( isset( $mydirname ) ) {
		$MY_DIRNAME = $mydirname;

// probably error
	} elseif ( isset( $GLOBALS['MY_DIRNAME'] ) ) {
		$MY_DIRNAME = $GLOBALS['MY_DIRNAME'];
	} else {
		$MY_DIRNAME = 'webphoto';
	}
}

$constpref = strtoupper( '_BL_' . $MY_DIRNAME . '_' );

// === define begin ===
if ( ! defined( $constpref . "LANG_LOADED" ) ) {

	define( $constpref . "LANG_LOADED", 1 );

//=========================================================
// same as myalbum
//=========================================================

	define( $constpref . "BTITLE_TOPNEW", "Fotos Recentes" );
	define( $constpref . "BTITLE_TOPHIT", "Top Fotos" );
	define( $constpref . "BTITLE_RANDOM", "Foto Aleatoria" );
	define( $constpref . "TEXT_DISP", "Mostrar" );
	define( $constpref . "TEXT_STRLENGTH", "Comprimento maximo da titulo da foto" );
	define( $constpref . "TEXT_CATLIMITATION", "Limite por categoria" );

// v2.30
	define( $constpref . "TEXT_CATLIMITRECURSIVE", "com Sub-categorias" );

	define( $constpref . "TEXT_BLOCK_WIDTH", "Maximo a mostrar" );
	define( $constpref . "TEXT_BLOCK_WIDTH_NOTES", "(se voce configurar isto como 0, a imagem miniatura é mostrada no seu tamanho original.)" );
	define( $constpref . "TEXT_RANDOMCYCLE", "Trocando o ciclo das imagens aleatorias (sec)" );
	define( $constpref . "TEXT_COLS", "Colunas de Fotos" );

//---------------------------------------------------------
// v0.20
//---------------------------------------------------------
	define( $constpref . "POPBOX_REVERT", "Clique na imagem para encolher." );

//---------------------------------------------------------
// v0.30
//---------------------------------------------------------
	define( $constpref . "TEXT_CACHETIME", "Cache Time" );

//---------------------------------------------------------
// v0.80
//---------------------------------------------------------
	define( $constpref . "TEXT_CATLIST_SUB", "Show sub category" );
	define( $constpref . "TEXT_CATLIST_MAIN_IMG", "Show image of main category" );
	define( $constpref . "TEXT_CATLIST_SUB_IMG", "Show image of sub category" );
	define( $constpref . "TEXT_CATLIST_COLS", "Number of columns" );
	define( $constpref . "TEXT_TAGCLOUD_LIMIT", "Number of tags" );

//---------------------------------------------------------
// v1.20
//---------------------------------------------------------
// google map
	define( $constpref . "GMAP_MODE", "GoogleMap Mode" );
	define( $constpref . "GMAP_MODE_NONE", "Not show" );
	define( $constpref . "GMAP_MODE_DEFAULT", "Default" );
	define( $constpref . "GMAP_MODE_SET", "Following value" );
	define( $constpref . "GMAP_LATITUDE", "Latitude" );
	define( $constpref . "GMAP_LONGITUDE", "Longitude" );
	define( $constpref . "GMAP_ZOOM", "Zoom" );
	define( $constpref . "GMAP_HEIGHT", "Height of Map" );
	define( $constpref . "PIXEL", "Pixel" );

//---------------------------------------------------------
// v1.40
//---------------------------------------------------------
	define( $constpref . "TIMELINE_LATEST", "Number of latest photos" );
	define( $constpref . "TIMELINE_RANDOM", "Number of random photos" );
	define( $constpref . "TIMELINE_HEIGHT", "Height of Timeline" );
	define( $constpref . "TIMELINE_SCALE", "Timeline scale" );
	define( $constpref . "TIMELINE_SCALE_WEEK", "one week" );
	define( $constpref . "TIMELINE_SCALE_MONTH", "one month" );
	define( $constpref . "TIMELINE_SCALE_YEAR", "one year" );
	define( $constpref . "TIMELINE_SCALE_DECADE", "10 years" );

// === define end ===
}
