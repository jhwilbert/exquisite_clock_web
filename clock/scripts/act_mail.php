<?
////TELL A FRIEND SUBMITTED...
if(isset($_POST["submit"])) {
	
//VALID EMAIL
	
	include_once( "functions.php");
	include_once( "../../../scripts/mail.php");
	$from_email = @$_POST["your_email"];
	$to_email = @$_POST["to_email"];
	$subject = @$_POST["subject"];
	$message = @$_POST["message"];
	$errors = "";  	

$headers = 'From: '.$from_email . "\r\n" .
    'Reply-To: '.$from_email . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

	//VALIDATE THE FROM EMAIL
	if(!valid_email(trim($from_email)))$errors .= "Your email address is invalid. ";
	//VALIDATE THE TO EMAILS
	if(!valid_email(trim($to_email)))$errors .= "To email address is invalid. ";
	
	if($errors=="")
	{
		//$success = sendMail( $to_email, "A video message for you", $message, "", $from_email );
		$success = mail($to_email, $subject, $message, $headers);
		if($success){
			echo "1";
		} else{
			$errors .= "Sorry, Your email couldn't be sent at this time. ";
			echo "0#".$errors;
		}
	} else {
		echo "0#".$errors;
	}
} else {	
	echo "0#No data recieved. ";
}
?>