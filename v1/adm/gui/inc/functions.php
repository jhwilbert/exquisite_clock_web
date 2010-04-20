<?php
	/* ****************** GLOBAL VARS ****************** */
	/** String representation of boolean data. */
	$boolStr = array("Não","Sim");

	/* ****************** HTML FUNCTIONS ****************** */
	/**
	 * Convert a string to the HTML format, changing all special 
	 * caracter to HTML entities. This funciton convert also the
	 * simple and double cuotes.
	 * @param String str String to be converted.
	 * @return String String Converted string with all HTML elemnts in the entities form.
	 */
	function toHtmlEnt($str){
		return trim(htmlentities ($str, ENT_QUOTES));
	}
	/**
	 * Undo the toHtmlEnt(String).
	 * @param String string The string in the HTML entities format.
	 * @return String String with the elemnts in HTML form.  
	 */
	function fromHtmlEnt ($string){
	   $trans_tbl = get_html_translation_table (HTML_ENTITIES);
	   $trans_tbl = array_flip ($trans_tbl);
	   return trim(strtr($string, $trans_tbl));
	}
	
	/**
	 * Treat a text to be stored in the data base.
	 * The transformation are:
	 * <ul>
	 * 	<li>Add slashs to correctness of quotes</li>
	 * 	<li>Convert the break lines in HTML break lines</li>
	 * </ul>
	 * @param String txt The texto from a text area form element
	 * @return String Converted string to be used in HTML format and included in data base
	 */
	function toDB($txt){
		// replace the break line to <br />
		$txt = str_replace(chr(13),"<br />",$txt);
		$txt = str_replace(chr(10),"",$txt);
		
		// add slashes
		$txt = addslashes($txt);
		return $txt;
	}
	
	/**
	 * Convert the text from data base to text area
	 * @param String txt The text to be included in a text area form element
	 * @return String The text in the right format
	 */
	function DBtoTA($txt){
		$txt = str_replace("<br />","\n",$txt);
		$txt = stripslashes($txt);
		return $txt;
	}

	/**
	 * Convert the text from data base to HTML representation
	 * @param String txt The text to be included in a HTML context
	 * @return String The text in the right format
	 */
	function DBtoHTML($txt){
		$txt = stripslashes($txt);
		return $txt;
	}
	
	/**
	 * Format the link.
	 * @param String link The link to be formated
	 * @return String The link formated
	 */
	function formatLink($link){
		$link =  str_replace("http://","",$link);
		$link = toHtmlEnt($link);
		return $link;
	}
	
	/**
	 * Show the error string if there is one.
	 * @param String error The error description. 
	 */
	function showError($error){
		if(toBool($error)){
			echo '<div id="error" class="error">'.stripslashes($error).'</div>';
		}
	}
	
	/**
	 * Restrict a text size respecting the words.
	 * @param txt Text to be cuted
	 * @param size The number of chars (approx.)
	 */
	function cutWord($txt, $size){
		$splitText = split(" ",fromHtmlEnt($txt));
		$s = 0;
		$resultText = "";
		for ($i = 0; $i < sizeof($splitText) && 
					 ($s + strlen($splitText[$i])) < $size; $i++) {
			$resultText .= toHtmlEnt($splitText[$i])." ";
			$s = $s + strlen($splitText[$i]);
		}
		if($i < sizeof($splitText))
			$resultText .= " ...";
		return $resultText;
	}

	/** Make the first letter lowercase */
	function firstLower($str){
		return strtolower(substr($str,0,1)).substr($str,1);
	}

	/** Make the first letter uppercase */
	function firstUpper($str){
		return strtoupper(substr($str,0,1)).substr($str,1);
	}
	
	function allFirstUpper($str){
		$str = split(" ",strtolower($str));
		for ($i = 0; $i < sizeof($str); $i++) {
			$str[$i] = firstUpper($str[$i]);
		}
		return implode(" ",$str);
	}


	/* ****************** GET VAR FUNCTIONS ****************** */
	/**
	 * Get a variable from GET or from POST. If there is no index
	 * the function will return a empty string.
	 * @param String idx Index of the required variable in GET or POST
	 * @return The variable value. 
	 */
	function getVar($idx){
		$var = "";
		if(isset($_POST[$idx])){
			$var = $_POST[$idx];
		}else if(isset($_GET[$idx])){
			$var = $_GET[$idx];
		}
		return $var;
	}
	
	/**
	 * Convert a empty var toa int representation 0 (zero) 
	 */
	function toInt($var){
		if($var == "") return 0;
		return $var;
	}
	
	/**
	 * Check if the variable is embty.
	 * If is is return FALSE, otherwise return TRUE
	 */
	function toBool($var){
		if($var=="") return false;
		else return true;
	}

	/* ****************** MAIL FUNCTIONS ****************** */
	function mailHtml($from, $to, $subject, $message){
		$from	  = "JH <jhwilbert@gmail.com>";
		$headers  = "From: $from\n";
		$headers .= "Reply-To: $from\n";
		$headers .= "Return-Path: $from\n";
		$headers .= "Message-Id: <".time()."@jhwilbert.com>\n";
		$headers .= "X-Mailer: php-mail-function-0.2\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: text/html; charset=iso-8859-1\n";
		return mail($to, $subject, $message, $headers); 
	}
	
	/* ****************** RESTRICT ERROR ****************** */
	function restricError($goTo,$objId,$error){
		echo 	"<body onload='ini()'>" .
				"<script>\n" .
				"	function ini (){" .
				"		f = document.getElementById('err');\n" .
				"		f.submit();\n" .
				"	}" .
				"</script>\n" .
				"<form name='err' id='err' action='$goTo' method='post' enctype='multipart/form-data'>\n" .
				"	<input type='hidden' name='id' value='$objId'>\n" .
				"	<input type='hidden' name='error' value='$error'>\n" .
				"</form>\n" .
				"</body>";
	
	}
	
	/* ****************** DATE FUNCTIONS ****************** */
	/**
	 * Format a date accordding the params
	 */
	function formatDate($date){
		if($date<=0) return "";
		return date("d/m/Y",$date);
	}
	function formatDateHora($date){
		if($date<=0) return "";
		return date("d/m/Y - H:i",$date);
	}
	function formatDateYear($date){
		if($date<=0) return "";
		return date("Y",$date);
	}
	
	function digits($int,$d){
		$str = (string) $int;
		$n = strlen($str);
		for($i=0;$i<($d-$n);$i++){
			$str = "0".$str;
		}
		return $str;
	}
	
	/**
	 * Get a formated date and convert to a int value 32 bits.
	 * It depends of the defined format in formatDate function; @link{#formatDate($date)} 
	 */
	function dateToInt($date){
		if($date=="" || $date<=0) return 0;
		$date = split("/",$date);
		$d = $date[0];
		$m = $date[1];
		$y = $date[2];
		return strtotime($y."-".$m."-".$d);
	}

	/* ****************** AUX FUNCTIONS ****************** */
	function paging($pg, $sub, $offset, $total){
		$next = ($sub+$offset);
		$prev = ($sub-$offset);
		$ps 	= ceil($total/$offset);
		$p  	= ceil($sub/$offset)+1;
		if($ps==0) $ps=1;

		if(strrpos($pg, ".php")==(strlen($pg)-4)){
			$pg .= "?";
		}else{
			$pg .= "&";
		}
		echo '<div id="paging">';
		echo '	<div id="pgl">';
		if($prev>=0){
			echo '<a href="'.$pg.'sub='.$prev.'">Back</a>';
		}
		echo '&nbsp;</div>';
		if($total>0)
			echo '<div id="pgc">'.$p.'/'.$ps.'</div>';
		echo '<div id="pgr">';
		if($next<$total){
			echo '<a href="'.$pg.'sub='.$next.'">Next</a>';
		}
		echo '&nbsp;</div>';
		echo '</div>';
	}
	
	/** Change the bg from table info */
	function changeBg($bg){
		if($bg=="linhaClara") $bg="linhaEscura"; else $bg="linhaClara"; 
		return $bg;
	}

	/**
	 * Build a option list to a selectform obejct.
	 * The names and values must have the same size.
	 * @param Array names list of names
	 * @param Array values list of values
	 * @param Object selected The value to mark as selected
	 */
	function buildOptions($names, $values, $selected){
		for ($i = 0; $i < sizeof($names) && $i < sizeof($values); $i++) {
			if($selected == $values[$i])
				echo "<option value='".$values[$i]."' selected>".$names[$i]."</option>\n";
			else
				echo "<option value='".$values[$i]."'>".$names[$i]."</option>\n";
		}
	}
	function buildOptionsTitle($names, $values, $titles, $selected){
		for ($i = 0; $i < sizeof($names) && $i < sizeof($values); $i++) {
			if($selected == $values[$i])
				echo "<option value='".$values[$i]."' title='".$titles[$i]."' selected>".$names[$i]."</option>\n";
			else
				echo "<option value='".$values[$i]."' title='".$titles[$i]."'>".$names[$i]."</option>\n";
		}
	}
	function buildOptionsStates($selected){
		$values = array();
		$names  = array();
		$values[] = "AC"; $names[] = "Acre";
		$values[] = "AL"; $names[] = "Alagoas";
		$values[] = "AM"; $names[] = "Amazonas";
		$values[] = "AP"; $names[] = "Amapá";
		$values[] = "BA"; $names[] = "Bahia";
		$values[] = "CE"; $names[] = "Ceará";
		$values[] = "DF"; $names[] = "Distrito Federal";
		$values[] = "ES"; $names[] = "Espírito Santo";
		$values[] = "GO"; $names[] = "Goiás";
		$values[] = "MA"; $names[] = "Maranhão";
		$values[] = "MG"; $names[] = "Minas Gerais";
		$values[] = "MS"; $names[] = "Mato Grosso do Sul";
		$values[] = "MT"; $names[] = "Mato Grosso";
		$values[] = "PA"; $names[] = "Pará";
		$values[] = "PB"; $names[] = "Paraíba";
		$values[] = "PE"; $names[] = "Pernambuco";
		$values[] = "PI"; $names[] = "Piauí";
		$values[] = "PR"; $names[] = "Paraná";
		$values[] = "RJ"; $names[] = "Rio de Janeiro";
		$values[] = "RN"; $names[] = "Rio Grande do Norte";
		$values[] = "RO"; $names[] = "Rondônia";
		$values[] = "RS"; $names[] = "Rio Grande do Sul";
		$values[] = "RR"; $names[] = "Roraima";
		$values[] = "SC"; $names[] = "Santa Catarina";
		$values[] = "SE"; $names[] = "Sergipe";
		$values[] = "SP"; $names[] = "São Paulo";
		$values[] = "TO"; $names[] = "Tocantins";
		buildOptions($names,$values,$selected);
	}

?>