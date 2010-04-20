<?php

	$obj = new Clock();
	
	if((is_numeric ($tag)) ||($tag=="all")) {
	
	
	} else {
		$tag="all";
	}	

	if($tag == "all" or $tag == null) {
		$tag = "all";
		  $all = $obj->loadAll("number asc");
	
		$tagname = "all";
			
	} else {
		$all = $obj->loadByTagId("number asc", $tag);
		$tagname = $obj->loadTagName($tag);
	} 	

	$number = array();
	
	for ($i = 0; $i < 10; $i++) {
		$number[$i] = array();
	}
	
	for ($i = 0; $i < sizeof($all); $i++) {
		
		$n = $all[$i];
		
		$totalids = $obj->getTotal('');
		$imgList = $n->image->getImages();
		
		$img = new MyImage();
		
		
		if(count($imgList)>0) $img = $imgList[0];
	
		$number[$n->getNumber()][] = $img->completePath();
		
		}

?>
