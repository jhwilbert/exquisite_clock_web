	function delUser(id){
		delObj('del.php?id='+id);
	}


	function validaFormUser(f){
		if(!validaForm(f)) return false;
		if(!validaMail(f.email)) return false;

		var pw = document.getElementById('pw');
		if(pw!=null){
			var pwcf = document.getElementById('pwcf');
			if(pw.value != pwcf.value){
				alert("Confirmação da senha não confere.");
				pw.value 	= ""
				pwcf.value = ""
				pw.focus();
				return false;
			}
		}

		var altpw = document.getElementById('altpw');
		if(altpw!=null){
			var altpwcf = document.getElementById('altpwcf');
			if(altpw.value != altpwcf.value){
				alert("Confirmação da senha não confere.");
				altpw.value 	= ""
				altpwcf.value = ""
				altpw.focus();
				return false;
			}
		}

		return true; 
	}
