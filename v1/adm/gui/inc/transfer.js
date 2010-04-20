	function transfer(s,r){
		sender 		= document.getElementById(s);
		reciever 	= document.getElementById(r);
		for(i=sender.length-1;i>=0;i--)
			if(sender[i].selected){
				reciever[reciever.length] = new Option(sender[i].text,sender[i].value);
				sender.remove(i);
			}
	}
	
	function setTranferValues(s,v){
		sender 		= document.getElementById(s);
		values 		= document.getElementById(v);
		transferSort(s);
		values.value="";
		if(sender[0]!=null){
			values.value+=sender[0].value;
			for(i=1;i<sender.length;i++)
				values.value+=","+sender[i].value;
		}
	}
		
	function transferSort(s){
		t = document.getElementById(s);
		a = new Array(reciever.length);
		for(i=reciever.length-1;i>=0;i--){
			a[i]= new Array(reciever[i].text,reciever[i].value);
			reciever.remove(i);
		}
		a.sort();
		for(i=0;i<a.length;i++){
			reciever[i] = new Option(a[i][0],a[i][1]);
		}
	}
