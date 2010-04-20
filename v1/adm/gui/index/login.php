<?php
	include("../../external.php");
	include("../inc/functions.php");
	include("../inc/myerrorhandler.php");
	include("../../class/file/myfile.php");
	include("../../class/file/myimage.php");
	include("../../class/file/imageresource.php");
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml"  lang="pt_BR" xml:lang="en_US">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<title><?echo $siteTitle;?> : Clock Administration</title>
	<link rel="STYLESHEET" type="text/css" href="../inc/style.css">
	<script language="JavaScript" type="text/javascript" src="../inc/main.js"></script>
</head>

<body>
<table border="0" cellpadding="0" cellspacing="0" id="main" class="txt" height="100%">
	<tr><td colspan="2" id="top">&nbsp;</td></tr>
	<tr><td colspan="2" id="logged">&nbsp;<tr><td>
	<tr>
		<td id="menu" height="100%">&nbsp;</td>
		<td id="contain" style="border:none;" height="100%">
			<div id="inc" style="margin-left:140px;">
			<?showError(getVar("error"));?>
			<div style="clear:both;float:left;">
				<br />
				<form name="login" action="login_act.php" method="post" enctype="multipart/form-data" onsubmit="return validaForm(this);">
					<b>Login:</b><br />
					<input type="text" maxlength="255" class="input" name="login" id="login" title="Login;Campo Obrigatório">
					<p>
					<b>Password:</b><br />
					<input type="password" maxlength="255" class="input" name="password" id="password" title="Senha;Campo Obrigatório">
					<p>
			  	
			  	<div style="clear:both;float:left;margin: 5px 0px 5px 0px;"><input type="submit" name="btSubmit" value=" Log In " class="btInput" /></div>
				</form>
				<br /><br /><br /><br />
			</div>
		</td>
	</tr>
	<tr>
</table>
</body>
</html>
