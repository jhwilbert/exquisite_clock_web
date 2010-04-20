$(document).ready(function() {
	
	$("#closeDiv").hide();
		
	// loads the numbers in statistics view	
	$("#statNumber0").click(function(event) { allowed= false; $('#statistics').load("load_numbers.php?num=0"); $('#statistics').show(); $("#closeDiv").show(); $("#statNumber0").css('background','url(imgs/transparency.png)');});
	$("#statNumber1").click(function(event) { allowed= false; $('#statistics').load("load_numbers.php?num=1"); $('#statistics').show(); $("#closeDiv").show(); $("#statNumber1").css('background','url(imgs/transparency.png)');});
	$("#statNumber2").click(function(event) { allowed= false; $('#statistics').load("load_numbers.php?num=2"); $('#statistics').show(); $("#closeDiv").show(); $("#statNumber2").css('background','url(imgs/transparency.png)');});
	$("#statNumber3").click(function(event) { allowed= false; $('#statistics').load("load_numbers.php?num=3"); $('#statistics').show(); $("#closeDiv").show(); $("#statNumber3").css('background','url(imgs/transparency.png)');});
	$("#statNumber4").click(function(event) { allowed= false; $('#statistics').load("load_numbers.php?num=4"); $('#statistics').show(); $("#closeDiv").show(); $("#statNumber4").css('background','url(imgs/transparency.png)');});
	$("#statNumber5").click(function(event) { allowed= false; $('#statistics').load("load_numbers.php?num=5"); $('#statistics').show(); $("#closeDiv").show(); $("#statNumber5").css('background','url(imgs/transparency.png)');});	
	$("#statNumber6").click(function(event) { allowed= false; $('#statistics').load("load_numbers.php?num=6"); $('#statistics').show(); $("#closeDiv").show(); $("#statNumber6").css('background','url(imgs/transparency.png)');});
	$("#statNumber6").click(function(event) { allowed= false; $('#statistics').load("load_numbers.php?num=7"); $('#statistics').show(); $("#closeDiv").show(); $("#statNumber7").css('background','url(imgs/transparency.png)');});
	$("#statNumber8").click(function(event) { allowed= false; $('#statistics').load("load_numbers.php?num=8"); $('#statistics').show(); $("#closeDiv").show(); $("#statNumber8").css('background','url(imgs/transparency.png)');});
	$("#statNumber9").click(function(event) { allowed= false; $('#statistics').load("load_numbers.php?num=9"); $('#statistics').show(); $("#closeDiv").show(); $("#statNumber9").css('background','url(imgs/transparency.png)');});
	
	$("#closeDiv").click(function(event) { allowed= true; $("#statistics").hide(); $("#closeDiv").hide(); $("#statNumber0").css('background','')});

	// fades in the page
	
	var $top = $('.interface');
    var $document = $(document);
    var timer = null;
    var timerIsRunning = false;
	var allowed = true;
    $top.hide();

    $('.interface').mousemove(function(e){
        e.stopPropagation();
    });
//	if(allowed == true) {
    setTimeout(function() {
                        $document.mousemove(function(e) {
                                if($top.is(':hidden')) {
                                    $top.fadeIn();
                                } else {
                                    if(!timerIsRunning && allowed==true) {
									
                                        timerIsRunning = true;
                                        clearTimeout(timer);
                                        timer = setTimeout(function() { $top.fadeOut();  }, 5000);
                                        setTimeout(function() {timerIsRunning = false;}, 2000);
                                    }
                                }
                        });
                }, 500);
//	} else {
		// do nothing
//	}

});

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
