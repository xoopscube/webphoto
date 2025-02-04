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
	define( $constpref . "NAME", "Gestão Multimédia" );

// A brief description of this module
	define( $constpref . "DESC", "Cria uma galeria de imagens onde os usuarios podem buscar, enviar e avaliar varios tipos de media." );

// Names of blocks for this module (Not all module has blocks)
	define( $constpref . "BNAME_RECENT", "Ultimos medias" );
	define( $constpref . "BNAME_HITS", "Top Medias" );
	define( $constpref . "BNAME_RANDOM", "Media Aleatoria" );
	define( $constpref . "BNAME_RECENT_P", "Ultimos Medias com Miniaturas" );
	define( $constpref . "BNAME_HITS_P", "Top Medias com Miniaturas" );

	define( $constpref . "CFG_IMAGINGPIPE", "Pacote de tratamento das imagens" );
	define( $constpref . "CFG_DESCIMAGINGPIPE", "Quase todos os ambientes em PHP podem usar GD. Mas GD funcionalmente inferior a duas outras versoes,<br>é melhor usar ImageMagick ou NetPBM, se for possivel." );
	define( $constpref . "CFG_FORCEGD2", "Forçar conversço para GD2" );
	define( $constpref . "CFG_DESCFORCEGD2", "Mesmo se o GD estiver disponivel na versao do PHP, é possivel a conversao para GD2(truecolor).<br>Algumas configuraçoes do PHP falham na criaçao de miniaturas com GD2<br>Esta configuraçao é relevante unicamente quando for usado GD" );
	define( $constpref . "CFG_IMAGICKPATH", "Percurso para o ImageMagick" );
	define( $constpref . "CFG_DESCIMAGICKPATH", "Embora todo o percurso para 'convert' deva estar escrito, deixe isso em branco na maioria dos ambientes.<br>Esta configuraçao é relevante unicamente quando for usado ImageMagick" );
	define( $constpref . "CFG_NETPBMPATH", "Percurso para o NetPBM" );
	define( $constpref . "CFG_DESCNETPBMPATH", "Embora todo o percurso para 'pnmscale' deva estar escrito, deixe isso em branco na maioria dos ambientes.<br>Esta configuraçao é relevante unicamente quando for usado NetPBM" );
	define( $constpref . "CFG_POPULAR", "Hits para ser popular" );
	define( $constpref . "CFG_NEWDAYS", "Dias entre o icone mostrado do 'novo'&'atualizado'" );
	define( $constpref . "CFG_NEWPHOTOS", "Numero de imagens como Novo no alto da pagina" );
	define( $constpref . "CFG_PERPAGE", "Imagens mostradas por paagina" );
	define( $constpref . "CFG_DESCPERPAGE", "Insira os numeros selecionaveis separados com '|'<br>ex) 10|20|50|100" );
	define( $constpref . "CFG_ALLOWNOIMAGE", "Permitir o envio sem imagens" );
	define( $constpref . "CFG_MAKETHUMB", "Fazer miniatura da imagem" );
	define( $constpref . "CFG_DESCMAKETHUMB", "Quando voce mudar 'Nao' para 'Sim', é melhor 'Atualizar as miniaturas'." );

// v2.30
define( $constpref . "CFG_WIDTH", "Largura maxima da imagem" );
define( $constpref . "CFG_DESCWIDTH", "Isto significa que a largura da imagem é redimensionada.<br>Se voce usa GD sem truecolor, isso implica em limitar a largura." );
define( $constpref . "CFG_HEIGHT", "Altura maxima da imagem" );
define( $constpref . "CFG_DESCHEIGHT", "Isto significa que a altura da imagem é redimensionada..<br>Se voce usa GD sem truecolor, isso implica em limitar a altura." );

define( $constpref . "CFG_FSIZE", "Tamanho maximo do arquivo" );
define( $constpref . "CFG_DESCFSIZE", "Limita o tamanho do arquivo enviado.(bytes)" );
	define( $constpref . "CFG_ADDPOSTS", "Numero adicionado de post de usuarios que postaram uma imagens." );
	define( $constpref . "CFG_DESCADDPOSTS", "Normalmente, 0 ou 1. Abaixo de zero 0 significa 0" );
	define( $constpref . "CFG_CATONSUBMENU", "Registrar a categoria mais alta no sub-menu" );
	define( $constpref . "CFG_NAMEORUNAME", "Mostrar o nome de quem postou" );
	define( $constpref . "CFG_DESCNAMEORUNAME", "Selecionar qual 'nome' é mostrado" );
	define( $constpref . "CFG_VIEWTYPE", "Type of view " );
	define( $constpref . "CFG_COLSOFTABLE", "N�mero de colunas na visualizaçao tipo tabela" );
	define( $constpref . "CFG_USESITEIMG", "Usar [siteimg] na integraçao da Administraçao de Imagens" );
	define( $constpref . "CFG_DESCUSESITEIMG", "A integraçao da administraçao de imagens insere [siteimg] ao inves de [img].<br>Voce tem de modificar o modulo.textsanitizer.php para cada modulo para habilitar a tag do [siteimg]" );
	define( $constpref . "OPT_USENAME", "Nome Real" );
	define( $constpref . "OPT_USEUNAME", "Nome de Login" );
	define( $constpref . "OPT_VIEWLIST", "Visualizaçao tipo Lista" );
	define( $constpref . "OPT_VIEWTABLE", "Visualizaçao tipo tabela" );

// Text for notifications
	define( $constpref . "GLOBAL_NOTIFY", "Global" );
	define( $constpref . "GLOBAL_NOTIFYDSC", "Opçoes de notificaçao globais" );
	define( $constpref . "CATEGORY_NOTIFY", "Categoria" );
	define( $constpref . "CATEGORY_NOTIFYDSC", "Opçoes de notificaçao aplicaveis da atual categoria de imagens" );
	define( $constpref . "PHOTO_NOTIFY", "Imagens" );
	define( $constpref . "PHOTO_NOTIFYDSC", "Opçoes de notificaçao aplicaveis da imagem atual" );

	define( $constpref . "GLOBAL_NEWPHOTO_NOTIFY", "Nova Imagem" );
	define( $constpref . "GLOBAL_NEWPHOTO_NOTIFYCAP", "Notifique-me quando novas imagens foram postadas" );
	define( $constpref . "GLOBAL_NEWPHOTO_NOTIFYDSC", "Receber notificaçao quando uma nova descriçao de imagem é postada." );
	define( $constpref . "GLOBAL_NEWPHOTO_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE}: auto-notificaçao: Nova Imagem" );

	define( $constpref . "CATEGORY_NEWPHOTO_NOTIFY", "Nova Imagem" );
	define( $constpref . "CATEGORY_NEWPHOTO_NOTIFYCAP", "Notifique-me quando uma nova imagem for postada nesta categoria" );
	define( $constpref . "CATEGORY_NEWPHOTO_NOTIFYDSC", "Receber notificaçao quando uma nova descriçao de imagem é postada nesta categoria" );
	define( $constpref . "CATEGORY_NEWPHOTO_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE}: auto-notificaçao: Nova Imagem" );

//=========================================================
// add for webphoto
//=========================================================

// Config Items
	define( $constpref . "CFG_SORT", "Ordem padrao na visualizaçao tipo lista" );
	define( $constpref . "OPT_SORT_IDA", "Numero do registro (Menor para o maior)" );
	define( $constpref . "OPT_SORT_IDD", "Numero de Registros (Mais recente para o menos recente)" );
	define( $constpref . "OPT_SORT_HITSA", "Popularidade (Menores para os maiores Hits)" );
	define( $constpref . "OPT_SORT_HITSD", "Popularidade (Maiores para os menores Hits)" );
	define( $constpref . "OPT_SORT_TITLEA", "Titulo (A to Z)" );
	define( $constpref . "OPT_SORT_TITLED", "Titulo (Z to A)" );
	define( $constpref . "OPT_SORT_DATEA", "Data da atualizaçao (Imagens antigas listas primeiro)" );
	define( $constpref . "OPT_SORT_DATED", "Data da atualizaçao (Novas imagens listadas primeiro)" );
	define( $constpref . "OPT_SORT_RATINGA", "Avaliaçao (Escores mais baixos para escores mais altos)" );
	define( $constpref . "OPT_SORT_RATINGD", "Avaliaçao (Escores mais altos pra escores mais baixos)" );
	define( $constpref . "OPT_SORT_RANDOM", "Aleatoria" );
	define( $constpref . "CFG_MIDDLE_WIDTH", "Largura da imagem em vista unica" );
	define( $constpref . "CFG_MIDDLE_HEIGHT", "Altura da imagem em vista unica" );
	define( $constpref . "CFG_THUMB_WIDTH", "Largura da miniatura" );
	define( $constpref . "CFG_THUMB_HEIGHT", "Altura da miniatura" );

	define( $constpref . "CFG_APIKEY", "Codigo Google API Key" );
	define( $constpref . "CFG_APIKEY_DSC", 'Obtenha o codigo do API em <br><a href="http://www.google.com/apis/maps/signup.html" target="_blank">Inscrever-se no Google Maps API</a><br><br>Para detalhes do parametro, veja o que segue<br><a href="http://www.google.com/apis/maps/documentation/reference.html" target="_blank">Referencia Google Maps API</a>' );
	define( $constpref . "CFG_LATITUDE", "Latitude" );
	define( $constpref . "CFG_LONGITUDE", "Longitude" );
	define( $constpref . "CFG_ZOOM", "Nivel de Zoom" );

	define( $constpref . "CFG_USE_POPBOX", "Usar PopBox" );

	define( $constpref . "CFG_INDEX_DESC", "Texto introdutorio na pagina principal" );
	define( $constpref . "CFG_INDEX_DESC_DEFAULT", "Aqui é onde vai sua pagina introdutoria.<br>Voce pode editar nas Preferencias" );

// Sub menu titles
	define( $constpref . "SMNAME_SUBMIT", "Enviar" );
	define( $constpref . "SMNAME_POPULAR", "Popular" );
	define( $constpref . "SMNAME_HIGHRATE", "Melhor avaliada" );
	define( $constpref . "SMNAME_MYPHOTO", "Minhas Imagens" );

// Names of admin menu items
	define( $constpref . "ADMENU_PHOTOMANAGER", "Administraçao de Imagens" );
	define( $constpref . "ADMENU_CATMANAGER", "Adicionar/Editar Categorias" );
	define( $constpref . "ADMENU_CHECKCONFIGS", "Checar Configuraçao" );
	define( $constpref . "ADMENU_BATCH", "Registro em lote" );
	define( $constpref . "ADMENU_GROUPPERM", "Permissoes Globais" );
	define( $constpref . "ADMENU_IMPORT", "Importar Imagens" );
	define( $constpref . "ADMENU_EXPORT", "Exportar Imagens" );

	define( $constpref . "ADMENU_GICONMANAGER", "Administraçao icones do Google" );
	define( $constpref . "ADMENU_MIMETYPES", "Administraçao tipos de MIME" );
	define( $constpref . "ADMENU_IMPORT_MYALBUM", "Importar lote do Myalbum" );
	define( $constpref . "ADMENU_CHECKTABLES", "Checar configuraçao das tabelas" );
	define( $constpref . "ADMENU_PHOTO_TABLE_MANAGE", "Administrar Tabela de Imagem" );
	define( $constpref . "ADMENU_CAT_TABLE_MANAGE", "Administrar Tabela das Categorias" );
	define( $constpref . "ADMENU_VOTE_TABLE_MANAGE", "Administrar Tabela de Votaçoes" );
	define( $constpref . "ADMENU_GICON_TABLE_MANAGE", "Administrar Tabela do icone do Google" );
	define( $constpref . "ADMENU_MIME_TABLE_MANAGE", "Administrar Tabela do MIME" );
	define( $constpref . "ADMENU_TAG_TABLE_MANAGE", "Administrar Tabela de Tag" );
	define( $constpref . "ADMENU_P2T_TABLE_MANAGE", "Administrar Tabela de tags das Imagens" );
	define( $constpref . "ADMENU_SYNO_TABLE_MANAGE", "Administrar Tabela de Sinonimo" );

//---------------------------------------------------------
// v0.20
//---------------------------------------------------------
	define( $constpref . "CFG_USE_FFMPEG", "Usar ffmpeg" );
	define( $constpref . "CFG_FFMPEGPATH", "Percurso para o ffmpeg" );
	define( $constpref . "CFG_DESCFFMPEGPATH", "Embora todo o percurso para o 'ffmpeg' deva ser escrito, deixe-o em branco na maioria dos ambientes.<br>Esta configuraçao é relevante apenas quando 'Usar ffmpeg' - sim" );
	define( $constpref . "CFG_USE_PATHINFO", "Usar pathinfo" );

//---------------------------------------------------------
// v0.30
//---------------------------------------------------------
	define( $constpref . "CFG_MAIL_HOST", "Nome do Servidor de e-mail" );
	define( $constpref . "CFG_MAIL_USER", "ID do usuario de e-mai" );
	define( $constpref . "CFG_MAIL_PASS", "Senha do e-mail" );
	define( $constpref . "CFG_MAIL_ADDR", "Endereço do e-mail" );
	define( $constpref . "CFG_MAIL_CHARSET", "Charset do e-mail" );
	define( $constpref . "CFG_MAIL_CHARSET_DSC", "Insira o Charset com o separador '|'.<br>Se voce nao precisa verificar o tipo de MIME, deixe isso em branco" );
	define( $constpref . "CFG_MAIL_CHARSET_LIST", "ISO-8859-1|US-ASCII|UTF-8" );
	define( $constpref . "CFG_FILE_DIR", "Percurso dos arquivos, via FTP" );
	define( $constpref . "CFG_FILE_DIR_DSC", "Preencha todo o percurso (O primeiro caracter deve ser '/'. O ultimo caracter nao deve ser '/'.)é recomendado configurar isso fora do diretorio raiz." );
	define( $constpref . "CFG_FILE_SIZE", "Tamanho maximo do arquivo, via FTP (byte)" );
	define( $constpref . "CFG_FILE_DESC", "Ajuda descriçao do FTP" );
	define( $constpref . "CFG_FILE_DESC_DSC", "Mostrar na ajuda, quando tiver permissao de 'Postar via FTP' " );
	define( $constpref . "CFG_FILE_DESC_TEXT", "
<b>Servidor FTP</b><br>
Host do servidor FTP: xxx<br>
ID do Usuario FTP: xxx<br>
Senha do FTP: xxx<br>" );

	define( $constpref . "ADMENU_MAILLOG_MANAGER", "Administraçao do Maillog" );
	define( $constpref . "ADMENU_MAILLOG_TABLE_MANAGE", "Administraçao da Tabela do Maillog" );
	define( $constpref . "ADMENU_USER_TABLE_MANAGE", "Administraçao da Tabela Auxiliar do Usuario" );

//---------------------------------------------------------
// v0.40
//---------------------------------------------------------
	define( $constpref . "CFG_BIN_PASS", "Senha de comando" );
	define( $constpref . "CFG_COM_DIRNAME", "Integraçao-comentario: nome do diretorio do d3forum" );
	define( $constpref . "CFG_COM_FORUM_ID", "Integraçao-comentario: ID do forum" );
	define( $constpref . "CFG_COM_VIEW", "Vizualizaçao da Integraçao-comentario" );

	define( $constpref . "ADMENU_UPDATE", "Atualizçao" );
	define( $constpref . "ADMENU_ITEM_TABLE_MANAGE", "Administraçao da Tabela do Item" );
	define( $constpref . "ADMENU_FILE_TABLE_MANAGE", "Administraçao da Tabela do arquivo" );

//---------------------------------------------------------
// v0.50
//---------------------------------------------------------
	define( $constpref . "CFG_UPLOADSPATH", "Path to upload files" );
	define( $constpref . "CFG_UPLOADSPATH_DSC", "Path from the directory installed XOOPS.<br>(The first character must be '/'. The last character should not be '/'.)<br>This directory's permission is 777 or 707 in unix." );
	define( $constpref . "CFG_MEDIASPATH", "Path to medias" );
	define( $constpref . "CFG_MEDIASPATH_DSC", "The directory where there are media files which are created the playlist. <br>Path from the directory installed XOOPS.<br>(The first character must be '/'. The last character should not be '/'.)" );
	define( $constpref . "CFG_LOGO_WIDTH", "Player Logo Width and Height" );
	define( $constpref . "CFG_USE_CALLBACK", "Use callback log" );
	define( $constpref . "CFG_USE_CALLBACK_DSC", "loggin Flash Player events by callback." );

	define( $constpref . "ADMENU_ITEM_MANAGER", "Item Management" );
	define( $constpref . "ADMENU_PLAYER_MANAGER", "Player Management" );
	define( $constpref . "ADMENU_FLASHVAR_MANAGER", "Flashvar Management" );
	define( $constpref . "ADMENU_PLAYER_TABLE_MANAGE", "Player Table Management" );
	define( $constpref . "ADMENU_FLASHVAR_TABLE_MANAGE", "Flashvar Table Management" );

//---------------------------------------------------------
// v0.60
//---------------------------------------------------------
	define( $constpref . "CFG_WORKDIR", "Work Directory Path" );
	define( $constpref . "CFG_WORKDIR_DSC", "Fill the fullpath (The first character must be '/'. The last character should not be '/'.)<br>Recommend to set to this out of the document route." );
	define( $constpref . "CFG_CAT_WIDTH", "Category Image Width and Height" );
	define( $constpref . "CFG_CSUB_WIDTH", "Image Width and Height in Sub Category" );
	define( $constpref . "CFG_GICON_WIDTH", "GoogleMap Icon Width and Height" );
	define( $constpref . "CFG_JPEG_QUALITY", "JPEG Quality" );
	define( $constpref . "CFG_JPEG_QUALITY_DSC", "1 - 100 <br>This configuration is significant only when using GD" );

//---------------------------------------------------------
// v0.80
//---------------------------------------------------------
	define( $constpref . "BNAME_CATLIST", "Category List" );
	define( $constpref . "BNAME_TAGCLOUD", "Tag Cloud" );

//---------------------------------------------------------
// v0.90
//---------------------------------------------------------
	define( $constpref . "CFG_PERM_CAT_READ", "Permission of Category" );
	define( $constpref . "CFG_PERM_CAT_READ_DSC", "Enable with the setting of Category table" );
	define( $constpref . "CFG_PERM_ITEM_READ", "Permission of Item" );
	define( $constpref . "CFG_PERM_ITEM_READ_DSC", "Enable with the setting of Item table" );
	define( $constpref . "OPT_PERM_READ_ALL", "Show ALL" );
	define( $constpref . "OPT_PERM_READ_NO_ITEM", "Not show Items" );
	define( $constpref . "OPT_PERM_READ_NO_CAT", "Not show Categories and Items" );

//---------------------------------------------------------
// v1.10
//---------------------------------------------------------
	define( $constpref . "CFG_USE_XPDF", "Use xpdf" );
	define( $constpref . "CFG_XPDFPATH", "Path to xpdf" );
	define( $constpref . "CFG_XPDFPATH_DSC", "Alhough the full path to 'pdftoppm' should be written, leave it blank in most environments.<br>This configuration is significant only when using xpdf" );

//---------------------------------------------------------
// v1.21
//---------------------------------------------------------
	define( $constpref . "ADMENU_RSS_MANAGER", "RSS Manager" );

//---------------------------------------------------------
// v1.30
//---------------------------------------------------------
	define( $constpref . "CFG_SMALL_WIDTH", "Image Width in timeline" );
	define( $constpref . "CFG_SMALL_HEIGHT", "Image Height in timeline" );
	define( $constpref . "CFG_TIMELINE_DIRNAME", "timeline dirname" );
	define( $constpref . "CFG_TIMELINE_DIRNAME_DSC", "Set dirname of timeline module" );
	define( $constpref . "CFG_TIMELINE_SCALE", "Timeline scale" );
	define( $constpref . "CFG_TIMELINE_SCALE_DSC", "Time scale in about 600px width" );
	define( $constpref . "OPT_TIMELINE_SCALE_WEEK", "one week" );
	define( $constpref . "OPT_TIMELINE_SCALE_MONTH", "one month" );
	define( $constpref . "OPT_TIMELINE_SCALE_YEAR", "one year" );
	define( $constpref . "OPT_TIMELINE_SCALE_DECADE", "10 years" );

//---------------------------------------------------------
// v1.40
//---------------------------------------------------------
// timeline
	define( $constpref . "CFG_TIMELINE_LATEST", "Number of latest photos in timeline" );
	define( $constpref . "CFG_TIMELINE_RANDOM", "Number of random photos in timeline" );
	define( $constpref . "BNAME_TIMELINE", "Timeline" );

// map, tag
	define( $constpref . "CFG_GMAP_PHOTOS", "Number of photos in map" );
	define( $constpref . "CFG_TAGS", "Number of tags in tagcloud" );

//---------------------------------------------------------
// v1.70
//---------------------------------------------------------
	define( $constpref . "CFG_ITEM_SUMMARY", "Max characters of photo description" );
	define( $constpref . "CFG_ITEM_SUMMARY_DSC", "Enter the maximum number of characters of photo description in the photo list.<br>-1 is unlimited" );
	define( $constpref . "CFG_CAT_SUMMARY", "Max characters of category description" );
	define( $constpref . "CFG_CAT_SUMMARY_DSC", "Enter the maximum number of characters of category description in the category list.<br>-1 is unlimited" );
	define( $constpref . "CFG_CAT_CHILD", "Show photos of subcategories" );
	define( $constpref . "CFG_CAT_CHILD_DSC", "Enter to show or not medias of subcategories in category list" );
	define( $constpref . "OPT_CAT_CHILD_NON", "Media of this category only. Hide subcategories" );
	define( $constpref . "OPT_CAT_CHILD_EMPTY", "When no media in this category, show medias of subcategories" );
	define( $constpref . "OPT_CAT_CHILD_ALWAYS", "Show always medias of subcategories" );

//---------------------------------------------------------
// v1.80
//---------------------------------------------------------
	define( $constpref . "CFG_USE_LAME", "Use lame" );
	define( $constpref . "CFG_LAMEPATH", "Path to lame" );
	define( $constpref . "CFG_LAMEPATH_DSC", "Although the full path to 'lame' should be written, leave it blank in most environments.<br>This configuration is significant only when using lame" );

	define( $constpref . "CFG_USE_TIMIDITY", "Use timidity" );
	define( $constpref . "CFG_TIMIDITYPATH", "Path to timidity" );
	define( $constpref . "CFG_TIMIDITYPATH_DSC", "Although the full path to 'timidity' should be written, leave it blank in most environments.<br>This configuration is significant only when using timidity" );

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
