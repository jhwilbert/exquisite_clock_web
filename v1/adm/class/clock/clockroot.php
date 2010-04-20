<?php
class ClockRoot{ 

	/* *************** The attribute list *************** */
	var $id;
	var $incDate;
	var $number;
	var $dbTable 	= "clock";
	var $className 	= "Clock";
	var $DB;

	/* *************** Pattern constructor *************** */
	function ClockRoot(){
		global $DB;
	 	global $jsonFileRoot;
			
		$this->id = 0;
		$this->incDate = time();
		$this->number = 0;
		$this->DB = $DB;
	}

	/* *************** Setters *************** */
	function setId($var){
		$this->id = toInt($var);
	}

	function setIncDate($var){
		$this->incDate = dateToInt($var);
	}

	function setNumber($var){
		$this->number = toInt($var);
	}


	/* *************** Getters *************** */
	function getId(){
		return $this->id;
	}

	function getIncDate(){
		return $this->incDate;
	}

	function getNumber(){
		return $this->number;
	}


	/* *************** Set Var From Form Values *************** */
	function setFromForm(){
		$this->setId(getVar("id"));
		$this->setNumber(getVar("number"));
	}
	
	

	/* *************** Databse functions *************** */
	function setFromRow($row){
		$this->id = $row["id"];
		$this->incDate = $row["incDate"];
		$this->number = $row["number"];
	}
	function setFromName($row){
		$this->id = $row["id"];
		//$this->incDate = $row["incDate"];
		$this->tag = $row["tag"];
	}
	
	function load($id){
		$strSQL = "" . 
			"SELECT * " . 
			"FROM ".$this->dbTable." " . 
			"WHERE 1=1 " . 
			"AND id=$id " . 
			"LIMIT 0,1"; 
		$result = $this->DB->getObj("".$this->className." :: function load($id)",$strSQL); 
		$row = mysql_fetch_array($result); 
		$this->setFromRow($row); 
	}
	
	


	/** Get total of records given an where clause. */
	function getStatistics(){
		$strSQL = "SELECT number, COUNT(id) FROM clock GROUP BY number"; 
		$result = $this->DB->getObj("".$this->className." :: function getStatistics()",$strSQL); 
		$arr = array();
		while($row=mysql_fetch_array($result)){
			$arr[] .= $row['COUNT(id)']; 
		//echo   "_____".$row['COUNT(id)'];
		}
  		return $arr;
	}
	
	function getStatisticsTag($tagid){
		$strSQL = "SELECT clock.number, COUNT(clock.id) FROM clock, clockTag WHERE clockTag . tagId LIKE $tagid AND clock.id = clockTag.clockId GROUP BY number"; 
		$result = $this->DB->getObj("".$this->className." :: function getStatistics()",$strSQL); 
		$arr = array();
		while($row=mysql_fetch_array($result)){
			$arr[] .= $row['COUNT(clock.id)']; 
		//echo   "_____".$row['COUNT(id)'];
		}
  		return $arr;
	}
	
	function getTotal(){
		$strSQL = "" . 
			"SELECT COUNT(id) AS total " . 
			"FROM ".$this->dbTable." " . 
			"WHERE 1=1 " . 
			";"; 
		$result = $this->DB->getObj("".$this->className." :: function getTotal()",$strSQL); 
		$row=mysql_fetch_array($result); 
		$total=$row["total"]; 
		return $total; 
	}


	
	function getLastID() {
		
		$strSQL = "SELECT id FROM ". $this->dbTable. " ORDER BY id DESC LIMIT 0,1";		
		$result = $this->DB->getObj("".$this->className." :: function getLastID()",$strSQL);		
		$row=mysql_fetch_array($result); 
		$lastid = $row[0];
		
		return $lastid;				
	}	
		
		
	function getLastTagID($tag) {
		
		$strSQL = "SELECT id FROM tag WHERE tag LIKE '%$tag%'";
		$result = $this->DB->getObj("".$this->className." :: function getLastTagID($tag)",$strSQL);
		
		$row=mysql_fetch_array($result); 
		$lastTagId = $row[0];

		return $lastTagId;
		
		

	}
	
	function selectAllTags() {

	    $strSQL="SELECT * FROM tag ORDER BY tag ASC";
	    $result = $this->DB->getObj("".$this->className." :: function selectAllTags()",$strSQL);   
	  	
	  	if($result) {
	  		
	    $n = 0;
		$full_array = Array();
		
	    while($row = mysql_fetch_array($result)) {
			$full_array[$n] = $row;
	      	$n ++;
	     }
		 return $full_array;
	  		
	  	}

		}
	
		function selectFlaggedTags() {

	    $strSQL="SELECT * FROM tag WHERE flag =1";
	    $result = $this->DB->getObj("".$this->className." :: function selectAllTags()",$strSQL);   
	  	
	    $n = 0;
		$full_array = Array();

	    while($row = mysql_fetch_array($result)) {
			$full_array[$n] = $row;
	      	$n ++; 
	     }

	  	    return $full_array;
	  
		}
		
	function flagTags($lastTagId) {
	
		$strSQL = "SELECT count( DISTINCT number ) FROM clock, tag t, clockTag c WHERE t.id=$lastTagId AND t.id = c.tagId AND clock.id = c.clockId ";
		$result = $this->DB->getObj("".$this->className." :: function flagTags($lastTagId)",$strSQL);	
		$row=mysql_fetch_array($result); 
		$numbersum = $row[0];
		
		return $numbersum;

		}
	
	function deflagTags() {
	
		$strSQL = "SELECT count( DISTINCT number ) FROM clock, tag t, clockTag c WHERE t.id=(SELECT tag.id FROM clockTag, tag WHERE 1=1 AND tagId = tag.id AND clockId = ".$this->id." LIMIT 0 , 1) AND t.id = c.tagId AND clock.id = c.clockId ";
		$result = $this->DB->getObj("".$this->className." :: function deflagTags()",$strSQL);	
		$row=mysql_fetch_array($result); 
		$numbersum = $row[0];
		
		
		if($numbersum != 10) {	
			$strSQL = "UPDATE tag SET flag=0 WHERE tag.id=(SELECT tag.id FROM clockTag WHERE 1=1 AND tagId = tag.id AND clockId = ".$this->id.")";
				$this->DB->exe("".$this->className." :: function deflagTags()",$strSQL); 
				
			  if ($numbersum == 0) {
				$strSQL1 = "DELETE FROM tag WHERE tag.id=(SELECT tag.id FROM clockTag WHERE 1=1 AND tagId = tag.id AND clockId = " .$this->id. ")";
				$this->DB->exe("".$this->className." :: function deflagTags()",$strSQL1);
			
		}	
		} else {
		//do nothing
		}
		return $numbersum;
		}
		
		
	function checkFlag($numbersum,$lastTagId) {

		if($numbersum == 10) {	
				$strSQL = "UPDATE tag SET flag=1 WHERE tag.id=$lastTagId";
				$this->DB->exe("".$this->className." :: function checkFlag($numbersum,$lastTagId)",$strSQL); 
				return $lastTagId;
		} else {
			
				return $lastTagId;
		//dont do anything
		}
		}
	

	function loadLimit($sub,$offset,$orderBy){
		if($orderBy=="") $orderBy = "id DESC";
    		$strSQL = "" . 
			"SELECT * " . 
			"FROM ".$this->dbTable." " . 
			"WHERE 1=1 " . 
			"ORDER BY $orderBy " . 
			"LIMIT $sub,$offset";
			
		$result = $this->DB->getObj("".$this->className." :: function loadLimit($sub, $offset, $orderBy)",$strSQL); 
		$all = Array(); 
		$i	 = 0; 
		while ($row=mysql_fetch_array($result)){ 
			$all[$i] = new Clock(); 
			$all[$i]->setFromRow($row); 
			$i++; 
		}
		return $all; 
	}

	function loadByNumber($number,$sub,$offset,$orderBy){
		if($orderBy=="") $orderBy = "id DESC";
    		$strSQL = "" . 
			"SELECT * " . 
			"FROM ".$this->dbTable." " . 
			"WHERE clock.number =" .$number." ". 
			"ORDER BY $orderBy " . 
			"LIMIT $sub,$offset";
			
		$result = $this->DB->getObj("".$this->className." :: function loadLimit($sub, $offset, $orderBy)",$strSQL); 
		$all = Array(); 
		$i	 = 0; 
		while ($row=mysql_fetch_array($result)){ 
			$all[$i] = new Clock(); 
			$all[$i]->setFromRow($row); 
			$i++; 
		}
		return $all; 
	}
	
	function loadAll($orderBy){
		//if($orderBy=="") $orderBy = "id DESC";
		$strSQL = "" . 
			"SELECT * " . 
			"FROM ".$this->dbTable." " . 
			"WHERE 1=1 " . 
			"ORDER BY RAND() " . 
			""; 
		$result = $this->DB->getObj("".$this->className." :: function loadAll($orderBy)",$strSQL); 
		$all = Array(); 
		$i	 = 0; 
		while ($row=mysql_fetch_array($result)){ 
			
			$all[$i] = new Clock(); 
			$all[$i]->setFromRow($row); 
			$i++; 
		}
		return $all; 
	}
	
		function loadAll2($orderBy){
		$strSQL = "" . 
			"SELECT * " . 
			"FROM ".$this->dbTable." " . 
			"WHERE 1=1 " . 
			"ORDER BY incDate DESC " . 
			""; 
		$result = $this->DB->getObj("".$this->className." :: function loadAll($orderBy)",$strSQL); 
		$all = Array(); 
		$i	 = 0; 
		while ($row=mysql_fetch_array($result)){ 
			
			$all[$i] = new Clock(); 
			$all[$i]->setFromRow($row); 
			$i++; 
		}
		return $all; 
	}
	
		function loadRecent($orderBy){
		$strSQL = "" . 
			"SELECT * " . 
			"FROM ".$this->dbTable." " . 
			"WHERE incDate  > UNIX_TIMESTAMP() - 60"; 
		$result = $this->DB->getObj("".$this->className." :: function loadRecent($orderBy)",$strSQL); 
		$all = Array(); 
		$i	 = 0; 
		while ($row=mysql_fetch_array($result)){ 
			
			$all[$i] = new Clock(); 
			$all[$i]->setFromRow($row); 
			$i++; 
		}
		return $all; 
	}
	
		function return_result($sql) {
	  // if the query was successful
	}


	
		function loadByTagId($orderBy, $tagid){
			if($orderBy=="") $orderBy = "id DESC";
		$strSQL = "" . 
			"SELECT clock.id, clock.incDate, clock.number FROM clock, clockTag WHERE clockTag . tagId LIKE $tagid AND clock.id = clockTag.clockId ORDER BY number asc "; 
		$result = $this->DB->getObj("".$this->className." :: function loadByTagId($orderBy,$tagid)",$strSQL); 
		$all = Array();
		 
		$i	 = 0; 
		while ($row=mysql_fetch_array($result)){ 		
			$all[$i] = new Clock(); 
			$all[$i]->setFromRow($row); 
			$i++; 
				//echo($row[2] . " ");
		}
			
		return $all; 
	}
	
	
	
	function loadTagName($tagid) {
		
		$strSQL = "" . 
			"SELECT * FROM tag WHERE  tag.id = $tagid"; 
		$result = $this->DB->getObj("".$this->className." :: function loadByTagId($tagid)",$strSQL); 
			$i	 = 0; 
		while ($row=mysql_fetch_array($result)){ 		
			$all[$i] = new Clock(); 
			$all[$i]->setFromName($row); 
			$i++; 
			
			$tagfinal = $row[2];
			
		}
		return $tagfinal;
		return $all; 
		
		}
		
	
	function browser() {

       $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']); 

        // Identify the browser. Check Opera and Safari first in case of spoof. Let Google Chrome be identified as Safari. 
        if (preg_match('/opera/', $userAgent)) { 
            $name = 'opera'; 
        } 
        elseif (preg_match('/webkit/', $userAgent)) { 
            $name = 'safari'; 
        } 
        elseif (preg_match('/msie/', $userAgent)) { 
            $name = 'msie'; 
        } 
        elseif (preg_match('/mozilla/', $userAgent) && !preg_match('/compatible/', $userAgent)) { 
            $name = 'mozilla'; 
        } 
        else { 
            $name = 'unrecognized'; 
        } 
		return $name;
        
}



	/* *************** Store functions *************** */
	function store(){
		if($this->id==0)
			$this->storeObj();
		else
			$this->updateObj();
	}

	function storeObj(){
		$strSQL = "" .
			"INSERT INTO ".$this->dbTable." " .
			"(incDate,number) " .
			"VALUES (" . 
				"".$this->incDate.",".
				"".$this->number."" .
			")";
		$this->id = $this->DB->exe("".$this->className." :: storeObj()",$strSQL); 
	}

	function updateObj(){
		$strSQL = "" .
			"UPDATE ".$this->dbTable." " .
			"SET " . 
				"number = ".$this->number." " .
			"WHERE 1=1 " . 
			"AND id = ".$this->id." " . 
			";";
		$this->DB->exe("".$this->className." :: updateObj()",$strSQL); 
	}

	/* *************** Del functions *************** */
	function del(){ 
		if(toInt($this->id)>0){ 

			$strSQL = "DELETE FROM ".$this->dbTable." WHERE id = ".$this->id .""; 
			$this->DB->exe("".$this->className." :: function del(".$this->id.")",$strSQL); 
			
			for ($s = 0; $s < 4 ; $s++) {
			
			$this->deflagTags();
		
			}	
		 
		} 
		
	} 

	/* *************** Install functions *************** */
	function install(){ 
		$strSQL = "CREATE TABLE IF NOT EXISTS ".$this->dbTable." ( " . 
			"id int unsigned NOT NULL auto_increment," . 
			"`incDate` int(32) NOT NULL DEFAULT 0 , " . 
			"`number` int(32) NOT NULL DEFAULT 0 , " . 
			"PRIMARY KEY  (id)," . 
			"UNIQUE KEY id (id)" . 
		") TYPE=MyISAM;";
		$this->DB->exe("".$this->className." :: function install()",$strSQL); 
	} 
	
	function generateJSON($jsonFileRoot) {
		
		$file_handle = fopen($jsonFileRoot.'/feed.json','w+');
		$file_handle2 = fopen($jsonFileRoot.'/wgetfeed.txt','w+');
		
		$all = $this->loadAll("number ASC");
		$recent = $this->loadRecent("");
		
		$currpath = 'http://gym.vegans.it/exquisite_clock/v1/adm/installation_rotated/clock/';
		//$currpath = "http://www.".$_SERVER['HTTP_HOST']."/v1/adm/installation_rotated/clock/";
		
		$number = array();
		$recentNumber = array();

		// expand multidimensionals

		for ($i = 0; $i < 10; $i++) {
			$number[$i] = array();
		}

		for ($a = 0; $a < 10; $a++) {
			$recentNumber[$a] = array();
		}
		
		for ($i = 0; $i < sizeof($all); $i++) {
			$n = $all[$i];
			$totalids = $this->getTotal('');				
			$imgList = $n->image->getImages();	
			$img = new MyImage();	
			if(count($imgList)>0) $img = $imgList[0];
			$number[$n->getNumber()][] = $img->completePath2();
		 }
		
		for ($a = 0; $a < sizeof($recent); $a++) {
			$m = $recent[$a];
			$totalrecentids = $this->getTotal('');
			$recentimgList = $m->image->getImages();
			$recentimg = new MyImage();
			if(count($recentimgList)>0) $recentimg = $recentimgList[0];
			$recentNumber[$m->getNumber()][] = $recentimg->completePath2();
		}		
		
		// print the jSON FILE
		$output_txt = "";
		$output = "{";
		for ($i = 0; $i < 10; $i++) {	
				for ($i = 0; $i < sizeof($number); $i++) {
					
					$output .= '"'.json_encode($i).'":[';							
					
					foreach($recentNumber[$i] as $finalrecentNumber) {
						
						$output_txt .=  $currpath.$finalrecentNumber . "\n";  			   	
					   	$output .= '{ "URL" : '.json_encode($finalrecentNumber).', "N" : "1"},';			    						
			       	}
			       	$lastitem = sizeof($number[$i])-1;
		        	$curritem = 0;
		
		        	foreach($number[$i] as $finalnumber) {                   
				 //   if($curritem == $lastitem){ $output .= '{ "URL" : '.json_encode($finalnumber).', "tag" :'.'"'.$tag.'"'.'}'."\n";   } else {$output .= '{ "URL" : '.json_encode($finalnumber).', "tag" :'.'"'.$tag.'"'.'},';}
				      if($curritem == $lastitem){ $output .= '{ "URL" : '.json_encode($finalnumber).'}'."\n";   } else {$output .= '{ "URL" : '.json_encode($finalnumber).'},';}
				     $curritem++;
				    }
		        if($i == 9){$output .= "]";} else { $output .= "],";}
			} 
		}
		$output .= "}";
		
		fwrite($file_handle2,$output_txt);
		fclose($file_handle2);
		
		fwrite($file_handle,$output);
		fclose($file_handle);
		
		return false;
		exit;	

	}
}
?>
