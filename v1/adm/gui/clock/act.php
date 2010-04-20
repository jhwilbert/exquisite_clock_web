<?php
	include("../inc/common.php");
	include("package.php");


	$obj = new Clock();
	$obj->setFromForm();
	$obj->store();

	$imageR = $obj->image;
	$images = $imageR->setFromForm($_FILES["img"],"clock");

	$allowTypes = array(".jpg"); $allowTypesStr = implode(" - ",$allowTypes);
	$w = '320'; $h = '480'; $op = "="; $thumbW = 90;
	$imagesErr = array(); $error = ""; $countErr = 0;
	$imagesOk  = array();

	for ($i = (sizeof($images)-1); $i >= 0; $i--) {
		$n = $images[$i];
		if($n->restrictType($allowTypes)){
			$imagesErr[] = $n->getName()." :: Only the following types are allowed: $allowTypesStr.";
			$countErr++;
		}elseif($n->restrictDimension($w,$h,$op)){
			$imagesErr[] = $n->getName()." :: Images must be the size ".$w."x".$h."px.";
			$countErr++;
		}else $imagesOk[] = $n;
	}

	$imageR->setImages($imagesOk,$thumbW);

	if($countErr>0){
		$error = toHtmlEnt(implode("<br/>",$imagesErr));
		restricError("inc.php",$obj->getId(),$error);
		exit;
	}

	header("location: list.php");
?>