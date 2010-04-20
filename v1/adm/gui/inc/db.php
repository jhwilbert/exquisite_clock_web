<?php
/**
 * Describes the DataBase functions
 */
class DB{
	
	/** Name of the data base */
	var $db;
	/** The data base path */
	var $path;
	/** The data base user */
	var $usr;
	/** The data base password */
	var $psw;
	/** DataBase connection */
	var $conn;
	
	function DB(){
		global 	$admDB;
		$this->db 	= $admDB["dbName"];
		$this->path = $admDB["dbPath"];
		$this->usr 	= $admDB["dbUsr"];
		$this->psw 	= $admDB["dbPsw"];
		$this->conn	= "";
	}
	
	/** Connect to the given data base. */
	function connect(){
		$this->conn = mysql_connect($this->path,$this->usr,$this->psw)
			or die($this->DBHandleError("BD :: connect()","mysql_connect",mysql_error()));
		mysql_select_db($this->db)
			or die($this->DBHandleError("BD :: connect()","mysql_select_db",mysql_error()));
	}
	/** Close the opened data base connection. */
	function close(){
		mysql_close($this->conn);
	}
	
	
	/** 
	 * Gert a object recorered from the DataBase.
	 * Use it to SELECT operations.
	 * @param String who Information about who is asking for the data base operation
	 * @param String strSQL The query to be executed
	 * @return Resource MySQL query resource
	 */
	function getObj($who, $strSQL){
		DB::connect();
		$result = mysql_query($strSQL,$this->conn)
			or die($this->DBHandleError($who,$strSQL,mysql_error()));
		$this->close();
		return $result;
	}
	
	/**
	 * Execute a data base command.
	 * Use it to UPDATE, INSERT and DELETE operations
	 * @param String who Information about who is asking for the data base operation
	 * @param String strSQL The query to be executed
	 */
	function exe($who, $strSQL){
		DB::connect();
		$result = mysql_query($strSQL,$this->conn)
			or die($this->DBHandleError($who,$strSQL,mysql_error()));
		$id = mysql_insert_id($this->conn);
		$this->close();
		if(!$result) $this->DBHandleError($who,$strSQL,mysql_error());
		return $id;
	}
	
	/**
	 * Hnadle the DataBase error.
	 * @param String who Indicate where is the database call.
	 * @param String strSQL	The query string.
	 * @param String msg The database error message.
	 */
	function DBHandleError($who, $strSQL, $msg){
		global $reportMail, $owner;
		$dateTime = date("d/m/Y, H:i:s",time());
		$str = "" .
				"<b>Who: </b>$who<br>" .
				"<b>strSQL: </b>$strSQL<br>" .
				"<b>Time: </b>".$dateTime."<p>".
				"$msg";
		mailHtml($owner." Report Error",$reportMail,$owner." :: Report Error - MySQL",$str);
		echo $str;
	}
	
	
}
?>
