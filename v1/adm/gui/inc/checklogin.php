<?php
	$ck = new User("","",""); 
	if(!toBool($ck->sessionUserId(""))){
		$error = toHtmlEnt("Digite seu login e senha para entrar.");
		restricError("../index/login.php",0,$error);
		exit;
	}
?>
