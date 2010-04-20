<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>
<title>Exquisite Clock :: Numbers are Everywhere ::</title>
   
<link type="text/css" rel="stylesheet" media="screen" href="css/main.css" />
<link rel="shortcut icon" href="imgs/favicon.ico" type="image/x-icon" />

</head>

<body>	

<?php

	include("inc/common.php");
//	$number = 2;
	$number = $_GET["num"];
 	/* ------------------ PAGING ------------------ */
	$sub 	= toInt(getVar("sub"));
	$actualsub = $sub;
	$offset = 350;
	$total  = 0;
	$orderBy = 'number ASC';
	/* ------------------ // ------------------ */
	

	$obj = new Clock();
	//$all = $obj->loadLimit($sub, $offset, $orderBy);
	$all = $obj->loadByNumber($number,$sub, $offset, $orderBy);
	$total = $obj->getTotal('');
	
	$objtag = new ClockTag();

	
?>

				<?$bg = "";
				
					for ($i = 0; $i < count($all); $i++) {
						$bg = changeBg($bg);
						
						// IMAGE FETCH
						$n = $all[$i];
						
						$imgList = $n->image->getImages();
						$img = new MyImage();
						
						if(count($imgList)>0) $img = $imgList[0];
						if($img->getId()>0)
						$imgStr = '<img src="../v1/adm/files/'.$img->thumbName().'" border="0" width="40" height="60" />';
						else $imgStr = "no image";
						if($i%8 == 0) echo '';
						
					echo '<a href="viewnumber.php?id='.$n->getId().'&keepThis=false&TB_iframe=true&height=505&width=340" class="thickbox">'.$imgStr.'</a>';
						//echo '<a href="viewnumber.php?height=500&width=320&id='.$n->getId().' "class="thickbox">'.$imgStr.'</a>';
					
					if($i%8 == 7) echo '';
					}
					$stop = false;
					while($i%8 <= 7 && !$stop){
						
						if($i%8 == 7) { echo ''; $stop = true; }
						$i++;
					}
					//echo '<div id="pagination">';
					//	paging('load_numbers.php', $sub, $offset, $total);
					//	echo '</div>';
					
?>
</body>
</html>