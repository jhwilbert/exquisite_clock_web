<?php include("inc/header.php");?>

<script language = "JavaScript">

function validate_required(field,alerttxt) {
	var msg = document.getElementById("msg");
	
with (field) {
if (value==null||value=="")
{ msg.innerHTML = alerttxt;return false }
else {return true}
}
}

function validate_email(field,alerttxt) {
with (field) {
apos=value.indexOf("@")
dotpos=value.lastIndexOf(".")
if (apos<1||dotpos-apos<2)
{msg.innerHTML = alerttxt;return false}
else {return true}
}

} function validate_form(thisform)	{
		with (thisform) {
	if (validate_required(name,"Please enter your name!")==false)
	{name.focus();return false}

	if (validate_email(email,"Not a valid e-mail address!")==false)
	{email.focus();return false}

	if (validate_required(message,"Please enter a message!")==false)
	{message.focus();return false}
	}
}
</script>

<div id="contactContent">
<img  src="imgs/contact_title.gif" border="0"><br>
Share with us your comments, suggestions.
<br><br>
<div id="contactBox">

<span style="color:#ff0000;font-weight:bold" id="msg"></span>

<form name="contact" action="sendmail.php" method="post" onSubmit="return validate_form(this);">
Name:<br>
<input type="text" class="input-box"  name="name" size="30" maxlength="30" value=""></td>

<br><br>Email Address:<br>
<input type="text" name="email" class="input-box" size="30" maxlength="30" value="" id="email">
<br><br>Message:<br>
<textarea name="message" class="text-box"  cols="45" rows="5"></textarea><br><br>
<input type="submit" name="submit" value="Send">
</form>

</div>
</div>
