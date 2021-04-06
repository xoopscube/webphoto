<?php
// === define begin ===
if ( ! defined( "_AM_WEBPHOTO_LANG_LOADED" ) ) {

	define( "_AM_WEBPHOTO_LANG_LOADED", 1 );

//=========================================================
// base on myalbum
//=========================================================

// menu
	define( '_AM_WEBPHOTO_MYMENU_TPLSADMIN', 'Modelos' );
	define( '_AM_WEBPHOTO_MYMENU_BLOCKSADMIN', 'Permissoes/Blocos' );

// add for webphoto
	define( "_AM_WEBPHOTO_MYMENU_GOTO_MODULE", "Ir ao Modulo" );

// Index (Categories)
	define( "_AM_WEBPHOTO_CAT_TH_PHOTOS", "Imagens" );
	define( "_AM_WEBPHOTO_CAT_TH_OPERATION", "Operação" );
	define( "_AM_WEBPHOTO_CAT_TH_IMAGE", "Banner" );
	define( "_AM_WEBPHOTO_CAT_TH_PARENT", "Categoria Pai" );
	define( "_AM_WEBPHOTO_CAT_MENU_NEW", "Criando uma Categoria" );
	define( "_AM_WEBPHOTO_CAT_MENU_EDIT", "Editando uma Categoria" );
	define( "_AM_WEBPHOTO_CAT_INSERTED", "Uma categoria foi adicionada" );
	define( "_AM_WEBPHOTO_CAT_UPDATED", "A categoria foi modificada" );
	define( "_AM_WEBPHOTO_CAT_BTN_BATCH", "Aplicar" );
	define( "_AM_WEBPHOTO_CAT_LINK_MAKETOPCAT", "Criar uma nova categoria no topo" );
	define( "_AM_WEBPHOTO_CAT_LINK_ADDPHOTOS", "Adiconar uma imagem nesta categoria" );
	define( "_AM_WEBPHOTO_CAT_LINK_EDIT", "Editar esta categoria" );
	define( "_AM_WEBPHOTO_CAT_LINK_MAKESUBCAT", "Criar uma nova categoria sob esta categoria" );
	define( "_AM_WEBPHOTO_CAT_FMT_NEEDADMISSION", "%s imagens são necessarias para ser admitida" );
	define( "_AM_WEBPHOTO_CAT_FMT_CATDELCONFIRM", "%s eliminar com suas sub-categorias, imagens e comentarios. OK?" );

// Admission
	define( "_AM_WEBPHOTO_TH_BATCHUPDATE", "Checagem coletiva da atualiza��o das imagens" );
	define( "_AM_WEBPHOTO_OPT_NOCHANGE", "- NAO ALTERE -" );
	define( "_AM_WEBPHOTO_JS_UPDATECONFIRM", "Checagem dos itens que ser�o atualizados. OK?" );

// Module Checker
	define( "_AM_WEBPHOTO_H4_ENVIRONMENT", "Ambiente de Checagem" );
	define( "_AM_WEBPHOTO_PHPDIRECTIVE", "Diretivas do PHP" );
	define( "_AM_WEBPHOTO_BOTHOK", "ambos ok" );
	define( "_AM_WEBPHOTO_NEEDON", "precisam de" );

	define( "_AM_WEBPHOTO_H4_TABLE", "Tabela de Checagem" );
	define( "_AM_WEBPHOTO_COMMENTSTABLE", "Tabela de Comentarios" );
	define( "_AM_WEBPHOTO_NUMBEROFPHOTOS", "Numero de Imagens" );
	define( "_AM_WEBPHOTO_NUMBEROFDESCRIPTIONS", "Numero de Descri��es" );
	define( "_AM_WEBPHOTO_NUMBEROFCATEGORIES", "Numero de Categorias" );
	define( "_AM_WEBPHOTO_NUMBEROFVOTEDATA", "Numero de votos" );
	define( "_AM_WEBPHOTO_NUMBEROFCOMMENTS", "Numero de comentarios" );

	define( "_AM_WEBPHOTO_H4_CONFIG", "Configuração da Checagem" );
	define( "_AM_WEBPHOTO_PIPEFORIMAGES", "Pipe para as imagens" );

	define( "_AM_WEBPHOTO_ERR_LASTCHAR", "Erro: O ultimo caracter não pode ser '/'" );
	define( "_AM_WEBPHOTO_ERR_FIRSTCHAR", "Erro: O primeiro caracter deve ser '/'" );
	define( "_AM_WEBPHOTO_ERR_PERMISSION", "Erro: primeiro deve criar e aplicar chmod 777 neste diretorio, via ftp ou shell." );
	define( "_AM_WEBPHOTO_ERR_NOTDIRECTORY", "Erro: não é um diretorio." );
	define( "_AM_WEBPHOTO_ERR_READORWRITE", "Erro: Este diretorio não tem permissoes de escrita e leitura. Deve alterar as permissoes do diretorio para 777." );
	define( "_AM_WEBPHOTO_ERR_SAMEDIR", "Erro: O percurso das imagens não dever ser o mesmo percurso das miniaturas" );
	define( "_AM_WEBPHOTO_LNK_CHECKGD2", "Verifique se 'GD2'esta funcionando corretamente com PHP" );
	define( "_AM_WEBPHOTO_CHECKGD2", "Se a pagina não aparecer corretamente, nõo utlise GD em modo truecolor." );
	define( "_AM_WEBPHOTO_GD2SUCCESS", "Sucesso!<br>Provavelmente voc� pode usar o GD2 (truecolor) neste ambiente." );

	define( "_AM_WEBPHOTO_H4_PHOTOLINK", "Checar link das Imagens e Miniaturas" );
	define( "_AM_WEBPHOTO_NOWCHECKING", "Checando agora." );

	define( "_AM_WEBPHOTO_FMT_NUMBEROFDEADPHOTOS", "%s Arquivo de imagem morta foi encontrado." );
	define( "_AM_WEBPHOTO_FMT_NUMBEROFDEADTHUMBS", "%s miniaturas devem ser reconstruidas." );
	define( "_AM_WEBPHOTO_FMT_NUMBEROFREMOVEDTMPS", "%s lixo de arquivos foram removidos." );
	define( "_AM_WEBPHOTO_LINK_REDOTHUMBS", "reconstruir miniaturas" );
	define( "_AM_WEBPHOTO_LINK_TABLEMAINTENANCE", "manutenção das tabelas" );

// Redo Thumbnail
	define( "_AM_WEBPHOTO_FMT_CHECKING", "checando %s ..." );
	define( "_AM_WEBPHOTO_FORM_RECORDMAINTENANCE", "manutenção das imagens como novo arranjo das miniaturas, etc." );
	define( "_AM_WEBPHOTO_FAILEDREADING", "a leitura falhou." );
	define( "_AM_WEBPHOTO_CREATEDTHUMBS", "criada uma miniatura." );
	define( "_AM_WEBPHOTO_BIGTHUMBS", "falhou a feitura de uma miniatura. copiada." );
	define( "_AM_WEBPHOTO_SKIPPED", "Pulou." );
	define( "_AM_WEBPHOTO_SIZEREPAIRED", "(reparado o tamanho dos campos do registro.)" );
	define( "_AM_WEBPHOTO_RECREMOVED", "este registro foi removido." );
	define( "_AM_WEBPHOTO_PHOTONOTEXISTS", "A foto principal não existe." );
	define( "_AM_WEBPHOTO_PHOTORESIZED", "A foto principal foi redimencionada." );

	define( "_AM_WEBPHOTO_TEXT_RECORDFORSTARTING", "numero do registro começando com" );
	define( "_AM_WEBPHOTO_TEXT_NUMBERATATIME", "numero de registros processados por vez" );
	define( "_AM_WEBPHOTO_LABEL_DESCNUMBERATATIME", "Um numero muito grande pode provocar uma falha do servidor." );

	define( "_AM_WEBPHOTO_RADIO_FORCEREDO", "forçar a reelaboração mesmo se a miniatura existir" );
	define( "_AM_WEBPHOTO_RADIO_REMOVEREC", "remover registros que não apresentam link para a imagem principal" );
	define( "_AM_WEBPHOTO_RADIO_RESIZE", "redimencionar fotos maiores que os pixels especificados nas prefer�ncias correntes" );

	define( "_AM_WEBPHOTO_FINISHED", "concluido" );
	define( "_AM_WEBPHOTO_LINK_RESTART", "reiniciado" );
	define( "_AM_WEBPHOTO_SUBMIT_NEXT", "proximo" );

// GroupPerm Global
	define( "_AM_WEBPHOTO_GROUPPERM_GLOBALDESC", "Configurar os previlégios dos grupos para este modulo" );
	define( "_AM_WEBPHOTO_GPERMUPDATED", "As permissoes foram mudadas com sucesso" );

// Import
	define( "_AM_WEBPHOTO_H3_FMT_IMPORTTO", 'Importação de imagens de outros modulo para %s' );
	define( "_AM_WEBPHOTO_FMT_IMPORTFROMMYALBUMP", 'Importando de "%s" como modulo tipo myAlbum-P' );
	define( "_AM_WEBPHOTO_FMT_IMPORTFROMIMAGEMANAGER", 'Importação do administrador de imagens do XOOPS' );

	define( "_AM_WEBPHOTO_IMPORTCONFIRM", 'Confirmar importação. OK?' );
	define( "_AM_WEBPHOTO_FMT_IMPORTSUCCESS", '%s imagens importadas' );

// Export
	define( "_AM_WEBPHOTO_H3_FMT_EXPORTTO", 'Exportando imagens de %s para outro modulo' );
	define( "_AM_WEBPHOTO_FMT_EXPORTTOIMAGEMANAGER", 'Exportando para o administrador de imagens do XOOPS' );
	define( "_AM_WEBPHOTO_FMT_EXPORTIMSRCCAT", 'Fonte' );
	define( "_AM_WEBPHOTO_FMT_EXPORTIMDSTCAT", 'Destinação' );
	define( "_AM_WEBPHOTO_CB_EXPORTRECURSIVELY", 'com imagens em suas sub-categorias' );
	define( "_AM_WEBPHOTO_CB_EXPORTTHUMB", 'Exportar miniaturas ao invos das imagens principais' );
	define( "_AM_WEBPHOTO_EXPORTCONFIRM", 'Confirmar exportação. OK?' );
	define( "_AM_WEBPHOTO_FMT_EXPORTSUCCESS", '%s imagens exportadas' );

//---------------------------------------------------------
// move from main.php
//---------------------------------------------------------
	define( "_AM_WEBPHOTO_BTN_SELECTALL", "Secionar tudo" );
	define( "_AM_WEBPHOTO_BTN_SELECTNONE", "Não selecionar" );
	define( "_AM_WEBPHOTO_BTN_SELECTRVS", "Selecionar Reverso" );
	define( "_AM_WEBPHOTO_FMT_PHOTONUM", "%s em todas as paginas" );

	define( "_AM_WEBPHOTO_ADMISSION", "Admissão de Imagens" );
	define( "_AM_WEBPHOTO_ADMITTING", "Imagens permitidas" );
	define( "_AM_WEBPHOTO_LABEL_ADMIT", "Admitir as imagens que assinalou" );
	define( "_AM_WEBPHOTO_BUTTON_ADMIT", "Admitir" );
	define( "_AM_WEBPHOTO_BUTTON_EXTRACT", "extrair" );

	define( "_AM_WEBPHOTO_LABEL_REMOVE", "Remover as imagens assinaladas" );
	define( "_AM_WEBPHOTO_JS_REMOVECONFIRM", "Remover?" );
	define( "_AM_WEBPHOTO_LABEL_MOVE", "Mudar a categoria das imagens assinaladas" );
	define( "_AM_WEBPHOTO_BUTTON_MOVE", "Mover" );
	define( "_AM_WEBPHOTO_BUTTON_UPDATE", "Modificar" );
	define( "_AM_WEBPHOTO_DEADLINKMAINPHOTO", "A imagem principal n�o existe" );

	define( "_AM_WEBPHOTO_NOSUBMITTED", "Não ha novas imgens enviadas." );
	define( "_AM_WEBPHOTO_ADDMAIN", "Adicionar um categoria principal" );
	define( "_AM_WEBPHOTO_IMGURL", "URL da imagem (OPCIONAL A altura da imagem sera redimencionada para 50): " );
	define( "_AM_WEBPHOTO_ADD", "Adicionar" );
	define( "_AM_WEBPHOTO_ADDSUB", "Adicionar uma sub-categoria" );
	define( "_AM_WEBPHOTO_IN", "no" );
	define( "_AM_WEBPHOTO_MODCAT", "Modificar Categoria" );

	define( "_AM_WEBPHOTO_MODREQDELETED", "Requisição de modificação foi eliminada." );
	define( "_AM_WEBPHOTO_IMGURLMAIN", "URL da imagem (OPCIONAL e somente valido para as categorias principais. A altura da imagem sera redimencionada para 50): " );
	define( "_AM_WEBPHOTO_PARENT", "Categoria Pai:" );
	define( "_AM_WEBPHOTO_SAVE", "Salvar altereçoes" );
	define( "_AM_WEBPHOTO_CATDELETED", "Categoria deletada." );
	define( "_AM_WEBPHOTO_CATDEL_WARNING", "AVISO: confirmar eliminação da categoria e TODAS suas imagens e comentarios?" );

	define( "_AM_WEBPHOTO_NEWCATADDED", "Nova categoria adicionada com sucesso!" );
	define( "_AM_WEBPHOTO_ERROREXIST", "ERRO: A foto que voce forneceu ja existe no banco de dados!" );
	define( "_AM_WEBPHOTO_ERRORTITLE", "ERRO: informar um titulo!" );
	define( "_AM_WEBPHOTO_ERRORDESC", "ERRO: informar uma descrição!" );
	define( "_AM_WEBPHOTO_WEAPPROVED", "Aprovamos seu envio de link enviado para a imagem em nosso banco de dados." );
	define( "_AM_WEBPHOTO_THANKSSUBMIT", "Agradecemos por sua participação!" );
	define( "_AM_WEBPHOTO_CONFUPDATED", "Configuração atualizada com sucesso!" );

	define( "_AM_WEBPHOTO_PHOTOBATCHUPLOAD", "Registrar imagens ja enviadas ao servidor" );
	define( "_AM_WEBPHOTO_PHOTOPATH", "Percurso" );
	define( "_AM_WEBPHOTO_TEXT_DIRECTORY", "Diretorio" );
	define( "_AM_WEBPHOTO_DESC_PHOTOPATH", "Digite o percurso integral do diretorio incluindo imagens registradas" );
	define( "_AM_WEBPHOTO_MES_INVALIDDIRECTORY", " Foi especificado um diretorio invalido." );
	define( "_AM_WEBPHOTO_MES_BATCHDONE", "%s imgem(ns) foram registradas." );
	define( "_AM_WEBPHOTO_MES_BATCHNONE", "Nenhuma foto foi encontrada no diretorio." );

//---------------------------------------------------------
// move from myalbum_constants.php
//---------------------------------------------------------
// Global Group Permission
	define( "_AM_WEBPHOTO_GPERM_INSERTABLE", "Postar (necessita aprovação)" );
	define( "_AM_WEBPHOTO_GPERM_SUPERINSERT", "Super Post" );
	define( "_AM_WEBPHOTO_GPERM_EDITABLE", "Editar (necessita aprovação)" );
	define( "_AM_WEBPHOTO_GPERM_SUPEREDIT", "Super Editar" );
	define( "_AM_WEBPHOTO_GPERM_DELETABLE", "Deletar (necessita aprovação)" );
	define( "_AM_WEBPHOTO_GPERM_SUPERDELETE", "Super Deletar" );
	define( "_AM_WEBPHOTO_GPERM_TOUCHOTHERS", "Tocar imagens postadas por outros" );
	define( "_AM_WEBPHOTO_GPERM_SUPERTOUCHOTHERS", "Super tocar outros" );
	define( "_AM_WEBPHOTO_GPERM_RATEVIEW", "Ver avaliação" );
	define( "_AM_WEBPHOTO_GPERM_RATEVOTE", "Votar" );
	define( "_AM_WEBPHOTO_GPERM_TELLAFRIEND", "Diga a um amigo" );

// add for webphoto
	define( "_AM_WEBPHOTO_GPERM_TAGEDIT", "Editar Tag" );

// v0.30
	define( "_AM_WEBPHOTO_GPERM_MAIL", "Postar via e-mail" );
	define( "_AM_WEBPHOTO_GPERM_FILE", "Postar via FTP" );

//=========================================================
// add for webphoto
//=========================================================

//---------------------------------------------------------
// google icon
// modify from gnavi
//---------------------------------------------------------

// list
	define( "_AM_WEBPHOTO_GICON_ADD", "Adicionar um novo icone do Google" );
	define( "_AM_WEBPHOTO_GICON_LIST_IMAGE", 'icone' );
	define( "_AM_WEBPHOTO_GICON_LIST_SHADOW", 'Sombra' );
	define( "_AM_WEBPHOTO_GICON_ANCHOR", 'Ponto ancora' );
	define( "_AM_WEBPHOTO_GICON_WINANC", 'Janela ancora' );
	define( "_AM_WEBPHOTO_GICON_LIST_EDIT", 'Editar icone' );

// form
	define( "_AM_WEBPHOTO_GICON_MENU_NEW", "Adicionar icone" );
	define( "_AM_WEBPHOTO_GICON_MENU_EDIT", "Editar icone" );
	define( "_AM_WEBPHOTO_GICON_IMAGE_SEL", "Selecionar icone da Imagem" );
	define( "_AM_WEBPHOTO_GICON_SHADOW_SEL", "Seleciona icone da Sombra" );
	define( "_AM_WEBPHOTO_GICON_SHADOW_DEL", 'Deletar icone da Sombra' );
	define( "_AM_WEBPHOTO_GICON_DELCONFIRM", "Confirmar exclusão do icone %s ?" );

//---------------------------------------------------------
// mime type
// modify from wfdownloads
//---------------------------------------------------------

// Mimetype Form
	define( "_AM_WEBPHOTO_MIME_CREATEF", "Criar Mimetype" );
	define( "_AM_WEBPHOTO_MIME_MODIFYF", "Modificar Mimetype" );
	define( "_AM_WEBPHOTO_MIME_NOMIMEINFO", "Nao foi selecionado mimetypes." );
	define( "_AM_WEBPHOTO_MIME_INFOTEXT", "<ul><li>Novos mimetypes podem ser criados, editados ou deletados facilmente atraves deste formulario.</li>
	<li>Ver mimetypes exibidos enviados pelo Admin e usuarios.</li>
	<li>Alterar o status dos mimetype enviados.</li></ul>
	" );

// Mimetype Database
	define( "_AM_WEBPHOTO_MIME_DELETETHIS", "Deletar os Mimetype selecionados?" );
	define( "_AM_WEBPHOTO_MIME_MIMEDELETED", "Mimetype %s esta sendo deletado" );
	define( "_AM_WEBPHOTO_MIME_CREATED", "Criado informaçoes do Mimetype" );
	define( "_AM_WEBPHOTO_MIME_MODIFIED", "Modificado as informaçoes do Mimetype" );

//image admin icon 
	define( "_AM_WEBPHOTO_MIME_ICO_EDIT", "Editar este item" );
	define( "_AM_WEBPHOTO_MIME_ICO_DELETE", "Deletar este item" );
	define( "_AM_WEBPHOTO_MIME_ICO_ONLINE", "Online" );
	define( "_AM_WEBPHOTO_MIME_ICO_OFFLINE", "Offline" );

// added for webphoto
	define( "_AM_WEBPHOTO_MIME_PERMS", "Grupos permitidos" );
	define( "_AM_WEBPHOTO_MIME_ALLOWED", "Mimetype permitidos" );
	define( "_AM_WEBPHOTO_MIME_NOT_ENTER_EXT", "Nao informar a extensão" );

//---------------------------------------------------------
// check config
//---------------------------------------------------------
	define( "_AM_WEBPHOTO_DIRECTORYFOR_PHOTOS", "Diretorio para imagens" );
	define( "_AM_WEBPHOTO_DIRECTORYFOR_THUMBS", "Diretorio para miniaturas" );
	define( "_AM_WEBPHOTO_DIRECTORYFOR_GICONS", "Diretorio para icones do Google" );
	define( "_AM_WEBPHOTO_DIRECTORYFOR_TMP", "Diretorio temporario" );

//---------------------------------------------------------
// checktable
//---------------------------------------------------------
	define( "_AM_WEBPHOTO_NUMBEROFRECORED", "Numero de registros" );

//---------------------------------------------------------
// manage
//---------------------------------------------------------
	define( "_AM_WEBPHOTO_MANAGE_DESC", "<b>Cuidado</b><br>A administração desta tabela somente<br>Nao muda as tabelas relacionadas" );
	define( "_AM_WEBPHOTO_ERR_NO_RECORD", "Nao ha registros" );

//---------------------------------------------------------
// import
//---------------------------------------------------------
	define( "_AM_WEBPHOTO_FMT_IMPORTFROM_WEBPHOTO", 'Importando do "%s" como tipo de m�dulo webphoto' );
	define( "_AM_WEBPHOTO_IMPORT_COMMENT_NO", "Não copiar comentarios" );
	define( "_AM_WEBPHOTO_IMPORT_COMMENT_YES", "Copiar comentarios" );

//---------------------------------------------------------
// v0.20
//---------------------------------------------------------
	define( "_AM_WEBPHOTO_PATHINFO_LINK", "Verificar se 'Pathinfo' esta trabalhando corretamente em seu servidor" );
	define( "_AM_WEBPHOTO_PATHINFO_DSC", "Se a pagina linkada aqui nao mostrar corretamente, voce nao deve usar o 'Pathinfo' " );
	define( "_AM_WEBPHOTO_PATHINFO_SUCCESS", "Sucesso!<br>Provavelmente voce pode usar o 'Pathinfo' em seu servidor" );
	define( "_AM_WEBPHOTO_CAP_REDO_EXIF", "Obter Exif" );
	define( "_AM_WEBPHOTO_RADIO_REDO_EXIF_TRY", "Obter quando nao configurado" );
	define( "_AM_WEBPHOTO_RADIO_REDO_EXIF_ALWAYS", "Obter sempre" );

//---------------------------------------------------------
// v0.30
//---------------------------------------------------------
// checkconfigs
	define( "_AM_WEBPHOTO_DIRECTORYFOR_FILE", "Diretorio para FTP do arquivo" );
	define( "_AM_WEBPHOTO_WARN_GEUST_CAN_READ", "Usuarios anonimos podem ler o arquivo neste diretorio" );
	define( "_AM_WEBPHOTO_WARN_RECOMMEND_PATH", "Recomendado configura-lo, exceto sob o diretorio raiz" );
	define( "_AM_WEBPHOTO_MULTIBYTE_LINK", "Verificar se 'Charset Convert' esta trabalhando corretamenteem seu servidor)" );
	define( "_AM_WEBPHOTO_MULTIBYTE_DSC", "Se a pagina linkada aqui nao mostrar corretamente, voce nao deve usar o 'Charset Convert' " );
	define( "_AM_WEBPHOTO_MULTIBYTE_SUCCESS", "Voce pode ler corretamente este sentença, sem caracter distorcido? " );

// maillog manager
	define( "_AM_WEBPHOTO_SHOW_LIST", "Mostrar lista" );
	define( "_AM_WEBPHOTO_MAILLOG_STATUS_REJECT", "E-mail Rejeitado" );
	define( "_AM_WEBPHOTO_MAILLOG_STATUS_PARTIAL", "O e-mail que foi rejeitado contem algum arquivo anexo" );
	define( "_AM_WEBPHOTO_MAILLOG_STATUS_SUBMIT", "E-mal submetido" );
	define( "_AM_WEBPHOTO_BUTTON_SUBMIT_MAIL", "Submeter e-mail" );
	define( "_AM_WEBPHOTO_ERR_MAILLOG_NO_ATTACH", "Voc~e deve selecionar os arquivos anexos" );

// mimetype
	define( "_AM_WEBPHOTO_MIME_ADD_NEW", "Adicionar novo tipo de MIME" );

//---------------------------------------------------------
// v0.40
//---------------------------------------------------------
// index
	define( "_AM_WEBPHOTO_MUST_UPDATE", "Voce deve atualizar" );
	define( "_AM_WEBPHOTO_TITLE_BIN", "Administrar comando" );
	define( "_AM_WEBPHOTO_TEST_BIN", "Executar teste" );

// redothumbs
	define( "_AM_WEBPHOTO_ERR_GET_IMAGE_SIZE", "nao é possivel obter o tamanho da imagem" );

// checktables
	define( "_AM_WEBPHOTO_FMT_NOT_READABLE", "%s (%s) nao é permitida a leitura." );

//---------------------------------------------------------
// v0.50
//---------------------------------------------------------
// config check
	define( "_AM_WEBPHOTO_DIRECTORYFOR_UPLOADS", "Directory for Upload Files" );
	define( "_AM_WEBPHOTO_DIRECTORYFOR_MEDIAS", "Directory for Media Files" );

// item manager
	define( "_AM_WEBPHOTO_ITEM_SELECT", "Select Item" );
	define( "_AM_WEBPHOTO_ITEM_ADD", "Add Item" );
	define( "_AM_WEBPHOTO_ITEM_LISTING", "View Item" );
	define( "_AM_WEBPHOTO_VOTE_DELETED", "Vote data deleted." );
	define( "_AM_WEBPHOTO_VOTE_STATS", "Vote Statistics" );
	define( "_AM_WEBPHOTO_VOTE_ENTRY", "Entry Votes" );
	define( "_AM_WEBPHOTO_VOTE_USER", "Registered User Votes" );
	define( "_AM_WEBPHOTO_VOTE_GUEST", "Anonymous User Votes" );
	define( "_AM_WEBPHOTO_VOTE_TOTAL", "total votes" );
	define( "_AM_WEBPHOTO_VOTE_USERAVG", "User Average Rating" );
	define( "_AM_WEBPHOTO_VOTE_USERVOTES", "User Total Votes" );
	define( "_AM_WEBPHOTO_LOG_VIEW", "View Log File" );
	define( "_AM_WEBPHOTO_LOG_EMPT", "Empty Log File" );
	define( "_AM_WEBPHOTO_PLAYLIST_PATH", "Playlist Path" );
	define( "_AM_WEBPHOTO_PLAYLIST_REFRESH", "Refresh Playlist Cache" );
	define( "_AM_WEBPHOTO_STATUS_CHANGE", "Status Change" );
	define( "_AM_WEBPHOTO_STATUS_OFFLINE", "Off Line" );
	define( "_AM_WEBPHOTO_STATUS_ONLINE", "On Line" );
	define( "_AM_WEBPHOTO_STATUS_AUTO", "Auto Publish" );

// item form
	define( "_AM_WEBPHOTO_TIME_NOW", "Current Time" );

// playlist form
	define( "_AM_WEBPHOTO_PLAYLIST_ADD", "Add Playlist" );
	define( "_AM_WEBPHOTO_PLAYLIST_TYPE", "Playlist Type" );
	define( "_AM_WEBPHOTO_PLAYLIST_FEED_DSC", "Enter the web feed URL." );
	define( "_AM_WEBPHOTO_PLAYLIST_DIR_DSC", "Select the directory name" );

// player manager
	define( "_AM_WEBPHOTO_PLAYER_MANAGER", "Player Manager" );
	define( "_AM_WEBPHOTO_PLAYER_ADD", "Add New Player" );
	define( "_AM_WEBPHOTO_PLAYER_MOD", "Modify Player" );
	define( "_AM_WEBPHOTO_PLAYER_CLONE", "Clone Player" );
	define( "_AM_WEBPHOTO_PLAYER_ADDED", "New Player Added" );
	define( "_AM_WEBPHOTO_PLAYER_DELETED", "Player deleted" );
	define( "_AM_WEBPHOTO_PLAYER_MODIFIED", "Player Modified" );
	define( "_AM_WEBPHOTO_PLAYER_PREVIEW", "Preview" );
	define( "_AM_WEBPHOTO_PLAYER_PREVIEW_DSC", "Save your changes first!" );
	define( "_AM_WEBPHOTO_PLAYER_PREVIEW_LINK", "Preview Source" );
	define( "_AM_WEBPHOTO_PLAYER_NO_ITEM", "Thers are no item to play" );
	define( "_AM_WEBPHOTO_PLAYER_WARNING", "WARNING: Are you sure you want to delete this Player? <br>Manually edit all entries using this player before deleting it." );
	define( "_AM_WEBPHOTO_PLAYER_ERR_EXIST", "ERROR: The same title player you provided is already in the database!" );
	define( "_AM_WEBPHOTO_BUTTON_CLONE", "Clone" );

//---------------------------------------------------------
// v0.60
//---------------------------------------------------------
// cat form
	define( "_AM_WEBPHOTO_CAP_CAT_SELECT", "Select the category image" );
	define( "_AM_WEBPHOTO_DSC_CAT_PATH", "Set Path from the directory installed XOOPS.<br>(The first character must be '/'.)" );
	define( "_AM_WEBPHOTO_DSC_CAT_FOLDER", "Show folder icon if not set" );

//---------------------------------------------------------
// v0.70
//---------------------------------------------------------
	define( "_AM_WEBPHOTO_RECOMMEND_OFF", "recommend off" );

//---------------------------------------------------------
// v0.80
//---------------------------------------------------------
	define( "_AM_WEBPHOTO_TITLE_WAITING", "List of Wating to approve" );
	define( "_AM_WEBPHOTO_TITLE_OFFLINE", "List of Offline" );
	define( "_AM_WEBPHOTO_TITLE_EXPIRED", "List of Expired" );

//---------------------------------------------------------
// v0.81
//---------------------------------------------------------
// checkconfigs
	define( "_AM_WEBPHOTO_QR_CHECK_LINK", "Check that 'QR Code' is working correctly" );
	define( "_AM_WEBPHOTO_QR_CHECK_DSC", "If the page linked to from here doesn't display correctly, you should not use 'QR Code' " );
	define( "_AM_WEBPHOTO_QR_CHECK_SUCCESS", "Can you see 'QR Code' correctly" );
	define( "_AM_WEBPHOTO_QR_CHECK_SHOW", "Show Debug Info" );
	define( "_AM_WEBPHOTO_QR_CHECK_INFO", "Debug Info" );

//---------------------------------------------------------
// v0.90
//---------------------------------------------------------
// cat form
	define( "_AM_WEBPHOTO_CAT_PARENT_CAP", "Permission of Parent Category" );
	define( "_AM_WEBPHOTO_CAT_PARENT_FMT", "Succeed to the permission of parent category ( %s )" );
	define( "_AM_WEBPHOTO_CAT_CHILD_CAP", "Child Categories" );
	define( "_AM_WEBPHOTO_CAT_CHILD_NUM", "Number of child categories" );
	define( "_AM_WEBPHOTO_CAT_CHILD_PERM", "Change permission of child categories" );

//---------------------------------------------------------
// v1.00
//---------------------------------------------------------
// groupperm
	define( "_AM_WEBPHOTO_GPERM_HTML", "Use HTML" );

//---------------------------------------------------------
// v1.21
//---------------------------------------------------------
	define( "_AM_WEBPHOTO_RSS_DEBUG", "RSS Debug View" );
	define( "_AM_WEBPHOTO_RSS_CLEAR", "RSS Cache Clear" );
	define( "_AM_WEBPHOTO_RSS_CLEARED", "Cleared" );

//---------------------------------------------------------
// v1.40
//---------------------------------------------------------
	define( "_AM_WEBPHOTO_TIMELINE_MODULE", "Timeline Module" );
	define( "_AM_WEBPHOTO_MODULE_NOT_INSTALL", "Module is not installed" );

//---------------------------------------------------------
// v1.50
//---------------------------------------------------------
	define( "_AM_WEBPHOTO_FILE_CHECK", "File Valid Check" );
	define( "_AM_WEBPHOTO_FILE_CHECK_DSC", "checks there are necessary files with file size" );

//---------------------------------------------------------
// v1.72
//---------------------------------------------------------
	define( "_AM_WEBPHOTO_MYSQL_CONFIG", "MySQL Config" );
	define( "_AM_WEBPHOTO_MULTIBYTE_CONFIG", "Multibyte Config" );

//---------------------------------------------------------
// v2.00
//---------------------------------------------------------
// invite
	define( "_AM_WEBPHOTO_INVITE_EMAIL", "Email address of the inviting person" );
	define( "_AM_WEBPHOTO_INVITE_NAME", "Your Name" );
	define( "_AM_WEBPHOTO_INVITE_MESSAGE", "Message" );
	define( "_AM_WEBPHOTO_INVITE_SUBMIT", "Invite" );
	define( "_AM_WEBPHOTO_INVITE_EXAMPLE", "Exsample: Hello, I am John. I send an invitation at the site which was talked about. <br>Jane, too, attempt to register by all means. " );
	define( "_AM_WEBPHOTO_INVITE_SUBJECT", "You get the invitation email. from %s to %s " );
	define( "_AM_WEBPHOTO_INVITE_ERR_NO_NAME", "No Name" );

// gperm
	define( "_AM_WEBPHOTO_GROUP_MOD_ADMIN", "Admin group of this module" );
	define( "_AM_WEBPHOTO_GROUP_MOD_USER", "User group of this module" );
	define( "_AM_WEBPHOTO_GROUP_MOD_CATEGORY", "Category group of this module" );
	define( "_AM_WEBPHOTO_GPERM_MODULE_ADMIN", "Module Admin" );
	define( "_AM_WEBPHOTO_GPERM_MODULE_READ", "Module Access" );

// item manage
	define( "_AM_WEBPHOTO_BUTTON_REFUSE", "Refuse" );
	define( "_AM_WEBPHOTO_ERR_NO_SELECT", "Error: Not select item" );

// user list
	define( '_AM_WEBPHOTO_USER_UID', "UID" );
	define( '_AM_WEBPHOTO_USER_UNAME', "User Name" );
	define( '_AM_WEBPHOTO_USER_NAME', "Real Name" );
	define( '_AM_WEBPHOTO_USER_POSTS', "Comments/Posts" );
	define( '_AM_WEBPHOTO_USER_LEVEL', "Level" );
	define( '_AM_WEBPHOTO_USER_REGDATE', "Member Since" );
	define( '_AM_WEBPHOTO_USER_LASTLOGIN', "Last Login" );
	define( '_AM_WEBPHOTO_USER_CONTROL', "Control" );
	define( '_AM_WEBPHOTO_USER_TOTAL', "Total of member" );
	define( '_AM_WEBPHOTO_USER_ASSIGN', "Assign a member" );
	define( '_AM_WEBPHOTO_USER_USER', "User" );

//---------------------------------------------------------
// v2.40
//---------------------------------------------------------
	define( '_AM_WEBPHOTO_PLEASE_IMPORT_MYALBUM', "Please execute the batch import from Myalbum." );

// === define end ===
}
