<?php
// $Id: admin.php,v 1.1 2008/10/13 10:16:04 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

// === define begin ===
if ( ! defined( "_AM_WEBPHOTO_LANG_LOADED" ) ) {

	define( "_AM_WEBPHOTO_LANG_LOADED", 1 );

//=========================================================
// base on myalbum
//=========================================================

// menu
	define( '_AM_WEBPHOTO_MYMENU_TPLSADMIN', 'Modelos' );
	define( '_AM_WEBPHOTO_MYMENU_BLOCKSADMIN', 'Permissoes/Blocos' );

//define('_AM_WEBPHOTO_MYMENU_MYPREFERENCES','Preferences');

// add for webphoto
	define( "_AM_WEBPHOTO_MYMENU_GOTO_MODULE", "Ir ao Modulo" );


// Index (Categories)
//define( "_AM_WEBPHOTO_H3_FMT_CATEGORIES" , "Categories Manager (%s)" ) ;
//define( "_AM_WEBPHOTO_CAT_TH_TITLE" , "Name" ) ;

	define( "_AM_WEBPHOTO_CAT_TH_PHOTOS", "Imagens" );
	define( "_AM_WEBPHOTO_CAT_TH_OPERATION", "Operação" );
	define( "_AM_WEBPHOTO_CAT_TH_IMAGE", "Banner" );
	define( "_AM_WEBPHOTO_CAT_TH_PARENT", "Categoria Pai" );

//define( "_AM_WEBPHOTO_CAT_TH_IMGURL" , "URL of Banner" ) ;

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
//define( "_AM_WEBPHOTO_H3_FMT_ADMISSION" , "Admitting images (%s)" ) ;
//define( "_AM_WEBPHOTO_TH_SUBMITTER" , "Submitter" ) ;
//define( "_AM_WEBPHOTO_TH_TITLE" , "Title" ) ;
//define( "_AM_WEBPHOTO_TH_DESCRIPTION" , "Description" ) ;
//define( "_AM_WEBPHOTO_TH_CATEGORIES" , "Category" ) ;
//define( "_AM_WEBPHOTO_TH_DATE" , "Last update" ) ;


// Photo Manager
//define( "_AM_WEBPHOTO_H3_FMT_PHOTOMANAGER" , "Photo Manager (%s)" ) ;

	define( "_AM_WEBPHOTO_TH_BATCHUPDATE", "Checagem coletiva da atualiza��o das imagens" );
	define( "_AM_WEBPHOTO_OPT_NOCHANGE", "- NAO ALTERE -" );
	define( "_AM_WEBPHOTO_JS_UPDATECONFIRM", "Checagem dos itens que ser�o atualizados. OK?" );


// Module Checker
//define( "_AM_WEBPHOTO_H3_FMT_MODULECHECKER" , "myAlbum-P checker (%s)" ) ;

	define( "_AM_WEBPHOTO_H4_ENVIRONMENT", "Ambiente de Checagem" );
	define( "_AM_WEBPHOTO_PHPDIRECTIVE", "Diretivas do PHP" );
	define( "_AM_WEBPHOTO_BOTHOK", "ambos ok" );
	define( "_AM_WEBPHOTO_NEEDON", "precisam de" );

	define( "_AM_WEBPHOTO_H4_TABLE", "Tabela de Checagem" );

//define( "_AM_WEBPHOTO_PHOTOSTABLE" , "Photos table" ) ;
//define( "_AM_WEBPHOTO_DESCRIPTIONTABLE" , "Descriptions table" ) ;
//define( "_AM_WEBPHOTO_CATEGORIESTABLE" , "Categories table" ) ;
//define( "_AM_WEBPHOTO_VOTEDATATABLE" , "Votedata table" ) ;

	define( "_AM_WEBPHOTO_COMMENTSTABLE", "Tabela de Comentarios" );
	define( "_AM_WEBPHOTO_NUMBEROFPHOTOS", "Numero de Imagens" );
	define( "_AM_WEBPHOTO_NUMBEROFDESCRIPTIONS", "Numero de Descri��es" );
	define( "_AM_WEBPHOTO_NUMBEROFCATEGORIES", "Numero de Categorias" );
	define( "_AM_WEBPHOTO_NUMBEROFVOTEDATA", "Numero de votos" );
	define( "_AM_WEBPHOTO_NUMBEROFCOMMENTS", "Numero de comentarios" );

	define( "_AM_WEBPHOTO_H4_CONFIG", "Configuração da Checagem" );
	define( "_AM_WEBPHOTO_PIPEFORIMAGES", "Pipe para as imagens" );

//define( "_AM_WEBPHOTO_DIRECTORYFORPHOTOS" , "Directory for Photos" ) ;
//define( "_AM_WEBPHOTO_DIRECTORYFORTHUMBS" , "Directory for Thumbnails" ) ;

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

//define( "_AM_WEBPHOTO_FMT_PHOTONOTREADABLE" , "a main photo (%s) is not readable." ) ;
//define( "_AM_WEBPHOTO_FMT_THUMBNOTREADABLE" , "a thumbnail (%s) is not readable." ) ;

	define( "_AM_WEBPHOTO_FMT_NUMBEROFDEADPHOTOS", "%s Arquivo de imagem morta foi encontrado." );
	define( "_AM_WEBPHOTO_FMT_NUMBEROFDEADTHUMBS", "%s miniaturas devem ser reconstruidas." );
	define( "_AM_WEBPHOTO_FMT_NUMBEROFREMOVEDTMPS", "%s lixo de arquivos foram removidos." );
	define( "_AM_WEBPHOTO_LINK_REDOTHUMBS", "reconstruir miniaturas" );
	define( "_AM_WEBPHOTO_LINK_TABLEMAINTENANCE", "manutenção das tabelas" );


// Redo Thumbnail
//define( "_AM_WEBPHOTO_H3_FMT_RECORDMAINTENANCE" , "myAlbum-P photo maintenance (%s)" ) ;

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


// Batch Register
//define( "_AM_WEBPHOTO_H3_FMT_BATCHREGISTER" , "myAlbum-P batch register (%s)" ) ;


// GroupPerm Global
//define( "_AM_WEBPHOTO_GROUPPERM_GLOBAL" , "Global Permissions" ) ;

	define( "_AM_WEBPHOTO_GROUPPERM_GLOBALDESC", "Configurar os previlégios dos grupos para este modulo" );
	define( "_AM_WEBPHOTO_GPERMUPDATED", "As permissoes foram mudadas com sucesso" );


// Import
	define( "_AM_WEBPHOTO_H3_FMT_IMPORTTO", 'Importação de imagens de outros modulo para %s' );
	define( "_AM_WEBPHOTO_FMT_IMPORTFROMMYALBUMP", 'Importando de "%s" como modulo tipo myAlbum-P' );
	define( "_AM_WEBPHOTO_FMT_IMPORTFROMIMAGEMANAGER", 'Importação do administrador de imagens do XOOPS' );

//define( "_AM_WEBPHOTO_CB_IMPORTRECURSIVELY" , 'Importing sub-categories recursively' ) ;
//define( "_AM_WEBPHOTO_RADIO_IMPORTCOPY" , 'Copy images (comments will not be copied)' ) ;
//define( "_AM_WEBPHOTO_RADIO_IMPORTMOVE" , 'Move images (comments will be copied)' ) ;

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

// find mine type
//define("_AM_WEBPHOTO_MIME_FINDMIMETYPE", "Find New Mimetype:");
//define("_AM_WEBPHOTO_MIME_FINDIT", "Get Extension!");

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
// cat manager
//---------------------------------------------------------
	define( "_AM_WEBPHOTO_DSC_CAT_IMGPATH", "Percurso do diretorio onde o XOOPS esta instaldo.<br>(O primeiro caracter deve ser '/'.)" );
	define( "_AM_WEBPHOTO_OPT_CAT_PERM_POST_ALL", "Todos os grupos" );

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

// === define end ===
}
