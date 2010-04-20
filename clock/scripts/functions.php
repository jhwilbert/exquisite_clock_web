<?
//VALID EMAIL
function valid_email($email)
{
		if(!preg_match("/^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$/", $email))
		return false;
		else
		return true;
}


//SEARCH WORDS
function search_word($word){
 	$videos_word = select_videos($word);
	if($videos_word){
		return $videos_word;
	} else {
		return false;
	}
}

//MAKE THE THUMBNAIL IMAGE
function makeThumbnail($video, $thumb){
	$command = "ffmpeg -i ".$SERVER_DIR.$video." -f mjpeg -ss 1 -vframes 1 -s 320x180 -an ".$SERVER_DIR.$thumb;
	exec($command,$output);
	echo 'success thumb='.$success;
	echo 'output thumb='.print_r($output);
	return $success;
}


function trimVideo($filename, $vin, $vout){
	

	$command = "ffmpeg -i ".$SERVER_DIR.$filename.  ' -ss ' . $vin . ' -t '. $vout .' -vcodec copy -acodec copy -y' . ' '. $filename;
	
	//$command = "ffmpeg -i ".$SERVER_DIR.$filename." -vcodec copy -acodec copy -ss 00:00:00 -t 00:00:01 ".$SERVER_DIR.$filename2;

	//echo "<br>";
	//echo "<br>";

	exec($command,$output, $success);
	echo 'success video='.$success;
	echo 'output video='.print_r($output);
	return $success;
}



//THIS CREATED THE DIR TO PUT THE VIDEO/THUMB FILE..EG 2008/5/31/
function makeFolderStructure($p){		
	$year=date("Y");	
	$month=date("m");
	$day=date("d");

	if (file_exists($p.$year)) {
	}
	else{           
		mkdir($p.$year, 0777);
		//chmod($p.$year, 0777);
	}
	//month
	if (file_exists($p.$year."/".$month)) {
	}
	else{
		mkdir($p.$year."/".$month, 0777);
		//chmod($p.$year, 0777);
	}
	//day
	if (file_exists($p.$year."/".$month."/".$day)) {
		
	}
	else{
		mkdir($p.$year."/".$month."/".$day, 0777);
		//chmod($p.$year, 0777);
	}
	return $year."/".$month."/".$day."/";
}
?>