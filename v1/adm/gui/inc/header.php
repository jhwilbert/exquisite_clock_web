<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml"  lang="pt_BR" xml:lang="en_US">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<title><?echo $siteTitle;?> :: Administrativo</title>
	<link rel="STYLESHEET" type="text/css" href="../inc/style.css">
	<script language="JavaScript" type="text/javascript" src="../inc/main.js"></script>
</head>

<body>

<table border="0" cellpadding="0" cellspacing="0" id="main" class="txt" height="100%">
	<tr><td colspan="2" id="top" height="99">&nbsp;</td></tr>
	<tr><td colspan="2" id="logged" height="10"><b>Logged:</b> <?=User::sessionUserName("")?> &nbsp;</td></tr>
	<tr>
		<td id="menu" height="100%">
			<!-- <b>Menu principal</b><br /> -->
			<div id="menuTitle">Menu</div>
			<ul>
				<li>* <a href="../clock/list.php">Clock</a></li>
				<li>&nbsp;</li>
				<li>* <a href="../user/list.php">Users</a></li>
				
				<li>&nbsp;</li>
	
				<li>* <a href="../index/exit.php"><b>Sair</b></a></li>
			</ul>
		</td>
		<td id="contain" height="100%">
	