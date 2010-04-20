<?php
/**
 * Return the list of year and the list of months 
 * to be used in a select form element
 */
function getMonthYear($month, $year){
	/********************* DATES *********************/
	//setlocale(LC_TIME, 'pt_BR.ISO8859-1'); /*
	setlocale(LC_TIME, 'portuguese');//*/
	$today = time();
	if($month == ""){ $month = strftime("%m",$today); }
	if($year  == ""){ $year  = strftime("%Y",$today); }
	
	$time 		= mktime(1, 1, 1, $month, 1, $year);
	$monthDays 	= date("t",$time);
	$startMonth 	= "01";
	$startYear 	= "2006";
	$cuurYear 	= strftime("%Y",$today); 
	$monthsV 	= array(); $monthsN = array();
	$yearsV  	= array(); $yearsN  = array();
	for ($i = 0; $i < 12; $i++) {
		$time = mktime(1, 1, 1, ($i+1), 1, $year);
		$monthsV[$i] = strftime("%m",$time);
		$monthsN[$i] = ucfirst(strftime("%B",$time));
	}
	$y=0;
	for ($i = $startYear; $i <= ($cuurYear+1); $i++) {
		$time = mktime(1, 1, 1, 1, 1, $i);
		$yearsV[$y] = strftime("%Y",$time);
		$yearsN[$y] = strftime("%Y",$time);
		$y++;
	}
	// echo date("m/Y",mktime(0,0,0,$month,date("d"),$year));
	return array("monthsN"=>$monthsN,"monthsV"=>$monthsV,"yearsN"=>$yearsN,"yearsV"=>$yearsV,"monthDays"=>$monthDays);
}

?>
