<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>
<title>Exquisite Clock :: Numbers are Everywhere ::</title>
   
<meta name="description" content="Exquisite Clock is based on the idea that time is everywhere and that people can share their vision of time. Through the website www.exquisiteclock.org, users are invited to collect and upload images of numbers that can be found in different contexts around them – objects, surfaces, landscapes, cables... anything that has a  resemblance to a number.The exquisite clock has an online database of numbers - an exquisite database - at its core. This supplies the website and interconnected physical platforms. The online database works like a feeder that provides data to different instances of clocks in the form of the website, and installations, mobile applications, designed products and urban screens.">
<meta name="keywords" content="exquisite, clock, fabrica, timekeeper, interactive art, collaborative art, participatory project, time, local time, watch, exquisite clock, photography, collaboration, web work, web art, installation, media arts">	

<link rel="shortcut icon" href="imgs/favicon.ico" type="image/x-icon" />
<link type="text/css" rel="stylesheet" media="screen" href="css/main.css" />
<link href="css/thickbox.css" media="screen" rel="stylesheet" type="text/css" />

<?php  
  if(isset($_GET['tag'])) {
	
	$tag= $_GET["tag"];
	
	} else {
	
	$tag="random";
}

  if(isset($_GET['live'])) {

	$live= $_GET["live"];
	
	} else {
	/*echo "we dont have tag for live"; */
	$live=1;
}
?>

<script type="text/javascript" src="javascript/jquery.js"></script>
<script type="text/javascript" src="javascript/scripts_interface.js"></script>
<script type="text/javascript" src="javascript/jquery.scrollTo.js"></script>
<script type="text/javascript" src="javascript/thickbox.js"></script>
<script type="text/javascript" src="javascript/swfobject.js"></script>

<?php

if ($live==0) { 
	include("inc/common.php");
	include("inc/clock_collection.php");
	echo '<script>';
	for ($i = 0; $i < sizeof($number); $i++) { echo "arr".$i." = new Array('".implode("','",$number[$i])."');\n";}
	echo '</script>';
} else if ($live==1) {
	include("inc/common.php");
	include("inc/clock_live.php");		
}

?>
<script type="text/javascript" src="javascript/scripts_<?php if($live ==1) { echo 'live'; } else if($live==0) { echo 'collection'; }; ?>.js"></script>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="startClock();" >

<script language="JavaScript" type="text/javascript">
$(document).ready( function() {
	$(window).bind('load', function() {
		$('.ro').each( function( key, elm ) { $('<img>').attr( 'src', newImage( $(this).attr('src') ) ); });
	});
	$(".ro").hover(onRollOver, onRollOut);
});

function tb_init(){
	$(document).click(function(e){
	e = e || window.event;
	var el = e.target || e.scrElement || null;
	if(el && el.parentNode && !el.className || !/thickbox/.test(el.className))
	el = el.parentNode;
	if(!el || !el.className || !/thickbox/.test(el.className))
	return;
	var t = el.title || el.name || null;
	var a = el.href || el.alt;
	var g = el.rel || false;
	tb_show(t,a,g);
	el.blur();
	return false;
	});
};

</script>

<div id="bigwrapper">
		
<div id="titlewrapper"> <!-- begin title  wrapper !-->
	
	<div id="title" class="interface">
	<a href="http://www.exquisiteclock.org" target="_self"><img src="imgs/logo.png" border="0" id="logo"></a>


	<div id="menuleft">
	<a href="http://about.exquisiteclock.org" target="_blank" ><img src="imgs/about.png" class="ro" border="0"></a><a href="http://exquisiteapp.org" target="_blank" ><img src="imgs/download.png" class="ro" border="0"></a>
	</div> <!-- menu left !-->	
	
	</div> <!-- title  !-->

	<div id="menutop" class="interface">	<!-- begin menu  !-->
	<? include("inc/menu_top.php"); ?>
	</div> <!-- end menu  !-->

	
</div>	 <!--title  wrapper !-->
	
<div id="resizewrap"><!-- begin resizewrap  !-->

		<div id="numbers" > <!-- begin numbers  !-->
			<div class="gap"></div>
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



<?php
	$obj = new Clock();
	
	if(isset($_GET['tag'])){

	if($_GET["tag"]=="random") {
	
	echo '<div id="statistics_header" >';
		
	$totalNumbers = $obj->getStatistics();
	
	$i = 0;
	foreach ($totalNumbers as $totalNumber) {
		echo '<div class="stats" id="statNumber'.$i.'">';   
		echo $totalNumber;
		echo "<img src='./imgs/spacerStats.gif' width='3'>"; 
		echo '</div>';
		$i++;
		
	}

	/*echo '<div id="statsTotal">';
	echo $totalCount = $obj->getTotal("clock");
	echo '</div>';
	*/
	echo '</div>'; 
	}
	
	} else  {
	
	//$tagid = $_GET["tag"];
	//$totalNumbers = $obj->getStatisticsTag($tagid);	
	}
?>
<div id="loading"></div>
<div id="menu" class="interface">
<div id="fabLogo">
<a href="http://fabrica.it" target="blank"><img src="imgs/fab_logo.png" border="0"></a>
</div>
<div id="closeDiv"></div>

<div id="add_numbers">
<a href="upload.php?keepThis=false&TB_iframe=false&height=510&width=710" title="" class="thickbox"><img src="imgs/addnumbers.png" class="ro" border="0"></a>
</div> <!-- end menu !-->

</div>
<div id="statistics" class="thickbo">
</div>

</div> <!-- end statistics wrapper !-->

</div><!-- end big wrapper !-->

</body>
</html>