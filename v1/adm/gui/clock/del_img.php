<?php
	include("../inc/common.php");
	include("package.php");
	
	$obj = new Clock();
	$obj->load(getVar("id"));
	$obj->image->delAllImages();

	header("location: inc.php?id=".$obj->getId());

?>
