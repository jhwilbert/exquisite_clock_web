<?php
	include("../inc/common.php");
	include("package.php");

	/* ------------------ PAGING ------------------ */
	$sub 	= toInt(getVar("sub"));
	$actualsub = $sub;
	$offset = 120;
	$total  = 0;
	$orderBy = 'number ASC';
	/* ------------------ // ------------------ */
	
	
	$obj = new Clock();
	$all = $obj->loadLimit($sub, $offset, $orderBy);
	$total = $obj->getTotal('');
	
	$objtag = new ClockTag();

	include("../inc/header.php");
	
?>
	<script language="JavaScript" type="text/javascript" src="java.js"></script>
	<link rel="STYLESHEET" type="text/css" href="../inc/table_info.css">

	<div id="inc">
		<div id="title">Clock List <?include("menu.php");?></div>
		<?showError(getVar("error"));?>
		<div style="clear:both;float:left;">
			<table border="0" cellpadding="5" cellspacing="1" class="info">
				<tr class="legenda">
				</tr>
				
				<?$bg = "";
				
					for ($i = 0; $i < count($all); $i++) {
						$bg = changeBg($bg);
						
						// IMAGE FETCH
						$n = $all[$i];
						$imgList = $n->image->getImages();
						$img = new MyImage();
						if(count($imgList)>0) $img = $imgList[0];
						if($img->getId()>0)
						$imgStr = '<img src="../../files/'.$img->thumbName().'" border="0" />';
						else $imgStr = "no image";
						if($i%8 == 0) echo '<tr>';
						
						$alltags = $objtag->loadTagsByClockId($n->getId());
						
						echo '<td align="center"><a href="inc.php?id='.$n->getId().'">'.$imgStr.'</a><br/>('.$n->getNumber().')<br/>';
							
							for ($b = 0; $b < sizeof($alltags); $b++) {
							
							$y = $alltags[$b];
							print $y->getTag()."  ";
							$numtags = count($alltags);
							}
						// INFO FETCH
						//echo '<br><a href="inc.php?id='.$n->getId().'">Edit</a> | <a href="#" onclick="del('.$n->getId().');return false;">Delete</a><br></td>';
						echo '<br><a href="inc.php?id='.$n->getId().'">Edit</a> | <a href="#" onclick="del('.$n->getId().','.$sub.');return false;">Delete</a><br></td>';
						

						
						if($i%8 == 7) echo '</tr>';
					}
					$stop = false;
					while($i%8 <= 7 && !$stop){
						echo "<td align='center'>-</td>";
						if($i%8 == 7) { echo '</tr>'; $stop = true; }
						$i++;
					}
					echo '<tr><td colspan="8" class="paginacao">';
					paging('list.php', $sub, $offset, $total);
					echo '</td></tr>';
				?>
			</table>
		</div>
	</div>
	
<?include("../inc/footer.php");?>
	