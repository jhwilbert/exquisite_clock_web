<?php 
/**
 * Make the image thumbnail. Only accept jpg and png images.
 * @param origem  Original image to make thumb
 * @param destino Where the thumbnail willbe stored
 * @param largura The prefered width to make the thumb nail
 */
function makeThumbnail($origem,$destino,$largura,$quality) {
	$ext      = split("[/\\.]",strtolower($origem)); 
	$n        = count($ext)-1; 
	$ext      = $ext[$n]; 
	
	$arr      = split("[/\\]",$origem); 
	$n        = count($arr)-1; 
	$arra     = explode('.',$arr[$n]); 
	$n2       = count($arra)-1; 
	$tn_name  = str_replace('.'.$arra[$n2],'',$arr[$n]); 

	if ($ext == 'jpg' || $ext == 'jpeg'){ 
	$im = imagecreatefromjpeg($origem); 
	}elseif($ext == 'png'){ 
		$im = imagecreatefrompng($origem); 
	}elseif($ext == 'gif'){ 
		// $im = imagecreatefromgif($origem);
		return false; 
	} 
	
	$w = imagesx($im); 
	$h = imagesy($im); 
	
	if ($w > $h){
		$nw = $largura;
		$nh = ($h * $largura)/$w; 
	}else{ 
		$nh = $largura; 
		$nw = ($w * $largura)/$h; 
	} 
	
	if(function_exists('imagecopyresampled')) { 
		if(function_exists('imageCreateTrueColor')){
			$ni = imageCreateTrueColor($nw,$nh); 
		}else{ 
			$ni    = imagecreate($nw,$nh); 
		} 
		if(!@imagecopyresampled($ni,$im,0,0,0,0,$nw,$nh,$w,$h)){
			imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h); 
		} 
	}else{ 
		$ni    = imagecreate($nw,$nh); 
		imagecopyresized($ni,$im,0,0,0,0,$nw,$nh,$w,$h);
		 
	} 
	
	if($ext=='jpg' || $ext=='jpeg'){ 
		imagejpeg($ni,$destino,$quality); 
	}elseif($ext=='png'){ 
		imagepng($ni,$destino); 
	}elseif($ext=='gif'){ 
		// imagegif($ni,$destino); 
		return false;
	}
}



function makeRotation($origem,$destino) {
	
	$quality = 85;
	$largura = 320;
	$ext      = split("[/\\.]",strtolower($origem)); 
	$n        = count($ext)-1; 
	$ext      = $ext[$n]; 
	
	$arr      = split("[/\\]",$origem); 
	$n        = count($arr)-1; 
	$arra     = explode('.',$arr[$n]); 
	$n2       = count($arra)-1; 
	$tn_name  = str_replace('.'.$arra[$n2],'',$arr[$n]); 

	if ($ext == 'jpg' || $ext == 'jpeg'){ 
	$im = imagecreatefromjpeg($origem);
	$imgrotated = imagerotate($im,90,0);
	}elseif($ext == 'png'){ 
		$im = imagecreatefrompng($origem); 
	}elseif($ext == 'gif'){ 
		// $im = imagecreatefromgif($origem);
		return false; 
	} 
	
	$w = imagesx($imgrotated); 
	$h = imagesy($imgrotated); 
	
	/*
	if ($w > $h){
		$nw = $largura;
		$nh = ($h * $largura)/$w; 
	}else{ 
		$nh = $largura; 
		$nw = ($w * $largura)/$h; 
	}
	*/
	$nw= 480;
	$nh = 320; 
	
	if(function_exists('imagecopyresampled')) { 
		if(function_exists('imageCreateTrueColor')){
			$ni = imageCreateTrueColor($nw,$nh); 
		}else{ 
			$ni    = imagecreate($nw,$nh); 
		} 
		if(!@imagecopyresampled($ni,$imgrotated,0,0,0,0,$nw,$nh,$w,$h)){
			imagecopyresized($ni,$imgrotated,0,0,0,0,$nw,$nh,$w,$h); 
		} 
	}else{ 
		$ni    = imagecreate($nw,$nh); 
		$resized = imagecopyresized($ni,$imgrotated,0,0,0,0,$nw,$nh,$w,$h);
	
	//	imagejpeg($imageRotate,$urlNewImage,65);
	} 
	
	if($ext=='jpg' || $ext=='jpeg'){ 
		imagejpeg($ni,$destino,$quality); 
	}elseif($ext=='png'){ 
		imagepng($ni,$destino); 
	}elseif($ext=='gif'){ 
		// imagegif($ni,$destino); 
		return false;
	}
	
}

?>
