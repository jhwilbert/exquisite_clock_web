<?php
  /** DIRETIVAS
   * Lembrar que as pastas a seguir devem estar liberadas para escrita (chmod(777))
   * adm/files/*
   * dgssearch/cache/
   */
	  /****************************** SEARCH CONFIG ******************************/
		$admCfg = array();
		$rootFolder = "exquisite_clock/v1";
	  /** 
	   * URL base do site. 
	   * Endereço para o browser acessar a raiz do site, 
	   * e.g.: http://www.meusite.com/diretorioraiz
	   * Não coloque / no final do endereço e certifique de começar com http://
	   */
	  $admCfg['urlBase']	= "http://gym.vegans.it/exquisite_clock/$rootFolder";
	  
	  /** Endereço físico no serivdor que corresponde à urlBase */
	 $admCfg['siteBase']	= $_SERVER['DOCUMENT_ROOT']."/$rootFolder/";
	  
	  /** Endereço físico no serivdor que indica onde a busca deve ser inicializada */
	  $admCfg['fsBase']		= $_SERVER['DOCUMENT_ROOT']."/$rootFolder/";
	  /****************************** || ******************************/
	
	
	  /****************************** FILE ROOT CONFIG ******************************/
		/** Server File Root path. It is the real path in server. */
		$serverFilesRoot = $_SERVER['DOCUMENT_ROOT']."/$rootFolder/adm/files/";
		$mobileFilesRoot = $_SERVER['DOCUMENT_ROOT']."/$rootFolder/adm/mobile/";
		$webFilesRoot = $_SERVER['DOCUMENT_ROOT']."/$rootFolder/adm/web/";
		$instFilesRoot = $_SERVER['DOCUMENT_ROOT']."/$rootFolder/adm/installation/";
		$instRotatedFilesRoot = $_SERVER['DOCUMENT_ROOT']."/$rootFolder/adm/installation_rotated/";
		$jsonFileRoot = $_SERVER['DOCUMENT_ROOT']."/exquisite_clock/clock/feed";
	  /****************************** || ******************************/


	  /****************************** SITE CONFIG ******************************/
		/** Site name, to be usend in title. */
		$siteTitle 	= "F A B R I C A :: Exquisite Clock";
		$reportMail 	= "jhwilbert@gmail.com";
		$owner 		= "F A B R I C A :: Exquisite Clock in JH";
		$contestMail	=	"";
	  /****************************** || ******************************/
	
	
	  /****************************** DB CONFIG ******************************/
		$admDB = array();
		$admDB["dbName"]  	= "exquisite_clock";
		$admDB["dbPath"]  	= "localhost:8889";
		$admDB["dbUsr"] 	= "root";
		$admDB["dbPsw"] 	= "root";
	  /****************************** || ******************************/
	  
?>
