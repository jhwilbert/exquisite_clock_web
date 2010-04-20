<?php
	session_start();
	include("../../external.php");
	include("../inc/db.php");
	include("../inc/functions.php");
	include("../inc/myerrorhandler.php");
	include("../../class/user/user.php");
	$DB = new DB();
	
	$user = new User("","","");
	$user->unsetSessions();
	header("location: index.php");
?>
