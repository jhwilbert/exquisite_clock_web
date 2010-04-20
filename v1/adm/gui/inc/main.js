	// -------------------------------------------------------
	// PopUp Unico Central
	function popupUC(pg,nome,w,h){//popUp Unico Central
		var x; 	var y;
		x = (screen.width-w)/2;	y = (screen.height-h)/2;
		window.open(pg,nome,'scrollbars=no,toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=no,width='+w+',height='+h+',left='+x+',top='+y+'');
	}

	// -------------------------------------------------------
	// Form validation
	function validaForm(f){
		for (i=0 ; i<f.length ; i++){        
			e = f.elements[i];
			str = e.title.split(";");
			//if (e.title=="Campo Obrigatório" && e.value == ""){
			if (str[1]=="Campo Obrigatório" && e.value == ""){
				alert("O campo "+str[0]+" deve ser preenchido");
				e.focus();
				return (false);
			} 
			e = null;
		}
		return(true);
	}
	
	// E-Mail validation
	function validaMail (emailId){
		var email = document.getElementById(emailId);
		if(email.value!=""){
			if (email.value.indexOf("@") <= 0 || email.value.indexOf(".") <= 0){
				alert("Invalid email format")
				email.focus()
				return (false);
			}
		}
		return (true);
	}

	// -------------------------------------------------------
	// confirm delete
	function delObj(page){
		//confirmation="Do you want to confirm the deletion";
		confirmation="Do you want to confirm the deletion?";
		if(confirm(confirmation)){
		window.location=page;
    	}
  	}

	// -------------------------------------------------------
	// clear a input value
  	function clearInput(id){
  		e = document.getElementById(id);
  		e.value = "";
  	}

	// -------------------------------------------------------
	function addElement(reciever, element) {
		var ni = document.getElementById(reciever);
		ni.appendChild(element);
	}
	
	function removeElement(reciever,toRem) {
		var ni = document.getElementById(reciever);
		ni.removeChild(toRem);
	}
	function removeAllNodes(objId){
			var obj = document.getElementById(objId);
			while(obj.hasChildNodes())
				obj.removeChild(obj.firstChild)
		
	}
	
	// -------------------------------------------------------
	// only days numbers according the month, controlled by the range min and max
    function onlyNumbers(evt) {
      var charCode = (evt.which) ? evt.which : evt.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        //alert("Please make sure entries are numbers only.")
        return false
      }
      return true
    }
    

	// -------------------------------------------------------
    //<!-- Show Hide Layers -->   
    function MM_findObj(n, d) { //v4.0
    var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
      d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
    if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
    for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
    if(!x && document.getElementById) x=document.getElementById(n); return x;
  }

  function MM_showHideLayers() { //v3.0
    var i,p,v,obj,args=MM_showHideLayers.arguments;
    for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
      if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
      obj.visibility=v; }
  }
	
	function showLayer(layer){
		MM_showHideLayers(layer,'','show');
	}
	function hideLayer(layer){
		MM_showHideLayers(layer,'','hide');
	}
  //<!-- Fim Show Hide Layers -->   
    
    // -------------------------------------------------------
    // only numbers
    function checkNumber(evt) {
      var charCode = (evt.which) ? evt.which : evt.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        //alert("Please make sure entries are numbers only.")
        return false
      }
      return true
    }

	// -------------------------------------------------------
	function validaCep(c,evt){
		if(checkNumber(evt)){
			if(c.value.length==5) c.value=c.value.slice(0,5)+"-"+c.value.slice(5,c.value.length);
			return true;
		}else{return false;}
	} 
		

