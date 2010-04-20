<?php
	session_start();
	include("../../external.php");
	include("../inc/db.php");
	include("../inc/dgssmtp.php");
	include("../inc/functions.php");
	include("../inc/myerrorhandler.php");
	include("../../class/user/user.php");
	$DB = new DB();
	
	$user = new User("","","");
	if($user->checkUser(getVar("login"),getVar("password"))){
		 $user->loadLgPw (getVar("login"),getVar("password"));
		 $user->sessionUserId($user->getId());
		 $user->sessionUserName($user->getName());
		 header("location: index.php");
	}else{
		$error = toHtmlEnt("Usuário ou senha não existente.");
		restricError("login.php",0,$error);
		exit;
	}

?>
