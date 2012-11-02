<?php

class Registration{
  

  public function __construct(){
		$tsm = TSM::getInstance();
		$this->tsm = $tsm;
		$this->db = $tsm->db;
  }
  
  public function changeTitle(){
    $this->tsm->website->setTitle("CHANGED!!"); 
  }
  
  public function getCampuses(){
    $q = "SELECT * FROM tsm_registration_campuses";
    $r = $this->db->runQuery($q);
    while($a = mysql_fetch_assoc($r)){
      $campuses[$a['campus_id']] = $a;
    }
    return $campuses;
  }

}

?>