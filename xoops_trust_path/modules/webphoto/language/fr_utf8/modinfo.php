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

$constpref = strtoupper( '_MI_' . $MY_DIRNAME . '_' );

// === define begin ===
if ( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref . "LANG_LOADED" ) ) {

	define( $constpref . "LANG_LOADED", 1 );

//=========================================================
// same as myalbum
//=========================================================

// The name of this module
	define( $constpref . "NAME", "Web Photo" );

// A brief description of this module
	define( $constpref . "DESC", "Gestionnaire de médias." );

// Names of blocks for this module (Not all module has blocks)
	define( $constpref . "BNAME_RECENT", "Photo récentes" );
	define( $constpref . "BNAME_HITS", "Photos populaires" );
	define( $constpref . "BNAME_RANDOM", "Photos au hasard" );
	define( $constpref . "BNAME_RECENT_P", "Photos récentes avec miniatures" );
	define( $constpref . "BNAME_HITS_P", "Photos populaires avec miniatures" );

	define( $constpref . "CFG_IMAGINGPIPE", "Librairie de traitement des images" );
	define( $constpref . "CFG_DESCIMAGINGPIPE", "La plupart des environnements PHP sont en mesure d'utiliser la librairie GD. Cependant ImageMagick et NetPBM sont plus performantes." );
	define( $constpref . "CFG_FORCEGD2", "Forcer la conversion GD2" );
	define( $constpref . "CFG_DESCFORCEGD2", "Cette option permet l'emploi de GD2 (conversion Truecolor).<br>Certaines configurations de PHP peuvent échouer dans le traitement des miniatures<br>Ce paramètre n'est actif que si vous avez sélectionné la librairie GD" );
	define( $constpref . "CFG_IMAGICKPATH", "Chemin d'accès à ImageMagick" );
	define( $constpref . "CFG_DESCIMAGICKPATH", "Bien que le chemin d'accès puisse être renseigné, laisser vide ce champ fonctionne avec la plupart des environnements.<br>Ce paramètre n'est actif que si vous avez sélectionné la librairie ImageMagick" );
	define( $constpref . "CFG_NETPBMPATH", "Chemin d'accès à NetPBM" );
	define( $constpref . "CFG_DESCNETPBMPATH", "Bien que le chemin d'accès puisse être renseigné, laisser vide ce champ fonctionne avec la plupart des environnements<br>Ce paramètre n'est actif que si vous avez sélectionné la librairie NetPBM" );
	define( $constpref . "CFG_POPULAR", "Nombre d'affichages pour qu'une photo soit signalée comme Populaire" );
	define( $constpref . "CFG_NEWDAYS", "Nombre de jour pour qu'une photo soit signalée comme Nouvelle ou Mise à jour" );
	define( $constpref . "CFG_NEWPHOTOS", "Nombre de photosNumber of Photos à afficher sur la page d'accueil du module" );
	define( $constpref . "CFG_PERPAGE", "Nombre de photos pouvant être affichées sur la page" );
	define( $constpref . "CFG_DESCPERPAGE", "Les choix proposés aux utilisateurs doivent être séparés par '|'<br>exemples : 10|20|50|100" );
	define( $constpref . "CFG_ALLOWNOIMAGE", "Permission de valider le formulaire de soumission sans photo" );
	define( $constpref . "CFG_MAKETHUMB", "Générer des miniatures à partir des photos" );
	define( $constpref . "CFG_DESCMAKETHUMB", "Il est recommandé de cocher Oui. Vous pourrez toujours regénérer les vignettes par la suite." );

// v2.30
define( $constpref . "CFG_WIDTH", "Image Width in popup" );
define( $constpref . "CFG_DESCWIDTH", "Image size when popup. <br><br>In old version, this parameter was the limitation of the image size when upload. <br>This limitation was abolished. <br>The specification was changed in V2.30." );
define( $constpref . "CFG_HEIGHT", "Image Height in popup" );
define( $constpref . "CFG_DESCHEIGHT", "Same as Image Width" );

define( $constpref . "CFG_FSIZE", "Poids maximal de la photo" );
define( $constpref . "CFG_DESCFSIZE", "Les fichiers chargés ne pourront pas dépasser cette valeur (exprimée en bytes)" );
	define( $constpref . "CFG_ADDPOSTS", "Incrémentation du compteur de Posts de l'utilisateur lorsqu'il ajoute une photo." );
	define( $constpref . "CFG_DESCADDPOSTS", "La valeur normale est 1." );
	define( $constpref . "CFG_CATONSUBMENU", "Faire apparaître les Catégories principales dans le Menu principal" );
	define( $constpref . "CFG_NAMEORUNAME", "Identité de l'utilisateur ayant ajouté la photo" );
	define( $constpref . "CFG_DESCNAMEORUNAME", "Choisir d'afficher le Pseudo ou le Nom véritable" );
	define( $constpref . "CFG_VIEWTYPE", "Type de vue" );
	define( $constpref . "CFG_COLSOFTABLE", "Nombre de colonne dans la vue Tableau" );
	define( $constpref . "CFG_USESITEIMG", "Utiliser le xoopsCode [siteimg] pour insérer des images" );
	define( $constpref . "CFG_DESCUSESITEIMG", "[siteimg] remplacera [img] instead of [img].<br>Pour ce faire, vous devez modifier le fichier module.textsanitizer.php pour chacun des modules employant [siteimg]" );
	define( $constpref . "OPT_USENAME", "Nom véritable" );
	define( $constpref . "OPT_USEUNAME", "Pseudo" );
	define( $constpref . "OPT_VIEWLIST", "Vue Liste" );
	define( $constpref . "OPT_VIEWTABLE", "Vue Table" );

// Text for notifications
	define( $constpref . "GLOBAL_NOTIFY", "Globale" );
	define( $constpref . "GLOBAL_NOTIFYDSC", "Choix des Notifications globales" );
	define( $constpref . "CATEGORY_NOTIFY", "Catégorie" );
	define( $constpref . "CATEGORY_NOTIFYDSC", "Notifications concernant la Catégorie de la photo affichée" );
	define( $constpref . "PHOTO_NOTIFY", "Photo" );
	define( $constpref . "PHOTO_NOTIFYDSC", "Notification concernant la photo affichée" );

	define( $constpref . "GLOBAL_NEWPHOTO_NOTIFY", "Nouvelle photo" );
	define( $constpref . "GLOBAL_NEWPHOTO_NOTIFYCAP", "M'alerter lorsqu'une nouvelle photo est publiée" );
	define( $constpref . "GLOBAL_NEWPHOTO_NOTIFYDSC", "M'alerter lorsque une nouvelle description de photo est publiée" );
	define( $constpref . "GLOBAL_NEWPHOTO_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE}: notification automatique : Nouvelle photo" );

	define( $constpref . "CATEGORY_NEWPHOTO_NOTIFY", "Nouvelle photo" );
	define( $constpref . "CATEGORY_NEWPHOTO_NOTIFYCAP", "M'alerter lorsqu'une nouvelle photo est publiée dans cette Catégorie" );
	define( $constpref . "CATEGORY_NEWPHOTO_NOTIFYDSC", "M'alerter lorsque une nouvelle description de photo est publiée dans cette Catégorie" );
	define( $constpref . "CATEGORY_NEWPHOTO_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE}: auto-notify : Nouvelle photo" );

//=========================================================
// add for webphoto
//=========================================================

// Config Items
	define( $constpref . "CFG_SORT", "Classement par défaut (Vue Liste)" );
	define( $constpref . "OPT_SORT_IDA", "Nombre d'enregistrements (Ordre croissant)" );
	define( $constpref . "OPT_SORT_IDD", "Nombre d'enregistrements (Ordre décroissant)" );
	define( $constpref . "OPT_SORT_HITSA", "Popularité (Ordre croissant)" );
	define( $constpref . "OPT_SORT_HITSD", "Popularité (Ordre décroissant)" );
	define( $constpref . "OPT_SORT_TITLEA", "Titre (ordre alphabétique)" );
	define( $constpref . "OPT_SORT_TITLED", "Titre (ordre ante-alphabétique)" );
	define( $constpref . "OPT_SORT_DATEA", "Date de mise à jour (Ordre chronologique)" );
	define( $constpref . "OPT_SORT_DATED", "Date de mise à jour (Ordre ante-chronologique)" );
	define( $constpref . "OPT_SORT_RATINGA", "Note (Ordre croissant)" );
	define( $constpref . "OPT_SORT_RATINGD", "Note (Ordre décroissant)" );
	define( $constpref . "OPT_SORT_RANDOM", "Au hasard" );
	define( $constpref . "CFG_MIDDLE_WIDTH", "Largeur de l'image affichée seule" );
	define( $constpref . "CFG_MIDDLE_HEIGHT", "Hauteur de l'image affichée seule" );
	define( $constpref . "CFG_THUMB_WIDTH", "Largeur de la miniature" );
	define( $constpref . "CFG_THUMB_HEIGHT", "Hauteur de la miniature" );

	define( $constpref . "CFG_APIKEY", "Clé API Google" );
	define( $constpref . "CFG_APIKEY_DSC", 'Pour obtenir votre clé Google :<br><a href="http://www.google.com/apis/maps/signup.html" target="_blank">Google Maps API</a><br><br>Les paramètres disponibles sont détaillés sur cette page :<br><a href="http://www.google.com/apis/maps/documentation/reference.html" target="_blank">Google Maps API Reference</a>' );
	define( $constpref . "CFG_LATITUDE", "Latitude" );
	define( $constpref . "CFG_LONGITUDE", "Longitude" );
	define( $constpref . "CFG_ZOOM", "Niveau de zoom" );

	define( $constpref . "CFG_USE_POPBOX", "Utiliser la PopBox" );

	define( $constpref . "CFG_INDEX_DESC", "Texte d'introduction <br>(page d'accueil du module)" );
	define( $constpref . "CFG_INDEX_DESC_DEFAULT", "Message d'introduction placé en page d'accueil du module.<br>Il peut être édité depuis les Prférences du module" );

// Sub menu titles
	define( $constpref . "SMNAME_SUBMIT", "Envoyer" );
	define( $constpref . "SMNAME_POPULAR", "Populaire" );
	define( $constpref . "SMNAME_HIGHRATE", "Les mieux notées" );
	define( $constpref . "SMNAME_MYPHOTO", "Mes photos" );

// Names of admin menu items
	define( $constpref . "ADMENU_PHOTOMANAGER", "Gestion des photos" );
	define( $constpref . "ADMENU_CATMANAGER", "Gestion des Catégories" );
	define( $constpref . "ADMENU_CHECKCONFIGS", "Configuration" );
	define( $constpref . "ADMENU_BATCH", "Batch" );
	define( $constpref . "ADMENU_GROUPPERM", "Permissions globales" );
	define( $constpref . "ADMENU_IMPORT", "Import images" );
	define( $constpref . "ADMENU_EXPORT", "Export images" );

	define( $constpref . "ADMENU_GICONMANAGER", "Gestion des icônes Google" );
	define( $constpref . "ADMENU_MIMETYPES", "Gestion des MIME Type" );
	define( $constpref . "ADMENU_IMPORT_MYALBUM", "Import depuis myAlbum" );
	define( $constpref . "ADMENU_CHECKTABLES", "Vérification des tables" );
	define( $constpref . "ADMENU_PHOTO_TABLE_MANAGE", "Détails des photos" );
	define( $constpref . "ADMENU_CAT_TABLE_MANAGE", "Détails des Catégories" );
	define( $constpref . "ADMENU_VOTE_TABLE_MANAGE", "Détails des votes" );
	define( $constpref . "ADMENU_GICON_TABLE_MANAGE", "Détails des icônes Google" );
	define( $constpref . "ADMENU_MIME_TABLE_MANAGE", "Détails des MIMETYPES" );
	define( $constpref . "ADMENU_TAG_TABLE_MANAGE", "Détails des Tags" );
	define( $constpref . "ADMENU_P2T_TABLE_MANAGE", "Détails des Tags-photos" );
	define( $constpref . "ADMENU_SYNO_TABLE_MANAGE", "Détails des synonymes" );

//---------------------------------------------------------
// v0.20
//---------------------------------------------------------
	define( $constpref . "CFG_USE_FFMPEG", "Utiliser ffmpeg" );
	define( $constpref . "CFG_FFMPEGPATH", "Chemin d'accès à ffmpeg" );
	define( $constpref . "CFG_DESCFFMPEGPATH", "Bien que le chemin d'accès à ffmpeg puisse être précisé, aucune information n'est en principe requise." );
	define( $constpref . "CFG_USE_PATHINFO", "Utiliser le chemin d'accès" );

//---------------------------------------------------------
// v0.30
//---------------------------------------------------------
	define( $constpref . "CFG_MAIL_HOST", "Nom du serveur d'e-mails" );
	define( $constpref . "CFG_MAIL_USER", "ID de l'e-mail utilisateur" );
	define( $constpref . "CFG_MAIL_PASS", "Mot de passe de l'e-mail" );
	define( $constpref . "CFG_MAIL_ADDR", "Adresse e-mail" );
	define( $constpref . "CFG_MAIL_CHARSET", "Charset de l'e-mail" );
	define( $constpref . "CFG_MAIL_CHARSET_DSC", "Indiquez les Charsets séparés par '|'.<br>Si vous ne souhaitez pas vérifier par MIMETYPE, laisser vide" );
	define( $constpref . "CFG_MAIL_CHARSET_LIST", "ISO-8859-1|US-ASCII" );
	define( $constpref . "CFG_FILE_DIR", "Chemin d'accès aux fichier par FTP" );
	define( $constpref . "CFG_FILE_DIR_DSC", "Saisir le chemin complet (le premier caractère doit être '/' et le dernier ne doit pas être '/'). Il est recommande de placer ce dossier hors accès web (zone sécurisée du serveur)." );
	define( $constpref . "CFG_FILE_SIZE", "Poids maximual des fichiers transférés par FTP (bytes)" );
	define( $constpref . "CFG_FILE_DESC", "Aide mémoirte à propor du FTP" );
	define( $constpref . "CFG_FILE_DESC_DSC", "Informations affichées dans la section Aide et accessibles aux Groupes disposant de la permission d'utiliser la fonction FTP" );
	define( $constpref . "CFG_FILE_DESC_TEXT", "
<b>Serveur FTP</b><br>
Nom du serveur: xxx<br>
Login: xxx<br>
Mot de passe: xxx<br>" );

	define( $constpref . "ADMENU_MAILLOG_MANAGER", "Gestion des e-mailings" );
	define( $constpref . "ADMENU_MAILLOG_TABLE_MANAGE", "Détails des log e-mailing" );
	define( $constpref . "ADMENU_USER_TABLE_MANAGE", "Détails des Utilisateur Aux" );

//---------------------------------------------------------
// v0.40
//---------------------------------------------------------
	define( $constpref . "CFG_BIN_PASS", "Mot de passe Commande" );
	define( $constpref . "CFG_COM_DIRNAME", "Intégration des commentaires : nom du répertoire de D3Forum" );
	define( $constpref . "CFG_COM_FORUM_ID", "Intégration des commantaires : ID du forum" );
	define( $constpref . "CFG_COM_VIEW", "Apparence des commentaires intégrés" );

	define( $constpref . "ADMENU_UPDATE", "Mettre à jour" );
	define( $constpref . "ADMENU_ITEM_TABLE_MANAGE", "Gestion des medias" );
	define( $constpref . "ADMENU_FILE_TABLE_MANAGE", "Gestion des fichiers" );

//---------------------------------------------------------
// v0.50
//---------------------------------------------------------
	define( $constpref . "CFG_UPLOADSPATH", "Chemin d'accès aux fichiers téléversés" );
	define( $constpref . "CFG_UPLOADSPATH_DSC", "Chemin d'accès au répertoire depuis la racine du site<br>(le premier caractères doit être '/' et le dernier ne doit pas être '/'). Le répertoire doit être CHMODé en 777 ou 707." );
	define( $constpref . "CFG_MEDIASPATH", "Chemin d'accès aux médias" );
	define( $constpref . "CFG_MEDIASPATH_DSC", "Le répertoire où sont placés les fichiers constituant les playlists.<br>Chemin d'accès au répertoire depuis la racine du site<br>(le premier caractères doit être '/' et le dernier ne doit pas être '/')" );
	define( $constpref . "CFG_LOGO_WIDTH", "Dimensions du logo du lecteur (largeur et hauteur)" );
	define( $constpref . "CFG_USE_CALLBACK", "Activer le rapport (callback)" );
	define( $constpref . "CFG_USE_CALLBACK_DSC", "Consigner les actions du Player Flash (callback)." );

	define( $constpref . "ADMENU_ITEM_MANAGER", "Gestion des éléments" );
	define( $constpref . "ADMENU_PLAYER_MANAGER", "Gestion des lecteurs" );
	define( $constpref . "ADMENU_FLASHVAR_MANAGER", "Gestion des Flashvar" );
	define( $constpref . "ADMENU_PLAYER_TABLE_MANAGE", "Gestion des lecteurs" );
	define( $constpref . "ADMENU_FLASHVAR_TABLE_MANAGE", "Gestion des Flashvar" );

//---------------------------------------------------------
// v0.60
//---------------------------------------------------------
	define( $constpref . "CFG_WORKDIR", "Chemin d'accès au répertoire de travail" );
	define( $constpref . "CFG_WORKDIR_DSC", "Saisir le chemin d'accès complet (le premier caractères doit être '/' et le dernier ne doit pas être '/'.)<br>Il est recommande de placer ce dossier hors accès web (zone sécurisée du serveur)." );
	define( $constpref . "CFG_CAT_WIDTH", "Largeur et hauteur de l'image de la catégorie" );
	define( $constpref . "CFG_CSUB_WIDTH", "Largeur et hauteur de l'image de la sous-catégorie" );
	define( $constpref . "CFG_GICON_WIDTH", "Largeur et hauteur de l'icône Googlemap " );
	define( $constpref . "CFG_JPEG_QUALITY", "Taux de compression JPEG" );
	define( $constpref . "CFG_JPEG_QUALITY_DSC", "1 - 100 <br>Ce paramètre n'est efficient qu'à la condition d'utiliser la librairie GD" );

//---------------------------------------------------------
// v0.80
//---------------------------------------------------------
	define( $constpref . "BNAME_CATLIST", "List des Catégories" );
	define( $constpref . "BNAME_TAGCLOUD", "Nuage de tags" );

//---------------------------------------------------------
// v0.90
//---------------------------------------------------------
	define( $constpref . "CFG_PERM_CAT_READ", "Permissions de la Catégorie" );
	define( $constpref . "CFG_PERM_CAT_READ_DSC", "A activer depuis la rubrique Gestion des Catégories" );
	define( $constpref . "CFG_PERM_ITEM_READ", "Permissions des éléments" );
	define( $constpref . "CFG_PERM_ITEM_READ_DSC", "A activer depuis la rubrique Gestion des médias" );
	define( $constpref . "OPT_PERM_READ_ALL", "Tout afficher" );
	define( $constpref . "OPT_PERM_READ_NO_ITEM", "Ne pas afficher les médias" );
	define( $constpref . "OPT_PERM_READ_NO_CAT", "Ne pas afficher les médias et les catégories" );

//---------------------------------------------------------
// v1.10
//---------------------------------------------------------
	define( $constpref . "CFG_USE_XPDF", "Utiliser xpdf" );
	define( $constpref . "CFG_XPDFPATH", "Chemin d'accès à xpdf" );
	define( $constpref . "CFG_XPDFPATH_DSC", "Bien que le chemin d'accès puisse être renseigné, laisser vide ce champ fonctionne avec la plupart des environnements.<br>Ce paramètre n'est efficient qu'à la condition d'utiliser xpdf" );

//---------------------------------------------------------
// v1.21
//---------------------------------------------------------
	define( $constpref . "ADMENU_RSS_MANAGER", "Gestion des RSS" );

//---------------------------------------------------------
// v1.30
//---------------------------------------------------------
	define( $constpref . "CFG_SMALL_WIDTH", "Largeur des images dans la Chronologie" );
	define( $constpref . "CFG_SMALL_HEIGHT", "Hauteur des images dans la Chronologie" );
	define( $constpref . "CFG_TIMELINE_DIRNAME", "Nom du dossier de la Chronologie" );
	define( $constpref . "CFG_TIMELINE_DIRNAME_DSC", "Indiquer le nom de dossier du module de chronologie" );
	define( $constpref . "CFG_TIMELINE_SCALE", "Echelle de la Chronologie" );
	define( $constpref . "CFG_TIMELINE_SCALE_DSC", "Echelle de temps répartie sur 600 pixels" );
	define( $constpref . "OPT_TIMELINE_SCALE_WEEK", "1 semaine" );
	define( $constpref . "OPT_TIMELINE_SCALE_MONTH", "1 mois" );
	define( $constpref . "OPT_TIMELINE_SCALE_YEAR", "1 an" );
	define( $constpref . "OPT_TIMELINE_SCALE_DECADE", "10 ans" );

//---------------------------------------------------------
// v1.40
//---------------------------------------------------------
// timeline
	define( $constpref . "CFG_TIMELINE_LATEST", "Nombre de photos dans le calendrier" );
	define( $constpref . "CFG_TIMELINE_RANDOM", "Nombre de photos aléatoire dans le calendrier" );
	define( $constpref . "BNAME_TIMELINE", "Timeline" );

// map, tag
	define( $constpref . "CFG_GMAP_PHOTOS", "Nombre de photos sur la carte" );
	define( $constpref . "CFG_TAGS", "Nombre de balises dans tagcloud" );

//---------------------------------------------------------
// v1.70
//---------------------------------------------------------
	define( $constpref . "CFG_ITEM_SUMMARY", "Max characters of photo description" );
	define( $constpref . "CFG_ITEM_SUMMARY_DSC", "Enter the maximum number of characters of photo description in the photo list.<br>-1 is unlimited" );
	define( $constpref . "CFG_CAT_SUMMARY", "Max characters of category description" );
	define( $constpref . "CFG_CAT_SUMMARY_DSC", "Enter the maximum number of characters of category description in the category list.<br>-1 is unlimited" );
	define( $constpref . "CFG_CAT_CHILD", "Show photos of subcategoies" );
	define( $constpref . "CFG_CAT_CHILD_DSC", "Enter to show or not photos of subcategoies in category list" );
	define( $constpref . "OPT_CAT_CHILD_NON", "Photo Video Media of this category only. Not show photos of subcategoies" );
	define( $constpref . "OPT_CAT_CHILD_EMPTY", "When no photo in this category, show photos of subcategoies" );
	define( $constpref . "OPT_CAT_CHILD_ALWAYS", "Show alwayas photos of subcategoies" );

//---------------------------------------------------------
// v1.80
//---------------------------------------------------------
	define( $constpref . "CFG_USE_LAME", "Use lame" );
	define( $constpref . "CFG_LAMEPATH", "Path to lame" );
	define( $constpref . "CFG_LAMEPATH_DSC", "Alhough the full path to 'lame' should be written, leave it blank in most environments.<br>This configuration is significant only when using lame" );

	define( $constpref . "CFG_USE_TIMIDITY", "Use timidity" );
	define( $constpref . "CFG_TIMIDITYPATH", "Path to timidity" );
	define( $constpref . "CFG_TIMIDITYPATH_DSC", "Alhough the full path to 'timidity' should be written, leave it blank in most environments.<br>This configuration is significant only when using timidity" );

	define( $constpref . "SMNAME_SEARCH", "Search" );

//---------------------------------------------------------
// v2.00
//---------------------------------------------------------
// config
	define( $constpref . "CFG_GROUPID_ADMIN", "Admin Group ID" );
	define( $constpref . "CFG_GROUPID_ADMIN_DSC", "The user group ID of the administrator of this module. <br>This value is set in module installation. <br>Don't change rashly. " );
	define( $constpref . "CFG_GROUPID_USER", "User Group ID" );
	define( $constpref . "CFG_GROUPID_USER_DSC", "The user group ID of the user of this module. <br>This value is set in module installation. <br>Don't change rashly. " );

// admin menu
	define( $constpref . "ADMENU_INVITE", "Invite a friend" );

// notifications
	define( $constpref . "GLOBAL_WAITING_NOTIFY", "Waiting Approval" );
	define( $constpref . "GLOBAL_WAITING_NOTIFYCAP", "Notify me when any new photos waiting approval are posted (Admin)" );
	define( $constpref . "GLOBAL_WAITING_NOTIFYDSC", "Notify me when any new photos waiting approval are posted" );
	define( $constpref . "GLOBAL_WAITING_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE}: auto-notify : Waiting Approval" );

//---------------------------------------------------------
// v2.10
//---------------------------------------------------------
	define( $constpref . "CFG_USE_LIGHTBOX", "Use LightBox" );

//---------------------------------------------------------
// v2.11
//---------------------------------------------------------
	define( $constpref . "ADMENU_REDOTHUMBS", "Rebuild Thumbnails" );

//---------------------------------------------------------
// v2.20
//---------------------------------------------------------
	define( $constpref . "CFG_EMBED_WIDTH", "Screen width of video site" );
	define( $constpref . "CFG_EMBED_HEIGHT", "Screen height of video site" );

//---------------------------------------------------------
// v2.40
//---------------------------------------------------------
	define( $constpref . "CFG_PEAR_PATH", 'Path of PEAR libraly' );
	define( $constpref . "CFG_PEAR_PATH_DSC", 'Enter the absolute path in the PEAR library with Net_POP3.<br>When not enter, modules/webphoto/PEAR is used.' );

//---------------------------------------------------------
// v2.60
//---------------------------------------------------------
	define( $constpref . "OPT_TIMELINE_SCALE_HOUR", "Hour" );
	define( $constpref . "OPT_TIMELINE_SCALE_DAY", "Day" );
	define( $constpref . "OPT_TIMELINE_SCALE_CENTURY", "Century" );
	define( $constpref . "OPT_TIMELINE_SCALE_MILLENNIUM", "Millennium" );
}
// === define begin ===
