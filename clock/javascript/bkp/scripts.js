num = new Array(arr0, arr1, arr2, arr3, arr4, arr5, arr6, arr7, arr8, arr9);

var usrarr0 = arr0.slice(0,10);
var usrarr1 = arr1.slice(0,10);
var usrarr2 = arr2.slice(0,10);
var usrarr3 = arr3.slice(0,10);
var usrarr4 = arr4.slice(0,10);
var usrarr5 = arr5.slice(0,10);
var usrarr6 = arr6.slice(0,10);
var usrarr7 = arr7.slice(0,10);
var usrarr8 = arr8.slice(0,10);
var usrarr9 = arr9.slice(0,10);

num_user = new Array(usrarr0,usrarr1,usrarr2,usrarr3,usrarr4,usrarr5,usrarr6,usrarr7,usrarr8,usrarr9);

var i = 5;

function rand ( s ) {
  return ( Math.floor ( Math.random ( ) * s + 1) );
} 

function getNumber(n) {
	return "../v1/adm/web/"+num_user[n][rand(num_user[n].length)-1];
}

function getNumberNoLimit(n) {
	i = i+1;
	var numberUser = num[n][rand(num[n].length)-1]
	num_user[n].push(numberUser)
	//num[n].splice(num[n],1);
	return "../v1/adm/web/"+ numberUser;
}


function switchNumber(pos) {
	
	if(pos=="hours1") {
		document.getElementById(pos).src = getNumberNoLimit(h1);
	}
	if(pos=="hours2") {
		document.getElementById(pos).src = getNumberNoLimit(h2);
	}
	if(pos=="minutes1") {
		document.getElementById(pos).src = getNumberNoLimit(m1);
	}
	
	if(pos=="minutes2") {
		document.getElementById(pos).src = getNumberNoLimit(m2);
	}			
	if(pos=="seconds1") {
		document.getElementById(pos).src = getNumberNoLimit(s1);
	}
	if(pos=="seconds2") {
		document.getElementById(pos).src = getNumberNoLimit(s2);
	}					
						
	
}



//*********************************GETS LOCAL HOURS AND DIVIDE THE STRINGS ************************//
var timer;

function clock() {
		

	time = new Date()
	hours=time.getHours().toString()
	minutes=time.getMinutes().toString()
	seconds=time.getSeconds().toString()
	
	h1=hours.substring(0,1)
	h2=hours.substring(1,2)
	m1=minutes.substring(0,1)
	m2=minutes.substring(1,2)
	s1=seconds.substring(0,1)
	s2=seconds.substring(1,2)
	
	if(hours<10){
		h2=h1
		h1=0
	}
	
	if(minutes<10){
		m2=m1
		m1=0
	}
	
	if(seconds<10){
		s2=s1
		s1=0
	}
	
	document.sec2.src = getNumber(s2)
	if(parseInt(s2, 10) == 0){
		document.sec1.src = getNumber(s1)
		if(parseInt(s1, 10) == 0){
			document.min2.src = getNumber(m2)
			if(parseInt(m2, 10) == 0){
				document.min1.src = getNumber(m1)		
				if(parseInt(m1, 10) == 0){
					document.hours2.src = getNumber(h2)
					if(parseInt(h2, 10) == 0){
						document.hours1.src = getNumber(h1)
					}
				}
			}
		}
	}
	
	
	timer = setTimeout("clock()",1000)
}

function startClock(){
	toolbar=0;

	time = new Date()
	hours=time.getHours().toString()
	minutes=time.getMinutes().toString()
	seconds=time.getSeconds().toString()
	
	h1=hours.substring(0,1)
	h2=hours.substring(1,2)
	m1=minutes.substring(0,1)
	m2=minutes.substring(1,2)
	s1=seconds.substring(0,1)
	s2=seconds.substring(1,2)
	
	if(hours<10){
		h2=h1
		h1=0
	}
	
	if(minutes<10){
		m2=m1
		m1=0
	}
	
	if(seconds<10){
		s2=s1
		s1=0
	}
	
	
	document.sec2.src = getNumber(s2)
	document.sec2.src = getNumber(s2)
	document.sec1.src = getNumber(s1)
	document.min2.src = getNumber(m2)
	document.min1.src = getNumber(m1)		
	document.hours2.src = getNumber(h2)
	document.hours1.src = getNumber(h1)
	
	timer = setTimeout("clock()",1000)
}



//*********************************ROLLOVER MOUSEOVERS AND SWAP IMAGES ************************//


function newImage(src){ 
	return src.substring( 0, src.search(/(\.[a-z]+)/) ) + '_o' + src.match(/(\.[a-z]+)/)[0]; 
};
function oldImage(src){ 
	return src.replace(/_o/, '');
};
function onRollOver() { 
	if ($(this).hasClass("ro")){
	$(this).attr( 'src', newImage($(this).attr('src'))); 
	}
}
function onRollOut() { 
	if ($(this).hasClass("ro")){
	$(this).attr( 'src', oldImage($(this).attr('src')));
	}
};



