<?php
class FileResource {
	var $legend = "";
	/** dbTable of files */
	var $dbFilesTable 	= "files";
	/** dbTable of object related to files */
	var $dbTable; 	// from the object
	/** Id of Object related to files */
	var $id;		// from the object
	/** dbTable of relation object-files */
	var $dbRelFileTable;
	
	/** Indicates howmany files can be associated with. 1->One | 0->N  */
	var $fileN;

	/** ClassName that indicate for whom is the resource */
	var $className;
	
	/** The database object reference */
	var $DB;

	function FileResource(&$dbTable, &$id, $fileN) {
		global $DB;
		$this->dbTable = &$dbTable;
		$this->id = &$id;
		$this->dbRelFileTable = strtolower($this->dbTable).firstUpper($this->dbFilesTable);
		$this->fileN = $fileN;
		$className = "FileResource :: ".$this->dbRelFileTable;
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
	 * Set the a list of files given the form list files
	 * @param Array $filesForm Array with $_FILES[name] object
	 * @param String $path Path in 'files' folder to store the file
	 * @return Array of MyFile seted accorded form files. Array $fileList
	 */
	function setFromForm($filesForm,$path){
		$n =  count($filesForm["name"]);
		$fileList = array();

		for ($i = 0; $i < $n; $i++) {
			 $fileArray = array();
			if($filesForm["name"][$i] != ""){
				$fileArray["name"]	 	= $filesForm["name"][$i];
				$fileArray["size"]	 	= $filesForm["size"][$i];
				$fileArray["tmp_name"]	= $filesForm["tmp_name"][$i];
				$fileArray["type"]	 	= $filesForm["type"][$i];
				$fileArray["error"]	 	= $filesForm["error"][$i];

				$file = new MyFile();
				$file->superFromFile($fileArray);
				$file->setFilePath($path);
				$file->setName($fileArray["name"]);
				$file->setLegend($legend);
				
				$fileList[] = $file;
			}
		}
		return $fileList;
	}
	
	/** 
	 * Set a list of files.
	 * Store each file in data base and store the relation in the relation table.
	 * @param Array $fileList Array of MyFile
	 */
	function setFiles($fileList){
		if(!$this->checkId()) return false;
		if($this->fileN == 1 && count($fileList)>0){
			$this->delAllFiles();
		}

		for ($i = 0; $i < sizeof($fileList); $i++) {
			$n = $fileList[$i];
			$n->superStore();
			$strSQL = "" .
				"INSERT INTO ".$this->dbRelFileTable." " .
				"(".$this->dbTable.",".$this->dbFilesTable.") " .
				"VALUES (" . 
					"".$this->id.",".
					"".$n->id."".
				")";
			$this->id = $this->DB->exe("".$this->className." :: setFiles()",$strSQL);
		}

		return true;
	}
	
	/**
	 * Get the list of files related with the class.
	 * @return Array A list of MyFile objecs.
	 */
	function getFiles(){
		if(!$this->checkId()) return array();
		$strSQL = "" .
				"SELECT t2.* " .
				"FROM ".$this->dbRelFileTable." t1, ".$this->dbFilesTable." t2 " .
				"WHERE 1=1 " .
				"AND t1.".$this->dbTable." = ".$this->getId()." " .
				"AND t1.".$this->dbFilesTable." = t2.id " .
				"";
		$result = $this->DB->getObj("".$this->className." :: function getFiles()",$strSQL);
		$files = array();
		$file  = new MyFile();
		while ($row = mysql_fetch_array($result)) {
			$file  = new MyFile();
			$file->loadRow($row);
			$files[] = $file;
		}
		return $files;
	}

	/**
	 * Delete all files
	 */
	function delAllFiles(){
		if(!$this->checkId()) return false;
		// Delete files objects
		$strSQL = "" .
				"SELECT t1.".$this->dbFilesTable." AS fileId " .
				"FROM ".$this->dbRelFileTable." t1 " .
				"WHERE 1=1 " .
				"AND t1.".$this->dbTable." = ".$this->getId()." " .
				"";
		$result = $this->DB->getObj("".$this->className." :: Delete files objects :: function delAllFiles()",$strSQL);
		$file  = new MyFIle();
		while ($row = mysql_fetch_array($result)) {
			$file->superDel($row["fileId"]);
		}

		// Delete relation
		$strSQL = "" .
				"DELETE " .
				"FROM ".$this->dbRelFileTable." " .
				"WHERE 1=1 " .
				"AND ".$this->dbTable." = ".$this->getId()." " .
				"";
		$result = $this->DB->getObj("".$this->className." :: Delete relation :: function delAllFiles()",$strSQL);
		return true;
	}

	/**
	 * Delete one image
	 */
	function delOneFile($fileId){
		if(!$this->checkId()) return false;
		// Check if the image is related to 
		$strSQL = "" .
				"SELECT t1.".$this->dbFilesTable." AS fileId " .
				"FROM ".$this->dbRelFileTable." t1 " .
				"WHERE 1=1 " .
				"AND t1.".$this->dbTable." = ".$this->getId()." " .
				"AND t1.".$this->dbFilesTable." = ".$fileId." " .
				"";
		$result = $this->DB->getObj("".$this->className." :: Check the relation :: function delOneImage($fileId)",$strSQL);
		if (mysql_affected_rows()>0) {
			$file = new MyFile();
			$file->superDel($fileId);
			// Delete relation
			$strSQL = "" .
					"DELETE " .
					"FROM ".$this->dbRelFileTable." " .
					"WHERE 1=1 " .
					"AND ".$this->dbTable." = ".$this->getId()." " .
					"AND ".$this->dbFilesTable." = ".$fileId." " .
					"";
			$result = $this->DB->getObj("".$this->className." :: Delete relation :: function delOneFile($fileId)",$strSQL);
		}
		return true;
	}

	/* *************** Install functions *************** */
	function install(){
		global $DB; 
		$strSQL = "CREATE TABLE IF NOT EXISTS ".$this->dbRelFileTable." ( " . 
			"".$this->dbTable." int unsigned NOT NULL," . 
			"".$this->dbFilesTable." int unsigned NOT NULL" . 
		") TYPE=MyISAM;";
		$DB->exe("".$this->className." :: function install()",$strSQL); 
	} 
}
?>
