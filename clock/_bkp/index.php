<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>
<title>Exquisite Clock :: Numbers are Everywhere ::</title>
   
<meta name="description" content="Exquisite Clock is based on the idea that time is everywhere and that people can share their vision of time. Through the website www.exquisiteclock.org, users are invited to collect and upload images of numbers that can be found in different contexts around them – objects, surfaces, landscapes, cables... anything that has a  resemblance to a number.The exquisite clock has an online database of numbers - an exquisite database - at its core. This supplies the website and interconnected physical platforms. The online database works like a feeder that provides data to different instances of clocks in the form of the website, and installations, mobile applications, designed products and urban screens.">
<meta name="keywords" content="exquisite, clock, fabrica, timekeeper, interactive art, collaborative art, participatory project, time, local time, watch, exquisite clock, photography, collaboration, web work, web art, installation, media arts">	

<link rel="shortcut icon" href="imgs/favicon.ico" type="image/x-icon" />
<link type="text/css" rel="stylesheet" media="screen" href="css/main.css" />
<link href="css/thickbox.css" media="screen" rel="stylesheet" type="text/css" />

<?php $tag= $_GET["tag"]; ?>

<script type="text/javascript" src="javascript/jquery.js"></script>
<script type="text/javascript" src="javascript/scripts_interface.js"></script>
<script type="text/javascript" src="javascript/thickbox.js"></script>
<script type="text/javascript" src="javascript/swfobject.js"></script>

<?php

if ($_GET["live"]==0) {  // its running clock from a static collection
	include("inc/common.php");
	include("inc/clock_collection.php");
	echo '<script>';
	for ($i = 0; $i < sizeof($number); $i++) { echo "arr".$i." = new Array('".implode("','",$number[$i])."');\n";}
	echo '</script>';
} else if ($_GET["live"]==1) { // clock is running in live mode
	include("inc/common.php");
	include("inc/clock_live.php");		
}

?>
<script type="text/javascript" src="javascript/scripts_<?php if($_GET["live"] ==1) { echo 'live'; } else if($_GET["live"]==0) { echo 'collection'; }; ?>.js"></script>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="startClock();" >

<script language="JavaScript" type="text/javascript">
$(document).ready( function() {
	$(window).bind('load', function() {
		$('.ro').each( function( key, elm ) { $('<img>').attr( 'src', newImage( $(this).attr('src') ) ); });
	});
	$(".ro").hover(onRollOver, onRollOut);
});
</script>
	
<div id="titlewrapper"> <!-- begin title  wrapper !-->
	
	<div id="title" class="interface">
	<a href="http://www.exquisiteclock.org" target="_self"><img src="imgs/logo.gif" border="0" id="logo"></a>

	<div id="flashcontent"></div>

	<div id="menuleft">
	<a href="http://about.exquisiteclock.org" target="_blank" ><img src="imgs/about.gif" class="ro" border="0"></a><a href="http://about.exquisiteclock.org" target="_blank" ><img src="imgs/contact.gif" class="ro" border="0"></a>
	</div> <!-- menu left !-->	
	
	</div> <!-- title  !-->
	
</div>	 <!--title  wrapper !-->
	
<div id="menutop" class="interface">	<!-- begin menu  !-->
<? include("inc/menu_top.php"); ?>
</div> <!-- end menu  !-->

<script type="text/javascript">
   var so = new SWFObject("swf/tag_flash.swf", "tag_flash", "300", "30", "8", "#ffffff");
   so.addVariable("tagname", "<? echo $tagname; ?>");
   so.write("flashcontent");	   
</script>

<div id="resizewrap"><!-- begin resizewrap  !-->

		<div id="numbers"> <!-- begin numbers  !-->
			<div class="gap"> </div>
				<div id="numbersHH"> 			
				<a href="#" onClick="switchNumber('hours1')" ><img name="hours1" id="hours1" class="number" src="imgs/blank.jpg" border="0"></a><a href="#" onClick="switchNumber('hours2')" ><img name="hours2" id="hours2" class="number" src="imgs/blank.jpg" border="0"></a>			
				</div>
				
			<div class="gap2"></div>
				<div id="numbersHH2"> 
				
				<a href="#" onClick="switchNumber('minutes1')" ><img name="min1" id="minutes1" class="number" src="imgs/blank.jpg" border="0"></a><a href="#" onClick="switchNumber('minutes2')" ><img name="min2" id="minutes2" class="number" src="imgs/blank.jpg" border="0"></a>
				</div>
			<div id="numbersHH"> 
			<a href="#" onClick="switchNumber('seconds1')" ><img name="sec1" id="seconds1" class="number" src="imgs/blank.jpg" border="0"></a><a href="#" onClick="switchNumber('seconds2')" ><img name="sec2" id="seconds2" class="number" src="imgs/blank.jpg" border="0"></a>
			
			</div>
		</div> <!-- end numbers !-->
	<div style="clear: both;"></div>
</div><!-- end resize wrap -->


</div> <!-- end  menu bottom !-->

<div class="interface"  id="statistics_wrapper">

<div id="statistics_header" > 

<?php
	$obj = new Clock();
	
	if($_GET["tag"]=="random") {
	$totalNumbers = $obj->getStatistics();
	
	$i = 0;
	foreach ($totalNumbers as $totalNumber) {
		echo '<div class="stats" id="statNumber'.$i.'">';   
		echo $totalNumber;
		echo "<img src='./imgs/spacerStats.gif' width='3'>"; 
		echo '</div>';
		$i++;
		
	}

	echo '<div id="statsTotal">';
	echo $totalCount = $obj->getTotal("clock");
	echo '</div>';
	
		
	} else {
	
	//$tagid = $_GET["tag"];
	//$totalNumbers = $obj->getStatisticsTag($tagid);
	
	}


?>

</div> <!-- end statistics header !-->



<div id="statistics"></div>

</div> <!-- end wrapper !-->

<div id="closeDiv"></div>

<div id="add_numbers" class="interface">
<a href="upload.php?keepThis=true&TB_iframe=false&height=510&width=710" title="" class="thickbox"><img src="imgs/addnumbers.png" class="ro" border="0"></a>
</div>


<div id="footer"> <!-- begin  footer !-->
<!--
? include("inc/footer.php"); ?> !-->
</div> <!-- end  footer !-->

</body>
</html>
