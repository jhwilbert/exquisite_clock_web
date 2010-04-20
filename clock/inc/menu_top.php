<script language=javascript>

function newclock() {
	document.body.focus();
	document.ex2.submit();
}


</script>

<?php
	
	$obj = new Clock();

	$tags  = $obj->selectFlaggedTags();
	
	$browser =  $obj->browser();
		
	if($full_array = "") {	
		
	} else {
		
	$desired_option = $tag;
		
	if($browser == "msie") {
	echo "<form name='ex2' action='inc/xfer.php' method='POST' >";
	echo "<select name='xfer' id='select1' size=1  onchange='javascript:newclock()'>";
		
	} else if ($browser == "mozilla") {

	echo "<form name='ex2' action='inc/xfer.php' method='POST' >";
	echo "<select name='xfer' id='select1' size=1  onChange='newclock()'>";
		
	} else if ($browser == "safari") {

	echo "<form name='ex2' action='inc/xfer.php' method='POST' >";
	echo "<select name='xfer' id='select1' size=1  onchange='javascript:newclock()'>";

	} 

	$selectdecode = ($tag="random" == $desired_option) ? 'selected="selected"' : '';
//	echo "<option value='../index.php?tag=all' >all numbers</option>\n";	
	echo "<option value='../index.php?live=1&tag=random'".$selectdecode . ">random</option>\n";
	
	foreach ($tags as $tag){
		$selected = ($tag['id'] == $desired_option) ? 'selected="selected"' : '';
			echo "<option value=../index.php?live=0&tag=".$tag['id']." ".$selected ." >".$tag['tag']."</option>";
		}
			
	echo "</select>";  
	echo "</form>";
} 

?>
