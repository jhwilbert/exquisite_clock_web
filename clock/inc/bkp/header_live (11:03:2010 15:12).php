<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>

<title>F A B R I C A : Exquisite Clock</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="description" content="Exquisite Clock is based on the idea that time is everywhere and that people can share their vision of time. Through the website www.exquisiteclock.org, users are invited to collect and upload images of numbers that can be found in different contexts around them – objects, surfaces, landscapes, cables... anything that has a  resemblance to a number.The exquisite clock has an online database of numbers - an exquisite database - at its core. This supplies the website and interconnected physical platforms. The online database works like a feeder that provides data to different instances of clocks in the form of the website, and installations, mobile applications, designed products and urban screens.">
<meta name="keywords" content="exquisite, clock, fabrica, timekeeper, interactive art, collaborative art, participatory project, time, local time, watch, exquisite clock, photography, collaboration, web work, web art, installation, media arts">


<link rel="shortcut icon" href="imgs/fabrica_favicon.ico" type="image/x-icon" />
<link type="text/css" rel="stylesheet" media="screen" href="css/main.css" />
<link href="css/thickbox.css" media="screen" rel="stylesheet" type="text/css" />



<script type="text/javascript" src="javascript/jquery.js"></script>
<script type="text/JavaScript" src="javascript/scripts_live.js"></script>
<script type="text/javascript" src="javascript/thickbox.js"></script>
<script type="text/javascript" src="javascript/swfobject.js"></script>

<script language="javascript" type="text/javascript">setTimeout("location.reload();",900000);</script>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="startClock();" >
	
<script language="JavaScript" type="text/javascript">


		

		
	$(document).ready(function() {
	
	// menu rollovers
	$(window).bind('load', function() {
	$('.ro').each( function( key, elm ) { $('<img>').attr( 'src', newImage( $(this).attr('src') ) ); });
	});
	$(".ro").hover(onRollOver, onRollOut);
	
	
	
	// rollovers for statistics	
	$(".stats").hover( function(){
		     $(this).css("background-image", "url(imgs/bgdiv_o.png)"); 
		},
		function(){
		     $(this).css("background-image", "url(imgs/bgdiv.png)");
	});
	
		
	// loads the numbers in statistics view	
	$("#statNumber1").click(function(event) { $('#statistcs').load("load_numbers.php?num=1");});
	$("#statNumber2").click(function(event) { $('#statistcs').load("load_numbers.php?num=2");});
	$("#statNumber3").click(function(event) { $('#statistcs').load("load_numbers.php?num=3");});
	$("#statNumber4").click(function(event) { $('#statistcs').load("load_numbers.php?num=4");});
	$("#statNumber5").click(function(event) { $('#statistcs').load("load_numbers.php?num=5");});	
	$("#statNumber6").click(function(event) { $('#statistcs').load("load_numbers.php?num=6");});
	$("#statNumber6").click(function(event) { $('#statistcs').load("load_numbers.php?num=7");});
	$("#statNumber8").click(function(event) { $('#statistcs').load("load_numbers.php?num=8");});
	$("#statNumber9").click(function(event) { $('#statistcs').load("load_numbers.php?num=9");});
	
	
	// fades in the page
	
	var $top = $('.interface');
    var $document = $(document);
    var timer = null;
    var timerIsRunning = false;

    $top.hide();

    $('.interface').mousemove(function(e){
        e.stopPropagation();
    });
    setTimeout(function() {
                        $document.mousemove(function(e) {
                                if($top.is(':hidden')) {
                                    $top.fadeIn();
                                } else {
                                    if(!timerIsRunning) {
                                        timerIsRunning = true;
                                        clearTimeout(timer);
                                        timer = setTimeout(function() { $top.fadeOut();  }, 5000);
                                        setTimeout(function() {timerIsRunning = false;}, 2000);
                                    }
                                }
                        });
                }, 500);
	

});
	


</script>