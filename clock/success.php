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
<img  src="imgs/contact_title.gif" border="0">
<br><br>
<div id="contactBox">

Thank you for your message!

</div>
</div>
<? include("inc/footer.php"); ?>