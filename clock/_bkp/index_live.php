<?php
	include("inc/common.php");	
	include("inc/header_live.php");
	$obj = new Clock();
	

	
	if($tag == "all" or $tag == null or $tag == "decode"  ) {
		$tag = "all";
		
		$tagname = "decode";			
	} else {
			$tagname = "decode";
	
	}
	
?>

<div id="titlewrapper"> <!-- begin title  wrapper !-->
	
	<div id="title" class="interface"> <!-- begin title  !-->
		
		<a href="http://www.exquisiteclock.org" target="_self"><img src="imgs/logo.gif" border="0" id="logo"></a>
	
		<div id="flashcontent"></div>
	
		<div id="menuleft">

	<a href="http://about.exquisiteclock.org" target="_blank" ><img src="imgs/about.gif" class="ro" border="0"></a><a href="http://about.exquisiteclock.org" target="_blank" ><img src="imgs/contact.gif" class="ro" border="0"></a>
		</div>
	
	</div> <!-- end title  !-->
		
		
	
		
</div>	 <!-- end title  wrapper !-->
	
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
</div><!-- end resizewrap -->


</div> <!-- end  menu bottom !-->

<? include("statistics.php"); ?>
<div id="footer"> <!-- begin  footer !-->
<!--
? include("inc/footer.php"); ?> !-->
</div> <!-- end  footer !-->


