	function viewImg(img,id,w,h){
		popupUC('view_img.php?img='+img,'img'+id,w,h);
	}
	function del(id,sub){
		delObj('del.php?id='+id+'&sub='+sub);
	}
	function delImg(id){
		delObj('del_img.php?id='+id);
	}
	