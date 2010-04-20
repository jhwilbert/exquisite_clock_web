<?php
	include("../inc/common.php");

	/* ------------------ PAGING ------------------ */
	$sub 	= toInt(getVar("sub"));
	$offset = 30;
	$total  = 0;
	$orderBy = '';
	/* ------------------ // ------------------ */
	
	$user = new User("","","");
	$all = $user->loadLimit($sub, $offset, $orderBy);
	
	include("../inc/header.php");
	
?>
	<script language="JavaScript" type="text/javascript" src="user.js"></script>
	<link rel="STYLESHEET" type="text/css" href="../inc/table_info.css">

	<div id="inc">
		<div id="title">User List <?include("menu.php");?></div>
		<?showError(getVar("error"));?>
		<div style="clear:both;float:left;">
			<table border="0" cellpadding="3" cellspacing="1" class="info">
				<tr class="legenda">
					<td width="10">&nbsp;</td>
					<td width="220">Name</td>
					<td width="100">Login</td>
					<td width="180">E-Mail</td>
					<?if($user->sessionUserId("")==1){?>
					<td width="22">Edit</td>
					<td width="33">Delete</td>
					<?}?>
				</tr>
				<?$bg = "";
					for ($i = 0; $i < count($all); $i++) {
						$bg = changeBg($bg);
						$n = $all[$i];
						$total = $n->getTotal();
						echo '' .
								'<tr class="'.$bg.'">' .
								'	<td>'.($sub+$i+1).'</td>' .
								'	<td>'.$n->getName().'</td>' .
								'	<td>'.$n->getLogin().'</td>' . 
								'	<td>'.$n->getEmail().'</td>';
						if($user->sessionUserId("")==1){
							echo '' .
								'	<td><a href="inc.php?id='.$n->getId().'">Edit</a></td>' .
								'	<td><a href="#" onclick="delUser('.$n->getId().');return false;">Delete</a></td>';
						}
						echo '</tr>';
					}
					echo '<tr><td colspan="8" class="paginacao">';
					paging('list.php', $sub, $offset, $total);
					echo '</td></tr>';
				?>
			</table>
		</div>
	</div>
	
<?include("../inc/footer.php");?>
	