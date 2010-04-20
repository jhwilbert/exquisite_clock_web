<?php
	include("../inc/common.php");
	
	if(getVar("id") == 1){
		$error = toHtmlEnt("Não é permitido excluir o usuário de Adminsitração 'ROOT'.");
		restricError("list.php",0,$error);
		exit;
	}
	$user = new User("","","");
	$user->del(getVar("id"));
	
	header("location: list.php");

?>
