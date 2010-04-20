<?php
	header("Content-type: text/xml");
	print "<?xml version=\"1.0\"?>";
	include("inc/common.php");
	
?>

	<clock> 
	<?php
	
		$tag = $_GET['tag'];
		
		// loads class into object
		$obj = new Clock();
		
		// loads the numbers or tagged ones
		$all = $obj->loadAll2("incDate DESC");
		
		if($tag == "all" or $tag == null) {
			
			$tag = "all";
		    $all = $obj->loadAll2("incDate DESC");
	
		$tagname = "all";
			
		} else {
			$all = $obj->loadByTagId("incDate DESC", $tag);
			$tagname = $obj->loadTagName($tag);
		} 	
		
		// prints paths node
		echo "<paths>".
			"<path>http://gym.vegans.it/exquisite_clock/v1/adm/files</path>".
			"<path>http://gym.vegans.it/exquisite_clock/v1/adm/web</path>".
			"<path>http://gym.vegans.it/exquisite_clock/v1/adm/mobile</path>";
		echo "</paths>";
		
		// prints tag node	
		echo "<tag>".$tagname."</tag>";
		
		$number = array();
		
		for ($i = 0; $i < 10; $i++) {		$number[$i] = array();		}
		
		// prints numbers node
	
		
		for ($i = 0; $i < sizeof($all); $i++) {
				
				$n = $all[$i];
								
				$totalids = $obj->getTotal('');				
				$imgList = $n->image->getImages();	
							
				$img = new MyImage();	
							
				if(count($imgList)>0) $img = $imgList[0];
										$number[$n->getNumber()][] = $img->completePath();
		
		}
		// create other nodes and fill them
		for ($i = 0; $i < 10; $i++) {			
			for ($i = 0; $i < sizeof($number); $i++) {
				
				echo "<collection>";
				echo "<digit number="."'".$i."'"." >";
			
				foreach($number[$i] as $finalnumber) {
				
					echo "<url>";
					echo $finalnumber;
					echo "</url>";
				
			}
			
			echo "</digit>";
			echo "</collection>";		
		} 
					
	}
		
?>
	</clock>

