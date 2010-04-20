<?php include("inc/common.php");
	$obj = new Clock();
	$obj->setFromForm();
	
	$usertags = $_POST["usertags"];
	$userselect = $_POST["userselect"];
	
	if($usertags  == "") {	
	$finaltag = $userselect;
	}
	else {
	$finaltag =  $usertags;
	}

	
	$imageR = $obj->image;
	$images = $imageR->setFromForm($_FILES["img"],"clock");

		
	$allowTypes = array(".jpg"); $allowTypesStr = implode(" - ",$allowTypes);
	$w = '320'; $h = '480'; $op = "="; $thumbW = 90;
	$sizeR = 512000;
	$prop ='1.5';
	$imagesErr = array(); 
	$error = ""; 
	$countErr = 0;
	$imagesOk  = array();
		
	for ($i = (sizeof($images)-1); $i >= 0; $i--) {
		
		$n = $images[$i];
		
		if($n->restrictType($allowTypes)){
			$imagesErr[] = $n->getName()." :: Only the following types are allowed: $allowTypesStr.";
			$countErr++;
		}elseif($n->restrictProportion($prop)) {
			$imagesErr[] = $n->getName()." :: Images must be between ".$w."x".$h."px abd 800 x 1200. They must have a 3:2 aspect ratio.";
			$countErr++;
			
		}elseif($n->restrictSize($sizeR,$op)) {
			$imagesErr[] = $n->getName()." :: Images must have a maximum size of 500kb.";
			$countErr++;
			
		}else {
			
		$obj->store();
		
		
		$imagesOk[] = $n;
		$imageR->setImages($imagesOk,$thumbW);
		
		$lastid = $obj->getLastID();
		
		$ct = new ClockTag();
	
		
		$tags = explode(".", $finaltag);
		
			
		$ct->storeTags($lastid,$tags);	 // cria as tags inexistentes e associa todas à imagem
		$obj->generateJSON($jsonFileRoot);	// generate files for installation
		
	
		foreach ($tags as $tag) { 		

		$lastTagId = $obj->getLastTagID($tag);
		$numbersum = $obj->flagTags($lastTagId);
	   	$flag = $obj->checkFlag($numbersum,$lastTagId);	
	
   	
		}
   	
	
	}

	if($countErr>0){
		
		$error = toHtmlEnt(implode("<br/>",$imagesErr));
		restricError("upload.php",0,$error);
		exit;
		
	}else{
		$error = "Image uploaded!";
		//echo sizeof($images);
		restricError("upload.php",0,$error);
			exit;
	}
	}

?>