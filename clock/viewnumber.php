<link type="text/css" rel="stylesheet" media="screen" href="css/main.css" />
<?php
include("inc/common.php");
//include("inc/header.php");

	$obj = new Clock();
	$obj->load(toInt(getVar("id")));
	$img = $obj->image->getImages();
	if(count($img)>0) $img = $img[0]; else $img = new MyImage();
	
	$objTag = new ClockTag();

		function listTagOfClock($clockId){
			
		$objTag = new ClockTag();	
		$all = $objTag->loadTagsByClockId($clockId);
		
		for ($i = 0; $i < sizeof($all); $i++) {
		$x = $all[$i];
		//echo $i.") [".$x->getId()."] ".$x->getTag()."<br/>";
		print "(". $x->getId().") ".$x->getTag()." ";

		}	
		
	} 		
		  echo "<div id='view_number'>";
		  echo '<img src="../v1/adm/installation/'.$img->completePath().'" border="0" alt="" /></a>';
		  echo "</div>"
		?>


 <br /><!--<
?php  listTagOfClock($_GET["id"]);?><br /><br /
!-->
		  				<?
		  			//	echo $obj->getNumber();