var allowed= true;

$(document).ready(function() {
	
	$("#closeDiv").hide();
	$("#loading").hide();
	
	$("#closeDiv").click(function(event) { $.scrollTo({top:'0px'}, 800, {onAfter:function(){ $("#statistics").hide(); }}); allowed= true; $("#add_numbers").show(); $("#closeDiv").hide(); $(".stats").css('background','')});

	$(".stats").each(
		function(intIndex){
			$( this ).bind (
				"click",
				function(){
				
					$("#loading").show();
					
					$.get("load_numbers.php", { num: intIndex, }, 
					   function(data){
							$("#loading").hide();
							$('#statistics').html(data);
							success: $.scrollTo({top:'2000px'},800, {onAfter:function(){  }});
						
					 });
					$('#statistics').show(); 
					allowed = false;
					$("#add_numbers").hide();
					$(".stats").css('background','');
					$("#closeDiv").show(); 
					//$("#statistics").append("<?php include('add_numbers.php'); ?>");
				///	$('#statistics').load("load_numbers.php?num="+intIndex);
					
					$("#statNumber"+intIndex).css('background','url(imgs/transparency.png)');
					
					
				});
	});
		
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
                                        timer = setTimeout(function() { if(allowed==true) { $top.fadeOut(); } }, 5000);
                                        setTimeout(function() {timerIsRunning = false;}, 2000);
                                    }
                                }
                        });
                }, 500);
});



// rollovers for statistics	
$(".stats").hover( function(){
	     $(this).css("background-image", "url(imgs/bgdiv_o.png)"); 
	},
	function(){
	     $(this).css("background-image", "url(imgs/bgdiv.png)");
});

function pageScroll() {
    	window.scrollBy(0,50); // horizontal and vertical scroll increments
    	scrolldelay = setTimeout('pageScroll()',100); // scrolls every 100 milliseconds
}