<?php
/**
 * Define the MyFile class.
 * Require the HTML functions.
 * Require the $serverFilesRoot variable.
 * Require the DataBase class.
 */
class MyFile {
	/** File database ID - reference in database. <br>DataBase type: int.*/
	var $id;

	/** Binary file name, given by user`s machine. <br>DataBase type: varchar(255). */
	var $fileName;
	/** Binary file extension. Define the file type. <br>DataBase type: varchar(255). */
	var $fileExt;
	/** File size in bytes. <br>DataBase type: int. */
	var $size;
	/** Temporary file name in server. <br>DataBase type: varchar(255). */
	var $tmpName;
	/** Binary file path e.g. 'files/dir/'. This is page relative. <br>DataBase type: varchar(255). */
	var $filePath;

	/** File friendly name given by user. <br>DataBase type: varchar(255). */
	var $name;
	/** A short description about the file. <br>DataBase type: varchar(255). */
	var $legend;
	
	/** Indicates what types are allowed */
	var $allowType;
	
	/** Reference to database object */
	var $DB;

	/** Pattern contructor */
	function MyFile (){
		global $DB;
		$this->fileName = "";
		$this->fileExt	= "";
		$this->size 		= "";
		$this->tmpName	= "";
		$this->filePath	= "";
		$this->id 				= 0;
		$this->name 			= "";
		$this->legend 		= "";
		$this->allowType 	= Array();
		
		$this->DB = $DB;
	}

	/* ****************** SETTERS ****************** */
	function setFileName ($var){
		if($var=="")
			$this->fileName = $this->uniqueName();
		else
			$this->fileName = $var;
	}
	function setFileExt ($var){
		$this->fileExt = $var;
	}
	function setSize ($var){
		$this->size = $var;
	}
	function setTmpName ($var){
		$this->tmpName = $var;
	}
	function setFilePath ($var){
		if((strrpos($var,"/")+1)!=strlen($var)) 
			if($var!="") $var = $var."/";
		$this->filePath = $var;
	}
	
	function setId ($var){
		$this->id = $var;
	}
	function setName ($var){
		$this->name = toHtmlEnt($var);
	}
	function setLegend ($var){
		$this->legend = toHtmlEnt($var);
	}
	function setAllowType($var){
		$this->allowType = $var;
	}

	/* ****************** GETTERS ****************** */
	function getFileName (){
		return $this->fileName;
	}
	function getFileExt (){
		return $this->fileExt;
	}
	function getSize (){
		return $this->size;
	}
	function getTmpName (){
		return $this->tmpName;
	}
	function getFilePath (){
		return $this->filePath;
	}
	
	function getId (){
		return $this->id;
	}
	function getName (){
		return $this->name;
	}
	function getLegend (){
		return $this->legend;
	}
	
	 /**
	  * Tells what files type are allowed as images.
	  * @return Array List of extensions indicating the allowed files. 
	  */
	 function allowType(){
	 	return $this->allowType;
	 }
	
	/* ****************** FUNCTIONS ****************** */

   /** Return the complete file path starting at file->path. */
	 function completePath(){
	 	return $this->getFilePath().$this->getFileName().$this->getFileExt();
	 }
	 
	 function completePath2(){
	 	return $this->getFileName().$this->getFileExt();
	 }
	/**
	 * Copy the binary file from tmp folder to the file seted complete path
	 */
	function copyFile(){
		global $serverFilesRoot;
		$tmpName  = $this->getTmpName();
		$fileName = $this->completePath();
		$filePath = $this->getFilePath();
		if(!is_dir($serverFilesRoot.$filePath)){
			echo "criando .. ".$serverFilesRoot.$filePath;
			mkdir($serverFilesRoot.$filePath);
		}
		if($tmpName!=""&&$tmpName!="none"){
			return copy($tmpName, $serverFilesRoot.$fileName);
    }
		//chmod($serverFilesRoot.$filePath,0660);
		return false;
  }

	/**
	 * Set the name, tmp_name, type (file extension), size.
	 * @param file The file object from the HTML form
	 */
	function superFromFile($file){
		//$this->setFileName(strtolower($file["name"]));
		$this->setFileName("");
		$typeTmp = strtolower(substr($file["name"],strrpos($file["name"],".")));
		$this->setFileExt($typeTmp);
		$this->setSize($file["size"]);
		$this->setTmpName($file["tmp_name"]);
	}

	/**
	 * Restrict the file by the type, given the extension file. No case sensitive
	 * @param Array with all extension allowed, must be '.ext' - the dot '.' must be used.
	 * @return Boolean Return TRUE if the file extension is not allowed, otherwise return false.
	 */
	function restrictType($arrayAllow){
		for($i=0;$i<count($arrayAllow);$i++){
			if(strcasecmp($this->getFileExt(),$arrayAllow[$i])==0) return false;
		}
		return true;
	}
		
	/**
	 * Restric the file given the file size in bytes and the operator
	 * Operator < means taht the file must be less than the given size, including it.
	 * Operator > means taht the file must be more than the given size, including it.
	 * Operator = means taht the file must be exatly the same given size.
	 * If the size is omited then tehre is no restriction
	 * If the operator is omited, will be used the operator = as default
	 * @param sizeR Size to be use in restriction
	 * @param op Operator to be used in restriction
	 * @return Boolean Return FALSE if the file size respects the given sizeR, otherwize return TRUE
	 */
	function restrictSize($sizeR,$op){
		switch ($op){
			case ">":
				if($sizeR!="" && $sizeR>$this->getSize()) return false;
				break;
			case "<":
				if($sizeR!="" && $sizeR<$this->getSize()) return false;
				break;
			default:
				if($sizeR!="" && $sizeR>$this->getSize()) return false;
				break;
		}
		return true;
	}
	
	/**
	 * Generate a unique file name without extension.
	 * It should delete the temporary file created in root folder.
	 * @return File name generated
	 */
	
	function uniqueName(){
		
		global $serverFilesRoot;
		$random = (rand()%9);
		$random1 = (rand()%9);
		$random2 = (rand()%9);
		$random3 = (rand()%9);
		$random4 = (rand()%9);
		
		$tmpfname = tempnam($serverFilesRoot, $random.$random1.$random2.$random3.$random4."arq");
		$tmpName = basename($tmpfname,".tmp");
		if(is_file($tmpfname)) unlink($tmpfname);
		return $tmpName;
	}

	/* ****************** DATABASE FUNCTIONS ****************** */
	/**
	 * Load the data from a given row with recovered data from database.
	 */
	function loadRow($row){
		$this->setId($row["id"]);
		$this->setName($row["name"]);
		$this->setLegend($row["legend"]);
		$this->setFileName($row["fileName"]);
		$this->setFileExt($row["fileExt"]);
		$this->setSize($row["size"]);
		$this->setFilePath($row["filePath"]);
	}
	
	/** 
	 * Load a element based in its ID in database.
	 * @param id of element
	 */
	function superLoad($id){
		if($id!=0){
			$strSQL = "SELECT * FROM files WHERE 1=1 AND id = ".$id;
			$result = $this->DB->getObj("MyFile :: function superLoad($id)",$strSQL);
			$rowF = mysql_fetch_array($result);
			$this->loadRow($rowF);
		}
	}

	/* ------------------ STORE/UPDATE FUNCTIONS ------------------ */
	/**
	 * Choose store function if the id=0,
	 * else choose the update function 
	 */
	function superStore(){
		if($this->id==0){
			$this->superStoreObj();
		}else{
			$this->superUpdateObj();
		}
	}
	
	/** Store a new object */
	function superStoreObj(){
		$this->copyFile();
		$strSQL = "" .
				"INSERT INTO files " .
				"(fileName, fileExt, size, filePath, name, legend, incDate) " .
				"VALUES (" .
					"'".$this->getFileName()."'," .
					"'".$this->getFileExt()."'," .
					"".$this->getSize()."," .
					"'".$this->getFilePath()."'," .
					"'".$this->getName()."'," .
					"'".$this->getLegend()."'," .
					"'".time()."" .
				"')";
		$this->id = $this->DB->exe("MyFile :: function superStoreObj()",$strSQL);
	}
	
	/** Update an object */
	function superUpdateObj(){
		$strSQL = "" .
				"UPDATE files " .
				"SET " .
					"fileName = '".$this->getFileName()."', " .
					"fileExt  = '".$this->getFileExt()."'," .
					"size      =  ".$this->getSize()."," .
					"filePath = '".$this->getFilePath()."'," .
					"name      = '".$this->getName()."'," .
					"legend    = '".$this->getLegend()."' " .
				"WHERE id  = ".$this->getId()." " .
				"";
		$this->DB->exe("MyFile :: function superUpdateObj()",$strSQL);
	}
	/* ------------------ // ------------------ */

	
	/** Delete from database and delete the file. */
	function superDel($id){
		global $serverFilesRoot, $DB;
		if($id!=0){
			$tmpFile = new MyFile();
			$tmpFile->superLoad($id);
			
			$fileLink = $serverFilesRoot.$tmpFile->completePath();
			
			
			if(is_file($fileLink))
				unlink($fileLink);
			
			$strSQL = "DELETE FROM files WHERE id = $id";
	  		$DB->exe("MyFile :: function superDel($id)", $strSQL);
		}
	}

	/* ****************** ISNTALL FUNCTIONS ****************** */
	/** Create the table in the database */
	function superInstall(){
		$strSQL = "" .
				"CREATE TABLE IF NOT EXISTS files (" .
					"id       int unsigned NOT NULL auto_increment," .
					"fileName varchar(255) NOT NULL DEFAULT ''," .
					"fileExt  varchar(255) NOT NULL DEFAULT ''," .
					"size     int NOT NULL DEFAULT 0," .
					"tmpname  varchar(255) NOT NULL DEFAULT ''," .
					"filePath varchar(255) NOT NULL DEFAULT ''," .
					"name     varchar(255) NOT NULL DEFAULT ''," .
					"legend   varchar(255) NOT NULL DEFAULT ''," .
					"incDate int(32) unsigned DEFAULT 0," .
					"PRIMARY KEY  (id)," .
					"UNIQUE KEY id (id)" .
				") TYPE=MyISAM;";
		
  		$this->DB->exe("MyFile :: function superInstall()",$strSQL);
	}
}
?>