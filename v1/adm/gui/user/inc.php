<?php
	include("../inc/common.php");
	
	$user = new User("","","");
	$user->load(toInt(getVar("id")));
	if(!$user->isLogged() && $user->getId()!=0 && $user->sessionUserId("")!=1){
		header("location: list.php");
		exit;
	}
	
	include("../inc/header.php");
	
?>
	<script language="JavaScript" type="text/javascript" src="user.js"></script>
	
	<div id="inc">
		<div id="title">User Inc <?include("menu.php");?></div>
		<?showError(getVar("error"));?>
		<div style="clear:both;float:left;">
			<form name="user" action="act.php" method="post" enctype="multipart/form-data" onsubmit="return validaFormUser(this);">
				<input type="hidden" name="id" value="<?echo $user->getId();?>" />
				<input type="hidden" name="oldLogin" value="<?echo $user->getLogin();?>" />
	
					Name:<br />
					<input type="text" maxlength="255" class="input" name="name" value="<?echo $user->getName();?>" title="Nome;Campo Obrigatório" />
					<p>
					E-Mail:<br />
					<input type="text" maxlength="255" class="input" name="email" value="<?echo $user->getEmail();?>" />
					<p>
					Login:<br />
					<input type="text" maxlength="255" class="input" name="login" value="<?echo $user->getLogin();?>" title="Login;Campo Obrigatório" />
					<p><br />
					<?if($user->getId()==0){?>
						Password:<br />
						<input type="password" maxlength="255" class="input" name="pw" id="pw" title="Senha;Campo Obrigatório" />
						<p>
						Confirm password:<br />
						<input type="password" maxlength="255" class="input" name="pwcf" id="pwcf" title="Confirmação da senha;Campo Obrigatório" />
					<?}else if($user->isLogged()){?>
						Change password:<br />
						<input type="password" maxlength="255" class="input" name="altpw" id="altpw" />
						<p>
						Confirm password:<br />
						<input type="password" maxlength="255" class="input" name="altpwcf" id="altpwcf" />
					<?}?>
					<p>
		  		<div style="clear:both;float:left;margin: 5px 0px 5px 0px;"><input type="submit" name="btSubmit" value=" Enviar " class="btInput" /></div>
			</form>
		</div>
	</div>
<?include("../inc/footer.php");?>

