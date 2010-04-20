<?php
	include("../v1/adm/external.php");
	include("../v1/adm/gui/inc/db.php");
	include("../v1/adm/gui/inc/functions.php");
	include("../v1/adm/gui/inc/makethumb.php");
	include("../v1/adm/gui/inc/myerrorhandler.php");

	$DB = new DB();

	include("../v1/adm/class/file/myfile.php");
	include("../v1/adm/class/file/myimage.php");
	include("../v1/adm/class/file/imageresource.php");
	include("../v1/adm/class/file/fileresource.php");
	include("../v1/adm/class/clock/clockroot.php");
	include("../v1/adm/class/clock/clock.php");
	

	

	include("../v1/adm/class/tag/tagroot.php");
	include("../v1/adm/class/tag/tag.php");
	include("../v1/adm/class/clocktag/clocktagroot.php");
	include("../v1/adm/class/clocktag/clocktag.php");
?>