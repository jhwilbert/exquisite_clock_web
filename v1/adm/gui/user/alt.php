<?php
	include("../inc/common.php");
	$user = new User("","","");
	header("location: inc.php?id=".$user->sessionUserId(""));
?>
