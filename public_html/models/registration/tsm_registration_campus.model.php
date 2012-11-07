<?php

class TSM_REGISTRATION_CAMPUS extends TSM_REGISTRATION{

  private $campusId;
  private $info;
  private $programs;

  public function __construct($campusId = null){
		$tsm = TSM::getInstance();
		$this->tsm = $tsm;
		$this->db = $tsm->db;
		if(isset($campusId)){
      $this->campusId = $campusId;
      $this->getInfo(); 
    }
  }
  
  public function getCampusId(){
    return $this->campusId;
  }
  
  public function getInfo(){
    $q = "SELECT * FROM tsm_reg_campuses WHERE campus_id = ".$this->campusId;
    $r = $this->db->runQuery($q);
    while($a = mysql_fetch_assoc($r)){
      $this->info = $a;
    }
    
    return $this->info;
  }
  
  public function getCurrentSchoolYear(){
    if($this->info == null){
      $this->getInfo();
    }
    
    return $this->info['current_school_year'];  
  }
  
  public function getPrograms(){
    $q = "SELECT * FROM tsm_reg_programs WHERE campus_id = ".$this->campusId." AND school_year = '".$this->info['current_school_year']."'";
    $r = $this->db->runQuery($q);
    $this->programs = null;
    while($a = mysql_fetch_assoc($r)){
      $this->programs[$a['program_id']] = $a;
    }
    
    return $this->programs;
  }
  
  public function createProgram(){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->insertRowFromPost("tsm_reg_programs")){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
    
    }
  }

}

?>