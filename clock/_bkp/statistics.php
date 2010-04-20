<?php
	$obj = new Clock();
?>

<div class="interface"  id="statistics_wrapper">

<div id="statistics_header" > 

<?php
	if($_GET["tag"]=="decode") {
		echo $tagid;
	$totalNumbers = $obj->getStatistics();	
	} else {
	$tagid = $_GET["tag"];
	
	$totalNumbers = $obj->getStatisticsTag($tagid);
	}
	
	$i = 0;
	foreach ($totalNumbers as $totalNumber) {
		echo '<div class="stats" id="statNumber'.$i.'">';   
		echo $totalNumber;
		echo "<img src='./imgs/spacerStats.gif' width='3'>"; 
		echo '</div>';
		$i++;
		
	}

	echo '<div id="statsTotal">';
	echo $totalCount = $obj->getTotal("clock");
	echo '</div>';
	
?>

</div> <!-- end statistics header !-->


<div id="closeDiv"></div>

<div class="interface" id="addNumber"></div>

<div id="statistics"></div>

</div> <!-- end wrapper !-->




