<?php
	include("../inc/common.php");
	include("package.php");
	
    $sub = $_GET["sub"];
	$obj = new Clock();
	$obj->load(getVar("id"));
	$obj->image->delAllImages();
	$obj->del();

	
	header("location: list.php?sub=".$sub);
	$obj->generateJSON($jsonFileRoot);	
?>
