<?php
	include("../inc/common.php");
	include("package.php");
	
	$obj = new Clock();
	$obj->load(toInt(getVar("id")));
	$img = $obj->image->getImages();
	if(count($img)>0) $img = $img[0]; else $img = new MyImage();
	
	$objTag = new ClockTag();
	//$numberTags = $objTag-> loadTagsByClockId($_GET["id"]);
	
	
		function listTagOfClock($clockId){
			
		$objTag = new ClockTag();	
		$all = $objTag->loadTagsByClockId($clockId);
		
		for ($i = 0; $i < sizeof($all); $i++) {
		$x = $all[$i];
		//echo $i.") [".$x->getId()."] ".$x->getTag()."<br/>";
		print "(". $x->getId().") ".$x->getTag()." ";

		}	
		
	} 
	
	
	//	$tagidtemp = listTagOfClock($_GET["id"]);
	//	preg_match("/\(([^()]+)\)/", $tagidtemp,$matches);
	//	echo $tagidfinal = $matches[1];
		
	//	$numbersum = $obj->deflagTags($tagidfinal);
	

	include("../inc/header.php");
?>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script language="JavaScript" type="text/javascript" src="java.js"></script>

	<div id="inc">
		<div id="title">Clock Inc <?include("menu.php");?></div> 
		<?showError(getVar("error"));?>
		<div style="clear:both;float:left;width:600px;">
		<form name="inc" action="act.php" method="post" enctype="multipart/form-data" onsubmit="return validaForm(this);">
			<input type="hidden" name="id" value="<?=$obj->getId()?>" />
			
			<table border="0" cellpadding="5" cellspacing="0" border="0" width="800">
				<tr>
					<td width="170" height="120" style="border:1px solid #ccc; vertical-align: middle; text-align:center;">
		  				<?if($img->getId()==0){?>
		  					no image
		  				<?}else{
		  					//echo '<a href="#" onclick="viewImg(\''.$img->completePath().'\','.$img->getId().','.$img->getWidth().','.$img->getHeight().');return false;"><img src="../../files/'.$img->thumbName().'" border="0" alt="" /></a>';
		  					echo '<a href="#" onclick="viewImg(\''.$img->completePath().'\','.$img->getId().','.$img->getWidth().','.$img->getHeight().');return false;"><img src="../../installation/'.$img->completePath().'" border="0" alt="" /></a>';
		  				}?>
		  			</td>
		  			<td valign="top" width="210">
		  				Image: <?if($img->getId()>0){?>&nbsp;&nbsp;&nbsp;<a href="#" onclick="delImg(<?=$obj->getId();?>);return false;">Delete</a><?}?><br />
		  				<input type="file" name="img[]" class="input" /><br />
		  				<p>
		  				Tags: <br /><?php  listTagOfClock($_GET["id"]);?><br /><br />
		  			    
		  		
		  				
		  				Select Number: <br />
		  				<?
		  					for ($i = 0; $i < 10; $i++) {
								if($obj->getNumber() == $i) $checked = "checked"; else $checked = "";
								echo '<input type="radio" name="number" value="'.$i.'" '.$checked.' id="r'.$i.'" /><label for="r'.$i.'"> '.$i.' </label>&nbsp;&nbsp;&nbsp;';
								if($i==4) echo "<br/>";
							}
		  				?>
		  				<in
		  			</td>
				</tr>
		  	</table><br/>

	  		<div style="clear:both;float:left;margin: 5px 0px 5px 0px;"><input type="submit" name="btSubmit" value=" Enviar " class="btInput" /></div>

		</form>
		</div>
	</div>

<?include("../inc/footer.php");?>
