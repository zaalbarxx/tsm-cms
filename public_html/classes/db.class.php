<?php

class Db{
  
	private $numQueries;
	
  public function __construct(){
		$tsm = TSM::getInstance();
		$this->tsm = $tsm;
  }

	public function setConnection($dbhost,$dbuser,$dbpass){
		$this->conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql database...sorry.  Please try again later.');
	}

	public function setDatabase($database){
		mysql_select_db($database,$this->conn);
	}

	public function runQuery($query){
		//echo $query."\r\n";
		$result = mysql_query($query,$this->conn) or die(mysql_error().$query);
		$this->numQueries++;
		return $result;
	}
	
	public function getNumQueries(){
		return $this->numQueries;
	}
	
	public function insertRowFromPost($table){
    $q = "SHOW COLUMNS FROM ".$table;
    $r = $this->runQuery($q);
    $insertq = "INSERT INTO ".$table." ";
    $fields = "(";
    $values = " VALUES (";
    while($a = mysql_fetch_assoc($r)){
      //print_r($a);
      if(isset($_POST[$a['Field']])){
        $fields .= "".$a['Field'].",";
        $values .= "'".$this->tsm->makeVarSafe($_POST[$a['Field']])."',";
      } 
    }
    $fields = substr_replace($fields ,"",-1);
    $values = substr_replace($values ,"",-1);
    $fields .= ")";
    $values .= ")";
    $insertq = $insertq.$fields.$values;
    if($this->runQuery($insertq)){
      return mysql_insert_id();
    } else {
      return false;
    }
  }
  
	public function updateRowFromPost($table,$id){
    $q = "SHOW COLUMNS FROM ".$table;
    $r = $this->runQuery($q);
    $insertq = "UPDATE ".$table." ";
    $values = " SET ";
    while($a = mysql_fetch_assoc($r)){
      if(!isset($firstColumn)){
        $firstColumn = $a['Field'];
      }
      //print_r($a);
      if(isset($_POST[$a['Field']])){
        $values .= " ".$a['Field']."='".$this->tsm->makeVarSafe($_POST[$a['Field']])."', ";
      } 
    }
    $values = substr_replace($values ,"",-2);
    $values .= " WHERE ".$firstColumn."='".$id."'";
    $insertq = $insertq.$values;
    if($this->runQuery($insertq)){
      return true;
    } else {
      return false;
    }
  }
}

?>