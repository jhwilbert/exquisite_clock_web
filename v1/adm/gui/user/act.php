<?php
	include("../inc/common.php");
	
	$user = new User(getVar("name"),getVar("login"),getVar("pw"));
	$user->setId(getVar("id"));
	$user->setEmail(getVar("email"));
	$user->setBirthDay(getVar("birthDay"));
	$user->setBirthPlace(getVar("birthPlace"));
	
	if((getVar("login") != getVar("oldLogin") ) && $user->loginExists($user->getLogin())){
		$error = toHtmlEnt("Usuário não cadastrado.<br />Este login já existe, por favor escolha outro.");
		restricError("inc.php",0,$error);
		exit;
	}
	$user->store();
	
	if(getVar("id")>0 && getVar("altpw")!=""){
		$user->updatePassword(getVar("altpw"));
		$error = toHtmlEnt("Senha alterada.");
		restricError("inc.php",$user->getId(),$error);
		exit;
	}
	
	header("location: list.php");
?>