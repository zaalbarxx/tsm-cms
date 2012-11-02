<?php

class Db{
	public function setConnection($dbhost,$dbuser,$dbpass){
		$this->conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql database...sorry.  Please try again later.');
	}

	public function setDatabase($database){
		mysql_select_db($database,$this->conn);
	}

	public function runQuery($query){
		$result = mysql_query($query,$this->conn) or die(mysql_error().$query);

		return $result;
	}
}

?>