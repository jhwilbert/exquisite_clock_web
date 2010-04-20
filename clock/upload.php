<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>

<title>F A B R I C A : Exquisite Clock</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="javascript/jquery.js"></script>		
<link type="text/css" rel="stylesheet" media="screen" href="css/main.css" />

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
	
<?php
//	include("inc/header.php");
	include("inc/common.php");
	
	$obj = new Clock();
	$tags  = $obj->selectAllTags();
?>


<script language="JavaScript" type="text/javascript">

function validate(){
			
		var msg = document.getElementById("msg");	
					
		var f = document.getElementById("imgFile");
		if(f.value == "") {
		msg.innerHTML = "Choose a file to upload.";
		return false;
		}
		
		
	var t = document.getElementById("tag");
	
	var s = document.getElementById("select");
	
		if(t.value == "" && s.value == "") {
		msg.innerHTML = "Please enter a tag for your image.";	
		return false;
		}
		
		else if( /\s/.test(t.value)) {
		msg.innerHTML = "Please enter just ONE set name.";	
		return false;
		}
		
		var r;
		for(i=0;i<10;i++){
		r = document.getElementById("r"+i);
		if(r.checked) return true;
		}
		msg.innerHTML = "Choose a number.";
		return false;
}



function selectbox() {
	var t = document.getElementById("tag").value = "";
	
	return false;
}

function formfield() {
	var t = document.getElementById("select").value = "";
	return false;
}

$(document).ready(function() {
	
  $('input:checkbox').click(function() {
        
		var buttonChecked = $('input:checkbox:checked');
         if (buttonChecked.length) {
         $('#submitButton').removeAttr('disabled');
		 $('#submitButton').css('background','black')
         } else {
         $('#submitButton').attr('disabled', 'disabled');
		 $('#submitButton').css('background','#d4d4d4')
         }
    });
});


</script>



<div id="upload"> <!-- begin div upload -->
<h1><strong>Add Numbers</strong><br> </h1>


<div id="uploadBox2"> 
<form name="form1" enctype="multipart/form-data" method="post" action="upload_act.php" onSubmit="return validate()">

<!--
<form name="form1" enctype="multipart/form-data" method="post" action="upload_act.php?keepThis=true&TB_iframe=false&height=300&width=500" onSubmit="return validate()">
	 -->
<div id="box">
	
<div id="box1"><!-- begin div box -->
<img src="imgs/step01.png" class="img" ><br>

<input name="img[]" class="formInput" type="file" id="imgFile" accept="*/jpg" size="30"> 

<br><br>
The clock accepts images in JPG format, portrait in 3:2 ratio.<strong> Suggested sizes:</strong> 1600 x 800, 400 x 600, 320, x 480.
</div><!-- end div box -->

<div id="box2"><!-- begin div box -->
<img src="imgs/step02.png" class="img" ><br>
<input type="radio" name="number" value="0" class="mark" id="r0"><label for="r0"> 0&nbsp;</label><input type="radio" name="number" value="1" id="r1"><label for="r1"> 1&nbsp;</label><input type="radio" name="number" value="2" id="r2"><label for="r2"> 2&nbsp;</label></td><input type="radio" name="number" value="3" id="r3"><label for="r3"> 3&nbsp;</label><input type="radio" name="number" value="4" id="r4"><label for="r4"> 4&nbsp;</label><input type="radio" name="number" value="5" id="r5"><label for="r5"> 5&nbsp;</label><input type="radio" name="number" value="6" id="r6"><label for="r6"> 6&nbsp;</label><input type="radio" name="number" value="7" id="r7"> <label for="r7"> 7&nbsp;</label><input type="radio" name="number" value="8" id="r8"><label for="r8"> 8&nbsp;</label><input type="radio" name="number" value="9" id="r9"><label for="r9"> 9&nbsp;</label>
</div><!-- end div box -->

<div id="box3"><!-- begin div box -->

<img src="imgs/step03.png" class="img" ><br>

<div id="boxDiv1"><!-- begins div boxDiv1 -->
	Add to existing set:
	<?php
	$browser =  $obj->browser();
	if($browser == "safari") {
		
	echo "<select name='userselect' id='select' size=1 onMouseUp='selectbox();' >";
		
	} else {
		
	echo "<select name='userselect' id='select' size=1 onChange='selectbox();' >";
	}
	
	echo "<option value=''></option>\n";		
	foreach ($tags as $tag){		
			echo "<option value='".$tag['tag']."'>" .$tag['tag']."</option>\n";			
			}
			echo "</select>";  
			echo "</form>"; 
	?>	

</div><!-- end div box -->

<div id="boxDiv1"> 
Or create a new one:
<input type="text" id="tag" onFocus='formfield();' name="usertags" />
</div>

</div> <!-- end div box -->
</div><!-- end div box -->
<div id="box4"><!-- begin div box -->
	
<input type="submit" id="submitButton" class="btn" name="Submit" value="Submit"><span style="color:#ff0000;font-weight:bold" id="msg"><?=getVar("error");?></span>
<div id="agreement">
<input type="checkbox" name="option1" 	checked="yes"> &nbsp;I agree to grant non-exclusive, royalty-free, worldwide license for the use of any images uploaded to the Exquisite Clock.
</div>
</div>
<br>
</form>

</div> <!-- ends div uploadBox2 -->

<div id="uploadBox1"> <!-- begin div uploadBox1 -->

<?php 

$images=array("imgs/sample01.jpg","imgs/sample02.jpg","imgs/sample03.jpg","imgs/sample04.jpg","imgs/sample05.jpg","imgs/sample06.jpg","imgs/sample07.jpg"); 	
$rand_keys=array_rand($images,2);
echo "<img src=".$images[$rand_keys[0]].">";

?>	

</div> <!-- ends div uploadBox1 -->

</div> <!-- ends div upload -->
</body>
