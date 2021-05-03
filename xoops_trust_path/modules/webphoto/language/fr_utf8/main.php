<?php
// === define begin ===
if ( ! defined( "_MB_WEBPHOTO_LANG_LOADED" ) ) {

	define( "_MB_WEBPHOTO_LANG_LOADED", 1 );

//=========================================================
// base on myalbum
//=========================================================

	define( "_WEBPHOTO_CATEGORY", "Catégorie" );
	define( "_WEBPHOTO_SUBMITTER", "Proposé par" );
	define( "_WEBPHOTO_NOMATCH_PHOTO", "Aucun media ne correspond à votre recherche" );

	define( "_WEBPHOTO_ICON_NEW", "Nouveau" );
	define( "_WEBPHOTO_ICON_UPDATE", "Mise à jour" );
	define( "_WEBPHOTO_ICON_POPULAR", "Populaire" );
	define( "_WEBPHOTO_ICON_LASTUPDATE", "Dernière mise à jour" );
	define( "_WEBPHOTO_ICON_HITS", "Affichages" );
	define( "_WEBPHOTO_ICON_COMMENTS", "Commentaires" );

	define( "_WEBPHOTO_SORT_IDA", "Numéro d'enregistrement (classement par ID croissant)" );
	define( "_WEBPHOTO_SORT_IDD", "Numéro d'enregistrement (classement par ID décroissant)" );
	define( "_WEBPHOTO_SORT_HITSA", "Popularité (ordre croissant)" );
	define( "_WEBPHOTO_SORT_HITSD", "Popularité (ordre décroissant)" );
	define( "_WEBPHOTO_SORT_TITLEA", "Titre (ordre alphabétique)" );
	define( "_WEBPHOTO_SORT_TITLED", "Titre (ordre ante alphabétique))" );
	define( "_WEBPHOTO_SORT_DATEA", "Date de mise à jour (ordre chronologique)" );
	define( "_WEBPHOTO_SORT_DATED", "Date de mise à jour (ordre ante chronologique)" );
	define( "_WEBPHOTO_SORT_RATINGA", "Note (des plus basses aux plus hautes)" );
	define( "_WEBPHOTO_SORT_RATINGD", "Note (des plus hautes aux plus basses)" );
	define( "_WEBPHOTO_SORT_RANDOM", "Au hasard" );

	define( "_WEBPHOTO_SORT_SORTBY", "Trié par :" );
	define( "_WEBPHOTO_SORT_TITLE", "Titre" );
	define( "_WEBPHOTO_SORT_DATE", "Date de mise à jour" );
	define( "_WEBPHOTO_SORT_HITS", "Popularité" );
	define( "_WEBPHOTO_SORT_RATING", "Note" );
	define( "_WEBPHOTO_SORT_S_CURSORTEDBY", "Elements actuellement classés par : %s" );

	define( "_WEBPHOTO_NAVI_PREVIOUS", "Précédent" );
	define( "_WEBPHOTO_NAVI_NEXT", "Suivant" );
	define( "_WEBPHOTO_S_NAVINFO", "Photo No. %s - %s (de %s affichages)" );
	define( "_WEBPHOTO_S_THEREARE", "Il y a actuellement <b>%s</b> images dans notre base de données." );
	define( "_WEBPHOTO_S_MOREPHOTOS", "Plus de photos de %s" );
	define( "_WEBPHOTO_ONEVOTE", "1 vote" );
	define( "_WEBPHOTO_S_NUMVOTES", "%s votes" );
	define( "_WEBPHOTO_ONEPOST", "1 commentaire" );
	define( "_WEBPHOTO_S_NUMPOSTS", "%s commentaires" );
	define( "_WEBPHOTO_VOTETHIS", "Voter" );
	define( "_WEBPHOTO_TELLAFRIEND", "En parler à un(e) ami(e)" );
	define( "_WEBPHOTO_SUBJECT4TAF", "Une photo pour vous !" );

//---------------------------------------------------------
// submit
//---------------------------------------------------------
// only "Y/m/d" , "d M Y" , "M d Y" can be interpreted
	define( "_WEBPHOTO_DTFMT_YMDHI", "d M Y H:i" );

	define( "_WEBPHOTO_TITLE_ADDPHOTO", "Ajouter une photo" );
	define( "_WEBPHOTO_TITLE_PHOTOUPLOAD", "Envoyer une photo" );
	define( "_WEBPHOTO_CAP_MAXPIXEL", "Taille maximale (pixels)" );
	define( "_WEBPHOTO_CAP_MAXSIZE", "Poids maximal (bytes)" );
	define( "_WEBPHOTO_CAP_VALIDPHOTO", "Valider" );
	define( "_WEBPHOTO_DSC_TITLE_BLANK", "Laisser le champ vide pour utiliser le nom du fichier en tant que titre" );

	define( "_WEBPHOTO_RADIO_ROTATETITLE", "Rotation de l'image" );
	define( "_WEBPHOTO_RADIO_ROTATE0", "Ne pas pivoter" );
	define( "_WEBPHOTO_RADIO_ROTATE90", "90° vers la droite" );
	define( "_WEBPHOTO_RADIO_ROTATE180", "180°" );
	define( "_WEBPHOTO_RADIO_ROTATE270", "90° vers la gauche" );

	define( "_WEBPHOTO_SUBMIT_RECEIVED", "Votre image est téléversée. Merci !" );
	define( "_WEBPHOTO_SUBMIT_ALLPENDING", "Toutes les photos proposées sont vérifiées avant publication." );

	define( "_WEBPHOTO_ERR_MUSTREGFIRST", "Désolé, vous ne disposez pas des permissions requises pour cette action.<br>Veuillez vous identifier ou créer un compte." );
	define( "_WEBPHOTO_ERR_MUSTADDCATFIRST", "Désolé, aucune Catégorie n'est disponible.<br>Créer d'abord une Catégorie" );
	define( "_WEBPHOTO_ERR_NOIMAGESPECIFIED", "Aucune photo n'a été téléversée" );
	define( "_WEBPHOTO_ERR_FILE", "Les photos sont trop volumineuses ou un problème de configuration est survenu" );
	define( "_WEBPHOTO_ERR_FILEREAD", "Les photos ne sont pas accessibles." );
	define( "_WEBPHOTO_ERR_TITLE", "Saisir un 'Titre' " );

//---------------------------------------------------------
// edit
//---------------------------------------------------------
	define( "_WEBPHOTO_TITLE_EDIT", "Modifier une photo" );
	define( "_WEBPHOTO_TITLE_PHOTODEL", "Supprimer une photo" );
	define( "_WEBPHOTO_CONFIRM_PHOTODEL", "Supprimer la photo ?" );
	define( "_WEBPHOTO_DBUPDATED", "Mise à jour de la Base de données effectuée avec succès !" );
	define( "_WEBPHOTO_DELETED", "Supprimée !" );

//---------------------------------------------------------
// rate
//---------------------------------------------------------
	define( "_WEBPHOTO_RATE_VOTEONCE", "Please do not vote for the same resource more than once." );
	define( "_WEBPHOTO_RATE_RATINGSCALE", "The scale is 1 - 10, with 1 being poor and 10 being excellent." );
	define( "_WEBPHOTO_RATE_BEOBJECTIVE", "Please be objective, if everyone receives a 1 or a 10, the ratings aren't very useful." );
	define( "_WEBPHOTO_RATE_DONOTVOTE", "Do not vote for your own resource." );
	define( "_WEBPHOTO_RATE_IT", "Rate It!" );
	define( "_WEBPHOTO_RATE_VOTEAPPRE", "Your vote is appreciated." );
	define( "_WEBPHOTO_RATE_S_THANKURATE", "Thank you for taking the time to rate photo video media here at %s." );

	define( "_WEBPHOTO_ERR_NORATING", "No rating selected." );
	define( "_WEBPHOTO_ERR_CANTVOTEOWN", "You cannot vote on the resource you submitted.<br>All votes are logged and reviewed." );
	define( "_WEBPHOTO_ERR_VOTEONCE", "Vote for the selected resource only once.<br>All votes are logged and reviewed." );

//---------------------------------------------------------
// move from myalbum_constants.php
//---------------------------------------------------------
// Caption
	define( "_WEBPHOTO_CAPTION_TOTAL", "Total:" );
	define( "_WEBPHOTO_CAPTION_GUESTNAME", "Invité" );
	define( "_WEBPHOTO_CAPTION_REFRESH", "Rafraîchir" );
	define( "_WEBPHOTO_CAPTION_IMAGEXYT", "Dimensions (type)" );
	define( "_WEBPHOTO_CAPTION_CATEGORY", "Catégorie" );

//=========================================================
// add for webphoto
//=========================================================

//---------------------------------------------------------
// database table items
//---------------------------------------------------------

// photo table
	define( "_WEBPHOTO_PHOTO_TABLE", "Tableau des photos" );
	define( "_WEBPHOTO_PHOTO_ID", "ID de la photo" );
	define( "_WEBPHOTO_PHOTO_TIME_CREATE", "Date de création" );
	define( "_WEBPHOTO_PHOTO_TIME_UPDATE", "Date de mise à jour" );
	define( "_WEBPHOTO_PHOTO_CAT_ID", "ID de la Catégorie" );
	define( "_WEBPHOTO_PHOTO_GICON_ID", "ID de la vignette" );
	define( "_WEBPHOTO_PHOTO_UID", "ID de l'utilisateur" );
	define( "_WEBPHOTO_PHOTO_DATETIME", "Date de la photo" );
	define( "_WEBPHOTO_PHOTO_TITLE", "Titre de la photo" );
	define( "_WEBPHOTO_PHOTO_PLACE", "Localisation" );
	define( "_WEBPHOTO_PHOTO_EQUIPMENT", "Equipement" );
	define( "_WEBPHOTO_PHOTO_FILE_URL", "Url du fichier" );
	define( "_WEBPHOTO_PHOTO_FILE_PATH", "Chemin d'accès au fichier" );
	define( "_WEBPHOTO_PHOTO_FILE_NAME", "Nom du fichier" );
	define( "_WEBPHOTO_PHOTO_FILE_EXT", "Extension du fichier" );
	define( "_WEBPHOTO_PHOTO_FILE_MIME", "MIME TYPE du fichier" );
	define( "_WEBPHOTO_PHOTO_FILE_MEDIUM", "Type de format du fichier" );
	define( "_WEBPHOTO_PHOTO_FILE_SIZE", "Taille du fichier" );
	define( "_WEBPHOTO_PHOTO_CONT_URL", "Url de la photo" );
	define( "_WEBPHOTO_PHOTO_CONT_PATH", "Chemin d'accès à la photo" );
	define( "_WEBPHOTO_PHOTO_CONT_NAME", "Nom de la photo" );
	define( "_WEBPHOTO_PHOTO_CONT_EXT", "Extension de la photo" );
	define( "_WEBPHOTO_PHOTO_CONT_MIME", "MIME TYPE de la photo" );
	define( "_WEBPHOTO_PHOTO_CONT_MEDIUM", "Type de format de la photo" );
	define( "_WEBPHOTO_PHOTO_CONT_SIZE", "Taille de la photo" );
	define( "_WEBPHOTO_PHOTO_CONT_WIDTH", "Largeur de la photo" );
	define( "_WEBPHOTO_PHOTO_CONT_HEIGHT", "Hauteur de la photo" );
	define( "_WEBPHOTO_PHOTO_CONT_DURATION", "Durée de la vidéo" );
	define( "_WEBPHOTO_PHOTO_CONT_EXIF", "Information Exif" );
	define( "_WEBPHOTO_PHOTO_MIDDLE_WIDTH", "Largeur moyenne de l'image" );
	define( "_WEBPHOTO_PHOTO_MIDDLE_HEIGHT", "Hauteur moyenne de l'image" );
	define( "_WEBPHOTO_PHOTO_THUMB_URL", "Url de la miniature" );
	define( "_WEBPHOTO_PHOTO_THUMB_PATH", "Chemin d'accès à la miniature" );
	define( "_WEBPHOTO_PHOTO_THUMB_NAME", "Nom de la miniature" );
	define( "_WEBPHOTO_PHOTO_THUMB_EXT", "Extension de la miniature" );
	define( "_WEBPHOTO_PHOTO_THUMB_MIME", "MIME TYPE de la miniature" );
	define( "_WEBPHOTO_PHOTO_THUMB_MEDIUM", "Type de format de la miniature" );
	define( "_WEBPHOTO_PHOTO_THUMB_SIZE", "Taille de la miniature" );
	define( "_WEBPHOTO_PHOTO_THUMB_WIDTH", "Largeur de la miniature" );
	define( "_WEBPHOTO_PHOTO_THUMB_HEIGHT", "Hauteur de la miniature" );
	define( "_WEBPHOTO_PHOTO_GMAP_LATITUDE", "Latitude de la carte Googlemap" );
	define( "_WEBPHOTO_PHOTO_GMAP_LONGITUDE", "Longitude de la carte Googlemap" );
	define( "_WEBPHOTO_PHOTO_GMAP_ZOOM", "Pourcentage du zoom" );
	define( "_WEBPHOTO_PHOTO_GMAP_TYPE", "Type de carte" );
	define( "_WEBPHOTO_PHOTO_PERM_READ", "Permission de consulter" );
	define( "_WEBPHOTO_PHOTO_STATUS", "Statut" );
	define( "_WEBPHOTO_PHOTO_HITS", "Affichages" );
	define( "_WEBPHOTO_PHOTO_RATING", "Notes" );
	define( "_WEBPHOTO_PHOTO_VOTES", "Votes" );
	define( "_WEBPHOTO_PHOTO_COMMENTS", "Commentaires" );
	define( "_WEBPHOTO_PHOTO_TEXT1", "texte1" );
	define( "_WEBPHOTO_PHOTO_TEXT2", "texte2" );
	define( "_WEBPHOTO_PHOTO_TEXT3", "texte3" );
	define( "_WEBPHOTO_PHOTO_TEXT4", "texte4" );
	define( "_WEBPHOTO_PHOTO_TEXT5", "texte5" );
	define( "_WEBPHOTO_PHOTO_TEXT6", "texte6" );
	define( "_WEBPHOTO_PHOTO_TEXT7", "texte7" );
	define( "_WEBPHOTO_PHOTO_TEXT8", "texte8" );
	define( "_WEBPHOTO_PHOTO_TEXT9", "texte9" );
	define( "_WEBPHOTO_PHOTO_TEXT10", "texte10" );
	define( "_WEBPHOTO_PHOTO_DESCRIPTION", "Description de la photo" );
	define( "_WEBPHOTO_PHOTO_SEARCH", "Rechercher" );

// category table
	define( "_WEBPHOTO_CAT_TABLE", "Tableau des Catégories" );
	define( "_WEBPHOTO_CAT_ID", "ID de la Catégorie" );
	define( "_WEBPHOTO_CAT_TIME_CREATE", "Date de création" );
	define( "_WEBPHOTO_CAT_TIME_UPDATE", "Date de mise à jour" );
	define( "_WEBPHOTO_CAT_GICON_ID", "ID de la vignette" );
	define( "_WEBPHOTO_CAT_FORUM_ID", "ID du forum" );
	define( "_WEBPHOTO_CAT_PID", "ID associé" );
	define( "_WEBPHOTO_CAT_TITLE", "Titre de la Catégorie" );
	define( "_WEBPHOTO_CAT_IMG_PATH", "Chemin d'accès à l'image de la Catégorie" );
	define( "_WEBPHOTO_CAT_IMG_MODE", "Mode d'affichage de l'image" );
	define( "_WEBPHOTO_CAT_ORIG_WIDTH", "Largeur originale de l'image" );
	define( "_WEBPHOTO_CAT_ORIG_HEIGHT", "Hauteur originale de l'image" );
	define( "_WEBPHOTO_CAT_MAIN_WIDTH", "Largeur de l'image dans la Catégorie principale" );
	define( "_WEBPHOTO_CAT_MAIN_HEIGHT", "Hauteur de l'image dans la Catégorie principale" );
	define( "_WEBPHOTO_CAT_SUB_WIDTH", "Largeur de l'image dans la sous-catégorie" );
	define( "_WEBPHOTO_CAT_SUB_HEIGHT", "Hauteur de l'image dans la sous-catégorie" );
	define( "_WEBPHOTO_CAT_WEIGHT", "Poids" );
	define( "_WEBPHOTO_CAT_DEPTH", "Profondeur" );
	define( "_WEBPHOTO_CAT_ALLOWED_EXT", "Extensions autorisées" );
	define( "_WEBPHOTO_CAT_ITEM_TYPE", "Type de données" );
	define( "_WEBPHOTO_CAT_GMAP_MODE", "Mode d'affichage de la carte Googlemap" );
	define( "_WEBPHOTO_CAT_GMAP_LATITUDE", "Latitude de la carte" );
	define( "_WEBPHOTO_CAT_GMAP_LONGITUDE", "Longitude de la carte" );
	define( "_WEBPHOTO_CAT_GMAP_ZOOM", "Pourcentage du zoom" );
	define( "_WEBPHOTO_CAT_GMAP_TYPE", "Type de carte" );
	define( "_WEBPHOTO_CAT_PERM_READ", "Permission de consulter" );
	define( "_WEBPHOTO_CAT_PERM_POST", "Permission de proposer" );
	define( "_WEBPHOTO_CAT_TEXT1", "texte1" );
	define( "_WEBPHOTO_CAT_TEXT2", "texte2" );
	define( "_WEBPHOTO_CAT_TEXT3", "texte3" );
	define( "_WEBPHOTO_CAT_TEXT4", "texte4" );
	define( "_WEBPHOTO_CAT_TEXT5", "texte5" );
	define( "_WEBPHOTO_CAT_DESCRIPTION", "Description de la Catégorie" );

// vote table
	define( "_WEBPHOTO_VOTE_TABLE", "Table des votes" );
	define( "_WEBPHOTO_VOTE_ID", "ID du vote" );
	define( "_WEBPHOTO_VOTE_TIME_CREATE", "Date du vote" );
	define( "_WEBPHOTO_VOTE_TIME_UPDATE", "Mise à jour du vote" );
	define( "_WEBPHOTO_VOTE_PHOTO_ID", "ID de la photo" );
	define( "_WEBPHOTO_VOTE_UID", "ID de l'utilisateur" );
	define( "_WEBPHOTO_VOTE_RATING", "Notes" );
	define( "_WEBPHOTO_VOTE_HOSTNAME", "Adresse IP" );

// google icon table
	define( "_WEBPHOTO_GICON_TABLE", "Tableau des icônes Google" );
	define( "_WEBPHOTO_GICON_ID", "ID de l'icône" );
	define( "_WEBPHOTO_GICON_TIME_CREATE", "Date de création" );
	define( "_WEBPHOTO_GICON_TIME_UPDATE", "Date de mise à jour" );
	define( "_WEBPHOTO_GICON_TITLE", "Titre de l'icône" );
	define( "_WEBPHOTO_GICON_IMAGE_PATH", "Chemin d'accès à l'icône" );
	define( "_WEBPHOTO_GICON_IMAGE_NAME", "Nom de l'image" );
	define( "_WEBPHOTO_GICON_IMAGE_EXT", "Extention de l'image" );
	define( "_WEBPHOTO_GICON_SHADOW_PATH", "Chemin d'accès masqué" );
	define( "_WEBPHOTO_GICON_SHADOW_NAME", "Nom caché" );
	define( "_WEBPHOTO_GICON_SHADOW_EXT", "Extension cachée" );
	define( "_WEBPHOTO_GICON_IMAGE_WIDTH", "Largeur de l'image" );
	define( "_WEBPHOTO_GICON_IMAGE_HEIGHT", "Hauteur de l'image" );
	define( "_WEBPHOTO_GICON_SHADOW_WIDTH", "Largeur de l'ombre" );
	define( "_WEBPHOTO_GICON_SHADOW_HEIGHT", "Hauteur de l'ombre" );
	define( "_WEBPHOTO_GICON_ANCHOR_X", "Point d'ancrage sur X" );
	define( "_WEBPHOTO_GICON_ANCHOR_Y", "Point d'ancrage sur Y" );
	define( "_WEBPHOTO_GICON_INFO_X", "Largeur de la fenêtre d'information" );
	define( "_WEBPHOTO_GICON_INFO_Y", "Hauteur de la fenêtre d'information" );

// mime type table
	define( "_WEBPHOTO_MIME_TABLE", "Tableau des MIME TYPES" );
	define( "_WEBPHOTO_MIME_ID", "ID du MIME TYPE" );
	define( "_WEBPHOTO_MIME_TIME_CREATE", "Date de création" );
	define( "_WEBPHOTO_MIME_TIME_UPDATE", "Date de mise à jour" );
	define( "_WEBPHOTO_MIME_EXT", "Extension" );
	define( "_WEBPHOTO_MIME_MEDIUM", "Format" );
	define( "_WEBPHOTO_MIME_TYPE", "MIME Type" );
	define( "_WEBPHOTO_MIME_NAME", "Nom du MIME TYPE" );
	define( "_WEBPHOTO_MIME_PERMS", "Permission" );

// added in v0.20
	define( "_WEBPHOTO_MIME_FFMPEG", "Option ffmpeg" );

// added in v1.80
	define( "_WEBPHOTO_MIME_KIND", "File Kind" );
	define( "_WEBPHOTO_MIME_OPTION", "Command Option" );

// tag table
	define( "_WEBPHOTO_TAG_TABLE", "Tableau des Tags" );
	define( "_WEBPHOTO_TAG_ID", "ID du tag" );
	define( "_WEBPHOTO_TAG_TIME_CREATE", "Date de création" );
	define( "_WEBPHOTO_TAG_TIME_UPDATE", "Date de mise à jour" );
	define( "_WEBPHOTO_TAG_NAME", "Nom du tag" );

// photo-to-tag table
	define( "_WEBPHOTO_P2T_TABLE", "Tableau de relation Photo / Tags" );
	define( "_WEBPHOTO_P2T_ID", "ID du Photo-tag" );
	define( "_WEBPHOTO_P2T_TIME_CREATE", "Date de création" );
	define( "_WEBPHOTO_P2T_TIME_UPDATE", "Date de mise à jour" );
	define( "_WEBPHOTO_P2T_PHOTO_ID", "ID de la photo" );
	define( "_WEBPHOTO_P2T_TAG_ID", "ID du tag" );
	define( "_WEBPHOTO_P2T_UID", "ID de l'utilisateur" );

// synonym table
	define( "_WEBPHOTO_SYNO_TABLE", "Table des synonymes" );
	define( "_WEBPHOTO_SYNO_ID", "ID du synonyme" );
	define( "_WEBPHOTO_SYNO_TIME_CREATE", "Date de création" );
	define( "_WEBPHOTO_SYNO_TIME_UPDATE", "Date de mise à jour" );
	define( "_WEBPHOTO_SYNO_WEIGHT", "Poids" );
	define( "_WEBPHOTO_SYNO_KEY", "Clé" );
	define( "_WEBPHOTO_SYNO_VALUE", "Synonyme" );

//---------------------------------------------------------
// title
//---------------------------------------------------------
	define( "_WEBPHOTO_TITLE_LATEST", "Les derniers" );
	define( "_WEBPHOTO_TITLE_SUBMIT", "Soumettre" );
	define( "_WEBPHOTO_TITLE_POPULAR", "Populaire" );
	define( "_WEBPHOTO_TITLE_HIGHRATE", "Les mieux notés" );
	define( "_WEBPHOTO_TITLE_MYPHOTO", "Mes photos" );
	define( "_WEBPHOTO_TITLE_RANDOM", "Photos au hasard" );
	define( "_WEBPHOTO_TITLE_HELP", "Aide" );
	define( "_WEBPHOTO_TITLE_CATEGORY_LIST", "Liste des Catégories" );
	define( "_WEBPHOTO_TITLE_TAG_LIST", "Liste des tags" );
	define( "_WEBPHOTO_TITLE_TAGS", "Tag" );
	define( "_WEBPHOTO_TITLE_USER_LIST", "Auteur de la liste" );
	define( "_WEBPHOTO_TITLE_DATE_LIST", "Date de la liste de photos" );
	define( "_WEBPHOTO_TITLE_PLACE_LIST", "Localisation de la liste de photos" );
	define( "_WEBPHOTO_TITLE_RSS", "RSS" );

	define( "_WEBPHOTO_VIEWTYPE_LIST", "Type de liste" );
	define( "_WEBPHOTO_VIEWTYPE_TABLE", "Tableau des types" );

	define( "_WEBPHOTO_CATLIST_ON", "Afficher la Catégorie" );
	define( "_WEBPHOTO_CATLIST_OFF", "Masquer la Catégorie" );
	define( "_WEBPHOTO_TAGCLOUD_ON", "Afficher le nuage de tags" );
	define( "_WEBPHOTO_TAGCLOUD_OFF", "Masquer le nuage de tags" );
	define( "_WEBPHOTO_GMAP_ON", "Afficher Googlemap" );
	define( "_WEBPHOTO_GMAP_OFF", "Masquer Googlemap" );

	define( "_WEBPHOTO_NO_TAG", "Ne pas entrer de tags" );

//---------------------------------------------------------
// google maps
//---------------------------------------------------------
	define( "_WEBPHOTO_TITLE_GET_LOCATION", "Paramètres de latitude et de longitude" );
	define( "_WEBPHOTO_GMAP_DESC", "Afficher la miniature au clic sur le marqueur de la carte" );
	define( "_WEBPHOTO_GMAP_ICON", "Icones Googlemap" );
	define( "_WEBPHOTO_GMAP_LATITUDE", "Latitude Googlemap" );
	define( "_WEBPHOTO_GMAP_LONGITUDE", "Longitude Googlemap" );
	define( "_WEBPHOTO_GMAP_ZOOM", "Zoom Googlemap" );
	define( "_WEBPHOTO_GMAP_ADDRESS", "Adresse" );
	define( "_WEBPHOTO_GMAP_GET_LOCATION", "Obtenir la latitude et la longitude" );
	define( "_WEBPHOTO_GMAP_SEARCH_LIST", "Liste de recherche" );
	define( "_WEBPHOTO_GMAP_CURRENT_LOCATION", "Localisation actuelle" );
	define( "_WEBPHOTO_GMAP_CURRENT_ADDRESS", "Adresse actuelle" );
	define( "_WEBPHOTO_GMAP_NO_MATCH_PLACE", "Aucun emplacement ne correspond" );
	define( "_WEBPHOTO_GMAP_NOT_COMPATIBLE", "Ne pas afficher Googlemap dans le navigateur" );
	define( "_WEBPHOTO_JS_INVALID", "Ne pas utiliser de Javascript dans le navigateur" );
	define( "_WEBPHOTO_IFRAME_NOT_SUPPORT", "Ne pas utiliser d'iframe dans le navigateur" );

//---------------------------------------------------------
// search
//---------------------------------------------------------
	define( "_WEBPHOTO_SR_SEARCH", "Rechercher" );

//---------------------------------------------------------
// popbox
//---------------------------------------------------------
	define( "_WEBPHOTO_POPBOX_REVERT", "Cliquer sur l'image pour développer" );

//---------------------------------------------------------
// tag
//---------------------------------------------------------
	define( "_WEBPHOTO_TAGS", "Tags" );
	define( "_WEBPHOTO_EDIT_TAG", "Modifier les Tags" );
	define( "_WEBPHOTO_DSC_TAG_DIVID", "séparez par une virgule (,) les tags que vous souhaitez utiliser" );
	define( "_WEBPHOTO_DSC_TAG_EDITABLE", "Vous êtes seulement autorisés à modifier vos propres tags" );

//---------------------------------------------------------
// submit form
//---------------------------------------------------------
	define( "_WEBPHOTO_CAP_ALLOWED_EXTS", "Extensions autorisées" );
	define( "_WEBPHOTO_CAP_PHOTO_SELECT", "Sélectionner l'image principale" );
	define( "_WEBPHOTO_CAP_THUMB_SELECT", "Sélectionner la miniature" );
	define( "_WEBPHOTO_DSC_THUMB_SELECT", "Créée depuis l'image principale lorsqu'aucune vignette n'est sélectionnée" );
	define( "_WEBPHOTO_DSC_SET_DATETIME", "Indiquez la date de la photo" );

	define( "_WEBPHOTO_DSC_PIXCEL_RESIZE", "Redimensionner automatiquement en cas de dépassement de la taille" );
	define( "_WEBPHOTO_DSC_PIXCEL_REJECT", "Téléversement impossible en cas de dépassement de la taille" );
	define( "_WEBPHOTO_BUTTON_CLEAR", "Effacer" );
	define( "_WEBPHOTO_SUBMIT_RESIZED", "Photo redimensionnée car dépassant les limites paramétrées" );

// PHP upload error
// http://www.php.net/manual/en/features.file-upload.errors.php
	define( "_WEBPHOTO_PHP_UPLOAD_ERR_OK", "Aucune erreur, le fichier a été téléversé avec succès." );
	define( "_WEBPHOTO_PHP_UPLOAD_ERR_INI_SIZE", "Les fichiers téléversés dépassent la limite de la configuration (upload_max_filesize)." );
	define( "_WEBPHOTO_PHP_UPLOAD_ERR_FORM_SIZE", "Le fichier téléversé dépasse la limite de %s ." );
	define( "_WEBPHOTO_PHP_UPLOAD_ERR_PARTIAL", "Le téléversement a été partiellement effectué" );
	define( "_WEBPHOTO_PHP_UPLOAD_ERR_NO_FILE", "Aucun fichier n'a pu être téléversé." );
	define( "_WEBPHOTO_PHP_UPLOAD_ERR_NO_TMP_DIR", "Un répertoire temporaire est manquant." );
	define( "_WEBPHOTO_PHP_UPLOAD_ERR_CANT_WRITE", "Echec d'écriture sur le disque." );
	define( "_WEBPHOTO_PHP_UPLOAD_ERR_EXTENSION", "Le téléversement a été interrompu en raison de l'extension du fichier." );

// upload error
	define( "_WEBPHOTO_UPLOADER_ERR_NOT_FOUND", "Le fichier téléversé n'a pas été trouvé" );
	define( "_WEBPHOTO_UPLOADER_ERR_INVALID_FILE_SIZE", "Taille du fichier invalide" );
	define( "_WEBPHOTO_UPLOADER_ERR_EMPTY_FILE_NAME", "Le nom du fichier est absent" );
	define( "_WEBPHOTO_UPLOADER_ERR_NO_FILE", "Aucun fichier téléversé" );
	define( "_WEBPHOTO_UPLOADER_ERR_NOT_SET_DIR", "Le répertoire pour les téléversement n'a pas été précisé" );
	define( "_WEBPHOTO_UPLOADER_ERR_NOT_ALLOWED_EXT", "L'extension n'est pas autorisée" );
	define( "_WEBPHOTO_UPLOADER_ERR_PHP_OCCURED", "Une erreur est survenue : erreur #" );
	define( "_WEBPHOTO_UPLOADER_ERR_NOT_OPEN_DIR", "Echec à l'ouverture du répertoire : " );
	define( "_WEBPHOTO_UPLOADER_ERR_NO_PERM_DIR", "Echerc à l'ouverture-écriture du répertoire : " );
	define( "_WEBPHOTO_UPLOADER_ERR_NOT_ALLOWED_MIME", "MIMETYPE non autorisé : " );
	define( "_WEBPHOTO_UPLOADER_ERR_LARGE_FILE_SIZE", "Le poids de l'image excède la limite : " );
	define( "_WEBPHOTO_UPLOADER_ERR_LARGE_WIDTH", "La largeur du fichier doit être inférieure à " );
	define( "_WEBPHOTO_UPLOADER_ERR_LARGE_HEIGHT", "La hauteur du fichier doit être inférieure à " );
	define( "_WEBPHOTO_UPLOADER_ERR_UPLOAD", "Echec lors du téléversement du fichier : " );

//---------------------------------------------------------
// help
//---------------------------------------------------------
	define( "_WEBPHOTO_HELP_DSC", "Aide / description du module" );

	define( "_WEBPHOTO_HELP_PICLENS_TITLE", "PicLens" );
	define( "_WEBPHOTO_HELP_PICLENS_DSC", '
Piclens est une extension firefox réalisée par Cooliris<br>
qui vous permet d\'installer une visionneuse de photo sur votre site<br><br>
<b>Mise en place</b><br>
(1) Télécharger Firefox<br>
<a href="http://www.mozilla-japan.org/products/firefox/" target="_blank">
http://www.mozilla-japan.org/products/firefox/
</a><br><br>
(2) Télécharger Piclens<br>
<a href="http://www.piclens.com/" target="_blank">
http://www.piclens.com/
</a><br><br>
(3) Accéder au module Webphoto<br>
http://THIS-SITE/modules/webphoto/ <br><br>
(4) Cliquer sur le bouton situé à l\extrémité droite du navigateur Firefox<br>
Note : lorsque l\'icône est noire, vous ne pouvez pas activer Piclens<br>' );

//
// dummy lines , adjusts line number for Japanese lang file.
//

	define( "_WEBPHOTO_HELP_MEDIARSSSLIDESHOW_TITLE", "Media RSS Slide Show" );
	define( "_WEBPHOTO_HELP_MEDIARSSSLIDESHOW_DSC", '
"Media RSS Slide Show" est une Gadget Google qui fonctionne avec Google Desktop<br>
Il permet d\'afficher sur votre bureau un diaporama de vos galeries d\'images<br><br>
<b>Mise en place</b><br>
(1) Télécharger "Google Desktop"<br>
<a href="http://desktop.google.co.jp/" target="_blank">
http://desktop.google.co.jp/
</a><br><br>
(2) Télécharger le Gadget "Media RSS  Slide Show"<br>
<a href="http://desktop.google.com/plugins/i/mediarssslideshow.html" target="_blank">
http://desktop.google.com/plugins/i/mediarssslideshow.html
</a><br><br>
(3) Modifier "URL of MediaRSS" dans les options du Gadget<br>' );

//---------------------------------------------------------
// others
//---------------------------------------------------------
	define( "_WEBPHOTO_RANDOM_MORE", "Plus de medias aléatoires" );
	define( "_WEBPHOTO_USAGE_PHOTO", "Cliquer sur la miniature pour voir la photo au grand format." );
	define( "_WEBPHOTO_USAGE_TITLE", "Cliquer sur le titre pour la page de détails" );
	define( "_WEBPHOTO_DATE_NOT_SET", "Ne pas indiquer de date pour la photo" );
	define( "_WEBPHOTO_PLACE_NOT_SET", "Medias sans géolocalisation" );
	define( "_WEBPHOTO_GOTO_ADMIN", "Administration" );

//---------------------------------------------------------
// search for Japanese
//---------------------------------------------------------
	define( "_WEBPHOTO_SR_CANDICATE", "Candidat de la recherche" );
	define( "_WEBPHOTO_SR_ZENKAKU", "Alphabet Zenkaku" );
	define( "_WEBPHOTO_SR_HANKAKU", "Alphabet Hanhaku" );

	define( "_WEBPHOTO_JA_KUTEN", "JA_KUTEN" );
	define( "_WEBPHOTO_JA_DOKUTEN", "JA_DOKUTEN" );
	define( "_WEBPHOTO_JA_PERIOD", "JA_PERIOD" );
	define( "_WEBPHOTO_JA_COMMA", "JA_COMMA" );

//---------------------------------------------------------
// v0.20
//---------------------------------------------------------
	define( "_WEBPHOTO_TITLE_VIDEO_THUMB_SEL", "Sélectionner une miniature vidéo" );
	define( "_WEBPHOTO_TITLE_VIDEO_REDO", "Re-générer le Flash et la miniature à partir de la vidéo téléversée" );
	define( "_WEBPHOTO_CAP_REDO_THUMB", "Créer une miniature" );
	define( "_WEBPHOTO_CAP_REDO_FLASH", "Cretae Flash Video" );
	define( "_WEBPHOTO_ERR_VIDEO_FLASH", "Impossible de créer une vidéo Flash" );
	define( "_WEBPHOTO_ERR_VIDEO_THUMB", "La miniature ne pouvant être créée à partir de la vidéo, une icône de remplacement est utilisée" );
	define( "_WEBPHOTO_BUTTON_SELECT", "Sélectionner" );

	define( "_WEBPHOTO_DSC_DOWNLOAD_PLAY", "Lire après le téléchargement" );
	define( "_WEBPHOTO_ICON_VIDEO", "Vidéo" );
	define( "_WEBPHOTO_HOUR", "heure" );
	define( "_WEBPHOTO_MINUTE", "min." );
	define( "_WEBPHOTO_SECOND", "sec." );

//---------------------------------------------------------
// v0.30
//---------------------------------------------------------
// user table
	define( "_WEBPHOTO_USER_TABLE", "Tableau des utilisateurs auxiliaires" );
	define( "_WEBPHOTO_USER_ID", "ID des utilisateurs auxiliaires" );
	define( "_WEBPHOTO_USER_TIME_CREATE", "Date de création" );
	define( "_WEBPHOTO_USER_TIME_UPDATE", "Date de mise à jour" );
	define( "_WEBPHOTO_USER_UID", "ID de l'utilisateur" );
	define( "_WEBPHOTO_USER_CAT_ID", "ID de la Catégorie" );
	define( "_WEBPHOTO_USER_EMAIL", "Adresse e-mail" );
	define( "_WEBPHOTO_USER_TEXT1", "texte1" );
	define( "_WEBPHOTO_USER_TEXT2", "texte2" );
	define( "_WEBPHOTO_USER_TEXT3", "texte3" );
	define( "_WEBPHOTO_USER_TEXT4", "texte4" );
	define( "_WEBPHOTO_USER_TEXT5", "texte5" );

// maillog
	define( "_WEBPHOTO_MAILLOG_TABLE", "Tableau d'enregistement des e-mails" );
	define( "_WEBPHOTO_MAILLOG_ID", "ID de l'enregistrement" );
	define( "_WEBPHOTO_MAILLOG_TIME_CREATE", "Date de création" );
	define( "_WEBPHOTO_MAILLOG_TIME_UPDATE", "Date de mise à jour" );
	define( "_WEBPHOTO_MAILLOG_PHOTO_IDS", "ID des photos" );
	define( "_WEBPHOTO_MAILLOG_STATUS", "Statut" );
	define( "_WEBPHOTO_MAILLOG_FROM", "Provenance de l'e-mail" );
	define( "_WEBPHOTO_MAILLOG_SUBJECT", "Sujet" );
	define( "_WEBPHOTO_MAILLOG_BODY", "Message" );
	define( "_WEBPHOTO_MAILLOG_FILE", "Patronyme" );
	define( "_WEBPHOTO_MAILLOG_ATTACH", "Fichiers joints" );
	define( "_WEBPHOTO_MAILLOG_COMMENT", "Commentaires" );

// mail register
	define( "_WEBPHOTO_TITLE_MAIL_REGISTER", "Enregistrement d'adresses e-mails" );
	define( "_WEBPHOTO_MAIL_HELP", "Merci de consulter la rubrique d'aide" );
	define( "_WEBPHOTO_CAT_USER", "Nom de l'utilisateur" );
	define( "_WEBPHOTO_BUTTON_REGISTER", "ENREGISTRER" );
	define( "_WEBPHOTO_NOMATCH_USER", "Aucun utilisateur ne correspond" );
	define( "_WEBPHOTO_ERR_MAIL_EMPTY", "Vous devez indiquer une adresse" );
	define( "_WEBPHOTO_ERR_MAIL_ILLEGAL", "Format d'e-mail incorrect" );

// mail retrieve
	define( "_WEBPHOTO_TITLE_MAIL_RETRIEVE", "Récupération d'e-mails" );
	define( "_WEBPHOTO_DSC_MAIL_RETRIEVE", "Récupérer une adresse e-mail depuis le serveur" );
	define( "_WEBPHOTO_BUTTON_RETRIEVE", "RECUPERER" );
	define( "_WEBPHOTO_SUBTITLE_MAIL_ACCESS", "Accéder au serveur d'e-mails" );
	define( "_WEBPHOTO_SUBTITLE_MAIL_PARSE", "Analyser les e-mails réceptionnés" );
	define( "_WEBPHOTO_SUBTITLE_MAIL_PHOTO", "Soumettre les photos attachés aux e-mails" );
	define( "_WEBPHOTO_TEXT_MAIL_ACCESS_TIME", "Limitation d'accès" );
	define( "_WEBPHOTO_TEXT_MAIL_RETRY", "Accéder au bout d'une minute" );
	define( "_WEBPHOTO_TEXT_MAIL_NOT_RETRIEVE", "Impossible de récupérer les e-mails.<br>La communication est probablement interrompue provisoirement.<br>Merci de patienter un moment avant de tenter une nouvelle récupération" );
	define( "_WEBPHOTO_TEXT_MAIL_NO_NEW", "Aucun nouvel e-mail trouvé" );
	define( "_WEBPHOTO_TEXT_MAIL_RETRIEVED_FMT", "%s e-mails récupérés" );
	define( "_WEBPHOTO_TEXT_MAIL_NO_VALID", "Aucun e-mail valide" );
	define( "_WEBPHOTO_TEXT_MAIL_SUBMITED_FMT", "%s photos proposées" );
	define( "_WEBPHOTO_GOTO_INDEX", "Se rendre en page d'accueil du module" );

// i.php
	define( "_WEBPHOTO_TITLE_MAIL_POST", "Envoyer par e-mail" );

// file
	define( "_WEBPHOTO_TITLE_SUBMIT_FILE", "Ajouter une photo depuis un fichier" );
	define( "_WEBPHOTO_CAP_FILE_SELECT", "Sélectionner un fichier" );
	define( "_WEBPHOTO_ERR_EMPTY_FILE", "Vous devez sélectionner un fichier" );
	define( "_WEBPHOTO_ERR_EMPTY_CAT", "Vous devez sélectionner une Catégorie" );
	define( "_WEBPHOTO_ERR_INVALID_CAT", "Catégorie non valide" );
	define( "_WEBPHOTO_ERR_CREATE_PHOTO", "Impossible de créer la photto" );
	define( "_WEBPHOTO_ERR_CREATE_THUMB", "Impossible de créer la miniature" );

// help
	define( "_WEBPHOTO_HELP_MUST_LOGIN", "Merci de bien vouloir vous connecter si vous voulez accéder à davantage de détails" );
	define( "_WEBPHOTO_HELP_NOT_PERM", "Les permissions requises ne vous ont pas été accordées. Veuillez contacter le webmestre" );

	define( "_WEBPHOTO_HELP_MOBILE_TITLE", "Téléphone modile" );
	define( "_WEBPHOTO_HELP_MOBILE_DSC", "Vous pouvez consulter la photo et la vidéo sur votre téléphone mobile<br>Les dimensions de l'écran doivent être de 240x320 " );
	define( "_WEBPHOTO_HELP_MOBILE_TEXT_FMT", '
<b>URL d\'accès</b><br>
<a href="{MODULE_URL}/i.php" rel="external">{MODULE_URL}/i.php</a>' );

	define( "_WEBPHOTO_HELP_MAIL_TITLE", "E-mail via mobile" );
	define( "_WEBPHOTO_HELP_MAIL_DSC", "Vous pouvez transmettre vos photo et vos vidéos par e-mail via votre téléphone mobile" );
	define( "_WEBPHOTO_HELP_MAIL_GUEST", "Ceci est un exemple. Si vous disposez des droits requis, vous pouvez accéder à la véritable adresse e-mail." );

	define( "_WEBPHOTO_HELP_FILE_TITLE", "Transmission par FTP" );
	define( "_WEBPHOTO_HELP_FILE_DSC", "Les transferts par FTP vous permettent de téléverser des photos et des vidéos de grandes tailles" );
	define( "_WEBPHOTO_HELP_FILE_TEXT_FMT", '
<b>Envoyer un fichier</b><br>
(1) Téléverser le fichier sur le serveur via FTP<br>
(2) Cliquer sur <a href="{MODULE_URL}/index.php?fct=submit_file" rel="external">Ajouter une photo depuis le fichier</a><br>
(3) Sélectionner le fichier téléversé et Valider' );

// mail check
// for Japanese
	define( "_WEBPHOTO_MAIL_DENY_TITLE_PREG", "" );
	define( "_WEBPHOTO_MAIL_AD_WORD_1", "" );
	define( "_WEBPHOTO_MAIL_AD_WORD_2", "" );

//---------------------------------------------------------
// v0.40
//---------------------------------------------------------
// item table
	define( "_WEBPHOTO_ITEM_TABLE", "Tableau des ressources" );
	define( "_WEBPHOTO_ITEM_ID", "ID de l'élément" );
	define( "_WEBPHOTO_ITEM_TIME_CREATE", "Date de création" );
	define( "_WEBPHOTO_ITEM_TIME_UPDATE", "Date de mise à jour" );
	define( "_WEBPHOTO_ITEM_CAT_ID", "ID de la Catégorie" );
	define( "_WEBPHOTO_ITEM_GICON_ID", "ID de l'icône Googlemap" );
	define( "_WEBPHOTO_ITEM_UID", "ID de l'utilisateur" );
	define( "_WEBPHOTO_ITEM_KIND", "Type de ressource" );
	define( "_WEBPHOTO_ITEM_EXT", "Extension du fichier" );
	define( "_WEBPHOTO_ITEM_DATETIME", "Date de la photo" );
	define( "_WEBPHOTO_ITEM_TITLE", "Titre photo" );
	define( "_WEBPHOTO_ITEM_PLACE", "Localisation" );
	define( "_WEBPHOTO_ITEM_EQUIPMENT", "Equipment" );
	define( "_WEBPHOTO_ITEM_GMAP_LATITUDE", "Latitude Googlemap" );
	define( "_WEBPHOTO_ITEM_GMAP_LONGITUDE", "Longitude Googlemap" );
	define( "_WEBPHOTO_ITEM_GMAP_ZOOM", "Pourcentage du zoom" );
	define( "_WEBPHOTO_ITEM_GMAP_TYPE", "Type de carte" );
	define( "_WEBPHOTO_ITEM_PERM_READ", "Permission de consulter" );
	define( "_WEBPHOTO_ITEM_STATUS", "Statut" );
	define( "_WEBPHOTO_ITEM_HITS", "Affichages" );
	define( "_WEBPHOTO_ITEM_RATING", "Notes" );
	define( "_WEBPHOTO_ITEM_VOTES", "Votes" );
	define( "_WEBPHOTO_ITEM_DESCRIPTION", "Description de la photo" );
	define( "_WEBPHOTO_ITEM_EXIF", "Informations Exif" );
	define( "_WEBPHOTO_ITEM_SEARCH", "Rechercher" );
	define( "_WEBPHOTO_ITEM_COMMENTS", "Commentaires" );
	define( "_WEBPHOTO_ITEM_FILE_ID_1", "ID du fichier: Contenu" );
	define( "_WEBPHOTO_ITEM_FILE_ID_2", "ID du fichier: Miniature" );
	define( "_WEBPHOTO_ITEM_FILE_ID_3", "ID du fichier: Moyen" );
	define( "_WEBPHOTO_ITEM_FILE_ID_4", "ID du fichier: Vidéo Flash" );
	define( "_WEBPHOTO_ITEM_FILE_ID_5", "ID du fichier: Vidéo Docomo" );
	define( "_WEBPHOTO_ITEM_FILE_ID_6", "ID du fichier: PDF" );
	define( "_WEBPHOTO_ITEM_FILE_ID_7", "ID du fichier: Flash au format swf" );
	define( "_WEBPHOTO_ITEM_FILE_ID_8", "ID du fichier: Petit" );
	define( "_WEBPHOTO_ITEM_FILE_ID_9", "ID du fichier: JPEG" );
	define( "_WEBPHOTO_ITEM_FILE_ID_10", "ID du fichier: MP3" );
	define( "_WEBPHOTO_ITEM_TEXT_1", "texte1" );
	define( "_WEBPHOTO_ITEM_TEXT_2", "texte2" );
	define( "_WEBPHOTO_ITEM_TEXT_3", "texte3" );
	define( "_WEBPHOTO_ITEM_TEXT_4", "texte4" );
	define( "_WEBPHOTO_ITEM_TEXT_5", "texte5" );
	define( "_WEBPHOTO_ITEM_TEXT_6", "texte6" );
	define( "_WEBPHOTO_ITEM_TEXT_7", "texte7" );
	define( "_WEBPHOTO_ITEM_TEXT_8", "texte8" );
	define( "_WEBPHOTO_ITEM_TEXT_9", "texte9" );
	define( "_WEBPHOTO_ITEM_TEXT_10", "texte10" );

// file table
	define( "_WEBPHOTO_FILE_TABLE", "Tableau des fichiers" );
	define( "_WEBPHOTO_FILE_ID", "ID du fichier" );
	define( "_WEBPHOTO_FILE_TIME_CREATE", "Date de création" );
	define( "_WEBPHOTO_FILE_TIME_UPDATE", "Date de mise à jour" );
	define( "_WEBPHOTO_FILE_ITEM_ID", "ID de l'élément" );
	define( "_WEBPHOTO_FILE_KIND", "Type de fichier" );
	define( "_WEBPHOTO_FILE_URL", "URL" );
	define( "_WEBPHOTO_FILE_PATH", "Chemin d'accès au fichier" );
	define( "_WEBPHOTO_FILE_NAME", "Nom du fichier" );
	define( "_WEBPHOTO_FILE_EXT", "Extension du fichier" );
	define( "_WEBPHOTO_FILE_MIME", "MIME type" );
	define( "_WEBPHOTO_FILE_MEDIUM", "Type de format" );
	define( "_WEBPHOTO_FILE_SIZE", "Taille du fichier" );
	define( "_WEBPHOTO_FILE_WIDTH", "Largeur de l'image" );
	define( "_WEBPHOTO_FILE_HEIGHT", "Hauteur de l'image" );
	define( "_WEBPHOTO_FILE_DURATION", "Durée de la vidéo" );

// file kind ( for admin checktables )
	define( "_WEBPHOTO_FILE_KIND_1", "Contenu" );
	define( "_WEBPHOTO_FILE_KIND_2", "Miniature" );
	define( "_WEBPHOTO_FILE_KIND_3", "Moyen" );
	define( "_WEBPHOTO_FILE_KIND_4", "Vidéo Flash" );
	define( "_WEBPHOTO_FILE_KIND_5", "Vidéo Docomo" );
	define( "_WEBPHOTO_FILE_KIND_6", "PDF" );
	define( "_WEBPHOTO_FILE_KIND_7", "Flash au format swf" );
	define( "_WEBPHOTO_FILE_KIND_8", "Small" );
	define( "_WEBPHOTO_FILE_KIND_9", "JPG" );
	define( "_WEBPHOTO_FILE_KIND_10", "MP3" );

// index
	define( "_WEBPHOTO_MOBILE_MAILTO", "Envoyer sur téléphone mobile" );

// i.php
	define( "_WEBPHOTO_TITLE_MAIL_JUDGE", "Evaluer l'Opérateur mobile" );
	define( "_WEBPHOTO_MAIL_MODEL", "Opérateur mobile" );
	define( "_WEBPHOTO_MAIL_BROWSER", "Navigateur" );
	define( "_WEBPHOTO_MAIL_NOT_JUDGE", "Impossible d'évaluer l'Opérateur mobile" );
	define( "_WEBPHOTO_MAIL_TO_WEBMASTER", "E-mail pour le webmestre" );

// help
	define( "_WEBPHOTO_HELP_MAIL_POST_FMT", '
<b>Préparation</b><br>
Enregistrez votre adresse e-mail liée à votre téléphone mobile<br>
<a href="{MODULE_URL}/index.php?fct=mail_register" rel="external">Enregistrer l\'adresse e-mail</a><br><br>
<b>Envoyer une photo</b><br>
Transmettre l\'e-mail à l\'adresse suivante avec la photo en pièce jointe.<br>
<a href="mailto:{MAIL_ADDR}">{MAIL_ADDR}</a> {MAIL_GUEST} <br><br>
<b>Faire pivoter les photos</b><br>
Vous pouvez faire pivoter les photos vers la droite et vers la gauche en précisant à la fin du Sujet de l\'e-mail<br>
 R@ : pivoter vers la droite <br>
 L@ : pivoter vers la gauche<br><br>' );
	define( "_WEBPHOTO_HELP_MAIL_SUBTITLE_RETRIEVE", "<b>Récupérer les e-mails et leurs documents joints</b><br>" );
	define( "_WEBPHOTO_HELP_MAIL_RETRIEVE_FMT", '
Cliquer sur <a href="{MODULE_URL}/i.php?op=post" rel="external">Envois par e-mail</a>, quelques secondes après la transmission de l\'e-mail.<br>
Webphoto va récupérer l\'e-mail que vous avez envoyé et afficher la photo proposée<br>' );
	define( "_WEBPHOTO_HELP_MAIL_RETRIEVE_TEXT", "Webphoto récupère le mail que vous avez envoyé et affiche la photo transmise en pièce jointe<br>" );
	define( "_WEBPHOTO_HELP_MAIL_RETRIEVE_AUTO_FMT", '
L\'e-mail est traité automatiquement %s secondes après la transmission de l\'e-mail.<br>
Merci de cliquer <a href="{MODULE_URL}/i.php?op=post" rel="external">Evoyer par e-mail</a>, si l\'e-mail n\'est pas traité.<br>' );

//---------------------------------------------------------
// v0.50
//---------------------------------------------------------
// item table
	define( "_WEBPHOTO_ITEM_TIME_PUBLISH", "Date de publication" );
	define( "_WEBPHOTO_ITEM_TIME_EXPIRE", "Date de suspension" );
	define( "_WEBPHOTO_ITEM_PLAYER_ID", "ID du lecteur" );
	define( "_WEBPHOTO_ITEM_FLASHVAR_ID", "ID de la variable FlashVar" );
	define( "_WEBPHOTO_ITEM_DURATION", "Durée de la vidéo" );
	define( "_WEBPHOTO_ITEM_DISPLAYTYPE", "Type d'affichage" );
	define( "_WEBPHOTO_ITEM_ONCLICK", "Action au clic sur la miniature" );
	define( "_WEBPHOTO_ITEM_SITEURL", "URL du site" );
	define( "_WEBPHOTO_ITEM_ARTIST", "Artiste" );
	define( "_WEBPHOTO_ITEM_ALBUM", "Album" );
	define( "_WEBPHOTO_ITEM_LABEL", "Label" );
	define( "_WEBPHOTO_ITEM_VIEWS", "Affichages" );
	define( "_WEBPHOTO_ITEM_PERM_DOWN", "Përmission de télécharger" );
	define( "_WEBPHOTO_ITEM_EMBED_TYPE", "Type de Plugin" );
	define( "_WEBPHOTO_ITEM_EMBED_SRC", "URL de paramétrage du Plugin" );
	define( "_WEBPHOTO_ITEM_EXTERNAL_URL", "URL extérieure" );
	define( "_WEBPHOTO_ITEM_EXTERNAL_THUMB", "URL extérieure pour la miniature" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TYPE", "Type de Playlist" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_FEED", "URL du flux de la Playlist" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_DIR", "Répertoire de la Playlist" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_CACHE", "Nom du cache de la Playlist" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TIME", "Délais de mise en cache de la Playlist" );
	define( "_WEBPHOTO_ITEM_CHAIN", "Chaîne" );
	define( "_WEBPHOTO_ITEM_SHOWINFO", "Afficher les informations" );

// player table
	define( "_WEBPHOTO_PLAYER_TABLE", "Tableau de lecteurs vidéo" );
	define( "_WEBPHOTO_PLAYER_ID", "ID du lecteur" );
	define( "_WEBPHOTO_PLAYER_TIME_CREATE", "Date de création" );
	define( "_WEBPHOTO_PLAYER_TIME_UPDATE", "Date de mise à jour" );
	define( "_WEBPHOTO_PLAYER_TITLE", "Nom du lecteur" );
	define( "_WEBPHOTO_PLAYER_STYLE", "Apparence" );
	define( "_WEBPHOTO_PLAYER_WIDTH", "Largeur du lecteur" );
	define( "_WEBPHOTO_PLAYER_HEIGHT", "Hauteur du lecteur" );
	define( "_WEBPHOTO_PLAYER_DISPLAYWIDTH", "Afficher la largeur" );
	define( "_WEBPHOTO_PLAYER_DISPLAYHEIGHT", "Afficher la hauteur" );
	define( "_WEBPHOTO_PLAYER_SCREENCOLOR", "Couleur de l'écran" );
	define( "_WEBPHOTO_PLAYER_BACKCOLOR", "Couleur de fond" );
	define( "_WEBPHOTO_PLAYER_FRONTCOLOR", "Couleur de premier plan" );
	define( "_WEBPHOTO_PLAYER_LIGHTCOLOR", "Couleur de l'éclairage" );

// FlashVar table
	define( "_WEBPHOTO_FLASHVAR_TABLE", "Tableau de FlashVar" );
	define( "_WEBPHOTO_FLASHVAR_ID", "ID de FlashVar" );
	define( "_WEBPHOTO_FLASHVAR_TIME_CREATE", "Date de création" );
	define( "_WEBPHOTO_FLASHVAR_TIME_UPDATE", "Date de mise à jour" );
	define( "_WEBPHOTO_FLASHVAR_ITEM_ID", "ID de l'élément" );
	define( "_WEBPHOTO_FLASHVAR_WIDTH", "Largur du lecteur" );
	define( "_WEBPHOTO_FLASHVAR_HEIGHT", "Hauteur du lecteur" );
	define( "_WEBPHOTO_FLASHVAR_DISPLAYWIDTH", "Afficher la largeur" );
	define( "_WEBPHOTO_FLASHVAR_DISPLAYHEIGHT", "Afficher la hauteur" );
	define( "_WEBPHOTO_FLASHVAR_IMAGE_SHOW", "Afficher l'image" );
	define( "_WEBPHOTO_FLASHVAR_SEARCHBAR", "Barre de recherche" );
	define( "_WEBPHOTO_FLASHVAR_SHOWEQ", "Afficher les égaliseurs" );
	define( "_WEBPHOTO_FLASHVAR_SHOWICONS", "Icônes d'activité" );
	define( "_WEBPHOTO_FLASHVAR_SHOWNAVIGATION", "Afficher la navigation" );
	define( "_WEBPHOTO_FLASHVAR_SHOWSTOP", "Afficher la fonction Stop" );
	define( "_WEBPHOTO_FLASHVAR_SHOWDIGITS", "Afficher le compteur" );
	define( "_WEBPHOTO_FLASHVAR_SHOWDOWNLOAD", "Afficher la fonction télécharger" );
	define( "_WEBPHOTO_FLASHVAR_USEFULLSCREEN", "Afficher le bouton plein écran" );
	define( "_WEBPHOTO_FLASHVAR_AUTOSCROLL", "Barre de défilement inactive" );
	define( "_WEBPHOTO_FLASHVAR_THUMBSINPLAYLIST", "Miniatures" );
	define( "_WEBPHOTO_FLASHVAR_AUTOSTART", "Démarrage automatique de la lecture" );
	define( "_WEBPHOTO_FLASHVAR_REPEAT", "Fonction Répéter" );
	define( "_WEBPHOTO_FLASHVAR_SHUFFLE", "Fonction Lecture léatoire" );
	define( "_WEBPHOTO_FLASHVAR_SMOOTHING", "Fonction Atténuation" );
	define( "_WEBPHOTO_FLASHVAR_ENABLEJS", "Activer le javascript" );
	define( "_WEBPHOTO_FLASHVAR_LINKFROMDISPLAY", "Lien depuis Afficher" );
	define( "_WEBPHOTO_FLASHVAR_LINK_TYPE", "Hyperliens sur l'écran" );
	define( "_WEBPHOTO_FLASHVAR_BUFFERLENGTH", "Longueur du tampon" );
	define( "_WEBPHOTO_FLASHVAR_ROTATETIME", "Durée de rotation de l'image" );
	define( "_WEBPHOTO_FLASHVAR_VOLUME", "volume" );
	define( "_WEBPHOTO_FLASHVAR_LINKTARGET", "Cible du lien" );
	define( "_WEBPHOTO_FLASHVAR_OVERSTRETCH", "Elasticité de l'image / vidéo" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION", "Transition du diaporama" );
	define( "_WEBPHOTO_FLASHVAR_SCREENCOLOR", "Couleur de l'écran" );
	define( "_WEBPHOTO_FLASHVAR_BACKCOLOR", "Couleur de fond" );
	define( "_WEBPHOTO_FLASHVAR_FRONTCOLOR", "Couleur du premier plan" );
	define( "_WEBPHOTO_FLASHVAR_LIGHTCOLOR", "Couleur de l'éclairage" );
	define( "_WEBPHOTO_FLASHVAR_TYPE", "Type" );
	define( "_WEBPHOTO_FLASHVAR_FILE", "Fichier media" );
	define( "_WEBPHOTO_FLASHVAR_IMAGE", "Prévisualiser l'image" );
	define( "_WEBPHOTO_FLASHVAR_LOGO", "Logo associé au lecteur" );
	define( "_WEBPHOTO_FLASHVAR_LINK", "Liens sur l'écran" );
	define( "_WEBPHOTO_FLASHVAR_AUDIO", "Programme automatique" );
	define( "_WEBPHOTO_FLASHVAR_CAPTIONS", "Légendes des URL" );
	define( "_WEBPHOTO_FLASHVAR_FALLBACK", "URL de retour" );
	define( "_WEBPHOTO_FLASHVAR_CALLBACK", "URL de rappel" );
	define( "_WEBPHOTO_FLASHVAR_JAVASCRIPTID", "ID du javascript" );
	define( "_WEBPHOTO_FLASHVAR_RECOMMENDATIONS", "Recommandations" );
	define( "_WEBPHOTO_FLASHVAR_STREAMSCRIPT", "URL de diffusion du script" );
	define( "_WEBPHOTO_FLASHVAR_SEARCHLINK", "Lien de recherche" );

// log file
	define( "_WEBPHOTO_LOGFILE_LINE", "Ligne" );
	define( "_WEBPHOTO_LOGFILE_DATE", "Date" );
	define( "_WEBPHOTO_LOGFILE_REFERER", "Lien référent" );
	define( "_WEBPHOTO_LOGFILE_IP", "Adresse IP" );
	define( "_WEBPHOTO_LOGFILE_STATE", "Etat" );
	define( "_WEBPHOTO_LOGFILE_ID", "ID" );
	define( "_WEBPHOTO_LOGFILE_TITLE", "Titre" );
	define( "_WEBPHOTO_LOGFILE_FILE", "Fichier" );
	define( "_WEBPHOTO_LOGFILE_DURATION", "Durée" );

// item option
	define( "_WEBPHOTO_ITEM_KIND_UNDEFINED", "Indéfini" );
	define( "_WEBPHOTO_ITEM_KIND_NONE", "Aucun média" );
	define( "_WEBPHOTO_ITEM_KIND_GENERAL", "General" );
	define( "_WEBPHOTO_ITEM_KIND_IMAGE", "Image (jpg,gif,png)" );
	define( "_WEBPHOTO_ITEM_KIND_VIDEO", "Vidéo (wmv,mov,flv..." );
	define( "_WEBPHOTO_ITEM_KIND_AUDIO", "Audio (mp3...)" );
	define( "_WEBPHOTO_ITEM_KIND_EMBED", "Plugin EMBED" );
	define( "_WEBPHOTO_ITEM_KIND_EXTERNAL_GENERAL", "Externe (général)" );
	define( "_WEBPHOTO_ITEM_KIND_EXTERNAL_IMAGE", "Externe (image)" );
	define( "_WEBPHOTO_ITEM_KIND_PLAYLIST_FEED", "Flux de la playlist" );
	define( "_WEBPHOTO_ITEM_KIND_PLAYLIST_DIR", "Répertoire de la playlist" );

	define( "_WEBPHOTO_ITEM_DISPLAYTYPE_GENERAL", "Général" );
	define( "_WEBPHOTO_ITEM_DISPLAYTYPE_IMAGE", "Image (jpg,gif,png)" );
	define( "_WEBPHOTO_ITEM_DISPLAYTYPE_EMBED", "Plugin EMBED" );
	define( "_WEBPHOTO_ITEM_DISPLAYTYPE_SWFOBJECT", "FlashPlayer (swf)" );
	define( "_WEBPHOTO_ITEM_DISPLAYTYPE_MEDIAPLAYER", "MediaPlayer (jpg,gif,png,flv,mp3)" );
	define( "_WEBPHOTO_ITEM_DISPLAYTYPE_IMAGEROTATOR", "ImageRotator (jpg,gif,png)" );

	define( "_WEBPHOTO_ITEM_ONCLICK_PAGE", "Page de détail" );
	define( "_WEBPHOTO_ITEM_ONCLICK_DIRECT", "Lien direct" );
	define( "_WEBPHOTO_ITEM_ONCLICK_POPUP", "Image Popup" );

	define( "_WEBPHOTO_ITEM_PLAYLIST_TYPE_DSC", "Quel est le type de ressource ?" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TYPE_NONE", "Aucun" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TYPE_IMAGE", "Image (jpg,gif,png)" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TYPE_AUDIO", "Audio (mp3)" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TYPE_VIDEO", "Vidéo (flv)" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TYPE_FLASH", "Flash (swf)" );

	define( "_WEBPHOTO_ITEM_SHOWINFO_DESCRIPTION", "Description" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_LOGOIMAGE", "Miniature" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_CREDITS", "Crédits" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_STATISTICS", "Statistiques" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_SUBMITTER", "Proposé par" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_POPUP", "PopUp" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_TAGS", "Tags" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_DOWNLOAD", "Télécharger" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_WEBSITE", "Site" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_WEBFEED", "Flux" );

	define( "_WEBPHOTO_ITEM_STATUS_WAITING", "En attente d'approbation" );
	define( "_WEBPHOTO_ITEM_STATUS_APPROVED", "Approuvé" );
	define( "_WEBPHOTO_ITEM_STATUS_UPDATED", "En ligne (mis à jour)" );
	define( "_WEBPHOTO_ITEM_STATUS_OFFLINE", "Désactivé" );
	define( "_WEBPHOTO_ITEM_STATUS_EXPIRED", "Expiré" );

// player option
	define( "_WEBPHOTO_PLAYER_STYLE_MONO", "Monochrome" );
	define( "_WEBPHOTO_PLAYER_STYLE_THEME", "Couleur du thème" );
	define( "_WEBPHOTO_PLAYER_STYLE_PLAYER", "Lecteur personnalisé" );
	define( "_WEBPHOTO_PLAYER_STYLE_PAGE", "Lecteur / page personnalisé" );

// flashvar desc
	define( "_WEBPHOTO_FLASHVAR_ID_DSC", "[Paramètres de base] <br>A utiliser pour indiquer l'idebntifiant de diffusion RTMP du lecteur.<br>L'ID sera également utilisé pour les statistiques.<br>Si vous lisez une playlist, vous pouvez indiquer un ID pour chaque élément. " );
	define( "_WEBPHOTO_FLASHVAR_DISPLAYHEIGHT_DSC", "[Playlist] [mediaplayer] <br>Paramétrer une dimension inférieure à la hauteur afin de voir la playlist. <br>Si vous conservez une valeur identique à la hauteur, les commandes du lecteur seront automatiquement masquées au sommet de la vidéo. " );
	define( "_WEBPHOTO_FLASHVAR_DISPLAYWIDTH_DSC", "[Playlist] [mediaplayer] <br>Pistes du bas :<br> Ecran = lecteur<br> Pistes latérales :<br>Ecran < au lecteur " );
	define( "_WEBPHOTO_FLASHVAR_DISPLAY_DEFAULT", "si la valeur indiquée est 0, celle du lecteur sera utilisée." );
	define( "_WEBPHOTO_FLASHVAR_COLOR_DEFAULT", "Si aucune valeur n'est indiquée, celle du lecteur sera utilisée." );
	define( "_WEBPHOTO_FLASHVAR_SEARCHBAR_DSC", "(Paramètres de base) <br>Sélectionner False pour masquer la barre de recherche sous le lecteur. <br>Vous pouvez indiquer le lien de la page de résultat en utilisant le lien de recherhce du FlashVar. " );
	define( "_WEBPHOTO_FLASHVAR_IMAGE_SHOW_DSC", "(Paramètres de base) <br>True = l'image de prévisualisation s'affiche" );
	define( "_WEBPHOTO_FLASHVAR_FILE_DSC", "(Paramètres de base) <br>Indiquer l'emplacement du fichier ou de la playlist à lire. <br>L'Imagerotator ne reconnaît que les playlists. " );
	define( "_WEBPHOTO_FLASHVAR_SHOWEQ_DSC", "(Affichage) <br>Sélectionner true pour afficher un égaliseur (fictif) au pied de la zone de lecture. <br>Recommandé pour la lecture de fichiers MP3. " );
	define( "_WEBPHOTO_FLASHVAR_SHOWSTOP_DSC", "[Barre de contrôle] [mediaplayer] <br>Sélectionner true pour afficher le bouton Stop dans la barre de contrôle. " );
	define( "_WEBPHOTO_FLASHVAR_SHOWDIGITS_DSC", "[Barre de contrôle] [mediaplayer] <br>Sélectionner false pour masquer le compteur de lecture dans la barre de contrôle. " );
	define( "_WEBPHOTO_FLASHVAR_SHOWDOWNLOAD_DSC", "[Barre de contrôle] [mediaplayer] <br>Sélectionner true pour afficher dans la barre de contrôle le boutton permettant de relier le media à FlashVar. " );
	define( "_WEBPHOTO_FLASHVAR_AUTOSCROLL_DSC", "[Playlist] [mediaplayer] <br>Sélectionner true  pour pouvoir faire défiler verticalement le média sans recourir aux ascenseurs. " );
	define( "_WEBPHOTO_FLASHVAR_THUMBSINPLAYLIST_DSC", "[Playlist] [mediaplayer] <br>Sélectionner false pour masquer la prévisualisation dans la zone de lecture" );
	define( "_WEBPHOTO_FLASHVAR_CAPTIONS_DSC", "(Lecture) [mediaplayer] <br>Les légendes devraient être au format Timedtext. <br>Lorsque vous utiliser un lecteur, vous pouvez indiquer une légende pour chacune des ressource lue. " );
	define( "_WEBPHOTO_FLASHVAR_FALLBACK_DSC", "(Lecture) [mediaplayer] <br>Si vous lisez un fichier MP4, indiquer l'emplacement d'un FLV. <br>Il sera automatiquement employé par un lecteur flash, qui devient alors compatible. " );
	define( "_WEBPHOTO_FLASHVAR_ENABLEJS_DSC", "(Intéraction web)<br>Sélectionner true pour autoriser l'intéraction javascript. <br>Ce paramètre ne peut fonctionner qu'avec une connection<br>L'intéraction javascript inclut le commandes de lecture, le chargement asynchrone des médias et l'affichage des informations relatives au média. " );
	define( "_WEBPHOTO_FLASHVAR_JAVASCRIPTID_DSC", "(Intéraction web)<br>Si vous mettez en relation plusieurs lecteurs / diaporamas en javascript, utiliser le Flashvar pour les singulariser avec un ID propre. " );
	define( "_WEBPHOTO_FLASHVAR_LINK_TYPE_DSC", "(Intéraction web)<br>Ce lien est assigné à l'affichage, au logo et au bouton Lien. <br >Lorsqu'aucune information n'est saisie, aucun lien n'est assigné. <br>Si une valeur est précisée, alors une page sera accessible. " );
	define( "_WEBPHOTO_FLASHVAR_CALLBACK_DSC", "(Intéraction web)<br>Indiquer le script chargé de collecter les statistiques. <br>Le lecteur enverra une valeur à chaque déclenchement et arrêtde lecture. <br>Pour transmettre les informations à Google Analytics automatiquement, indiquer urchin ou analytics. " );
	define( "_WEBPHOTO_FLASHVAR_RECOMMENDATIONS_DSC", "(Intéraction web)[mediaplayer] <br>Indiquez un fichier XML contenant la liste des ressources que vous souhaitez recommander <br>Les vignettes s'afficheront à l'arrêt de la vidéo (exemple sur Youtube). " );
	define( "_WEBPHOTO_FLASHVAR_SEARCHLINK_DSC", "(Intéraction web)[mediaplayer] <br>Indiquer la destination de la page de résultat des recherches <br>Par défaut il s'agit de 'search.longtail.tv', mais vous pouvez indiquer des destinations différente. <br>Appliquer Flashvar à la barre de recherche pour la masquer totalement. " );
	define( "_WEBPHOTO_FLASHVAR_STREAMSCRIPT_DSC", "(Intéraction web)[mediaplayer] <br>Indiquer l'URL du script à exécuter pour utiliser le streaming vidéo. <br>Les paramètres du fichier et sa position seront transmis au script. <br>Si vous utilisez le streaming LigHTTPD, indiquez lighttpd. " );
	define( "_WEBPHOTO_FLASHVAR_TYPE_DSC", "(Intéraction web)[mediaplayer] <br>Le lecteur qui détermine le type de fichier à jouer se base sur les 3 derniers caractères du Flashvar. <br>Ce paramétrage ne fonctionne pas avec l'ID enregistré en base de données et avec le mod_rewrite sur On. Vous devez dans ce cas indiquer le Flashvar avec le Type de fichier approprié. <br>Si vous n'êtes pas sûr, le lecteur considèrera qu'une la plylist est chargée. " );

// flashvar option
	define( "_WEBPHOTO_FLASHVAR_LINK_TYPE_NONE", "Aucun" );
	define( "_WEBPHOTO_FLASHVAR_LINK_TYPE_SITE", "URL du site" );
	define( "_WEBPHOTO_FLASHVAR_LINK_TYPE_PAGE", "Page de détail" );
	define( "_WEBPHOTO_FLASHVAR_LINK_TYPE_FILE", "Fichier média" );
	define( "_WEBPHOTO_FLASHVAR_LINKTREGET_SELF", "Même fenêtre" );
	define( "_WEBPHOTO_FLASHVAR_LINKTREGET_BLANK", "nouvelle fenêtre" );
	define( "_WEBPHOTO_FLASHVAR_OVERSTRETCH_FALSE", "Faux" );
	define( "_WEBPHOTO_FLASHVAR_OVERSTRETCH_FIT", "Remplir" );
	define( "_WEBPHOTO_FLASHVAR_OVERSTRETCH_TRUE", "Vrai" );
	define( "_WEBPHOTO_FLASHVAR_OVERSTRETCH_NONE", "Aucun" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_OFF", "Diaporama du lecture désactivé" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_FADE", "Exctinction progressive" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_SLOWFADE", "Exctinction progressive et lente" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_BGFADE", "Extinction de l'arrière plan" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_CIRCLES", "Cercles" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_BLOCKS", "Blocs" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_BUBBLES", "Bulles" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_FLASH", "Flash" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_FLUIDS", "Fluide" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_LINES", "Lignes" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_RANDOM", "Aléatoire" );

// edit form
	define( "_WEBPHOTO_CAP_DETAIL", "Afficher les détails" );
	define( "_WEBPHOTO_CAP_DETAIL_ONOFF", "Activé/Désactivé" );
	define( "_WEBPHOTO_PLAYER", "Lecteur" );
	define( "_WEBPHOTO_EMBED_ADD", "Ajouter une extension EMBED" );
	define( "_WEBPHOTO_EMBED_THUMB", "Une source extérieure fournit la miniature." );
	define( "_WEBPHOTO_ERR_EMBED", "Vous devez indiquer un Plugin" );
	define( "_WEBPHOTO_ERR_PLAYLIST", "Vous devez indiquer une playlist" );

// sort
	define( "_WEBPHOTO_SORT_VOTESA", "Votes (mini)" );
	define( "_WEBPHOTO_SORT_VOTESD", "Votes (maxi)" );
	define( "_WEBPHOTO_SORT_VIEWSA", "Affichage des médias (mini)" );
	define( "_WEBPHOTO_SORT_VIEWSD", "Affichage des médias (maxi)" );

// flashvar form
	define( "_WEBPHOTO_FLASHVARS_LIST", "Liste des variables flash" );
	define( "_WEBPHOTO_FLASHVARS_LOGO_SELECT", "Sélectionner un logo de lecteur" );
	define( "_WEBPHOTO_FLASHVARS_LOGO_UPLOAD", "Charger un logo de lecteur" );
	define( "_WEBPHOTO_FLASHVARS_LOGO_DSC", "(Affichage) <br>Les logos de lecteur sont en place" );
	define( "_WEBPHOTO_BUTTON_COLOR_PICKUP", "Couleur" );
	define( "_WEBPHOTO_BUTTON_RESTORE", "Restaurer les valeurs par défaut" );

// Playlist Cache
	define( "_WEBPHOTO_PLAYLIST_STATUS_REPORT", "Compte rendu du statut" );
	define( "_WEBPHOTO_PLAYLIST_STATUS_FETCHED", "Ce flux a été récupéré et mis en cache." );
	define( "_WEBPHOTO_PLAYLIST_STATUS_CREATED", "Une nouvelle playlist a été mise en cache" );
	define( "_WEBPHOTO_PLAYLIST_ERR_CACHE", "[ERREUR] lors de la création du cache" );
	define( "_WEBPHOTO_PLAYLIST_ERR_FETCH", "Impossible de récupérer le flux. <br>Veuillez confirmer l'emplacement du flux et mettre à jour le cache." );
	define( "_WEBPHOTO_PLAYLIST_ERR_NODIR", "Le répertoire des médias n'existe pas" );
	define( "_WEBPHOTO_PLAYLIST_ERR_EMPTYDIR", "Le répertoire des médias est vide" );
	define( "_WEBPHOTO_PLAYLIST_ERR_WRITE", "Impossible de créer le fichier de cache" );

	define( "_WEBPHOTO_USER", "Utilisateur" );
	define( "_WEBPHOTO_OR", "ou" );

//---------------------------------------------------------
// v0.60
//---------------------------------------------------------
// item table
//define("_WEBPHOTO_ITEM_ICON" , "Icon Name" ) ;

	define( "_WEBPHOTO_ITEM_EXTERNAL_MIDDLE", "URL extérieur (middle)" );

// cat table
	define( "_WEBPHOTO_CAT_IMG_NAME", "Nom de la Catégorie d'images" );

// edit form
	define( "_WEBPHOTO_CAP_MIDDLE_SELECT", "Sélectionner l'image (middle)" );

//---------------------------------------------------------
// v0.70
//---------------------------------------------------------
// item table
	define( "_WEBPHOTO_ITEM_CODEINFO", "Info code" );
	define( "_WEBPHOTO_ITEM_PAGE_WIDTH", "Largeur de la page" );
	define( "_WEBPHOTO_ITEM_PAGE_HEIGHT", "Hauteur de la page" );
	define( "_WEBPHOTO_ITEM_EMBED_TEXT", "Embed" );

// item option
	define( "_WEBPHOTO_ITEM_CODEINFO_CONT", "Média" );
	define( "_WEBPHOTO_ITEM_CODEINFO_THUMB", "Miniature de l'image" );
	define( "_WEBPHOTO_ITEM_CODEINFO_MIDDLE", "Image (middle)" );
	define( "_WEBPHOTO_ITEM_CODEINFO_FLASH", "Vidéo Flash" );
	define( "_WEBPHOTO_ITEM_CODEINFO_DOCOMO", "Vidéo Docomo" );
	define( "_WEBPHOTO_ITEM_CODEINFO_PAGE", "URL" );
	define( "_WEBPHOTO_ITEM_CODEINFO_SITE", "Site" );
	define( "_WEBPHOTO_ITEM_CODEINFO_PLAY", "Playlist" );
	define( "_WEBPHOTO_ITEM_CODEINFO_EMBED", "Embed" );
	define( "_WEBPHOTO_ITEM_CODEINFO_JS", "Script" );

	define( "_WEBPHOTO_ITEM_PLAYLIST_TIME_HOUR", "1 heure" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TIME_DAY", "1 jour" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TIME_WEEK", "1 semaine" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TIME_MONTH", "1 mois" );

// photo
	define( "_WEBPHOTO_DOWNLOAD", "Télécharger" );

// file_read
	define( "_WEBPHOTO_NO_FILE", "Le fichier n'existe pas" );

//---------------------------------------------------------
// v0.80
//---------------------------------------------------------
// item table
	define( "_WEBPHOTO_ITEM_ICON_NAME", "Nom de l'icône" );
	define( "_WEBPHOTO_ITEM_ICON_WIDTH", "Largeur de l'icône" );
	define( "_WEBPHOTO_ITEM_ICON_HEIGHT", "Hauteur de l'icône" );

// item form
	define( "_WEBPHOTO_DSC_SET_ITEM_TIME_UPDATE", "Indiquer la date de mise à jour" );
	define( "_WEBPHOTO_DSC_SET_ITEM_TIME_PUBLISH", "Indiquer la date de publication" );
	define( "_WEBPHOTO_DSC_SET_ITEM_TIME_EXPIRE", "Indiquer la date de suspension" );

//---------------------------------------------------------
// v0.81
//---------------------------------------------------------
// vote option
	define( "_WEBPHOTO_VOTE_RATING_1", "1" );
	define( "_WEBPHOTO_VOTE_RATING_2", "2" );
	define( "_WEBPHOTO_VOTE_RATING_3", "3" );
	define( "_WEBPHOTO_VOTE_RATING_4", "4" );
	define( "_WEBPHOTO_VOTE_RATING_5", "5" );
	define( "_WEBPHOTO_VOTE_RATING_6", "6" );
	define( "_WEBPHOTO_VOTE_RATING_7", "7" );
	define( "_WEBPHOTO_VOTE_RATING_8", "8" );
	define( "_WEBPHOTO_VOTE_RATING_9", "9" );
	define( "_WEBPHOTO_VOTE_RATING_10", "10" );

//---------------------------------------------------------
// v0.90
//---------------------------------------------------------
// edit form
	define( "_WEBPHOTO_GROUP_PERM_ALL", "Tous les Groupes" );

//---------------------------------------------------------
// v1.00
//---------------------------------------------------------
// item table
	define( "_WEBPHOTO_ITEM_EDITOR", "Editeur" );
	define( "_WEBPHOTO_ITEM_DESCRIPTION_HTML", "Tags HTML" );
	define( "_WEBPHOTO_ITEM_DESCRIPTION_SMILEY", "Smiley" );
	define( "_WEBPHOTO_ITEM_DESCRIPTION_XCODE", "XOOPS codes" );
	define( "_WEBPHOTO_ITEM_DESCRIPTION_IMAGE", "Images" );
	define( "_WEBPHOTO_ITEM_DESCRIPTION_BR", "Linebreak (br)" );

// edit form
	define( "_WEBPHOTO_TITLE_EDITOR_SELECT", "Sélectionner un éditeur" );
	define( "_WEBPHOTO_CAP_DESCRIPTION_OPTION", "Options" );
	define( "_WEBPHOTO_CAP_HTML", "Activer les Tags HTML" );
	define( "_WEBPHOTO_CAP_SMILEY", "Activer les Smiley" );
	define( "_WEBPHOTO_CAP_XCODE", "Activer les XOOPS codes" );
	define( "_WEBPHOTO_CAP_IMAGE", "Activer les images" );
	define( "_WEBPHOTO_CAP_BR", "Activer linebreak (br)" );

//---------------------------------------------------------
// v1.10
//---------------------------------------------------------
// item table
	define( "_WEBPHOTO_ITEM_WIDTH", "Largeur de l'image" );
	define( "_WEBPHOTO_ITEM_HEIGHT", "Hauteur de l'image" );
	define( "_WEBPHOTO_ITEM_CONTENT", "Contenu du text" );

//---------------------------------------------------------
// v1.20
//---------------------------------------------------------
// item option
	define( "_WEBPHOTO_ITEM_CODEINFO_PDF", "PDF" );
	define( "_WEBPHOTO_ITEM_CODEINFO_SWF", "Flash swf" );

// form
	define( "_WEBPHOTO_ERR_PDF", "Impossible de créer le fichier PDF" );
	define( "_WEBPHOTO_ERR_SWF", "Impossible de créer le fichier swf" );

// jodconverter
	define( "_WEBPHOTO_JODCONVERTER_JUNK_WORDS", "" );

//---------------------------------------------------------
// v1.30
//---------------------------------------------------------
	define( "_WEBPHOTO_TITLE_MAP", "Googlemap" );
	define( "_WEBPHOTO_MAP_LARGE", "Voir la carte grand format" );

// timeline
	define( "_WEBPHOTO_TITLE_TIMELINE", "Chronologie" );
	define( "_WEBPHOTO_TIMELINE_ON", "Afficher la chronologie" );
	define( "_WEBPHOTO_TIMELINE_OFF", "Masquer la chronologie" );
	define( "_WEBPHOTO_TIMELINE_SCALE_WEEK", "1 semaine" );
	define( "_WEBPHOTO_TIMELINE_SCALE_MONTH", "1 mois" );
	define( "_WEBPHOTO_TIMELINE_SCALE_YEAR", "1 an" );
	define( "_WEBPHOTO_TIMELINE_SCALE_DECADE", "10 ans" );
	define( "_WEBPHOTO_TIMELINE_LARGE", "Afficher la chronologie étendue" );
	define( "_WEBPHOTO_TIMELINE_CAUTION_IE", "Des problèmes d'affichage peuvent survenir avec vec Internet Expoler. Veuillez essayer d'autres navigateurs (Firefox, Opera, Safari)." );

// item option
	define( "_WEBPHOTO_ITEM_CODEINFO_SMALL", "Small image" );

// edit form
	define( "_WEBPHOTO_CAP_SMALL_SELECT", "Select the small image" );

//---------------------------------------------------------
// v1.60
//---------------------------------------------------------
	define( "_WEBPHOTO_TITLE_SUBMIT_SELECT", "Select submit form" );
	define( "_WEBPHOTO_TITLE_SUBMIT_SINGLE", "Registration of one photo video media" );
	define( "_WEBPHOTO_TITLE_SUBMIT_BULK", "Batch registration of photo video media" );

//---------------------------------------------------------
// v1.80
//---------------------------------------------------------
// item option
	define( "_WEBPHOTO_ITEM_CODEINFO_JPEG", "JPEG Image" );
	define( "_WEBPHOTO_ITEM_CODEINFO_MP3", "MP3" );

// form
	define( "_WEBPHOTO_ERR_JPEG", "Cannot create JPEG" );
	define( "_WEBPHOTO_ERR_MP3", "Cannot create MP3" );

// mime option
	define( "_WEBPHOTO_MIME_KIND_GENERAL", "Genaral" );
	define( "_WEBPHOTO_MIME_KIND_IMAGE", "Image" );
	define( "_WEBPHOTO_MIME_KIND_IMAGE_CONVERT", "Image convert" );
	define( "_WEBPHOTO_MIME_KIND_VIDEO", "Video" );
	define( "_WEBPHOTO_MIME_KIND_VIDEO_FFMPEG", "Video ffmpeg" );
	define( "_WEBPHOTO_MIME_KIND_AUDIO", "Audio" );
	define( "_WEBPHOTO_MIME_KIND_AUDIO_MID", "Audio midi" );
	define( "_WEBPHOTO_MIME_KIND_AUDIO_WAV", "Audio wav" );
	define( "_WEBPHOTO_MIME_KIND_OFFICE", "Office" );

// player option
	define( "_WEBPHOTO_PLAYER_TITLE_DEFAULT", "Undefined" );

	define( "_WEBPHOTO_TITLE_IMAGE", "Images" );
	define( "_WEBPHOTO_TITLE_VIDEO", "Videos" );
	define( "_WEBPHOTO_TITLE_MUSIC", "Musics" );
	define( "_WEBPHOTO_TITLE_OFFICE", "Offices" );

//---------------------------------------------------------
// v1.90
//---------------------------------------------------------
// menu
	define( "_WEBPHOTO_TITLE_PICTURE", "Pictures" );
	define( "_WEBPHOTO_TITLE_AUDIO", "Musics" );

// item
	define( "_WEBPHOTO_ITEM_DETAIL_ONCLICK", "Action on click the content image" );
	define( "_WEBPHOTO_ITEM_WEIGHT", "Weight" );

// item option
	define( "_WEBPHOTO_ITEM_KIND_OFFICE", "Office (doc,xls,ppt...)" );
	define( "_WEBPHOTO_ITEM_KIND_IMAGE_OTHER", "Image (bmp,tif,wmf...)" );
	define( "_WEBPHOTO_ITEM_DETAIL_ONCLICK_DEFAULT", "Default (uploaded content)" );

// file
	define( "_WEBPHOTO_FILE_KIND_CONT", "Content" );
	define( "_WEBPHOTO_FILE_KIND_THUMB", "Thumbnail" );
	define( "_WEBPHOTO_FILE_KIND_MIDDLE", "Middle image" );
	define( "_WEBPHOTO_FILE_KIND_FLASH", "Flash flv" );
	define( "_WEBPHOTO_FILE_KIND_DOCOMO", "Docomo video" );
	define( "_WEBPHOTO_FILE_KIND_PDF", "PDF" );
	define( "_WEBPHOTO_FILE_KIND_SWF", "Flash swf" );
	define( "_WEBPHOTO_FILE_KIND_SMALL", "Small image" );
	define( "_WEBPHOTO_FILE_KIND_JPEG", "JPEG" );
	define( "_WEBPHOTO_FILE_KIND_MP3", "MP3" );

// mime option
	define( "_WEBPHOTO_MIME_KIND_OFFICE_DOC", "Office doc" );
	define( "_WEBPHOTO_MIME_KIND_OFFICE_XLS", "Office xls" );
	define( "_WEBPHOTO_MIME_KIND_OFFICE_PPT", "Office ppt" );
	define( "_WEBPHOTO_MIME_KIND_OFFICE_PDF", "Office pdf" );

// submit
	define( "_WEBPHOTO_UPLOADING", "Uploading..." );
	define( "_WEBPHOTO_EMBED_ENTER", "Enter the video id from the url" );
	define( "_WEBPHOTO_EMBED_EXAMPLE", "Example" );

// photo
	define( "_WEBPHOTO_ICON_GROUP", "Only in group" );

//---------------------------------------------------------
// v2.00
//---------------------------------------------------------
// item
	define( "_WEBPHOTO_ITEM_PERM_LEVEL", "Permission Level" );
	define( "_WEBPHOTO_ITEM_PERM_LEVEL_PUBLIC", "Public" );
	define( "_WEBPHOTO_ITEM_PERM_LEVEL_GROUP", "Only in group" );

// cat
	define( "_WEBPHOTO_CAT_GROUP_ID", "User Group ID" );

//---------------------------------------------------------
// v2.10
//---------------------------------------------------------
// item
	define( "_WEBPHOTO_ITEM_DESCRIPTION_SCROLL", "Scroll view of Media Description" );
	define( "_WEBPHOTO_ITEM_DESCRIPTION_SCROLL_DSC", "Enter the height of the scroll by the px unit.
 <br>When 0, it is usual view without the scroll." );

// item option
	define( "_WEBPHOTO_ITEM_DETAIL_ONCLICK_IMAGE", "Show media in new window" );
	define( "_WEBPHOTO_ITEM_DETAIL_ONCLICK_LIGHTBOX", "Show media with lightbox" );

// submit
	define( "_WEBPHOTO_MAIL_SUBMIT_WAITING", "Waiting Approval" );
	define( "_WEBPHOTO_MAIL_SUBMIT_APPROVE", "Approved your photo video media" );
	define( "_WEBPHOTO_MAIL_SUBMIT_REFUSE", "Refused your photo video media" );

// edit
	define( "_WEBPHOTO_LOOK_PHOTO", "View Media" );

//---------------------------------------------------------
// v2.11
//---------------------------------------------------------
// submit
	define( "_WEBPHOTO_ITEM_KIND_GROUP_UNDEFINED", "Undefined" );
	define( "_WEBPHOTO_ITEM_KIND_GROUP_IMAGE", "Image" );
	define( "_WEBPHOTO_ITEM_KIND_GROUP_VIDEO", "Video" );
	define( "_WEBPHOTO_ITEM_KIND_GROUP_AUDIO", "Audio" );
	define( "_WEBPHOTO_ITEM_KIND_GROUP_OFFICE", "Office" );
	define( "_WEBPHOTO_ITEM_KIND_GROUP_OTHERS", "Others" );

	define( "_WEBPHOTO_CONFIRM_PHOTODEL_DSC", "All information, description comment and etc, are deleted" );

// search
	define( "_WEBPHOTO_SEARCH_KEYTOOSHORT", "Keywords must be at least <b>%s</b> characters long" );

//---------------------------------------------------------
// v2.20
//---------------------------------------------------------
// edit form
	define( "_WEBPHOTO_EMBED_SUPPORT_TITLE", "The external source will provide Title" );
	define( "_WEBPHOTO_EMBED_SUPPORT_DESCRIPTION", "The external source will provide Description" );
	define( "_WEBPHOTO_EMBED_SUPPORT_SITEURL", "The external source will provide Site url" );
	define( "_WEBPHOTO_EMBED_SUPPORT_DURATION", "The external source will provide Duration" );
	define( "_WEBPHOTO_EMBED_SUPPORT_EMBED_TEXT", "The external source will provide Emded" );
	define( "_WEBPHOTO_EMBED_SUPPORT_TAGS", "The external source will provide Tags" );

//---------------------------------------------------------
// v2.30
//---------------------------------------------------------
// item table
	define( "_WEBPHOTO_ITEM_DISPLAYFILE", "Display File" );
	define( "_WEBPHOTO_ITEM_FILE_ID_11", "File ID: WAV" );
	define( "_WEBPHOTO_ITEM_FILE_ID_12", "File ID: Large" );
	define( "_WEBPHOTO_ITEM_FILE_ID_13", "File ID: 13" );
	define( "_WEBPHOTO_ITEM_FILE_ID_14", "File ID: 14" );
	define( "_WEBPHOTO_ITEM_FILE_ID_15", "File ID: 15" );
	define( "_WEBPHOTO_ITEM_FILE_ID_16", "File ID: 16" );
	define( "_WEBPHOTO_ITEM_FILE_ID_17", "File ID: 17" );
	define( "_WEBPHOTO_ITEM_FILE_ID_18", "File ID: 18" );
	define( "_WEBPHOTO_ITEM_FILE_ID_19", "File ID: 19" );
	define( "_WEBPHOTO_ITEM_FILE_ID_20", "File ID: 20" );

// file
	define( "_WEBPHOTO_FILE_KIND_11", "WAVE" );
	define( "_WEBPHOTO_FILE_KIND_12", "Large" );
	define( "_WEBPHOTO_FILE_KIND_13", "File Kind: 13" );
	define( "_WEBPHOTO_FILE_KIND_14", "File Kind: 14" );
	define( "_WEBPHOTO_FILE_KIND_15", "File Kind: 15" );
	define( "_WEBPHOTO_FILE_KIND_16", "File Kind: 16" );
	define( "_WEBPHOTO_FILE_KIND_17", "File Kind: 17" );
	define( "_WEBPHOTO_FILE_KIND_18", "File Kind: 18" );
	define( "_WEBPHOTO_FILE_KIND_19", "File Kind: 19" );
	define( "_WEBPHOTO_FILE_KIND_20", "File Kind: 20" );

// item kind
	define( "_WEBPHOTO_ITEM_KIND_IMAGE_CMYK", "Image (cmyk)" );
	define( "_WEBPHOTO_ITEM_KIND_VIDEO_H264", "Video (H264)" );

// item detail
	define( "_WEBPHOTO_ITEM_DETAIL_ONCLICK_DOWNLOAD", "Download" );

// item codeinfo
	define( "_WEBPHOTO_ITEM_CODEINFO_LARGE", "Large Image" );
	define( "_WEBPHOTO_ITEM_CODEINFO_WAV", "WAVE" );

// item display file
	define( "_WEBPHOTO_ITEM_DISPLAYFILE_DEFAULT", "Default" );

// photo form
	define( "_WEBPHOTO_CAP_JPEG_SELECT", "Select the JPEG image" );
	define( "_WEBPHOTO_FILE_JPEG_DSC", "Create the thumb image" );
	define( "_WEBPHOTO_FILE_JPEG_DELETE_DSC", "Delete with the thumb image" );

// mime option
	define( "_WEBPHOTO_MIME_KIND_IMAGE_JPEG", "Image jpg" );
	define( "_WEBPHOTO_MIME_KIND_VIDEO_FLV", "Video flv" );
	define( "_WEBPHOTO_MIME_KIND_AUDIO_MP3", "Audio mp3" );
	define( "_WEBPHOTO_MIME_KIND_AUDIO_FFMPEG", "Audio ffmpeg" );

// error
	define( "_WEBPHOTO_ERR_WAV", "Cannot create wave" );

//---------------------------------------------------------
// v2.40
//---------------------------------------------------------
// === redefine previous definition ===
	define( "_WEBPHOTO_FLASHVARS_FORM", "Edit of Flash Player's Options" );

// --- flashvar ---
// common
	define( "_WEBPHOTO_FLASHVAR_HEIGHT_DSC", "[Basics] height " );
	define( "_WEBPHOTO_FLASHVAR_WIDTH_DSC", "[Basics] width " );

	define( "_WEBPHOTO_FLASHVAR_SCREENCOLOR_DSC", "[Colors] screencolor <br>Background color of the display. <br>Is black by default." );
	define( "_WEBPHOTO_FLASHVAR_BACKCOLOR_DSC", "[Colors]  backcolor <br>background color of the controlbar and playlist. <br>This is white by default." );
	define( "_WEBPHOTO_FLASHVAR_FRONTCOLOR_DSC", "[Colors] frontcolor <br>color of all icons and texts in the controlbar and playlist. <br>Is black by default." );
	define( "_WEBPHOTO_FLASHVAR_LIGHTCOLOR_DSC", "[Colors] lightcolor <br>Color of an icon or text when you rollover it with the mouse. <br>Is black by default." );

	define( "_WEBPHOTO_FLASHVAR_SHUFFLE_DSC", "[Behaviour] shuffle <br>Shuffle playback of playlist items. <br>The player will randomly pick the items." );
	define( "_WEBPHOTO_FLASHVAR_VOLUME_DSC", "[Behaviour] volume <br>This sets the smoothing of videos, so you won�ft see blocks when a video is upscaled.  <br>Set this to false to disable the feature and get performance improvements with old computers / big files. " );

// player
	define( "_WEBPHOTO_FLASHVAR_IMAGE_DSC", "[Playlist] image <br>Location of a preview (poster) image; shown in display before the video starts." );

	define( "_WEBPHOTO_FLASHVAR_AUTOSTART_DSC", "[Behaviour] autostart <br>Set this to true to automatically start the player on load." );
	define( "_WEBPHOTO_FLASHVAR_BUFFERLENGTH_DSC", "[Behaviour] bufferlength <br>Number of seconds of the file that has to be loaded before the player starts playback. <br>Set this to a low value to enable instant-start (good for fast connections) and to a high value to get less mid-stream buffering (good for slow connections)." );
	define( "_WEBPHOTO_FLASHVAR_SMOOTHING_DSC", "[Behaviour] smoothing <br>This sets the smoothing of videos, so you won�ft see blocks when a video is upscaled.  <br>Set this to false to disable the feature and get performance improvements with old computers / big files. " );

// imagetotator
	define( "_WEBPHOTO_FLASHVAR_LOGO_DSC", "[Appearance] logo <br>Set this to an image that can be put as a watermark logo in the top right corner of the display.  <br>Transparent PNG files give the best results" );
	define( "_WEBPHOTO_FLASHVAR_OVERSTRETCH_DSC", "[Appearance] overstretch <br>Sets how to stretch images to make them fit the display. <br>The default stretches to fit the display.  <br>Set this to true to stretch them proportionally to fill the display, fit to stretch them disproportionally and none to keep original dimensions. " );
	define( "_WEBPHOTO_FLASHVAR_SHOWICONS_DSC", "[Appearance] showicons <br>Set this to false to hide the activity icon and play button in the middle of the display. " );
	define( "_WEBPHOTO_FLASHVAR_SHOWNAVIGATION_DSC", "[Appearance] shownavigation <br>�RSet this to false to completely hide the navigation bar. " );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_DSC", "[Appearance] transition <br>Sets the transition to use between images.  <br>The default, random, randomly pick a transition. To restrict to a certain transition, use these values: fade, bgfade, blocks, bubbles, circles, flash, fluids, lines or slowfade. " );
	define( "_WEBPHOTO_FLASHVAR_USEFULLSCREEN_DSC", "[Appearance] usefullscreen <br>Set this to false to hide the fullscreen button and disable fullscreen. " );

	define( "_WEBPHOTO_FLASHVAR_AUDIO_DSC", "[Behaviour] audio <br>Set this to false to completely hide the navigation bar. " );
	define( "_WEBPHOTO_FLASHVAR_LINKFROMDISPLAY_DSC", "[Behaviour] linkfromdisplay <br>Set this to true to make a click on the display result in a jump to the webpage assigned to the link playlist metadata. " );
	define( "_WEBPHOTO_FLASHVAR_LINKTARGET_DSC", "[Behaviour] linktarget <br>Set this to the frame you want hyperlinks to open in. Set it to _blank to open links in a new window or _top to open in the top frame. " );
	define( "_WEBPHOTO_FLASHVAR_REPEAT_DSC", "[Behaviour] repeat <br>Set this to true to automatically repeat playback of all images.  <br>Set this to list to playback an entire playlist once. " );
	define( "_WEBPHOTO_FLASHVAR_ROTATETIME_DSC", "[Behaviour] rotatetime <br>Sets the duration in seconds an image is shown before transitioning again." );

// === new definition ===
	define( "_WEBPHOTO_FLASHVARS_ADD", "Add Flash Player's Options" );

// --- flashvar table ---
// Playlist Properties
	define( "_WEBPHOTO_FLASHVAR_PLAYLISTFILE", "Playlist File" );
	define( "_WEBPHOTO_FLASHVAR_START", "Start Time" );
	define( "_WEBPHOTO_FLASHVAR_DURATION", "Duration" );
	define( "_WEBPHOTO_FLASHVAR_MEDIAID", "Media ID" );
	define( "_WEBPHOTO_FLASHVAR_PROVIDER", "Provider" );
	define( "_WEBPHOTO_FLASHVAR_STREAMER", "Streamer" );
	define( "_WEBPHOTO_FLASHVAR_NETSTREAMBASEPATH", "Netstream Base Path" );

// Layout
	define( "_WEBPHOTO_FLASHVAR_DOCK", "Dock" );
	define( "_WEBPHOTO_FLASHVAR_ICONS", "Icons" );
	define( "_WEBPHOTO_FLASHVAR_SKIN", "Skin" );
	define( "_WEBPHOTO_FLASHVAR_CONTROLBAR_POSITION", "Controlbar Pposition" );
	define( "_WEBPHOTO_FLASHVAR_CONTROLBAR_IDLEHIDE", "Controlbar Iidle Hide" );
	define( "_WEBPHOTO_FLASHVAR_DISPLAY_SHOWMUTE", "Display Show Mute " );
	define( "_WEBPHOTO_FLASHVAR_PLAYLIST_POSITION", "Playlist Position " );
	define( "_WEBPHOTO_FLASHVAR_PLAYLIST_SIZE", "Playlist Size" );

// Behavior
	define( "_WEBPHOTO_FLASHVAR_PLAYER_REPEAT", "Repeat" );
	define( "_WEBPHOTO_FLASHVAR_ITEM", "Item" );
	define( "_WEBPHOTO_FLASHVAR_MUTE", "Mute" );
	define( "_WEBPHOTO_FLASHVAR_PLAYERREADY", "Player Ready" );
	define( "_WEBPHOTO_FLASHVAR_PLUGINS", "Plugins" );
	define( "_WEBPHOTO_FLASHVAR_STRETCHING", "Stretching" );

// Logo
	define( "_WEBPHOTO_FLASHVAR_LOGO_FILE", "Logo File" );
	define( "_WEBPHOTO_FLASHVAR_LOGO_LINK", "Logo Link" );
	define( "_WEBPHOTO_FLASHVAR_LOGO_LINKTARGET", "Logo Link Target" );
	define( "_WEBPHOTO_FLASHVAR_LOGO_HIDE", "Logo Hide" );
	define( "_WEBPHOTO_FLASHVAR_LOGO_MARGIN", "Logo Margin" );
	define( "_WEBPHOTO_FLASHVAR_LOGO_POSITION", "Logo Position" );
	define( "_WEBPHOTO_FLASHVAR_LOGO_TIMEOUT", "Logo Timeout" );
	define( "_WEBPHOTO_FLASHVAR_LOGO_OVER", "Logo Over" );
	define( "_WEBPHOTO_FLASHVAR_LOGO_OUT", "Logo Out" );

// --- description ---
	define( "_WEBPHOTO_FLASHVAR_START_DSC", "[Playlist] start <br>Position in seconds where playback should start. <br>This option works for HTTP Pseudostreaming, RTMP Streaming and the MP3 and YouTube files. <br>It does not work for regular videos.)" );
	define( "_WEBPHOTO_FLASHVAR_DURATION_DSC", "[Playlist] duration <br>Duration of the file in seconds. <br>Set this to present the duration in the controlbar before the video starts. <br>It can also be set to a shorter value than the actual file duration. <br>The player will restrict playback to only that section." );
	define( "_WEBPHOTO_FLASHVAR_PLAYLISTFILE_DSC", "[Playlist] playlistfile <br>Location of an XML playlist to load into the player." );
	define( "_WEBPHOTO_FLASHVAR_MEDIAID_DSC", "[Playlist] mediaid <br>Unique string (e.g. 9Ks83JsK) used to identify this media file. <br>Is used by certain plugins, e.g. for the targeting of advertisements. <br>The player itself doesn�ft use this ID anywhere." );
	define( "_WEBPHOTO_FLASHVAR_PROVIDER_DSC", "[Playlist] provider <br>Set this flashvar to tell the player in which format (regular/streaming) the player is. <br>By default, the provider is detected by the player based upon the file extension. <br>If there is no suiteable extension, it can be manually set. <br>The following provider strings are supported:" );
	define( "_WEBPHOTO_FLASHVAR_STREAMER_DSC", "[Playlist] streamer <br>Location of an RTMP or HTTP server instance to use for streaming. <br>Can be an RTMP application or external PHP/ASP file. <br>See RTMP Streaming and HTTP Pseudostreaming." );
	define( "_WEBPHOTO_FLASHVAR_NETSTREAMBASEPATH_DSC", "[Playlist] netstreambasepath  <br>The netstreambasepath should be set to a URL from which relative paths will be calculated for video files.  <br>Introduced in JW Player 5.4, this configuration parameter directs the video and http media providers to request video files relative to the specified netstreambasepath rather than relative to the player SWF.  <br>This will likely cause issues for publishers using the JW Embedder with relative file paths." );

	define( "_WEBPHOTO_FLASHVAR_DOCK_DSC", "[Layout] dock <br>set this to false to show plugin buttons in controlbar. <br>By default (true), plugin buttons are shown in the display." );
	define( "_WEBPHOTO_FLASHVAR_ICONS_DSC", "[Layout] icons <br>set this to false to hide the play button and buffering icons in the display." );
	define( "_WEBPHOTO_FLASHVAR_SKIN_DSC", "[Layout] skin <br>Location of a skin file, containing graphics which change the look of the player. <br>There are two types of skins available:" );
	define( "_WEBPHOTO_FLASHVAR_CONTROLBAR_POSITION_DSC", "[Layout] controlbar.position <br>Position of the controlbar. <br>Can be set to bottom, top, over and none." );
	define( "_WEBPHOTO_FLASHVAR_CONTROLBAR_IDLEHIDE_DSC", "[Layout] controlbar.idlehide <br>If controlbar.position is set to over, this option determines whether the controlbar stays hidden when the player is paused or stopped." );
	define( "_WEBPHOTO_FLASHVAR_DISPLAY_SHOWMUTE_DSC", "[Layout] display.showmute <br>Shows a mute icon in the player's display window while the player is playing. <br>Disabled by default." );
	define( "_WEBPHOTO_FLASHVAR_PLAYLIST_POSITION_DSC", "[Layout] playlist.position <br>Position of the playlist. <br>Can be set to bottom, top, right, left, over or none." );
	define( "_WEBPHOTO_FLASHVAR_PLAYLIST_SIZE_DSC", "[Layout]  playlist.size <br>When the playlist is positioned below the display, this option can be used to change its height.  <br>When the playlist lives left or right of the display, this option represents its width. In the other cases, this option isn't needed." );

	define( "_WEBPHOTO_FLASHVAR_PLAYER_REPEAT_DSC", "[Behaviour] repeat <br>What to do when the mediafile has ended. <br>none Color of an icon or text when you rollover it with the mouse. Is black by default. <br>list: play each file in the playlist once, stop at the end. <br>always: continously play the file (or all files in the playlist). <br>single: continously repeat the current file in the playlist." );
	define( "_WEBPHOTO_FLASHVAR_ITEM_DSC", "[Behaviour] item <br>Playlist item that should start to play.  <br>Use this to start the player with a specific item instead of with the first item." );
	define( "_WEBPHOTO_FLASHVAR_MUTE_DSC", "[Behaviour] mute <br>Mute the sounds on startup.  <br>Is saved in a cookie." );
	define( "_WEBPHOTO_FLASHVAR_PLAYERREADY_DSC", "[Behaviour] playerready <br>By default, the player calls a playerReady() JavaScript function when it is initialized.  <br>This option is used to let the player call a different function after it�fs initialized (e.g. registerPlayer())." );
	define( "_WEBPHOTO_FLASHVAR_PLUGINS_DSC", "[Behaviour] plugins <br>A powerful feature, this is a comma-separated list of plugins to load (e.g. hd,viral). <br>Plugins are separate JavaScript or SWF files that extend the functionality of the player, e.g. with advertising, analytics or viral sharing features. <br>Visit our addons repository to browse the long list of available plugins." );
	define( "_WEBPHOTO_FLASHVAR_STRETCHING_DSC", "[Behaviour] stretching <br>Defines how to resize the poster image and video to fit the display." );

	define( "_WEBPHOTO_FLASHVAR_LOGO_FILE_DSC", "[Logo] logo.file <br>" );
	define( "_WEBPHOTO_FLASHVAR_LOGO_LINK_DSC", "[Logo] logo.link <br>HTTP link to jump to when the watermark image is clicked. <br>If it is not set, a click on the watermark does nothing." );
	define( "_WEBPHOTO_FLASHVAR_LOGO_LINKTARGET_DSC", "[Logo] logo.linktarget <br>Link target for logo click. <br>Can be _self, _blank, _parent, _top or a named frame." );
	define( "_WEBPHOTO_FLASHVAR_LOGO_HIDE_DSC", "[Logo] logo.hide <br>By default, the logo will automatically show when the player buffers and hide 3 seconds later. <br>When this option is set false, the logo will stay visible all the time." );
	define( "_WEBPHOTO_FLASHVAR_LOGO_MARGIN_DSC", "[Logo] logo.margin <br>The distance of the logo, in pixels from the sides of the player." );
	define( "_WEBPHOTO_FLASHVAR_LOGO_POSITION_DSC", "[Logo] logo.position <br>This sets the corner in which to display the watermark. <br>It can be one of the following:" );
	define( "_WEBPHOTO_FLASHVAR_LOGO_TIMEOUT_DSC", "[Logo] logo.timeout <br>When logo.hide is set to true, this option sets the number of seconds the logo is visible after it appears." );
	define( "_WEBPHOTO_FLASHVAR_LOGO_OVER_DSC", "[Logo] logo.over <br>The alpha transparency of the logo on mouseover. <br>Can be a decimal number from 0 to 1." );
	define( "_WEBPHOTO_FLASHVAR_LOGO_OUT_DSC", "[Logo] logo.out <br>The default alpha transparency of the logo when not moused over.<br> Can be a decimal number from 0 to 1." );

// --- options ---
	define( "_WEBPHOTO_FLASHVAR_PLAYER_REPEAT_NONE", "none" );
	define( "_WEBPHOTO_FLASHVAR_PLAYER_REPEAT_LIST", "list" );
	define( "_WEBPHOTO_FLASHVAR_PLAYER_REPEAT_ALWAYS", "always" );
	define( "_WEBPHOTO_FLASHVAR_PLAYER_REPEAT_SINGLE", "single" );

	define( "_WEBPHOTO_FLASHVAR_STRETCHING_NONE", "none" );
	define( "_WEBPHOTO_FLASHVAR_STRETCHING_EXACTFIT", "exactfit" );
	define( "_WEBPHOTO_FLASHVAR_STRETCHING_UNIFORM", "uniform" );
	define( "_WEBPHOTO_FLASHVAR_STRETCHING_FILL", "fill" );

	define( "_WEBPHOTO_FLASHVAR_CONTROLBAR_POSITION_BOTTOM", "bottom" );
	define( "_WEBPHOTO_FLASHVAR_CONTROLBAR_POSITION_TOP", "top" );
	define( "_WEBPHOTO_FLASHVAR_CONTROLBAR_POSITION_OVER", "over" );
	define( "_WEBPHOTO_FLASHVAR_CONTROLBAR_POSITION_NONE", "none" );

	define( "_WEBPHOTO_FLASHVAR_PLAYLIST_POSITION_BOTTOM", "bottom" );
	define( "_WEBPHOTO_FLASHVAR_PLAYLIST_POSITION_TOP", "top" );
	define( "_WEBPHOTO_FLASHVAR_PLAYLIST_POSITION_RIGHT", "right" );
	define( "_WEBPHOTO_FLASHVAR_PLAYLIST_POSITION_LEFT", "left" );
	define( "_WEBPHOTO_FLASHVAR_PLAYLIST_POSITION_OVER", "over" );
	define( "_WEBPHOTO_FLASHVAR_PLAYLIST_POSITION_NONE", "none" );

	define( "_WEBPHOTO_FLASHVAR_LOGO_POSITION_BOTTOM_LEFT", "bottom-left" );
	define( "_WEBPHOTO_FLASHVAR_LOGO_POSITION_BOTTOM_RIGHT", "bottom-right" );
	define( "_WEBPHOTO_FLASHVAR_LOGO_POSITION_TOP_LEFT", "top-left" );
	define( "_WEBPHOTO_FLASHVAR_LOGO_POSITION_TOP_RIGHT", "top-right" );

//---------------------------------------------------------
// v2.60
//---------------------------------------------------------
// cat handler
	define( "_WEBPHOTO_CAT_TIMELINE_MODE", "Timeline mode" );
	define( "_WEBPHOTO_CAT_TIMELINE_SCALE", "Timeline scale" );

// === define end ===
}
