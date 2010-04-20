<?php
class ImageResource {
	
	/** dbTable of images */
	var $dbImagesTable 	= "images";
	/** dbTable of object related to images */
	var $dbTable; 	// from the object
	/** Id of Object related to images */
	var $id;		// from the object
	/** dbTable of relation object-images */
	var $dbRelImgTable;
	
	/** Indicates howmany images can be associated with. 1->One | 0->N  */
	var $imgN;

	/** ClassName that indicate ofr whom is the resource */
	var $className;
	
	/** The database object reference */
	var $DB;

	function ImageResource(&$dbTable, &$id, $imgN) {
		global $DB;
		$this->dbTable = &$dbTable;
		$this->id = &$id;
		$this->dbRelImgTable = strtolower($this->dbTable).firstUpper($this->dbImagesTable);
		$this->imgN = $imgN;
		$className = "ImageResource :: ".$this->dbRelImgTable;
		$this->DB = $DB;
	}
  
	/* *************** Image functions *************** */
	/** Check if there is a valid Id to execute the operations */
	function checkId(){
		if($this->id > 0)
			return true;
		else
			return false;
	}
	
	/** Return the object Id */
	function getId(){
		return $this->id;
	}
	/**
	 * Set the a list of images given the form list files
	 * @param Array $filesForm Array with $_FILES[name] object
	 * @param String $path Path in 'files' folder to store the image
	 * @return Array of MyImage seted accorded form files. Array $imgList
	 */
	function setFromForm($filesForm,$path){
		$n =  count($filesForm["name"]);
		$imgList = array();

		for ($i = 0; $i < $n; $i++) {
			 $imgArray = array();
			if($filesForm["name"][$i] != ""){
				$imgArray["name"]	 = $filesForm["name"][$i];
				$imgArray["size"]	 = $filesForm["size"][$i];
				$imgArray["tmp_name"]	 = $filesForm["tmp_name"][$i];
				$imgArray["type"]	 = $filesForm["type"][$i];
				$imgArray["error"]	 = $filesForm["error"][$i];

				$img = new MyImage();
				$img->fromFile($imgArray);
				$img->setFilePath($path);
				$img->setName($imgArray["name"]);
				$img->setAlt($imgArray["name"]);
				
				$imgList[] = $img;
			}
		}
		return $imgList;
	}
	
	/** 
	 * Set a list of images.
	 * Store each image in data base and store the relation in the relation table.
	 * @param Array $imgList Array of MyImage
	 * @param Int $thumbW Width of thumbnail. If it is zero, there is no thumbnail
	 */
	function setImages($imgList, $thumbW){
		if(!$this->checkId()) return false;
		if($this->imgN == 1 && count($imgList)>0){
			$this->delAllImages();
		}

		for ($i = 0; $i < sizeof($imgList); $i++) {
			$n = $imgList[$i];
			$n->store();
			$strSQL = "" .
				"INSERT INTO ".$this->dbRelImgTable." " .
				"(".$this->dbTable.",".$this->dbImagesTable.") " .
				"VALUES (" . 
					"".$this->id.",".
					"".$n->id."".
				")";
			$this->id = $this->DB->exe("".$this->className." :: setImg()",$strSQL);
			if($thumbW>0){ 
				
				$n->mkThumb($thumbW); 
				$n->mkMobileImg(); 
				$n->mkWebImg(); 
				$n->mkInstallationImg(); 
				$n->mkInstallationRotatedImg();
				} 
		}

		return true;
	}
	

	
	/**
	 * Get the list of images related with the class.
	 * @return Array A list of MyImage objecs.
	 */
	function getImages(){
		if(!$this->checkId()) return array();
		$strSQL = "" .
				"SELECT t2.* " .
				"FROM ".$this->dbRelImgTable." t1, ".$this->dbImagesTable." t2 " .
				"WHERE 1=1 " .
				"AND t1.".$this->dbTable." = ".$this->getId()." " .
				"AND t1.".$this->dbImagesTable." = t2.id " .
				"";
		$result = $this->DB->getObj("".$this->className." :: function getImages()",$strSQL);
		$imgs = array();
		$img  = new MyImage();
		while ($row = mysql_fetch_array($result)) {
			$img  = new MyImage();
			$img->setFromRow($row);
			$imgs[] = $img;
		}
		return $imgs;
	}

	/**
	 * Delete all images
	 */
	function delAllImages(){
		if(!$this->checkId()) return false;
		// Delete images objects
		$strSQL = "" .
				"SELECT t1.".$this->dbImagesTable." AS imgId " .
				"FROM ".$this->dbRelImgTable." t1 " .
				"WHERE 1=1 " .
				"AND t1.".$this->dbTable." = ".$this->getId()." " .
				"";
		$result = $this->DB->getObj("".$this->className." :: Delete images objects :: function delAllImages()",$strSQL);
		$img  = new MyImage();
		while ($row = mysql_fetch_array($result)) {
			$img->del($row["imgId"]);
		}

		// Delete relation
		$strSQL = "" .
				"DELETE " .
				"FROM ".$this->dbRelImgTable." " .
				"WHERE 1=1 " .
				"AND ".$this->dbTable." = ".$this->getId()." " .
				"";
		$result = $this->DB->getObj("".$this->className." :: Delete relation :: function delAllImages()",$strSQL);
		return true;
	}

	/**
	 * Delete one image
	 */
	function delOneImage($imgId){
		if(!$this->checkId()) return false;
		// Check if the image is related to 
		$strSQL = "" .
				"SELECT t1.".$this->dbImagesTable." AS imgId " .
				"FROM ".$this->dbRelImgTable." t1 " .
				"WHERE 1=1 " .
				"AND t1.".$this->dbTable." = ".$this->getId()." " .
				"AND t1.".$this->dbImagesTable." = ".$imgId." " .
				"";
		$result = $this->DB->getObj("".$this->className." :: Check the relation :: function delOneImage($imgId)",$strSQL);
		if (mysql_affected_rows()>0) {
			$img = new MyImage();
			$img->del($imgId);
			// Delete relation
			$strSQL = "" .
					"DELETE " .
					"FROM ".$this->dbRelImgTable." " .
					"WHERE 1=1 " .
					"AND ".$this->dbTable." = ".$this->getId()." " .
					"AND ".$this->dbImagesTable." = ".$imgId." " .
					"";
			$result = $this->DB->getObj("".$this->className." :: Delete relation :: function delOneImage($imgId)",$strSQL);
		}
		return true;
	}

	/* *************** Install functions *************** */
	function install(){
		global $DB; 
		$strSQL = "CREATE TABLE IF NOT EXISTS ".$this->dbRelImgTable." ( " . 
			"".$this->dbTable." int unsigned NOT NULL," . 
			"".$this->dbImagesTable." int unsigned NOT NULL" . 
		") TYPE=MyISAM;";
		$DB->exe("".$this->className." :: function install()",$strSQL); 
	} 
}
?>
