<?php 
	include("inc/common.php");
	$obj = new Clock();
	echo $jsonFileRoot;
	$obj->generateJSON($jsonFileRoot);
?>