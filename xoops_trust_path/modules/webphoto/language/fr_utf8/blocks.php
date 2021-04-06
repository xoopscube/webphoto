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

	define( $constpref . "BTITLE_TOPNEW", "Photos récentes" );
	define( $constpref . "BTITLE_TOPHIT", "Photos populaires" );
	define( $constpref . "BTITLE_RANDOM", "Photos au hasard" );
	define( $constpref . "TEXT_DISP", "Afficher" );
	define( $constpref . "TEXT_STRLENGTH", "Longueur maximale pour le titre" );
	define( $constpref . "TEXT_CATLIMITATION", "Filtrer par Catégorie(s)" );
	
// 2.30
	define( $constpref . "TEXT_CATLIMITRECURSIVE", "Inclure les sous-catégories" );
	
	define( $constpref . "TEXT_BLOCK_WIDTH", "Largeur maximale" );
	define( $constpref . "TEXT_BLOCK_WIDTH_NOTES", "(si la valeur est 0, la miniature sera affichée avec ses dimensions originales)" );
	define( $constpref . "TEXT_RANDOMCYCLE", "Alternance des images au hasard (en secondes)" );
	define( $constpref . "TEXT_COLS", "Nombre de colonnes" );

//---------------------------------------------------------
// v0.20
//---------------------------------------------------------
	define( $constpref . "POPBOX_REVERT", "Cliquer pour réduite." );

//---------------------------------------------------------
// v0.30
//---------------------------------------------------------
	define( $constpref . "TEXT_CACHETIME", "Délais de mise en cache" );

//---------------------------------------------------------
// v0.80
//---------------------------------------------------------
	define( $constpref . "TEXT_CATLIST_SUB", "Afficher la sous-catégorie" );
	define( $constpref . "TEXT_CATLIST_MAIN_IMG", "Afficher l'image de la Catégorie principale" );
	define( $constpref . "TEXT_CATLIST_SUB_IMG", "Afficher l'image de la sous-catégorie" );
	define( $constpref . "TEXT_CATLIST_COLS", "Nombre de colonnes" );
	define( $constpref . "TEXT_TAGCLOUD_LIMIT", "Nombrre de tags" );

//---------------------------------------------------------
// v1.20
//---------------------------------------------------------
// google map
	define( $constpref . "GMAP_MODE", "Mode d'affichage de GoogleMap" );
	define( $constpref . "GMAP_MODE_NONE", "Masquer" );
	define( $constpref . "GMAP_MODE_DEFAULT", "Défaut" );
	define( $constpref . "GMAP_MODE_SET", "Valeur suivante" );
	define( $constpref . "GMAP_LATITUDE", "Latitude" );
	define( $constpref . "GMAP_LONGITUDE", "Longitude" );
	define( $constpref . "GMAP_ZOOM", "Zoom" );
	define( $constpref . "GMAP_HEIGHT", "Hauteur de la carte" );
	define( $constpref . "PIXEL", "Pixels" );

//---------------------------------------------------------
// v1.40
//---------------------------------------------------------
	define( $constpref . "TIMELINE_LATEST", "Nombre de photos" );
	define( $constpref . "TIMELINE_RANDOM", "Nombre de photos au hasard" );
	define( $constpref . "TIMELINE_HEIGHT", "Hauteur de la chronologie" );
	define( $constpref . "TIMELINE_SCALE", "Échelle de temps" );
	define( $constpref . "TIMELINE_SCALE_WEEK", "Une semaine" );
	define( $constpref . "TIMELINE_SCALE_MONTH", "Un mois" );
	define( $constpref . "TIMELINE_SCALE_YEAR", "Un an" );
	define( $constpref . "TIMELINE_SCALE_DECADE", "10 ans" );

// === define end ===
}
