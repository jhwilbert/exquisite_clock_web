<?php
	session_start();
	include("../../external.php");
	include("../inc/db.php");
	include("../inc/dgssmtp.php");
	include("../inc/functions.php");
	include("../inc/myerrorhandler.php");
	$DB = new DB();

	include("../../class/file/myfile.php");
	include("../../class/file/myimage.php");
	include("../../class/file/fileresource.php");
	include("../../class/file/imageresource.php");
	include("../../class/user/user.php");
	
	include("../../class/clock/clockroot.php");
	include("../../class/clock/clock.php");
	include("../../class/tag/tagroot.php");
	include("../../class/tag/tag.php");
	include("../../class/clocktag/clocktagroot.php");
	include("../../class/clocktag/clocktag.php");

	$obj = Array();
	$i=0;
	
	$obj[$i++] = new MyFile();
	$obj[$i++] = new MyImage();
	$obj[$i++] = new User("","","");
	$obj[$i++] = new Clock();
	$obj[$i++] = new Tag();
	$obj[$i++] = new ClockTag();
	$obj[0]->superInstall();
	for ($j = 1; $j < sizeof($obj); $j++) {
		$obj[$j]->install();
	}

	$msg = "The system package instaled...";
	restricError("../index/login.php",0,$msg);
	exit;
?>