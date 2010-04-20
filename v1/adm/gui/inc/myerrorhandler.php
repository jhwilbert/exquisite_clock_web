<?php
/**
 * Require the mailHtml function.
 */

	/** Handle error doing a action after send it to a report email. */
	function myErrorHandler($errno, $errstr, $errfile, $errline) {
		global $reportMail, $owner;
		$dateTime = date("d/m/Y, H:i:s",time());
		if($errno == 2048) return;
		$str  = "<b>ErrNo: </b>".$errno."<br>";
		$str .= "<b>Erro: </b>".$errstr."<br>";
		$str .= "<b>File: </b>".$errfile."<br>";
		$str .= "<b>Line: </b>".$errline."<br>";
		$str .= "<b>Time: </b>".$dateTime."<br>";
		//mailHtml($owner." Report Error",$reportMail,$owner." :: Report Error - PHP",$str);
		echo "<p><hr>".$str."<p>";
	}

	//==============================================================================================================================
	// redefine the user error constants - PHP 4 only
	define("FATAL", E_USER_ERROR);
	define("ERROR", E_USER_WARNING);
	define("WARNING", E_USER_NOTICE);
	
	// set the error reporting level for this script
	//error_reporting(FATAL | ERROR | WARNING);    //$str =  hw_error(0).": ".hw_errormsg(0);
	error_reporting(E_ALL);
	// set to the user defined error handler
	$old_error_handler = set_error_handler("myErrorHandler");    

?>