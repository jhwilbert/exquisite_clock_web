<?
/**
 * Defines the User class
 * Require the HTML functions.
 * Require the DataBase class.
 * Requisre Session Start function
 */

class User {
		/** Unique identifier according the DataBase. <br>DataBase type: int(10). */
		var $id;
		/** User name <br> DataBase type: varchar(255)*/
		var $name;
		/** User email <br> DataBase type: varchar(255)*/
		var $email;
		/** User login - without special caracters <br> DataBase type: varchar(255)*/
		var $login;
		/** User password - crypted <br> DataBase type: varchar(255)*/
		var $password;
		/** User birthday <br> DataBase type: int <i>(32 bits)</i>*/
		var $birthDay;
		/** The place where the user was born. Prefered city/country <br> DataBase type: varchar(255)*/
		var $birthPlace;
		/** Description about the user <br> DataBase type: longtext*/
		var $desc;
		/** Date of inclusion. Generated automaticly by the system. <br>DataBase type: int <i>(32 bits)</i>. */
		var $incDate;
	
		/** The total of elemenst stored. */
		var $total;
		
		/** The const to abstract the dbTable */
		var $dbTable = "user";
		/** The const to abstract the class name */
		var $className = "User";
		
		/** Reference to database object */
		var $DB;
		
		/** Pattern contructor */
		function User($name,$login,$password){
			global $DB;
			$this->id   				= 0;
			$this->setName($name);
			$this->email 				= "";
			$this->setLogin($login);
			$this->setPassword($password);
			$this->birthDay 		= 0;
			$this->birthPlace 	= "";
			$this->desc 				= "";
	
			$this->incDate	= time();
	
			$this->total	= 0;
			
			$this->DB = $DB;
		}
		/** Return the crypt key code */
		function cryptKey(){
			return "minasdata.com.br";
		}
	
		/* ****************** SETTERS ****************** */
		function setId($var){
			$this->id = $var;
		}
		/**
		 * Set the name changing the HTML elements to 
		 * HTML entities, for the sake of the input 
		 * form element correctness.
		 */
		function setName($var){
			$this->name = toHtmlEnt($var);
		}
		/**
		 * Set the email changing the HTML elements to 
		 * HTML entities, for the sake of the input 
		 * form element correctness.
		 */
		function setEmail($var){
			$this->email = toHtmlEnt($var);
		}
		/**
		 * Set the login changing the HTML elements to 
		 * HTML entities, for the sake of the input 
		 * form element correctness.
		 */
		function setLogin($var){
			$this->login = toHtmlEnt($var);
		}
		/**
		 * Set the password crypted by the crypt key.
		 */
		function setPassword($var){
			$this->password = crypt($var,User::cryptKey());
		}
		/**
		 * Set the birthDay
		 * @param String var The formated birthday accordding the country selection
		 */
		function setBirthDay($var){
			$this->birthDay = dateToInt($var);
		}
		/**
		 * Set the birth place changing the HTML elements to 
		 * HTML entities, for the sake of the input 
		 * form element correctness.
		 */
		function setBirthPlace($var){
			$this->birthPlace = toHtmlEnt($var);
		}
		/** Set the user description trating the quotes and break lines */
		function setDesc($var){
			$this->desc = toDB($var);
		}
	
		/* ****************** GETTERS ****************** */
		/** Get the ID. If it is a new Banner object, it will return 0 (zero) */
		function getId(){
			return $this->id;
		}
		/** Get the name with the HTML elements in the HTML entities format. */
		function getName(){
			return $this->name;
		}
		/** Get the email with the HTML elements in the HTML entities format. */
		function getEmail(){
			return $this->email;
		}
		/** Get the login with the HTML elements in the HTML entities format. */
		function getLogin(){
			return $this->login;
		}
		/** Get the crypted password */
		function getPassword(){
			return $this->password;
		}
		/** Get the formated birthday */
		function getBirthDay(){
			return formatDate($this->birthDay); 
		}
		/** Get the birth place */
		function getBirthPlace(){
			return $this->birthPlace; 
		}
		/** Get the description to be used in a HTML context */
		function getDesc(){
			return DBtoHTML($this->desc);
		}
		/** Get the description to input in a text area form element */
		function getDescTA(){
			return DBtoTA($this->desc);
		}
		/** Get the formated inc date */
		function getIncDate(){
			return formatDate($this->incDate); 
		}
		/** Return the total of elements stored */
		function getTotal(){
			return $this->total;
		}
		
		/* ****************** DATABASE FUNCTIONS ****************** */
		/**
		 * Set the User object given a row recovered from the DataBase
		 */
		function setFromRow($row){
			$this->id					= $row["id"];
			$this->name				= $row["name"];
			$this->email			= $row["email"];
			$this->login			= $row["login"];
			$this->password		= $row["password"];
			$this->birthDay		= $row["birthDay"];
			$this->birthPlace	= $row["birthPlace"];
			$this->desc 			= $row["description"];
			$this->incDate 		= $row["incDate"];
		}
	
		/** 
		 * Load one element gieven an ID.
		 * @param Int id Identifier to the data base object
		 */
		function load($id){
			if($id!=0){
				$strSQL = "" .
						"SELECT * " .
						"FROM ".$this->dbTable." " .
						"WHERE 1=1 " .
						"AND id=$id " .
						"LIMIT 0,1";
				$result = $this->DB->getObj("".$this->className." :: function load($id)",$strSQL);
				$row	= mysql_fetch_array($result);
				$this->setFromRow($row);
			}
		}
		
		/**
		 * Load an user given the Login and Password.
		 */
		function loadLgPw($login,$password){
			$password = crypt($password,User::cryptKey());
			$strSQL = "" .
					"SELECT * " .
					"FROM ".$this->dbTable." " .
					"WHERE 1=1 " .
					"AND login = '".$login."' " .
					"AND password = '".$password."' " .
					"LIMIT 0,1";
			$result = $this->DB->getObj("".$this->className." :: function loadLgPw($login,password)",$strSQL);
			$row	= mysql_fetch_array($result);
			$this->setFromRow($row);
		}
		
		
		/**
		 * Load a range of objects controled by the limit command of the database
		 * @param Int sub The sub limit of the range
		 * @param Int offset The offset of the range
		 * @param String orderBy A data base description how to order the elements
		 * @return Array List of all recovered User
		 */
		function loadLimit($sub,$offset,$orderBy){
			$total = 0;
			if($orderBy=="") $orderBy = "id ASC";
			$strSQL = "" .
					"SELECT COUNT(t2.id) AS total, t1.* " .
					"FROM ".$this->dbTable." t1, ".$this->dbTable." t2 " .
					"WHERE 1=1 " .
					"AND t1.id>1 " .
					"GROUP BY t1.id " .
					"ORDER BY $orderBy " .
					"LIMIT $sub,$offset";
			$result = $this->DB->getObj("".$this->className." :: function loadLimit($sub, $offset, orderBy)",$strSQL);
			
			$all = Array();
			$i	 = 0;
			while ($row=mysql_fetch_array($result)){
				$all[$i] = new User("","","");
				$all[$i]->setFromRow($row);
				$all[$i]->total = $row["total"];
				$i++;
			}
			return $all;
		}
		
		/* ------------------ STORE/UPDATE FUNCTIONS ------------------ */
		/** 
		 * Choose store function if the id=0,
		 * else choose the update function 
		 */
		function store(){
			if($this->id==0){
				$this->storeObj();
			}else{
				$this->updateObj();
			}
		}
		
		/** Store a new object */
		function storeObj(){
			$strSQL = "" .
					"INSERT INTO ".$this->dbTable." " .
					"(name, email, login, password, birthDay, birthPlace, description, incDate) " .
					"VALUES (" .
					"'".$this->name."'," .
					"'".$this->email."'," .
					"'".$this->login."'," .
					"'".$this->password."'," .
					"".$this->birthDay."," .
					"'".$this->birthPlace."'," .
					"'".$this->desc."'," .
					"".$this->incDate.")";
			$this->id = $this->DB->exe("".$this->className." :: storeObj()",$strSQL);
		}
		
		/** Update an object. This functions doesn't update the user password. */
		function updateObj(){
			$strSQL = "" .
					"UPDATE ".$this->dbTable." " .
					"SET " .
						"name  				= '".$this->name."'," .
						"email 				= '".$this->email."'," .
						"login  			= '".$this->login."'," .
						"birthDay  		= ".$this->birthDay."," .
						"birthPlace  	= '".$this->birthPlace."'," .
						"description  = '".$this->desc."' " .
					"WHERE 1=1 " .
					"AND id = ".$this->id;
			$this->DB->exe("".$this->className." :: updateObj()",$strSQL);
		}
		
		/**
		 * Separeted function to update the user password.
		 */
		function updatePassword($var){
			if($this->getId()>0){
				$this->setPassword($var);
				$strSQL = "" .
						"UPDATE ".$this->dbTable." " .
						"SET " .
							"password			= '".$this->password."' " .
						"WHERE 1=1 " .
						"AND id = ".$this->id;
				$this->DB->exe("".$this->className." :: updatePassword",$strSQL);
			}
		}
		
		/* ------------------ // ------------------ */
		
		 
		/* ------------------ USER SPECIAL FUNCTIONS ------------------ */
		/**
		 * Cehck if the user exisists given a login and password
		 * @param lg menas user login
		 * @param pw means user password
		 * @return True if the login and password are correct, otherwise return false
		 */
		function checkUser($lg,$pw){
			$user = new User("",$lg,$pw);
			$strSQL = "SELECT id,name FROM user WHERE 1=1 AND login LIKE '".$user->getLogin()."' AND password = '".$user->getPassword()."'";
			$result = $this->DB->getObj("".$this->className." :: checkUser($lg,pw)",$strSQL);
			if($result=mysql_fetch_array($result)){
				return true;
			}else{
				return false;
			}
		}
		
		/**
		 * Check if login already exisits.
		 * Return true if the given login already exists, 
		 * otherwise return false. 
		 */
		function loginExists($lg){
			$strSQL = "SELECT id,login FROM user WHERE 1=1 AND login LIKE '$lg'";
			$result = $this->DB->getObj("".$this->className." :: loginExists($lg)",$strSQL);
			if(mysql_num_rows($result)>0){
				return true;
			}
			return false;
		}
		
		/**
		 * Set the session user id of the param 'var' is given, 
		 * otherwise return the session user id value.
		 * Necessary call the start_session() before use this function.
		 * @return String User id logged
		 */
		function sessionUserId($var){
			if($var!=""){
				$_SESSION["userId"] = $var;
			}
			if(isset($_SESSION["userId"]))
				$userId = $_SESSION["userId"];
			else $userId = ""; 
			return $userId;
		}
		
		/**
		 * Set the session user name of the param 'var' is given, 
		 * otherwise return the session user name value.
		 * Necessary call the start_session() before use this function.
		 * @return String User name logged
		 */
		function sessionUserName($var){
			if($var!=""){
				$_SESSION["userName"] = $var;
			}
			if(isset($_SESSION["userName"]))
				$userName = $_SESSION["userName"];
			else $userName = ""; 
			return $userName;
		}
		
		function unsetSessions(){
			unset($_SESSION["userId"]);
			unset($_SESSION["userName"]);
		}
		
		/**
		 * Check if the current user is logged.
		 * Return true if the session user id is equal the current user id,
		 * otherwise return false. 
		 */
		function isLogged(){
			if($this->sessionUserId("") == $this->getId()){
				return true;
			}
			return false;
		}
		
		/* ------------------ // ------------------ */

		/** Delete an object */
		function del($id){
			if($id!=0){
				$strSQL = "DELETE FROM ".$this->dbTable." WHERE id = $id";
		  	$this->DB->exe("".$this->className." :: function del($id)",$strSQL);
			}
			return true;
		}
	
		/* ****************** ISNTALL FUNCTIONS ****************** */
		/** Create the table in the database */
		function install(){
			$strSQL = "" .
					"CREATE TABLE IF NOT EXISTS ".$this->dbTable." (" .
						"id int  		 	unsigned     NOT NULL auto_increment," .
						"name    		 	varchar(255) NOT NULL," .
						"email    		varchar(255) NOT NULL," .
						"login    		varchar(255) NOT NULL," .
						"password    	varchar(255) NOT NULL," .
						"birthDay 		int(32) unsigned DEFAULT 0, " .
						"birthPlace		varchar(255) NOT NULL," .
						"description 	longtext ," .
						"incDate 		 	int(32) unsigned DEFAULT 0, " .
						"PRIMARY KEY  (id)," .
						"UNIQUE KEY id (id)," .
						"UNIQUE KEY login (login)" .
					") TYPE=MyISAM;";
			
	  		$this->DB->exe("".$this->className." :: function install()",$strSQL);
	  		
		  		$user = new User("Administrador","root","daeherld");
	  		if(!$user->loginExists("root")){
		  		$user->storeObj();
	  		}
		}

}
?>