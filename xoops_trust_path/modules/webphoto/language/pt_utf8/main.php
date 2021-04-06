<?php
// === define begin ===
if ( ! defined( "_MB_WEBPHOTO_LANG_LOADED" ) ) {

	define( "_MB_WEBPHOTO_LANG_LOADED", 1 );

//=========================================================
// base on myalbum
//=========================================================

	define( "_WEBPHOTO_CATEGORY", "Categoria" );
	define( "_WEBPHOTO_SUBMITTER", "Enviar" );
	define( "_WEBPHOTO_NOMATCH_PHOTO", "Nao ha imagem correspondente a seu pedido" );

	define( "_WEBPHOTO_ICON_NEW", "Novo" );
	define( "_WEBPHOTO_ICON_UPDATE", "Atualizado" );
	define( "_WEBPHOTO_ICON_POPULAR", "Popular" );
	define( "_WEBPHOTO_ICON_LASTUPDATE", "ultima Atualizaçao" );
	define( "_WEBPHOTO_ICON_HITS", "Hits" );
	define( "_WEBPHOTO_ICON_COMMENTS", "Comentarios" );

	define( "_WEBPHOTO_SORT_IDA", "Gravar numero (ID menor para as maiores)" );
	define( "_WEBPHOTO_SORT_IDD", "Gravar numero (ID maiorpra as menores)" );
	define( "_WEBPHOTO_SORT_HITSA", "Popularidade (Menos para muitos Hits)" );
	define( "_WEBPHOTO_SORT_HITSD", "Popularidade (Muitos para menos Hits)" );
	define( "_WEBPHOTO_SORT_TITLEA", "Titulo (A a Z)" );
	define( "_WEBPHOTO_SORT_TITLED", "Titulo (Z a A))" );
	define( "_WEBPHOTO_SORT_DATEA", "Data da atualizaçao (Imagens antigas listadas primeiros)" );
	define( "_WEBPHOTO_SORT_DATED", "Data da atualizaçao (Imagens recentes listadas primeiro)" );
	define( "_WEBPHOTO_SORT_RATINGA", "Avaliaçao (Escore mais baixo para escore maior)" );
	define( "_WEBPHOTO_SORT_RATINGD", "Avaliaçao (Escore mais alto para escore menor)" );
	define( "_WEBPHOTO_SORT_RANDOM", "Aleatorio" );

	define( "_WEBPHOTO_SORT_SORTBY", "Classificaçao por:" );
	define( "_WEBPHOTO_SORT_TITLE", "Titulo" );
	define( "_WEBPHOTO_SORT_DATE", "Data da atualizaçao" );
	define( "_WEBPHOTO_SORT_HITS", "Popularidade" );
	define( "_WEBPHOTO_SORT_RATING", "Avaliaçao" );
	define( "_WEBPHOTO_SORT_S_CURSORTEDBY", "Imagens atualmente classificadas por: %s" );

	define( "_WEBPHOTO_NAVI_PREVIOUS", "Anterior" );
	define( "_WEBPHOTO_NAVI_NEXT", "Proxima" );
	define( "_WEBPHOTO_S_NAVINFO", "Imagem no. %s - %s (fora de %s hit imagens)" );
	define( "_WEBPHOTO_S_THEREARE", "Existe <b>%s</b> Imagens em nosso banco de dados." );
	define( "_WEBPHOTO_S_MOREPHOTOS", "Mais fotos de %s" );
	define( "_WEBPHOTO_ONEVOTE", "1 voto" );
	define( "_WEBPHOTO_S_NUMVOTES", "%s votos" );
	define( "_WEBPHOTO_ONEPOST", "1 post" );
	define( "_WEBPHOTO_S_NUMPOSTS", "%s posts" );
	define( "_WEBPHOTO_VOTETHIS", "Vote nesta" );
	define( "_WEBPHOTO_TELLAFRIEND", "Diga a um amigo" );
	define( "_WEBPHOTO_SUBJECT4TAF", "Uma imagem para voce" );

//---------------------------------------------------------
// submit
//---------------------------------------------------------
// only "Y/m/d" , "d M Y" , "M d Y" can be interpreted
	define( "_WEBPHOTO_DTFMT_YMDHI", "d M Y H:i" );

	define( "_WEBPHOTO_TITLE_ADDPHOTO", "Adicionar Imagem" );
	define( "_WEBPHOTO_TITLE_PHOTOUPLOAD", "Enviar imagem" );
	define( "_WEBPHOTO_CAP_MAXPIXEL", "Tamanho maximo em pixel" );
	define( "_WEBPHOTO_CAP_MAXSIZE", "Tamanho maximo do arquivo (byte)" );
	define( "_WEBPHOTO_CAP_VALIDPHOTO", "Valido" );
	define( "_WEBPHOTO_DSC_TITLE_BLANK", "Deixe o titulo em branco para usar os nomes de arquivo como titulo" );

	define( "_WEBPHOTO_RADIO_ROTATETITLE", "Rotaçao da imagem" );
	define( "_WEBPHOTO_RADIO_ROTATE0", "nao girar" );
	define( "_WEBPHOTO_RADIO_ROTATE90", "girar a direita" );
	define( "_WEBPHOTO_RADIO_ROTATE180", "girar 180 graus" );
	define( "_WEBPHOTO_RADIO_ROTATE270", "girar a esquerda" );

	define( "_WEBPHOTO_SUBMIT_RECEIVED", "Nas recebemos sua foto. Obrigado!" );
	define( "_WEBPHOTO_SUBMIT_ALLPENDING", "Todas as fotos postadas dependenm de verificaçao." );

	define( "_WEBPHOTO_ERR_MUSTREGFIRST", "Desculpe, voce nao tem permissao para executar essa açao. <br>Por favor, registre-se ou faça seu login primeiro!" );
	define( "_WEBPHOTO_ERR_MUSTADDCATFIRST", "Desculpe, nao ha categorias ainda para acrescentar.<br>Por favor, crie uma categoria primeiro!" );
	define( "_WEBPHOTO_ERR_NOIMAGESPECIFIED", "Nenhuma imagem foi enviada" );
	define( "_WEBPHOTO_ERR_FILE", "As imagens sao grandes demais ou ha um problema com a configruaçao" );
	define( "_WEBPHOTO_ERR_FILEREAD", "Imagens estao sem permissao de leitura." );
	define( "_WEBPHOTO_ERR_TITLE", "Informar 'Titulo' " );

//---------------------------------------------------------
// edit
//---------------------------------------------------------
	define( "_WEBPHOTO_TITLE_EDIT", "Editar a Imagem" );
	define( "_WEBPHOTO_TITLE_PHOTODEL", "Deletar a Imagem" );
	define( "_WEBPHOTO_CONFIRM_PHOTODEL", "Deletar a foto?" );
	define( "_WEBPHOTO_DBUPDATED", "Banco de dados atualizado com sucesso!" );
	define( "_WEBPHOTO_DELETED", "Deletada!" );

//---------------------------------------------------------
// rate
//---------------------------------------------------------
	define( "_WEBPHOTO_RATE_VOTEONCE", "Por favor, nao vote para a mesma imagem mais de uma vez." );
	define( "_WEBPHOTO_RATE_RATINGSCALE", "A escala é de 1 a 10, sendo que 1 é pior e 10 excelente." );
	define( "_WEBPHOTO_RATE_BEOBJECTIVE", "Por favor, seja objetivo. Se todos receberem um 1 ou um 10, as avaliaçoes nao serao uteis." );
	define( "_WEBPHOTO_RATE_DONOTVOTE", "Nao vote para seu proprio recurso." );
	define( "_WEBPHOTO_RATE_IT", "Avaliar a imagem!" );
	define( "_WEBPHOTO_RATE_VOTEAPPRE", "Seu voto sera apreciado." );
	define( "_WEBPHOTO_RATE_S_THANKURATE", "Obrigado por ter tomado seu tempo avaliando uma de nossas imagens %s." );

	define( "_WEBPHOTO_ERR_NORATING", "Nenhuma avaliaçao selecionada." );
	define( "_WEBPHOTO_ERR_CANTVOTEOWN", "Voce nao pode votar em um recurso enviado por voce.<br>Todos os votos sao registrados e revisados." );
	define( "_WEBPHOTO_ERR_VOTEONCE", "Vote para os recursos selecionados apenas uma vez.<br>Todos os votos sao registrados e revisados." );

//---------------------------------------------------------
// move from myalbum_constants.php
//---------------------------------------------------------
// Caption
	define( "_WEBPHOTO_CAPTION_TOTAL", "Total:" );
	define( "_WEBPHOTO_CAPTION_GUESTNAME", "Convidado" );
	define( "_WEBPHOTO_CAPTION_REFRESH", "Atualizar" );
	define( "_WEBPHOTO_CAPTION_IMAGEXYT", "Tamanho(Tipo)" );
	define( "_WEBPHOTO_CAPTION_CATEGORY", "Categoria" );

//=========================================================
// add for webphoto
//=========================================================

//---------------------------------------------------------
// database table items
//---------------------------------------------------------

// photo table
	define( "_WEBPHOTO_PHOTO_TABLE", "Tabela da Imagem" );
	define( "_WEBPHOTO_PHOTO_ID", "ID da Imagem" );
	define( "_WEBPHOTO_PHOTO_TIME_CREATE", "Hora da criaçao" );
	define( "_WEBPHOTO_PHOTO_TIME_UPDATE", "Hora da atualizaçao" );
	define( "_WEBPHOTO_PHOTO_CAT_ID", "ID da categoria" );
	define( "_WEBPHOTO_PHOTO_GICON_ID", "ID do icone" );
	define( "_WEBPHOTO_PHOTO_UID", "ID do usuario" );
	define( "_WEBPHOTO_PHOTO_DATETIME", "Data da imagem" );
	define( "_WEBPHOTO_PHOTO_TITLE", "Titulo da Imagem" );
	define( "_WEBPHOTO_PHOTO_PLACE", "Lugar" );
	define( "_WEBPHOTO_PHOTO_EQUIPMENT", "Equipamento" );
	define( "_WEBPHOTO_PHOTO_FILE_URL", "URL do arquivo" );
	define( "_WEBPHOTO_PHOTO_FILE_PATH", "Percurso do arquivo" );
	define( "_WEBPHOTO_PHOTO_FILE_NAME", "Nome do Arquivo" );
	define( "_WEBPHOTO_PHOTO_FILE_EXT", "Extensao do arquivo" );
	define( "_WEBPHOTO_PHOTO_FILE_MIME", "MIME tipo do arquivo" );
	define( "_WEBPHOTO_PHOTO_FILE_MEDIUM", "Tipo do arquivo medio" );
	define( "_WEBPHOTO_PHOTO_FILE_SIZE", "Tamanho do arquivo" );
	define( "_WEBPHOTO_PHOTO_CONT_URL", "URL da Imagem" );
	define( "_WEBPHOTO_PHOTO_CONT_PATH", "Percurso da imagem" );
	define( "_WEBPHOTO_PHOTO_CONT_NAME", "Nome da imagem" );
	define( "_WEBPHOTO_PHOTO_CONT_EXT", "Extensao da Imagem" );
	define( "_WEBPHOTO_PHOTO_CONT_MIME", "MIME tipo da imagem" );
	define( "_WEBPHOTO_PHOTO_CONT_MEDIUM", "Imagem tipo m�dia" );
	define( "_WEBPHOTO_PHOTO_CONT_SIZE", "Tamanho do arquivo da foto" );
	define( "_WEBPHOTO_PHOTO_CONT_WIDTH", "Largura da imagem" );
	define( "_WEBPHOTO_PHOTO_CONT_HEIGHT", "Altura da imagem" );
	define( "_WEBPHOTO_PHOTO_CONT_DURATION", "Tempo de duraçao do video" );
	define( "_WEBPHOTO_PHOTO_CONT_EXIF", "Informaçao Exif" );
	define( "_WEBPHOTO_PHOTO_MIDDLE_WIDTH", "Largura da imagem media" );
	define( "_WEBPHOTO_PHOTO_MIDDLE_HEIGHT", "Altura da imagem media" );
	define( "_WEBPHOTO_PHOTO_THUMB_URL", "URL da miniatura" );
	define( "_WEBPHOTO_PHOTO_THUMB_PATH", "Percurso da miniatura" );
	define( "_WEBPHOTO_PHOTO_THUMB_NAME", "Nome da miniatura" );
	define( "_WEBPHOTO_PHOTO_THUMB_EXT", "Extensao da miniatura" );
	define( "_WEBPHOTO_PHOTO_THUMB_MIME", "MIME tipo da miniatura" );
	define( "_WEBPHOTO_PHOTO_THUMB_MEDIUM", "Tipo medio da miniatura" );
	define( "_WEBPHOTO_PHOTO_THUMB_SIZE", "Tamanho do arquivo da miniatura" );
	define( "_WEBPHOTO_PHOTO_THUMB_WIDTH", "Largura da miniatura" );
	define( "_WEBPHOTO_PHOTO_THUMB_HEIGHT", "Altura da miniatura" );
	define( "_WEBPHOTO_PHOTO_GMAP_LATITUDE", "Latitude no GoogleMap" );
	define( "_WEBPHOTO_PHOTO_GMAP_LONGITUDE", "Longitude no GoogleMap" );
	define( "_WEBPHOTO_PHOTO_GMAP_ZOOM", "Zoom do GoogleMap" );
	define( "_WEBPHOTO_PHOTO_GMAP_TYPE", "Tipo de GoogleMap" );
	define( "_WEBPHOTO_PHOTO_PERM_READ", "Permissao de leitura" );
	define( "_WEBPHOTO_PHOTO_STATUS", "Situaçao" );
	define( "_WEBPHOTO_PHOTO_HITS", "Hits" );
	define( "_WEBPHOTO_PHOTO_RATING", "Avaliaçao" );
	define( "_WEBPHOTO_PHOTO_VOTES", "Votos" );
	define( "_WEBPHOTO_PHOTO_COMMENTS", "Comentario" );
	define( "_WEBPHOTO_PHOTO_TEXT1", "text1" );
	define( "_WEBPHOTO_PHOTO_TEXT2", "text2" );
	define( "_WEBPHOTO_PHOTO_TEXT3", "text3" );
	define( "_WEBPHOTO_PHOTO_TEXT4", "text4" );
	define( "_WEBPHOTO_PHOTO_TEXT5", "text5" );
	define( "_WEBPHOTO_PHOTO_TEXT6", "text6" );
	define( "_WEBPHOTO_PHOTO_TEXT7", "text7" );
	define( "_WEBPHOTO_PHOTO_TEXT8", "text8" );
	define( "_WEBPHOTO_PHOTO_TEXT9", "text9" );
	define( "_WEBPHOTO_PHOTO_TEXT10", "text10" );
	define( "_WEBPHOTO_PHOTO_DESCRIPTION", "Descriçao da Imagem" );
	define( "_WEBPHOTO_PHOTO_SEARCH", "Busca" );

// category table
	define( "_WEBPHOTO_CAT_TABLE", "Tabela da Categoria" );
	define( "_WEBPHOTO_CAT_ID", "ID da categoria" );
	define( "_WEBPHOTO_CAT_TIME_CREATE", "Hora da criaçao" );
	define( "_WEBPHOTO_CAT_TIME_UPDATE", "Hora da atualizaçao" );
	define( "_WEBPHOTO_CAT_GICON_ID", "ID do icone" );
	define( "_WEBPHOTO_CAT_FORUM_ID", "ID do forum" );
	define( "_WEBPHOTO_CAT_PID", "ID relacionado" );
	define( "_WEBPHOTO_CAT_TITLE", "Titulo da categoria" );
	define( "_WEBPHOTO_CAT_IMG_PATH", "Percurso relativo para a imagem" );
	define( "_WEBPHOTO_CAT_IMG_MODE", "Modo de exibiçao da imagem" );
	define( "_WEBPHOTO_CAT_ORIG_WIDTH", "Lagura da imagem original" );
	define( "_WEBPHOTO_CAT_ORIG_HEIGHT", "Altura da imagem original" );
	define( "_WEBPHOTO_CAT_MAIN_WIDTH", "Largura da imagem na categoria proncipal" );
	define( "_WEBPHOTO_CAT_MAIN_HEIGHT", "Altura da imagem na categoria principal" );
	define( "_WEBPHOTO_CAT_SUB_WIDTH", "Largura da imagem na sub-categoria" );
	define( "_WEBPHOTO_CAT_SUB_HEIGHT", "Altura da imagem na sub-categoria" );
	define( "_WEBPHOTO_CAT_WEIGHT", "Peso" );
	define( "_WEBPHOTO_CAT_DEPTH", "Profundidade" );
	define( "_WEBPHOTO_CAT_ALLOWED_EXT", "Extensoes Permitidas" );
	define( "_WEBPHOTO_CAT_ITEM_TYPE", "Tipo de item" );
	define( "_WEBPHOTO_CAT_GMAP_MODE", "Modo de exibiçao no GoogleMap" );
	define( "_WEBPHOTO_CAT_GMAP_LATITUDE", "Latitude no GoogleMap" );
	define( "_WEBPHOTO_CAT_GMAP_LONGITUDE", "Longitude no GoogleMap" );
	define( "_WEBPHOTO_CAT_GMAP_ZOOM", "Zoom no GoogleMap" );
	define( "_WEBPHOTO_CAT_GMAP_TYPE", "Tipo no GoogleMap" );
	define( "_WEBPHOTO_CAT_PERM_READ", "Permissao de leitura" );
	define( "_WEBPHOTO_CAT_PERM_POST", "Permisao de Postagem" );
	define( "_WEBPHOTO_CAT_TEXT1", "text1" );
	define( "_WEBPHOTO_CAT_TEXT2", "text2" );
	define( "_WEBPHOTO_CAT_TEXT3", "text3" );
	define( "_WEBPHOTO_CAT_TEXT4", "text4" );
	define( "_WEBPHOTO_CAT_TEXT5", "text5" );
	define( "_WEBPHOTO_CAT_DESCRIPTION", "Descriçao da Categoria" );

// vote table
	define( "_WEBPHOTO_VOTE_TABLE", "Tabela de Voto" );
	define( "_WEBPHOTO_VOTE_ID", "ID do voto" );
	define( "_WEBPHOTO_VOTE_TIME_CREATE", "Hora da criaçao" );
	define( "_WEBPHOTO_VOTE_TIME_UPDATE", "Hora da atualizaçao" );
	define( "_WEBPHOTO_VOTE_PHOTO_ID", "IID da imagem" );
	define( "_WEBPHOTO_VOTE_UID", "ID do usuario" );
	define( "_WEBPHOTO_VOTE_RATING", "Avaliaçao" );
	define( "_WEBPHOTO_VOTE_HOSTNAME", "Endereço de IP" );

// google icon table
	define( "_WEBPHOTO_GICON_TABLE", "Tabela do icone Google" );
	define( "_WEBPHOTO_GICON_ID", "ID do icone" );
	define( "_WEBPHOTO_GICON_TIME_CREATE", "Hora da criaçao" );
	define( "_WEBPHOTO_GICON_TIME_UPDATE", "Hora da atualizaçao" );
	define( "_WEBPHOTO_GICON_TITLE", "Titulo do icone" );
	define( "_WEBPHOTO_GICON_IMAGE_PATH", "Percurso da imagem" );
	define( "_WEBPHOTO_GICON_IMAGE_NAME", "Nome da imagem" );
	define( "_WEBPHOTO_GICON_IMAGE_EXT", "Extntion da imagem" );
	define( "_WEBPHOTO_GICON_SHADOW_PATH", "Percurso da sombra" );
	define( "_WEBPHOTO_GICON_SHADOW_NAME", "Nome da sombra" );
	define( "_WEBPHOTO_GICON_SHADOW_EXT", "Extensao da sombra" );
	define( "_WEBPHOTO_GICON_IMAGE_WIDTH", "Largura da imagem" );
	define( "_WEBPHOTO_GICON_IMAGE_HEIGHT", "Altura da imagem" );
	define( "_WEBPHOTO_GICON_SHADOW_WIDTH", "Altura da sombra" );
	define( "_WEBPHOTO_GICON_SHADOW_HEIGHT", "Tamanho da sombra Y" );
	define( "_WEBPHOTO_GICON_ANCHOR_X", "ancora X Tamanho" );
	define( "_WEBPHOTO_GICON_ANCHOR_Y", "ancora Y Tamanho" );
	define( "_WEBPHOTO_GICON_INFO_X", "Informaçao do tamanho da janela X" );
	define( "_WEBPHOTO_GICON_INFO_Y", "Informaçao do tamanho da janela Y" );

// mime type table
	define( "_WEBPHOTO_MIME_TABLE", "Tabela MIME Tipo" );
	define( "_WEBPHOTO_MIME_ID", "ID MIME" );
	define( "_WEBPHOTO_MIME_TIME_CREATE", "Hora da criaçao" );
	define( "_WEBPHOTO_MIME_TIME_UPDATE", "Hora da atualizaçao" );
	define( "_WEBPHOTO_MIME_EXT", "Extensao" );
	define( "_WEBPHOTO_MIME_MEDIUM", "Tipo m�dio" );
	define( "_WEBPHOTO_MIME_TYPE", "Tipo de MIME" );
	define( "_WEBPHOTO_MIME_NAME", "Nome do MIME" );
	define( "_WEBPHOTO_MIME_PERMS", "Permissao" );

// added in v0.20
	define( "_WEBPHOTO_MIME_FFMPEG", "Opçao ffmpeg" );

// added in v1.80
	define( "_WEBPHOTO_MIME_KIND", "File Kind" );
	define( "_WEBPHOTO_MIME_OPTION", "Command Option" );

// tag table
	define( "_WEBPHOTO_TAG_TABLE", "Tabela de Tag" );
	define( "_WEBPHOTO_TAG_ID", "ID da Tag" );
	define( "_WEBPHOTO_TAG_TIME_CREATE", "Hora da criaçao" );
	define( "_WEBPHOTO_TAG_TIME_UPDATE", "Hora da atualizaçao" );
	define( "_WEBPHOTO_TAG_NAME", "Nome da Tag" );

// photo-to-tag table
	define( "_WEBPHOTO_P2T_TABLE", "Tabela Relaçao Imagem Tag" );
	define( "_WEBPHOTO_P2T_ID", "ID Imagem-Tag" );
	define( "_WEBPHOTO_P2T_TIME_CREATE", "Hora da criaçao" );
	define( "_WEBPHOTO_P2T_TIME_UPDATE", "Hora da atualizaçao" );
	define( "_WEBPHOTO_P2T_PHOTO_ID", "ID da imagem" );
	define( "_WEBPHOTO_P2T_TAG_ID", "ID da Tag" );
	define( "_WEBPHOTO_P2T_UID", "ID do usuario" );

// synonym table
	define( "_WEBPHOTO_SYNO_TABLE", "Tabela Sinonimo" );
	define( "_WEBPHOTO_SYNO_ID", "ID do sinonimo" );
	define( "_WEBPHOTO_SYNO_TIME_CREATE", "epoca da criaçao" );
	define( "_WEBPHOTO_SYNO_TIME_UPDATE", "epoca da atualizaçao" );
	define( "_WEBPHOTO_SYNO_WEIGHT", "Peso" );
	define( "_WEBPHOTO_SYNO_KEY", "Codigo" );
	define( "_WEBPHOTO_SYNO_VALUE", "Sinonimo" );

//---------------------------------------------------------
// title
//---------------------------------------------------------
	define( "_WEBPHOTO_TITLE_LATEST", "ultima" );
	define( "_WEBPHOTO_TITLE_SUBMIT", "Enviar" );
	define( "_WEBPHOTO_TITLE_POPULAR", "Popular" );
	define( "_WEBPHOTO_TITLE_HIGHRATE", "Melhor avaliada" );
	define( "_WEBPHOTO_TITLE_MYPHOTO", "Minhas Imagens" );
	define( "_WEBPHOTO_TITLE_RANDOM", "Imagens Aleatorias" );
	define( "_WEBPHOTO_TITLE_HELP", "Ajuda" );
	define( "_WEBPHOTO_TITLE_CATEGORY_LIST", "Lista de Categoria" );
	define( "_WEBPHOTO_TITLE_TAG_LIST", "Lista de Tag" );
	define( "_WEBPHOTO_TITLE_TAGS", "Tag" );
	define( "_WEBPHOTO_TITLE_USER_LIST", "Lista de Postadas" );
	define( "_WEBPHOTO_TITLE_DATE_LIST", "Lista da data das imagens" );
	define( "_WEBPHOTO_TITLE_PLACE_LIST", "Lista de lugares das imagens" );
	define( "_WEBPHOTO_TITLE_RSS", "RSS" );

	define( "_WEBPHOTO_VIEWTYPE_LIST", "Tipo e Lista" );
	define( "_WEBPHOTO_VIEWTYPE_TABLE", "Tipo de Tabela" );

	define( "_WEBPHOTO_CATLIST_ON", "Mostrar Categoria" );
	define( "_WEBPHOTO_CATLIST_OFF", "Esconder Categoria" );
	define( "_WEBPHOTO_TAGCLOUD_ON", "Mostrar nuvem de Tag" );
	define( "_WEBPHOTO_TAGCLOUD_OFF", "Esconder nuvem de Tag" );
	define( "_WEBPHOTO_GMAP_ON", "Mostrar GoogleMap" );
	define( "_WEBPHOTO_GMAP_OFF", "Esconder GoogleMap" );

	define( "_WEBPHOTO_NO_TAG", "Nao configurar Tag" );

//---------------------------------------------------------
// google maps
//---------------------------------------------------------
	define( "_WEBPHOTO_TITLE_GET_LOCATION", "Configuraçao da Latitude e Longitude" );
	define( "_WEBPHOTO_GMAP_DESC", "Mostrar miniatura da imagem, quando clicar no GoogleMaps" );
	define( "_WEBPHOTO_GMAP_ICON", "icones do GoogleMap" );
	define( "_WEBPHOTO_GMAP_LATITUDE", "Latitude do GoogleMap" );
	define( "_WEBPHOTO_GMAP_LONGITUDE", "Longitude do GoogleMap" );
	define( "_WEBPHOTO_GMAP_ZOOM", "Zoom do GoogleMap" );
	define( "_WEBPHOTO_GMAP_ADDRESS", "Endereço" );
	define( "_WEBPHOTO_GMAP_GET_LOCATION", "Obter latitude e longitude" );
	define( "_WEBPHOTO_GMAP_SEARCH_LIST", "Lista de Busca" );
	define( "_WEBPHOTO_GMAP_CURRENT_LOCATION", "Locaçao atual" );
	define( "_WEBPHOTO_GMAP_CURRENT_ADDRESS", "Endreço atual" );
	define( "_WEBPHOTO_GMAP_NO_MATCH_PLACE", "Nao ha lugar correspondente" );
	define( "_WEBPHOTO_GMAP_NOT_COMPATIBLE", "Nao mostrar o GoogleMaps em seu navegador" );
	define( "_WEBPHOTO_JS_INVALID", "Nao use JavaScript em seu navegador" );
	define( "_WEBPHOTO_IFRAME_NOT_SUPPORT", "Nao use iframe em seu navegador" );

//---------------------------------------------------------
// search
//---------------------------------------------------------
	define( "_WEBPHOTO_SR_SEARCH", "Busca" );

//---------------------------------------------------------
// popbox
//---------------------------------------------------------
	define( "_WEBPHOTO_POPBOX_REVERT", "Clique na imagem para reduzir o tamanho dela." );

//---------------------------------------------------------
// tag
//---------------------------------------------------------
	define( "_WEBPHOTO_TAGS", "Tags" );
	define( "_WEBPHOTO_EDIT_TAG", "Editar Tags" );
	define( "_WEBPHOTO_DSC_TAG_DIVID", "divida com a virgula(,) quando confogurar duas os mais" );
	define( "_WEBPHOTO_DSC_TAG_EDITABLE", "Voce pode editar somente as tags que voce postou" );

//---------------------------------------------------------
// submit form
//---------------------------------------------------------
	define( "_WEBPHOTO_CAP_ALLOWED_EXTS", "Extensoes permitidas" );
	define( "_WEBPHOTO_CAP_PHOTO_SELECT", "Selecione a imagem principal" );
	define( "_WEBPHOTO_CAP_THUMB_SELECT", "Selecione a imagem miniatura" );
	define( "_WEBPHOTO_DSC_THUMB_SELECT", "Cria da imagem principal, quando nao selecionado" );
	define( "_WEBPHOTO_DSC_SET_DATETIME", "Configurar datetime da imagem" );
	define( "_WEBPHOTO_DSC_SET_TIME_UPDATE", "Configurar hora da atualizaçao" );
	define( "_WEBPHOTO_DSC_PIXCEL_RESIZE", "Redimensionar automaticamente se maior que este tamanho" );
	define( "_WEBPHOTO_DSC_PIXCEL_REJECT", "Nao pode ser enviada, se maior que este temanho" );
	define( "_WEBPHOTO_BUTTON_CLEAR", "Limpar" );
	define( "_WEBPHOTO_SUBMIT_RESIZED", "Redimensionada, porque a imagem é grande demais " );

// PHP upload error
// http://www.php.net/manual/en/features.file-upload.errors.php
	define( "_WEBPHOTO_PHP_UPLOAD_ERR_OK", "Nao houve erro, o arquivo enviado com sucesso." );
	define( "_WEBPHOTO_PHP_UPLOAD_ERR_INI_SIZE", "O arquivo enviado excedeu o upload_max_filesize." );
	define( "_WEBPHOTO_PHP_UPLOAD_ERR_FORM_SIZE", "O arquivo enviado excedeu %s ." );
	define( "_WEBPHOTO_PHP_UPLOAD_ERR_PARTIAL", "O arquivo enviado foi somente carregado parcialmente." );
	define( "_WEBPHOTO_PHP_UPLOAD_ERR_NO_FILE", "Nenhum arquivo foi enviado." );
	define( "_WEBPHOTO_PHP_UPLOAD_ERR_NO_TMP_DIR", "Pasta temporaria esta faltando." );
	define( "_WEBPHOTO_PHP_UPLOAD_ERR_CANT_WRITE", "Falhou a gravaçao do arquivo no disco." );
	define( "_WEBPHOTO_PHP_UPLOAD_ERR_EXTENSION", "O arquivo enviado parou devido a estensao." );

// upload error
	define( "_WEBPHOTO_UPLOADER_ERR_NOT_FOUND", "Arquivo enviado nao encontrado" );
	define( "_WEBPHOTO_UPLOADER_ERR_INVALID_FILE_SIZE", "Tamanho do arquivo invalido" );
	define( "_WEBPHOTO_UPLOADER_ERR_EMPTY_FILE_NAME", "Nome do arquivo esta vazio" );
	define( "_WEBPHOTO_UPLOADER_ERR_NO_FILE", "Nenhum arquivo enviado" );
	define( "_WEBPHOTO_UPLOADER_ERR_NOT_SET_DIR", "Diretorio do upload nao configurado" );
	define( "_WEBPHOTO_UPLOADER_ERR_NOT_ALLOWED_EXT", "Extensao nao permitida" );
	define( "_WEBPHOTO_UPLOADER_ERR_PHP_OCCURED", "Erro ocorrido: Erro #" );
	define( "_WEBPHOTO_UPLOADER_ERR_NOT_OPEN_DIR", "Falhou a abertura do diretorio: " );
	define( "_WEBPHOTO_UPLOADER_ERR_NO_PERM_DIR", "Falhou a abertura do diretorio com pemissao de escrita: " );
	define( "_WEBPHOTO_UPLOADER_ERR_NOT_ALLOWED_MIME", "Tipo de MIME nao permitido: " );
	define( "_WEBPHOTO_UPLOADER_ERR_LARGE_FILE_SIZE", "Tamanho do arquivo muito grande: " );
	define( "_WEBPHOTO_UPLOADER_ERR_LARGE_WIDTH", "A largura do arquivo deve ser menor que " );
	define( "_WEBPHOTO_UPLOADER_ERR_LARGE_HEIGHT", "A altura do arquivo deve ser menor que" );
	define( "_WEBPHOTO_UPLOADER_ERR_UPLOAD", "Falhou o envio do arquivo: " );

//---------------------------------------------------------
// help
//---------------------------------------------------------
	define( "_WEBPHOTO_HELP_DSC", "Esta é a descriçao da aplicaçao que trabalha em seu PC" );

	define( "_WEBPHOTO_HELP_PICLENS_TITLE", "PicLens" );
	define( "_WEBPHOTO_HELP_PICLENS_DSC", '
Piclens é o complemento o qual a Cooliris Inc fornece para o FireFox<br>
Esta é uma visao das imagens no site<br><br>
<b>Configuraçao</b><br>
(1) Baixar FireFox<br>
<a href="http://www.mozilla-japan.org/products/firefox/" target="_blank">
http://www.mozilla-japan.org/products/firefox/
</a><br><br>
(2) Baixar o complemento Piclens<br>
<a href="http://www.piclens.com/" target="_blank">
http://www.piclens.com/
</a><br><br>
(3) Ver webphoto em webphoto<br>
http://THIS-SITE/modules/webphoto/ <br><br>
(4) Clique no icone azul no canto superior dirito do Firefox<br>
Vocee nao pode usar o Piclens, quando o icone e preto<br>' );

//
// dummy lines , adjusts line number for Japanese lang file.
//

	define( "_WEBPHOTO_HELP_MEDIARSSSLIDESHOW_TITLE", "Media RSS Slide Show" );
	define( "_WEBPHOTO_HELP_MEDIARSSSLIDESHOW_DSC", '
"Media RSS  Slide Show" is the google desktop gadget<br>
This shows photos from the internet with the slide show<br><br>
<b>Setting</b><br>
(1) Download "Google Desktop"<br>
<a href="http://desktop.google.co.jp/" target="_blank">
http://desktop.google.co.jp/
</a><br><br>
(2) Download "Media RSS  Slide Show" gadget<br>
<a href="http://desktop.google.com/plugins/i/mediarssslideshow.html" target="_blank">
http://desktop.google.com/plugins/i/mediarssslideshow.html
</a><br><br>
(3) Change "URL of MediaRSS" into the following, using the option of the gadget<br>' );

//---------------------------------------------------------
// others
//---------------------------------------------------------
	define( "_WEBPHOTO_RANDOM_MORE", "Mais imagens Aleatorias" );
	define( "_WEBPHOTO_USAGE_PHOTO", "Abre uma janela Pop-up com a imagem grande, quando a miniatura for clicada" );
	define( "_WEBPHOTO_USAGE_TITLE", "Move para a pagina da imagem, quando o titulo da imagem for clicado" );
	define( "_WEBPHOTO_DATE_NOT_SET", "Nao configurado a data da imagem" );
	define( "_WEBPHOTO_PLACE_NOT_SET", "Nao configurado o lugar da imagem" );
	define( "_WEBPHOTO_GOTO_ADMIN", "Ir para a o Painel Administrativo" );

//---------------------------------------------------------
// search for Japanese
//---------------------------------------------------------
	define( "_WEBPHOTO_SR_CANDICATE", "Candicate para busca" );
	define( "_WEBPHOTO_SR_ZENKAKU", "Zenkaku" );
	define( "_WEBPHOTO_SR_HANKAKU", "Hanhaku" );

	define( "_WEBPHOTO_JA_KUTEN", "" );
	define( "_WEBPHOTO_JA_DOKUTEN", "" );
	define( "_WEBPHOTO_JA_PERIOD", "" );
	define( "_WEBPHOTO_JA_COMMA", "" );

//---------------------------------------------------------
// v0.20
//---------------------------------------------------------
	define( "_WEBPHOTO_TITLE_VIDEO_THUMB_SEL", "Selecionar miniatura do video" );
	define( "_WEBPHOTO_TITLE_VIDEO_REDO", "Re-criar Flash e Miniatura do video enviado" );
	define( "_WEBPHOTO_CAP_REDO_THUMB", "Criar miniatura" );
	define( "_WEBPHOTO_CAP_REDO_FLASH", "Croiar video Flash" );
	define( "_WEBPHOTO_ERR_VIDEO_FLASH", "Nao criar video Flash" );
	define( "_WEBPHOTO_ERR_VIDEO_THUMB", "Substituir com o icone, porque nao pode criar miniatura do video" );
	define( "_WEBPHOTO_BUTTON_SELECT", "Selecionar" );

	define( "_WEBPHOTO_DSC_DOWNLOAD_PLAY", "Tocar apos o download" );
	define( "_WEBPHOTO_ICON_VIDEO", "Video" );
	define( "_WEBPHOTO_HOUR", "hora" );
	define( "_WEBPHOTO_MINUTE", "min" );
	define( "_WEBPHOTO_SECOND", "seg" );

//---------------------------------------------------------
// v0.30
//---------------------------------------------------------
// user table
	define( "_WEBPHOTO_USER_TABLE", "Tabela Uusario Aux" );
	define( "_WEBPHOTO_USER_ID", "ID do Usuçrio Aux" );
	define( "_WEBPHOTO_USER_TIME_CREATE", "Hora da criaçao" );
	define( "_WEBPHOTO_USER_TIME_UPDATE", "Hora da atualizaçao" );
	define( "_WEBPHOTO_USER_UID", "ID do usuario" );
	define( "_WEBPHOTO_USER_CAT_ID", "Categoria do ID" );
	define( "_WEBPHOTO_USER_EMAIL", "Endereço de E-mail" );
	define( "_WEBPHOTO_USER_TEXT1", "text1" );
	define( "_WEBPHOTO_USER_TEXT2", "text2" );
	define( "_WEBPHOTO_USER_TEXT3", "text3" );
	define( "_WEBPHOTO_USER_TEXT4", "text4" );
	define( "_WEBPHOTO_USER_TEXT5", "text5" );

// maillog
	define( "_WEBPHOTO_MAILLOG_TABLE", "Tabela do Maillog" );
	define( "_WEBPHOTO_MAILLOG_ID", "ID do Maillog" );
	define( "_WEBPHOTO_MAILLOG_TIME_CREATE", "Hora da criaçao" );
	define( "_WEBPHOTO_MAILLOG_TIME_UPDATE", "Hora da atualizaçao" );
	define( "_WEBPHOTO_MAILLOG_PHOTO_IDS", "ID da Imagem" );
	define( "_WEBPHOTO_MAILLOG_STATUS", "Situaçao" );
	define( "_WEBPHOTO_MAILLOG_FROM", "Mail do endereço" );
	define( "_WEBPHOTO_MAILLOG_SUBJECT", "Assunto" );
	define( "_WEBPHOTO_MAILLOG_BODY", "Corpo" );
	define( "_WEBPHOTO_MAILLOG_FILE", "Nome do arquivo" );
	define( "_WEBPHOTO_MAILLOG_ATTACH", "Arquivos anexados" );
	define( "_WEBPHOTO_MAILLOG_COMMENT", "Commntario" );

// mail register
	define( "_WEBPHOTO_TITLE_MAIL_REGISTER", "Endereço de E-mail do Registro" );
	define( "_WEBPHOTO_MAIL_HELP", "Por favor, consulte 'Ajuda' para uso" );
	define( "_WEBPHOTO_CAT_USER", "Nome do Usuario" );
	define( "_WEBPHOTO_BUTTON_REGISTER", "Registro" );
	define( "_WEBPHOTO_NOMATCH_USER", "Nao hausuario" );
	define( "_WEBPHOTO_ERR_MAIL_EMPTY", "Voc~e deve informar 'Endereço de E-mail' " );
	define( "_WEBPHOTO_ERR_MAIL_ILLEGAL", "Formato ilegal do endereço de e-mail" );

// mail retrieve
	define( "_WEBPHOTO_TITLE_MAIL_RETRIEVE", "Recupera E-mail" );
	define( "_WEBPHOTO_DSC_MAIL_RETRIEVE", "Recuperar e-mail do servidor de e-mails" );
	define( "_WEBPHOTO_BUTTON_RETRIEVE", "Recuperar" );
	define( "_WEBPHOTO_SUBTITLE_MAIL_ACCESS", "Acessando o servidor de e-mail" );
	define( "_WEBPHOTO_SUBTITLE_MAIL_PARSE", "Analisando os emails recebidos" );
	define( "_WEBPHOTO_SUBTITLE_MAIL_PHOTO", "Enviando imagens anexadas aos e-mails" );
	define( "_WEBPHOTO_TEXT_MAIL_ACCESS_TIME", "Limitaçao no acesso" );
	define( "_WEBPHOTO_TEXT_MAIL_RETRY", "Acesse 1 minuto mais tarde" );
	define( "_WEBPHOTO_TEXT_MAIL_NOT_RETRIEVE", "E-mail nao pode ser recuperado.<br>Provavelmente a comunica��o temporaria falhou.<br>Por favor, retorne mais tarde" );
	define( "_WEBPHOTO_TEXT_MAIL_NO_NEW", "Nao ha um novo e-mail" );
	define( "_WEBPHOTO_TEXT_MAIL_RETRIEVED_FMT", "Recuperado %s e-mails" );
	define( "_WEBPHOTO_TEXT_MAIL_NO_VALID", "Nao ha e-mail valido" );
	define( "_WEBPHOTO_TEXT_MAIL_SUBMITED_FMT", "Enviado %s imagens" );
	define( "_WEBPHOTO_GOTO_INDEX", "Ir ao modulo topo da pagina" );

// i.php
	define( "_WEBPHOTO_TITLE_MAIL_POST", "Postado por e-mail" );

// file
	define( "_WEBPHOTO_TITLE_FILE", "Adicionada imagem do arquivo" );
	define( "_WEBPHOTO_CAP_FILE_SELECT", "Selecionar arquivo" );
	define( "_WEBPHOTO_ERR_EMPTY_FILE", "Voct deve selecionar o arquivo" );
	define( "_WEBPHOTO_ERR_EMPTY_CAT", "Voct deve selecionar a categoria" );
	define( "_WEBPHOTO_ERR_INVALID_CAT", "Categoria Invalida" );
	define( "_WEBPHOTO_ERR_CREATE_PHOTO", "Imagem nao pode ser criada" );
	define( "_WEBPHOTO_ERR_CREATE_THUMB", "Miniatura da imagem nao pode ser criada" );

// help
	define( "_WEBPHOTO_HELP_MUST_LOGIN", "Por favor, efetue seu login caso deseje saber mais detalhes" );
	define( "_WEBPHOTO_HELP_NOT_PERM", "Voc� nao tem permissao. Por favor contate com o Webmaster" );

	define( "_WEBPHOTO_HELP_MOBILE_TITLE", "Celular" );
	define( "_WEBPHOTO_HELP_MOBILE_DSC", "Voce pode ver a imagem e o v�deo no celular<br>o tamanho da tela � de aproximadamente 240x320 " );
	define( "_WEBPHOTO_HELP_MOBILE_TEXT_FMT", '
<b>URL de Acesso</b><br>
<a href="{MODULE_URL}/i.php" target="_blank">{MODULE_URL}/i.php</a>' );

	define( "_WEBPHOTO_HELP_MAIL_TITLE", "E-mail do celular" );
	define( "_WEBPHOTO_HELP_MAIL_DSC", "Voce pode postar a imagem e o video por e-mail de seu telefone celular" );
	define( "_WEBPHOTO_HELP_MAIL_GUEST", "Este é um exemplo. Voce pode ver o endereço REAL do e-mail, se tiver permissao." );

	define( "_WEBPHOTO_HELP_FILE_TITLE", "Enviar por FTP" );
	define( "_WEBPHOTO_HELP_FILE_DSC", "Voce pode enviar a imagem tamanho grande e o video, quando voce envia o arquivo por FTP" );
	define( "_WEBPHOTO_HELP_FILE_TEXT_FMT", '
<b>Enviar Imagem</b><br>
(1) Enviar o arquivo pelo servidor FTP<br>
(2) Clique <a href="{MODULE_URL}/index.php?fct=submit_file" target="_blank">Adicionar imagem do arquivo</a><br>
(3) Selecione o arquivo enviado e postado' );

// mail check
// for Japanese
	define( "_WEBPHOTO_MAIL_DENY_TITLE_PREG", "" );
	define( "_WEBPHOTO_MAIL_AD_WORD_1", "" );
	define( "_WEBPHOTO_MAIL_AD_WORD_2", "" );

//---------------------------------------------------------
// v0.40
//---------------------------------------------------------
// item table
	define( "_WEBPHOTO_ITEM_TABLE", "Tabela Item" );
	define( "_WEBPHOTO_ITEM_ID", "ID do Item" );
	define( "_WEBPHOTO_ITEM_TIME_CREATE", "Hora da criaçao" );
	define( "_WEBPHOTO_ITEM_TIME_UPDATE", "Hora da atualizaçao" );
	define( "_WEBPHOTO_ITEM_CAT_ID", "ID da categoria" );
	define( "_WEBPHOTO_ITEM_GICON_ID", "ID do icone GoogleMap" );
	define( "_WEBPHOTO_ITEM_UID", "ID do usuario" );
	define( "_WEBPHOTO_ITEM_KIND", "Tipo de arquivo" );
	define( "_WEBPHOTO_ITEM_EXT", "Extensao do arquivo" );
	define( "_WEBPHOTO_ITEM_DATETIME", "Datetime da imagem" );
	define( "_WEBPHOTO_ITEM_TITLE", "Titulo da imagem" );
	define( "_WEBPHOTO_ITEM_PLACE", "Lugar" );
	define( "_WEBPHOTO_ITEM_EQUIPMENT", "Equipamento" );
	define( "_WEBPHOTO_ITEM_GMAP_LATITUDE", "Latitude do GoogleMap" );
	define( "_WEBPHOTO_ITEM_GMAP_LONGITUDE", "Longitude no GoogleMap" );
	define( "_WEBPHOTO_ITEM_GMAP_ZOOM", "Zoom no GoogleMap" );
	define( "_WEBPHOTO_ITEM_GMAP_TYPE", "Tipo no GoogleMap" );
	define( "_WEBPHOTO_ITEM_PERM_READ", "Permissao de leitura" );
	define( "_WEBPHOTO_ITEM_STATUS", "Situaçao" );
	define( "_WEBPHOTO_ITEM_HITS", "Hits" );
	define( "_WEBPHOTO_ITEM_RATING", "Avaliaçao" );
	define( "_WEBPHOTO_ITEM_VOTES", "Votos" );
	define( "_WEBPHOTO_ITEM_DESCRIPTION", "Descriçao da imagem" );
	define( "_WEBPHOTO_ITEM_EXIF", "Informaçao Exif" );
	define( "_WEBPHOTO_ITEM_SEARCH", "Busca" );
	define( "_WEBPHOTO_ITEM_COMMENTS", "Comentarios" );
	define( "_WEBPHOTO_ITEM_FILE_ID_1", "ID do arquivo: Conteudo" );
	define( "_WEBPHOTO_ITEM_FILE_ID_2", "ID do arquivo: Miniatura" );
	define( "_WEBPHOTO_ITEM_FILE_ID_3", "ID do arquivo: Medio" );
	define( "_WEBPHOTO_ITEM_FILE_ID_4", "ID do arquivo: Video Flash" );
	define( "_WEBPHOTO_ITEM_FILE_ID_5", "ID do arquivo: Video Docomo" );
	define( "_WEBPHOTO_ITEM_FILE_ID_6", "file6" );
	define( "_WEBPHOTO_ITEM_FILE_ID_7", "file7" );
	define( "_WEBPHOTO_ITEM_FILE_ID_8", "file8" );
	define( "_WEBPHOTO_ITEM_FILE_ID_9", "file9" );
	define( "_WEBPHOTO_ITEM_FILE_ID_10", "file10" );
	define( "_WEBPHOTO_ITEM_TEXT_1", "text1" );
	define( "_WEBPHOTO_ITEM_TEXT_2", "text2" );
	define( "_WEBPHOTO_ITEM_TEXT_3", "text3" );
	define( "_WEBPHOTO_ITEM_TEXT_4", "text4" );
	define( "_WEBPHOTO_ITEM_TEXT_5", "text5" );
	define( "_WEBPHOTO_ITEM_TEXT_6", "text6" );
	define( "_WEBPHOTO_ITEM_TEXT_7", "text7" );
	define( "_WEBPHOTO_ITEM_TEXT_8", "text8" );
	define( "_WEBPHOTO_ITEM_TEXT_9", "text9" );
	define( "_WEBPHOTO_ITEM_TEXT_10", "text10" );

// file table
	define( "_WEBPHOTO_FILE_TABLE", "Tabela Arquivo" );
	define( "_WEBPHOTO_FILE_ID", "ID do arquivo" );
	define( "_WEBPHOTO_FILE_TIME_CREATE", "Hora da criaçao" );
	define( "_WEBPHOTO_FILE_TIME_UPDATE", "Hora da atualizaçao" );
	define( "_WEBPHOTO_FILE_ITEM_ID", "ID do item" );
	define( "_WEBPHOTO_FILE_KIND", "Tipo de arquivo" );
	define( "_WEBPHOTO_FILE_URL", "URL" );
	define( "_WEBPHOTO_FILE_PATH", "Percurso do arquivo" );
	define( "_WEBPHOTO_FILE_NAME", "Nome do arquivo" );
	define( "_WEBPHOTO_FILE_EXT", "Extensao do arquivo" );
	define( "_WEBPHOTO_FILE_MIME", "Tipo de MIME" );
	define( "_WEBPHOTO_FILE_MEDIUM", "Tipo medio" );
	define( "_WEBPHOTO_FILE_SIZE", "Tamanho do arquivo" );
	define( "_WEBPHOTO_FILE_WIDTH", "Largura da imagem" );
	define( "_WEBPHOTO_FILE_HEIGHT", "Altura da imagem" );
	define( "_WEBPHOTO_FILE_DURATION", "Tempo de duraçao do video" );

// file kind ( for admin checktables )
	define( "_WEBPHOTO_FILE_KIND_1", "Conteudo" );
	define( "_WEBPHOTO_FILE_KIND_2", "Miniatura" );
	define( "_WEBPHOTO_FILE_KIND_3", "Medio" );
	define( "_WEBPHOTO_FILE_KIND_4", "Video Flash" );
	define( "_WEBPHOTO_FILE_KIND_5", "Video Docomo" );
	define( "_WEBPHOTO_FILE_KIND_6", "file6" );
	define( "_WEBPHOTO_FILE_KIND_7", "file7" );
	define( "_WEBPHOTO_FILE_KIND_8", "file8" );
	define( "_WEBPHOTO_FILE_KIND_9", "file9" );
	define( "_WEBPHOTO_FILE_KIND_10", "file10" );

// index
	define( "_WEBPHOTO_MOBILE_MAILTO", "Enviar URL para o celular" );

// i.php
	define( "_WEBPHOTO_TITLE_MAIL_JUDGE", "Juiz da operadora do celular" );
	define( "_WEBPHOTO_MAIL_MODEL", "Operadora do celular" );
	define( "_WEBPHOTO_MAIL_BROWSER", "Navegador WEB" );
	define( "_WEBPHOTO_MAIL_NOT_JUDGE", "Nao foi possivel julgar a operadora do celular" );
	define( "_WEBPHOTO_MAIL_TO_WEBMASTER", "E-mail para o webmaster" );

// help
	define( "_WEBPHOTO_HELP_MAIL_POST_FMT", '
<b>Preparar</b><br>
Registre o endere�o de e-mail do celular<br>
<a href="{MODULE_URL}/index.php?fct=mail_register" target="_blank">Registrar o endere�o de e-mail</a><br><br>
<b>Enviar Imagem</b><br>
Enviar e-mail para o seguinte endere�o com o arquivo da imagem anexo.<br>
<a href="mailto:{MAIL_ADDR}">{MAIL_ADDR}</a> {MAIL_GUEST} <br><br>
<b>Rotação da Imagem</b><br>
Você pode girar a imagem para a direita ou esquerda, desde que você informe o fim do "Assunto" como segue<br>
 R@ : girar a direita <br>
 L@ : girar a esquerda <br><br>' );
	define( "_WEBPHOTO_HELP_MAIL_SUBTITLE_RETRIEVE", "<b>Recuperar e-mail e enviar imagem</b><br>" );
	define( "_WEBPHOTO_HELP_MAIL_RETRIEVE_FMT", '
Clique<a href="{MODULE_URL}/i.php?op=post" target="_blank">Enviar por e-mai</a>, depois de alguns segundos envie e-mail.<br>
Webphoto recuperou o e-mail para o qual voc� enviou, submeter e mostrar a imagem anexa<br>' );
	define( "_WEBPHOTO_HELP_MAIL_RETRIEVE_TEXT", "Webphoto recuperou o e-mail para o qual voc� enviou, submeter e mostrar a imagem anexa<br>" );
	define( "_WEBPHOTO_HELP_MAIL_RETRIEVE_AUTO_FMT", '
O e-mail � enviado automaticamente %s segundos mais tarde, quando voce envia e-mail.<br>
Por favor, clique <a href="{MODULE_URL}/i.php?op=post" target="_blank">Postar por e-mail</a>, se n�o enviada.<br>' );

//---------------------------------------------------------
// v0.50
//---------------------------------------------------------
// item table
	define( "_WEBPHOTO_ITEM_TIME_PUBLISH", "Published Time" );
	define( "_WEBPHOTO_ITEM_TIME_EXPIRE", "Expired Time" );
	define( "_WEBPHOTO_ITEM_PLAYER_ID", "Player ID" );
	define( "_WEBPHOTO_ITEM_FLASHVAR_ID", "FlashVar ID" );
	define( "_WEBPHOTO_ITEM_DURATION", "Video Duration Time" );
	define( "_WEBPHOTO_ITEM_DISPLAYTYPE", "Display Type" );
	define( "_WEBPHOTO_ITEM_ONCLICK", "Action when click thumbnail" );
	define( "_WEBPHOTO_ITEM_SITEURL", "WebSite URL" );
	define( "_WEBPHOTO_ITEM_ARTIST", "Artist" );
	define( "_WEBPHOTO_ITEM_ALBUM", "Album" );
	define( "_WEBPHOTO_ITEM_LABEL", "Label" );
	define( "_WEBPHOTO_ITEM_VIEWS", "Views" );
	define( "_WEBPHOTO_ITEM_PERM_DOWN", "Download Permission" );
	define( "_WEBPHOTO_ITEM_EMBED_TYPE", "Plugin Type" );
	define( "_WEBPHOTO_ITEM_EMBED_SRC", "Plugin URL Param" );
	define( "_WEBPHOTO_ITEM_EXTERNAL_URL", "External URL" );
	define( "_WEBPHOTO_ITEM_EXTERNAL_THUMB", "External Thumbnail URL" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TYPE", "Playlist Type" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_FEED", "Playlist Feed URL" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_DIR", "Playlist Directory" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_CACHE", "Playlist Cache Name" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TIME", "Playlist Cache Time" );
	define( "_WEBPHOTO_ITEM_CHAIN", "Chain" );
	define( "_WEBPHOTO_ITEM_SHOWINFO", "Show Infomation" );

// player table
	define( "_WEBPHOTO_PLAYER_TABLE", "Player Table" );
	define( "_WEBPHOTO_PLAYER_ID", "Player ID" );
	define( "_WEBPHOTO_PLAYER_TIME_CREATE", "Create Time" );
	define( "_WEBPHOTO_PLAYER_TIME_UPDATE", "Update Time" );
	define( "_WEBPHOTO_PLAYER_TITLE", "Player Title " );
	define( "_WEBPHOTO_PLAYER_STYLE", "Style Option" );
	define( "_WEBPHOTO_PLAYER_WIDTH", "Player Width" );
	define( "_WEBPHOTO_PLAYER_HEIGHT", "Player Height" );
	define( "_WEBPHOTO_PLAYER_DISPLAYWIDTH", "Display Width" );
	define( "_WEBPHOTO_PLAYER_DISPLAYHEIGHT", "Display Height" );
	define( "_WEBPHOTO_PLAYER_SCREENCOLOR", "Screen Color" );
	define( "_WEBPHOTO_PLAYER_BACKCOLOR", "Back Color" );
	define( "_WEBPHOTO_PLAYER_FRONTCOLOR", "Front Color" );
	define( "_WEBPHOTO_PLAYER_LIGHTCOLOR", "Light Color" );

// FlashVar table
	define( "_WEBPHOTO_FLASHVAR_TABLE", "FlashVar Table" );
	define( "_WEBPHOTO_FLASHVAR_ID", "FlashVar ID" );
	define( "_WEBPHOTO_FLASHVAR_TIME_CREATE", "Create Time" );
	define( "_WEBPHOTO_FLASHVAR_TIME_UPDATE", "Update Time" );
	define( "_WEBPHOTO_FLASHVAR_ITEM_ID", "Item ID" );
	define( "_WEBPHOTO_FLASHVAR_WIDTH", "Player Width" );
	define( "_WEBPHOTO_FLASHVAR_HEIGHT", "Player Height" );
	define( "_WEBPHOTO_FLASHVAR_DISPLAYWIDTH", "Display Width" );
	define( "_WEBPHOTO_FLASHVAR_DISPLAYHEIGHT", "Display Height" );
	define( "_WEBPHOTO_FLASHVAR_IMAGE_SHOW", "Show Image" );
	define( "_WEBPHOTO_FLASHVAR_SEARCHBAR", "Searchbar" );
	define( "_WEBPHOTO_FLASHVAR_SHOWEQ", "Show Equalizer" );
	define( "_WEBPHOTO_FLASHVAR_SHOWICONS", "Activity Icons" );
	define( "_WEBPHOTO_FLASHVAR_SHOWNAVIGATION", "Show Navigation" );
	define( "_WEBPHOTO_FLASHVAR_SHOWSTOP", "Show Stop" );
	define( "_WEBPHOTO_FLASHVAR_SHOWDIGITS", "Show Digits" );
	define( "_WEBPHOTO_FLASHVAR_SHOWDOWNLOAD", "Show Download" );
	define( "_WEBPHOTO_FLASHVAR_USEFULLSCREEN", "Full Screen Button" );
	define( "_WEBPHOTO_FLASHVAR_AUTOSCROLL", "Scroll Bar Off" );
	define( "_WEBPHOTO_FLASHVAR_THUMBSINPLAYLIST", "Thumbnails" );
	define( "_WEBPHOTO_FLASHVAR_AUTOSTART", "Auto Start" );
	define( "_WEBPHOTO_FLASHVAR_REPEAT", "Repeat" );
	define( "_WEBPHOTO_FLASHVAR_SHUFFLE", "Shuffle" );
	define( "_WEBPHOTO_FLASHVAR_SMOOTHING", "Smoothing" );
	define( "_WEBPHOTO_FLASHVAR_ENABLEJS", "Enable Javascript" );
	define( "_WEBPHOTO_FLASHVAR_LINKFROMDISPLAY", "Link from Display" );
	define( "_WEBPHOTO_FLASHVAR_LINK_TYPE", "Screen Hyperlink" );
	define( "_WEBPHOTO_FLASHVAR_BUFFERLENGTH", "Bufferlength" );
	define( "_WEBPHOTO_FLASHVAR_ROTATETIME", "Image Rotation Time" );
	define( "_WEBPHOTO_FLASHVAR_VOLUME", "volume" );
	define( "_WEBPHOTO_FLASHVAR_LINKTARGET", "Link Target" );
	define( "_WEBPHOTO_FLASHVAR_OVERSTRETCH", "Stretch Image/Video" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION", "Slide Show Transition" );
	define( "_WEBPHOTO_FLASHVAR_SCREENCOLOR", "Screen Color" );
	define( "_WEBPHOTO_FLASHVAR_BACKCOLOR", "Back Color" );
	define( "_WEBPHOTO_FLASHVAR_FRONTCOLOR", "Front Color" );
	define( "_WEBPHOTO_FLASHVAR_LIGHTCOLOR", "Light Color" );
	define( "_WEBPHOTO_FLASHVAR_TYPE", "Type" );
	define( "_WEBPHOTO_FLASHVAR_FILE", "Media File" );
	define( "_WEBPHOTO_FLASHVAR_IMAGE", "Preview Image" );
	define( "_WEBPHOTO_FLASHVAR_LOGO", "Player Logo Image" );
	define( "_WEBPHOTO_FLASHVAR_LINK", "Screen Hyperlink" );
	define( "_WEBPHOTO_FLASHVAR_AUDIO", "Audio Program" );
	define( "_WEBPHOTO_FLASHVAR_CAPTIONS", "Captions URL" );
	define( "_WEBPHOTO_FLASHVAR_FALLBACK", "Fallback URL" );
	define( "_WEBPHOTO_FLASHVAR_CALLBACK", "Callback URL" );
	define( "_WEBPHOTO_FLASHVAR_JAVASCRIPTID", "JavaScript ID" );
	define( "_WEBPHOTO_FLASHVAR_RECOMMENDATIONS", "Recommendations" );
	define( "_WEBPHOTO_FLASHVAR_STREAMSCRIPT", "Stream Script URL" );
	define( "_WEBPHOTO_FLASHVAR_SEARCHLINK", "Search Link" );

// log file
	define( "_WEBPHOTO_LOGFILE_LINE", "Line" );
	define( "_WEBPHOTO_LOGFILE_DATE", "Date" );
	define( "_WEBPHOTO_LOGFILE_REFERER", "Referer" );
	define( "_WEBPHOTO_LOGFILE_IP", "IP Address" );
	define( "_WEBPHOTO_LOGFILE_STATE", "State" );
	define( "_WEBPHOTO_LOGFILE_ID", "ID" );
	define( "_WEBPHOTO_LOGFILE_TITLE", "Title" );
	define( "_WEBPHOTO_LOGFILE_FILE", "File" );
	define( "_WEBPHOTO_LOGFILE_DURATION", "Duration" );

// item option
	define( "_WEBPHOTO_ITEM_KIND_UNDEFINED", "Undefined" );
	define( "_WEBPHOTO_ITEM_KIND_NONE", "No Media" );
	define( "_WEBPHOTO_ITEM_KIND_GENERAL", "General" );
	define( "_WEBPHOTO_ITEM_KIND_IMAGE", "Image (jpg,gif,png)" );
	define( "_WEBPHOTO_ITEM_KIND_VIDEO", "Video (wmv,mov,flv..." );
	define( "_WEBPHOTO_ITEM_KIND_AUDIO", "Audio (mp3...)" );
	define( "_WEBPHOTO_ITEM_KIND_EMBED", "Embed Plugin" );
	define( "_WEBPHOTO_ITEM_KIND_EXTERNAL_GENERAL", "External General" );
	define( "_WEBPHOTO_ITEM_KIND_EXTERNAL_IMAGE", "External Image" );
	define( "_WEBPHOTO_ITEM_KIND_PLAYLIST_FEED", "PlayList Web Feed" );
	define( "_WEBPHOTO_ITEM_KIND_PLAYLIST_DIR", "PlayList Media directory" );

	define( "_WEBPHOTO_ITEM_DISPLAYTYPE_GENERAL", "General" );
	define( "_WEBPHOTO_ITEM_DISPLAYTYPE_IMAGE", "Image (jpg,gif,png)" );
	define( "_WEBPHOTO_ITEM_DISPLAYTYPE_EMBED", "Embed Plugin" );
	define( "_WEBPHOTO_ITEM_DISPLAYTYPE_SWFOBJECT", "FlashPlayer (swf)" );
	define( "_WEBPHOTO_ITEM_DISPLAYTYPE_MEDIAPLAYER", "MediaPlayer (jpg,gif,png,flv,mp3)" );
	define( "_WEBPHOTO_ITEM_DISPLAYTYPE_IMAGEROTATOR", "ImageRotator (jpg,gif,png)" );

	define( "_WEBPHOTO_ITEM_ONCLICK_PAGE", "Detail Page" );
	define( "_WEBPHOTO_ITEM_ONCLICK_DIRECT", "Direct Link" );
	define( "_WEBPHOTO_ITEM_ONCLICK_POPUP", "Image Popup" );

	define( "_WEBPHOTO_ITEM_PLAYLIST_TYPE_DSC", "What is the media file type?" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TYPE_NONE", "None" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TYPE_IMAGE", "Image (jpg,gif,png)" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TYPE_AUDIO", "Audio (mp3)" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TYPE_VIDEO", "Video (flv)" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TYPE_FLASH", "Flash (swf)" );

	define( "_WEBPHOTO_ITEM_SHOWINFO_DESCRIPTION", "Description" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_LOGOIMAGE", "Thumbnail" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_CREDITS", "Credits" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_STATISTICS", "Statistics" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_SUBMITTER", "Submitter" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_POPUP", "PopUp" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_TAGS", "Tags" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_DOWNLOAD", "Download" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_WEBSITE", "Site" );
	define( "_WEBPHOTO_ITEM_SHOWINFO_WEBFEED", "Feed" );

	define( "_WEBPHOTO_ITEM_STATUS_WAITING", "Waiting Approval" );
	define( "_WEBPHOTO_ITEM_STATUS_APPROVED", "Appoved" );
	define( "_WEBPHOTO_ITEM_STATUS_UPDATED", "Online (Updated)" );
	define( "_WEBPHOTO_ITEM_STATUS_OFFLINE", "Off Line" );
	define( "_WEBPHOTO_ITEM_STATUS_EXPIRED", "Expired" );

// player option
	define( "_WEBPHOTO_PLAYER_STYLE_MONO", "Monochrome" );
	define( "_WEBPHOTO_PLAYER_STYLE_THEME", "Color from Theme" );
	define( "_WEBPHOTO_PLAYER_STYLE_PLAYER", "Custom Player" );
	define( "_WEBPHOTO_PLAYER_STYLE_PAGE", "Custom Player/Page" );

// flashvar desc
	define( "_WEBPHOTO_FLASHVAR_ID_DSC", "[Basics] <br>Use this to set the RTMP stream identifier with the mediaplayer. <br>The ID will also be sent to statistics callbacks. <br>If you play a playlist, you can set an id for every entry. " );
	define( "_WEBPHOTO_FLASHVAR_DISPLAYHEIGHT_DSC", "[Playlist] [mediaplayer] <br>Set this smaller as the height to show a playlist below the display. <br>If you set it the same as the height, the controlbar will auto-hide on top of the video. " );
	define( "_WEBPHOTO_FLASHVAR_DISPLAYWIDTH_DSC", "[Playlist] [mediaplayer] <br>Bottom tracks:<br> Screen = Player<br> Side tracks:<br>Screen < Player " );
	define( "_WEBPHOTO_FLASHVAR_DISPLAY_DEFAULT", "when 0, use value of the player." );
	define( "_WEBPHOTO_FLASHVAR_COLOR_DEFAULT", "when blank, use value of the player." );
	define( "_WEBPHOTO_FLASHVAR_SEARCHBAR_DSC", "[Basics] <br>Set this to false to hide the searchbar below the display. <br>You can set the search destination with the searchlink flashvar. " );
	define( "_WEBPHOTO_FLASHVAR_IMAGE_SHOW_DSC", "[Basics] <br>true = Show preview image" );
	define( "_WEBPHOTO_FLASHVAR_FILE_DSC", "[Basics] <br>Sets the location of the file or playlist to play. <br>The imagerotator only plays playlists. " );
	define( "_WEBPHOTO_FLASHVAR_SHOWEQ_DSC", "[Display] <br>Set this to true to show a (fake) equalizer at the bottom of the display. <br>Nice for MP3 files. " );
	define( "_WEBPHOTO_FLASHVAR_SHOWSTOP_DSC", "[Controlbar] [mediaplayer] <br>Set this to true to show a stop button in the controlbar. " );
	define( "_WEBPHOTO_FLASHVAR_SHOWDIGITS_DSC", "[Controlbar] [mediaplayer] <br>Set this to false to hide the elapsed/remaining digits in the controlbar. " );
	define( "_WEBPHOTO_FLASHVAR_SHOWDOWNLOAD_DSC", "[Controlbar] [mediaplayer] <br>Set this to true to show a button in the player controlbar which links to the link flashvar. " );
	define( "_WEBPHOTO_FLASHVAR_AUTOSCROLL_DSC", "[Playlist] [mediaplayer] <br>Set this to true to automatically scroll through the playlist on rollover, instead of using a scrollbar. " );
	define( "_WEBPHOTO_FLASHVAR_THUMBSINPLAYLIST_DSC", "[Playlist] [mediaplayer] <br>Set this to false to hide preview images in the display" );
	define( "_WEBPHOTO_FLASHVAR_CAPTIONS_DSC", "[Playback] [mediaplayer] <br>Captions should be in TimedText format. <br>When using a playlist, you can assign captions for every entry. " );
	define( "_WEBPHOTO_FLASHVAR_FALLBACK_DSC", "[Playback] [mediaplayer] <br>If you play an MP4 file, set here the location of an FLV fallback. <br>It'll automatically be picked by older flash player. " );
	define( "_WEBPHOTO_FLASHVAR_ENABLEJS_DSC", "[External] <br>Set this to true to enable javascript interaction. <br>This'll only work online! <br>Javascript interaction includes playback control, asynchroneous loading of media files and return of track information. " );
	define( "_WEBPHOTO_FLASHVAR_JAVASCRIPTID_DSC", "[External] <br>If you interact with multiple mediaplayers/rotators in javascript, use this flashvar to give each of them a unique ID. " );
	define( "_WEBPHOTO_FLASHVAR_LINK_TYPE_DSC", "[External] <br>This link is assigned to the display, logo and link button. <br >when None, assign nothing. <br>Else, assign a webpage to open. " );
	define( "_WEBPHOTO_FLASHVAR_CALLBACK_DSC", "[External] <br>Set this to a serverside script that can process statistics. <br>The player will send it a POST every time an item starts/stops. <br>To send callbacks automatically to Google Analytics, set this to urchin or analytics. " );
	define( "_WEBPHOTO_FLASHVAR_RECOMMENDATIONS_DSC", "[External] [mediaplayer] <br>Set this to an XML with items you want to recommend. <br>The thumbs will show up when the current movie stops playing, just like Youtube. " );
	define( "_WEBPHOTO_FLASHVAR_SEARCHLINK_DSC", "[External] [mediaplayer] <br>Sets the destination of the searchbar. <br>The default is 'search.longtail.tv', but you can set other destinations. <br>Use the searchbar flashvar to hide the bar altogether. " );
	define( "_WEBPHOTO_FLASHVAR_STREAMSCRIPT_DSC", "[External] [mediaplayer] <br>Set this to the URL of a script to use for http streaming movies. <br>The parameters file and pos are sent to the script. <br>If you use LigHTTPD streaming, set this to lighttpd. " );
	define( "_WEBPHOTO_FLASHVAR_TYPE_DSC", "[External] [mediaplayer] <br>the mediaplayer which determines the type of file to play based upon the last three characters of the file flashvar. <br>This doesn't work with database id's or mod_rewrite, so you can set this flashvar to the correct filetype. <br>If not sure, the player assumes a playlist is loaded. " );

// flashvar option
	define( "_WEBPHOTO_FLASHVAR_LINK_TYPE_NONE", "None" );
	define( "_WEBPHOTO_FLASHVAR_LINK_TYPE_SITE", "Website URL" );
	define( "_WEBPHOTO_FLASHVAR_LINK_TYPE_PAGE", "Detail Page" );
	define( "_WEBPHOTO_FLASHVAR_LINK_TYPE_FILE", "Media File" );
	define( "_WEBPHOTO_FLASHVAR_LINKTREGET_SELF", "Self Window" );
	define( "_WEBPHOTO_FLASHVAR_LINKTREGET_BLANK", "New Window" );
	define( "_WEBPHOTO_FLASHVAR_OVERSTRETCH_FALSE", "False" );
	define( "_WEBPHOTO_FLASHVAR_OVERSTRETCH_FIT", "Fit" );
	define( "_WEBPHOTO_FLASHVAR_OVERSTRETCH_TRUE", "True" );
	define( "_WEBPHOTO_FLASHVAR_OVERSTRETCH_NONE", "None" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_OFF", "Slide Show Player Off" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_FADE", "Fade" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_SLOWFADE", "Slow Fade" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_BGFADE", "Background Fade" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_CIRCLES", "Circles" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_BLOCKS", "Blocks" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_BUBBLES", "Bubbles" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_FLASH", "Flash" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_FLUIDS", "Fluids" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_LINES", "Lines" );
	define( "_WEBPHOTO_FLASHVAR_TRANSITION_RANDOM", "Random" );

// edit form
	define( "_WEBPHOTO_CAP_DETAIL", "Show Detail" );
	define( "_WEBPHOTO_CAP_DETAIL_ONOFF", "On/Off" );
	define( "_WEBPHOTO_PLAYER", "Player" );
	define( "_WEBPHOTO_EMBED_ADD", "Add Embed Plugin" );
	define( "_WEBPHOTO_EMBED_THUMB", "The external source will provide a thumbnail." );
	define( "_WEBPHOTO_ERR_EMBED", "You MUST set plugin" );
	define( "_WEBPHOTO_ERR_PLAYLIST", "You MUST set playlist" );

// sort
	define( "_WEBPHOTO_SORT_VOTESA", "Votes (Least)" );
	define( "_WEBPHOTO_SORT_VOTESD", "Votes (Most)" );
	define( "_WEBPHOTO_SORT_VIEWSA", "Media Views (Least)" );
	define( "_WEBPHOTO_SORT_VIEWSD", "Media Views (Most)" );

// flashvar form
	define( "_WEBPHOTO_FLASHVARS_LIST", "List of Flash Variables" );
	define( "_WEBPHOTO_FLASHVARS_LOGO_SELECT", "Select a player logo" );
	define( "_WEBPHOTO_FLASHVARS_LOGO_UPLOAD", "Upload a player logo " );
	define( "_WEBPHOTO_FLASHVARS_LOGO_DSC", "[Display] <br>Player Logos are in " );
	define( "_WEBPHOTO_BUTTON_COLOR_PICKUP", "Color" );
	define( "_WEBPHOTO_BUTTON_RESTORE", "Restore Default" );

// Playlist Cache
	define( "_WEBPHOTO_PLAYLIST_STATUS_REPORT", "Status Report" );
	define( "_WEBPHOTO_PLAYLIST_STATUS_FETCHED", "This webfeed has been fetched and cached." );
	define( "_WEBPHOTO_PLAYLIST_STATUS_CREATED", "A new playlist has been cached" );
	define( "_WEBPHOTO_PLAYLIST_ERR_CACHE", "[ERROR] creating cache file" );
	define( "_WEBPHOTO_PLAYLIST_ERR_FETCH", "Failed to fetch the web feed. <br>Please confirm the web feed location and refresh the cache." );
	define( "_WEBPHOTO_PLAYLIST_ERR_NODIR", "The media directory does not exist" );
	define( "_WEBPHOTO_PLAYLIST_ERR_EMPTYDIR", "The media directory is empty" );
	define( "_WEBPHOTO_PLAYLIST_ERR_WRITE", "can not write the cache file" );

	define( "_WEBPHOTO_USER", "User" );
	define( "_WEBPHOTO_OR", "OR" );

//---------------------------------------------------------
// v0.60
//---------------------------------------------------------
// item table
//define("_WEBPHOTO_ITEM_ICON" , "Icon Name" ) ;

	define( "_WEBPHOTO_ITEM_EXTERNAL_MIDDLE", "External Middle URL" );

// cat table
	define( "_WEBPHOTO_CAT_IMG_NAME", "Category Image Name" );

// edit form
	define( "_WEBPHOTO_CAP_MIDDLE_SELECT", "Select the middle image" );

//---------------------------------------------------------
// v0.70
//---------------------------------------------------------
// item table
	define( "_WEBPHOTO_ITEM_CODEINFO", "Code Info" );
	define( "_WEBPHOTO_ITEM_PAGE_WIDTH", "Page Width" );
	define( "_WEBPHOTO_ITEM_PAGE_HEIGHT", "Page Height" );
	define( "_WEBPHOTO_ITEM_EMBED_TEXT", "Embed" );

// item option
	define( "_WEBPHOTO_ITEM_CODEINFO_CONT", "Media" );
	define( "_WEBPHOTO_ITEM_CODEINFO_THUMB", "Thumbnail Image" );
	define( "_WEBPHOTO_ITEM_CODEINFO_MIDDLE", "Middle Image" );
	define( "_WEBPHOTO_ITEM_CODEINFO_FLASH", "Flash Video" );
	define( "_WEBPHOTO_ITEM_CODEINFO_DOCOMO", "Docomo Video" );
	define( "_WEBPHOTO_ITEM_CODEINFO_PAGE", "URL" );
	define( "_WEBPHOTO_ITEM_CODEINFO_SITE", "Site" );
	define( "_WEBPHOTO_ITEM_CODEINFO_PLAY", "Playlist" );
	define( "_WEBPHOTO_ITEM_CODEINFO_EMBED", "Embed" );
	define( "_WEBPHOTO_ITEM_CODEINFO_JS", "Script" );

	define( "_WEBPHOTO_ITEM_PLAYLIST_TIME_HOUR", "1 hour" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TIME_DAY", "1 day" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TIME_WEEK", "1 week" );
	define( "_WEBPHOTO_ITEM_PLAYLIST_TIME_MONTH", "1 month" );

// photo
	define( "_WEBPHOTO_DOWNLOAD", "Download" );

// file_read
	define( "_WEBPHOTO_NO_FILE", "Not exist file" );

//---------------------------------------------------------
// v0.80
//---------------------------------------------------------
// item table
	define( "_WEBPHOTO_ITEM_ICON_NAME", "Icon Name" );
	define( "_WEBPHOTO_ITEM_ICON_WIDTH", "Icon Width" );
	define( "_WEBPHOTO_ITEM_ICON_HEIGHT", "Icon Height" );

// item form
	define( "_WEBPHOTO_DSC_SET_ITEM_TIME_UPDATE", "Set update time" );
	define( "_WEBPHOTO_DSC_SET_ITEM_TIME_PUBLISH", "Set publish time" );
	define( "_WEBPHOTO_DSC_SET_ITEM_TIME_EXPIRE", "Set expire time" );

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
	define( "_WEBPHOTO_GROUP_PERM_ALL", "All Groups" );

//---------------------------------------------------------
// v1.00
//---------------------------------------------------------
// item table
	define( "_WEBPHOTO_ITEM_EDITOR", "Editor" );
	define( "_WEBPHOTO_ITEM_DESCRIPTION_HTML", "HTML tags" );
	define( "_WEBPHOTO_ITEM_DESCRIPTION_SMILEY", "Smiley icons" );
	define( "_WEBPHOTO_ITEM_DESCRIPTION_XCODE", "XOOPS codes" );
	define( "_WEBPHOTO_ITEM_DESCRIPTION_IMAGE", "Images" );
	define( "_WEBPHOTO_ITEM_DESCRIPTION_BR", "Linebreak" );

// edit form
	define( "_WEBPHOTO_TITLE_EDITOR_SELECT", "Select Editor" );
	define( "_WEBPHOTO_CAP_DESCRIPTION_OPTION", "Options" );
	define( "_WEBPHOTO_CAP_HTML", "Enable HTML tags" );
	define( "_WEBPHOTO_CAP_SMILEY", "Enable smiley icons" );
	define( "_WEBPHOTO_CAP_XCODE", "Enable XOOPS codes" );
	define( "_WEBPHOTO_CAP_IMAGE", "Enable images" );
	define( "_WEBPHOTO_CAP_BR", "Enable linebreak" );

//---------------------------------------------------------
// v1.10
//---------------------------------------------------------
// item table
	define( "_WEBPHOTO_ITEM_WIDTH", "Width of Image" );
	define( "_WEBPHOTO_ITEM_HEIGHT", "Height of Image" );
	define( "_WEBPHOTO_ITEM_CONTENT", "Text Content" );

//---------------------------------------------------------
// v1.20
//---------------------------------------------------------
// item option
	define( "_WEBPHOTO_ITEM_CODEINFO_PDF", "PDF" );
	define( "_WEBPHOTO_ITEM_CODEINFO_SWF", "Flash swf" );

// form
	define( "_WEBPHOTO_ERR_PDF", "Cannot create PDF" );
	define( "_WEBPHOTO_ERR_SWF", "Cannot create Flash swf" );

// jodconverter
	define( "_WEBPHOTO_JODCONVERTER_JUNK_WORDS", "" );

//---------------------------------------------------------
// v1.30
//---------------------------------------------------------
	define( "_WEBPHOTO_TITLE_MAP", "GoogleMap" );
	define( "_WEBPHOTO_MAP_LARGE", "Show large map" );

// timeline
	define( "_WEBPHOTO_TITLE_TIMELINE", "Timeline" );
	define( "_WEBPHOTO_TIMELINE_ON", "Show timeline" );
	define( "_WEBPHOTO_TIMELINE_OFF", "Hide timeline" );
	define( "_WEBPHOTO_TIMELINE_SCALE_WEEK", "One Week" );
	define( "_WEBPHOTO_TIMELINE_SCALE_MONTH", "One Month" );
	define( "_WEBPHOTO_TIMELINE_SCALE_YEAR", "One Year" );
	define( "_WEBPHOTO_TIMELINE_SCALE_DECADE", "10 Years" );
	define( "_WEBPHOTO_TIMELINE_LARGE", "Show large timeline" );
	define( "_WEBPHOTO_TIMELINE_CAUTION_IE", "In InternetExplore, you cannot see it sometimes. Please try in other browsers such as Firfox, Opera, Safari." );

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
	define( "_WEBPHOTO_ITEM_DESCRIPTION_SCROLL", "Scroll view of Photo Video Media Description" );
	define( "_WEBPHOTO_ITEM_DESCRIPTION_SCROLL_DSC", "Enter the height of the scroll by the px unit.
 <br>When 0, it is usual view without the scroll." );

// item option
	define( "_WEBPHOTO_ITEM_DETAIL_ONCLICK_IMAGE", "Show photo video media in new window" );
	define( "_WEBPHOTO_ITEM_DETAIL_ONCLICK_LIGHTBOX", "Show photo video media with lightbox" );

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
