<?php
	session_start();
	include("../../external.php");
	include("../inc/db.php");
	include("../inc/dgssmtp.php");
	include("../inc/functions.php");
	include("../inc/makethumb.php");
	include("../inc/myerrorhandler.php");
	include("../../class/user/user.php");
	include("../inc/checklogin.php");
	

	$DB = new DB();

?>