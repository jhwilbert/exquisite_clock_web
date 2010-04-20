	/**
	 * Retorna objeto de XMLHttpReuqest de acordo com o browser,
	 * ou retorna falso caso o browser nao suporte.
	 */
	function getXmlhttp(){
		try{
		    xmlhttp = new XMLHttpRequest();
		}catch(ee){
		    try{
		        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		    }catch(e){
		        try{
		            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		        }catch(E){
		            xmlhttp = false;
		        }
		    }
		}
		return xmlhttp;
	}


	function setContent(pg,div){
        var content = document.getElementById(div);
        content.innerHTML='loading...';
        
	    xmlhttp = getXmlhttp();
	    xmlhttp.open("GET", pg,true);
	
	    //Executada quando o navegador obtiver o codigo
	    xmlhttp.onreadystatechange=function() {
	
	        if (xmlhttp.readyState==4){
	
	            //Lê o texto
	            var texto=xmlhttp.responseText;
	
	            //Desfaz o urlencode
	            texto=texto.replace(/\+/g," ");
	            texto=unescape(texto);
	            //Exibe o texto no div conteúdo
	            content.innerHTML=texto;
	        }
	    }
	    xmlhttp.send(null)
	}

	function setContentInParent(pg,div){
        var content = parent.document.getElementById(div);
        content.innerHTML='loading...';
        
	    xmlhttp = getXmlhttp();
	    xmlhttp.open("GET", pg,true);
	
	    //Executada quando o navegador obtiver o codigo
	    xmlhttp.onreadystatechange=function() {
	
	        if (xmlhttp.readyState==4){
	
	            //Lê o texto
	            var texto=xmlhttp.responseText;
	
	            //Desfaz o urlencode
	            texto=texto.replace(/\+/g," ");
	            texto=unescape(texto);
	            //Exibe o texto no div conteúdo
	            content.innerHTML=texto;
	        }
	    }
	    xmlhttp.send(null)
	}
	