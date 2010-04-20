<?php
/**
 * Define the MyImage class that extends the super class MyFile
 * Require the MyFile class
 * Require the HTML functions.
 * Require the $serverFilesRoot variable.
 * Require the DataBase class.
 * Require the MakeThumb function.
 */
class MyImage extends MyFile{
	/** Width of the image in pixels (px). <br>DataBase type: int. */
	var $width;
	/** Height of the image in pixels (px). <br>DataBase type: int .*/
	var $height;
	/** Align ('left', 'right') of the image. <br>DataBase type: varchar(255). */
	var $align;
	/** Alt - mensage to show with image. <br>DataBase type: varchar(255). */
	var $alt;
	
	
	/** Pattern constructor */
	function MyImage (){
		parent::MyFile();
		$this->width	= 0;
		$this->height	= 0;
		$this->align	= "left";
		$this->alt		= "";
		$this->allowType = Array(".jpg",".png");
	}
	
	/* ****************** SETTERS ****************** */
	function setWidth($var){
		$this->width = $var;
	}
	function setHeight($var){
		$this->height = $var;
	}
	function setAlign($var){
		$this->align = $var;
	}
	function setAlt($var){
		$this->alt = toHtmlEnt($var);
	}

	/* ****************** SETTERS ****************** */
	function getWidth(){
		return $this->width;
	}
	function getHeight(){
		return $this->height;
	}
	function getAlign(){
		return $this->align;
	}
	function getAlt(){
		return $this->alt;
	}

	/* ****************** THUMB FUNCTIONS ****************** */
	/** Return the thumbnail file name */
	 function thumbName(){
	 	return $this->getFilePath()."thumb_".$this->getFileName().$this->getFileExt();
	 }
	
	function mobileName(){
	 	return $this->getFilePath()."mobile_".$this->getFileName().$this->getFileExt();
	 }

	function webName(){
	 	return $this->getFilePath().$this->getFileName().$this->getFileExt();
	 }
	 
	 function instName(){
	 	return $this->getFilePath().$this->getFileName().$this->getFileExt();
	 }
	 function instRotatedName(){
	 	return $this->getFilePath().$this->getFileName().$this->getFileExt();
	 }
	/**
	 * Make the thumb of the image.
	 */
	function mkThumb($w){
		global $serverFilesRoot;
		$from 	= $serverFilesRoot.$this->completePath();
		$to 	= $serverFilesRoot.$this->thumbName();
		makeThumbnail($from,$to,$w,85);
	}
	
	/**
	 * Make the iphone version of the image.
	 */

	function mkMobileImg(){
		global $serverFilesRoot;
		global $mobileFilesRoot;
		$from 	= $serverFilesRoot.$this->completePath();
		$to 	= $mobileFilesRoot.$this->mobileName();
		makeThumbnail($from,$to,150,85);
	}

	/**
	 * Make the web version of the image.
	 */
	 
	function mkWebImg(){
		global $serverFilesRoot;
		global $webFilesRoot;
		$from 	= $serverFilesRoot.$this->completePath();
		$to 	= $webFilesRoot.$this->webName();
		makeThumbnail($from,$to,340,85);
	}	
	
	function mkInstallationImg(){

		global $serverFilesRoot;
		global $instFilesRoot;
		$from 	= $serverFilesRoot.$this->completePath();
		$to 	= $instFilesRoot.$this->instName();
		makeThumbnail($from,$to,480,100);
	}	
	
		function mkInstallationRotatedImg(){

		global $serverFilesRoot;
		global $instRotatedFilesRoot;
		$from 	= $serverFilesRoot.$this->completePath();
		$to 	= $instRotatedFilesRoot.$this->instRotatedName();
		makeRotation($from,$to);
	}	
	
	/* ****************** FUNCTIONS ****************** */
	/** 
	 * Set the image using the file variabel from form. 
   	 * Using the superFromFile, set the name, tmp_name, type (file extension), size.
	 * And hits function ser the width and height of the image
	 * @param file The file object from the HTML form
	 */
	function fromFile($file){
		parent::superFromFile($file);
		
		if(!$this->restrictType($this->allowType)){
			$info = getimagesize($file["tmp_name"]);
	
			$this->setWidth($info[0]);
			$this->setHeight($info[1]);
		}
	}
	
	/**
	 * Restrict the image dimension given the width, height and operator (<,>,=).
	 * Operator < means taht the image must be less than the given params, including them.
	 * Operator > means taht the image must be more than the given params, including them.
	 * Operator = means taht the image must be exatly the same given params.
	 * If one of the width or heigt are omited, this menas its not a restriction. 
	 * If the operator is omited, will be used the operator = as default
	 * @param w The width to restrict the image
	 * @param h The height to restrict the image
	 * @param op Operator to be used in restriction
	 * @return Boolean Return FALSE if the dimension respects the restriction, otherwise return TRUE 
	 */
	 function restrictDimension($w,$h,$op){
	 	switch ($op){
			case ">":
				if($w!="" && $w<$this->getWidth())  return true;
				if($h!="" && $h<$this->getHeight()) return true;
				break;
			case "<":
				if($w!="" && $w>$this->getWidth())  return true;
				if($h!="" && $h>$this->getHeight()) return true;
				break;
			default:
				if($w!="" && $w!=$this->getWidth())  return true;
				if($h!="" && $h!=$this->getHeight()) return true;
				break;
		}
		return false;
	 }
	 
	  function restrictProportion($prop) {
	 	$proportion = $this->getHeight() / $this->getWidth();
	 	if($this->getWidth() > '319' && $this->getHeight() > '479' && $this->getWidth() < '1001' && $this->getHeight() < '1501' && $proportion =='1.5') {
	 		//echo 'correct proportion and size'.$proportion;
	 		return false;
	 	} else  {
	 		//echo "out of proportion";
	 		return true;
	 	}
	 }
	 
	/* ****************** DATABASE FUNCTIONS ****************** */
	/**
	 * Set the file given a database row result
	 * @param row from the function mysql_fetch_array
	 */
	function setFromRow($row){
		$this->superLoad($row["id"]);
	
		$this->setWidth($row["width"]);
		$this->setHeight($row["height"]);
		$this->setAlign($row["align"]);
		$this->setAlt($row["alt"]);
	}

	/** 
	 * Load a element based in its ID in database
	 * @param id of element
	 */
	function load($id){
		if($id!=0){
			$strSQL = "SELECT * FROM images WHERE 1=1 AND id=$id";
			$result = $this->DB->getObj("MyImage :: function load($id)",$strSQL);
			$row	= mysql_fetch_array($result);
			$this->setFromRow($row);
		}
	}

	/** 
	 * Load all elements stored in the database
	 * @return An array with all elements restored
	 */
	function loadAll($orderBy){
		if($orderBy=="") $orderBy = "id DESC";
		$strSQL = "SELECT * FROM images WHERE 1=1 ORDER BY $orderBy";
		$result = $this->DB->getObj("MyImage :: function loadAll($orderBy)",$strSQL);
			
		$all = Array();
		$i	 = 0;
		while ($row=mysql_fetch_array($result)){
		$all[$i] = new myImage();
		$all[$i]->setFromRow($row);
		$i++;
		}
		return $all;
	}
	
	/* ------------------ STORE/UPDATE FUNCTIONS ------------------ */
	function store(){
		if($this->getId()==0){
			$this->storeObj();
		}else{
			$this->updateObj();
		}
	}
	
	/**
	 * Store an object in database. 
	 * It depends of myFile superStore function.
	 */
	function storeObj(){
		$this->superStore();
		$strSQL = "" .
				"INSERT INTO images " .
				"(id, width, height, align, alt) " .
				"VALUES (" .
					"".$this->getId().", " .
					"".$this->getWidth().", " .
					"".$this->getHeight().", " .
					"'".$this->getAlign()."'," .
					"'".$this->getAlt()."')";
		$this->id = $this->DB->exe("MyImage :: function storeObj()",$strSQL);
	}
	
	/**
	 * Update a image element in database given the image id. 
	 * It depends of myFile superUpdate function.
	 */
	function updateObj(){
		$this->superUpdate();
		$strSQL = "" .
				"UPDATE images" .
				"SET " .
					"width    = ".$this->getWidth().", " .
					"height   = ".$this->getHeight()."," .
					"align    = '".$this->getAlign()."', " .
					"alt      = '".$this->getAlt()."' " .
				"WHERE id = ".$this->getId()." " .
				"";
		$this->DB->exe("MyImage :: function updateObj()",$strSQL);
	}
	/* ------------------ // ------------------ */
	
	/** Delete from database */
	function del($id){
		global $serverFilesRoot, $mobileFilesRoot, $webFilesRoot, $instFilesRoot,$instRotatedFilesRoot, $DB;
		if($id!=0){
			
			$tmpImg = new MyImage();
			
			$tmpImg->load($id);
			
			$imgLink = $serverFilesRoot.$tmpImg->thumbName();
			$imgLink1 = $mobileFilesRoot.$tmpImg->mobileName();
			$imgLink2 = $webFilesRoot.$tmpImg->webName();
			$imgLink3 = $instFilesRoot.$tmpImg->instName();
			$imgLink4 = $instRotatedFilesRoot.$tmpImg->instRotatedName();
				
			if(is_file($imgLink))
				unlink($imgLink);
				
			if(is_file($imgLink1))
				unlink($imgLink1);
				
			if(is_file($imgLink2))
				unlink($imgLink2);
				
			if(is_file($imgLink3))
				unlink($imgLink3);
							
			if(is_file($imgLink4))
				unlink($imgLink4);	
				
			$strSQL = "DELETE FROM images WHERE id = $id";
			$DB->exe("MyImage :: funciton del($id)", $strSQL);
			parent::superDel($id);
		}
	}

	/* ****************** ISNTALL FUNCTIONS ****************** */
	/** Create the table in the database */
	function install(){
		$strSQL = "" .
				"CREATE TABLE IF NOT EXISTS images (" .
					"id     int unsigned NOT NULL auto_increment," .
					"width  int unsigned NOT NULL DEFAULT 0," .
					"height int unsigned NOT NULL DEFAULT 0," .
					"align  varchar(255) NOT NULL DEFAULT 'left'," .
					"alt    varchar(255) NOT NULL DEFAULT ''," .
					"PRIMARY KEY  (id)," .
					"UNIQUE KEY id (id)" .
				") TYPE=MyISAM;";
		
  		$this->DB->exe("MyImage :: function install()",$strSQL);
	}
}

?>