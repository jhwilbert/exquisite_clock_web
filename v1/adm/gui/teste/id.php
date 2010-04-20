<?php
	session_start();
	include("../../external.php");
	include("../inc/db.php");
	include("../inc/functions.php");
	include("../inc/myerrorhandler.php");

	$DB = new DB();

	include("package.php");
	
listClockTag($clock->getId());

?>
	