<?php
	include("inc/common.php");
	
	$obj = new Clock();
	
	if((is_numeric ($_GET["tag"])) ||($_GET["tag"]=="all")) {
	
	$tag= $_GET["tag"];
	
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
			
	
	include("inc/header.php");
?>

<div id="title"> <!-- begin title  !-->
	<a href="http://www.exquisiteclock.org" target="_self"><img src="imgs/logo.gif" border="0" id="logo"></a>	<div id="flashcontent"></div>
	<script type="text/javascript">
	   var so = new SWFObject("swf/tag_flash.swf", "tag_flash", "250", "29", "8", "#ffffff");
	   so.addVariable("tagname", "<? echo $tagname; ?>");
	   so.write("flashcontent");	   
	</script>

	
	<div id="menutop"> 
		teste
	<? include("inc/menu_top.php"); ?>
	</div> 
</div> <!-- end title  !-->

<div id="resizewrap"><!-- begin resizewrap  !-->

		<div id="numbers"> <!-- begin numbers  !-->
			<div class="gap"></div>
				<div id="numbersHH"><a href="#" onClick="switchNumber('hours1')" border="0"><img name="hours1" id="hours1" class="number" src="imgs/blank.jpg"></a><a href="#" onClick="switchNumber('hours2')" border="0"><img name="hours2" id="hours2" class="number" src="imgs/blank.jpg"></a></div>
				
			<div class="gap2"></div>
				<div id="numbersHH2"><a href="#" onClick="switchNumber('minutes1')" border="0"><img name="min1" id="minutes1" class="number" src="imgs/blank.jpg"></a><a href="#" onClick="switchNumber('minutes2')" border="0"><img name="min2" id="minutes2" class="number" src="imgs/blank.jpg"></a></div>
			
			<div id="numbersHH"><a href="#" onClick="switchNumber('seconds1')" border="0"><img name="sec1" id="seconds1" class="number" src="imgs/blank.jpg"></a><a href="#" onClick="switchNumber('seconds2')" border="0"><img name="sec2" id="seconds2" class="number" src="imgs/blank.jpg"></a></div>
		</div> <!-- end numbers !-->
	<div style="clear: both;"></div>
</div><!-- end resizewrap -->

<div id="menu"> <!-- begin  menu bottom !-->
<? include("inc/menu_bottom.php"); ?>
</div> <!-- end  menu bottom !-->

<div id="footer"> <!-- begin  footer !-->
<? include("inc/footer.php"); ?>
</div> <!-- end  footer !-->


