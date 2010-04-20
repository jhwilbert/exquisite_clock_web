<?php

echo '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
	<key>uploadUrl</key>
	<string>http://gym.vegans.it/exquisite_clock_vr2/clock/upload_act.php</string>
	<key>version</key>
	<string>1.0.0.0</string>
';


include("inc/common.php");

$obj = new Clock();
$all = $obj->loadAll("number asc");
$tags  = $obj->selectFlaggedTags();

echo "<key>tags</key><array>";
 
 foreach ($tags as $tag){
//	echo $tag['id'];
//	echo "<option value='../index.php?tag=".$tag['id']."'>" .$tag['tag']."</option>\n";
	echo "<string>" .ucwords($tag['tag'])."</string>";
  //echo "<li><a href='index_webhigh.php?tag=".$tag['id']."'>" .$tag['tag']."</a>"."</li>";	
}

echo "</array>";;  //close the select


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

	$number[$n->getNumber()][] = $img->getFileName().$img->getFileExt();
}

// loop through numbers and generate
// an array node for each number
for($i = 0; $i < sizeOf($number); $i++) {
	echo '
		<key>'.$i.'</key>
			<array>';
	for($ii =0; $ii < sizeOf($number[$i]); $ii++) {
			echo '
				<string>'.$number[$i][$ii].'</string>';
	}
	echo '
			</array>';
}


echo '</dict>
</plist>';

?>