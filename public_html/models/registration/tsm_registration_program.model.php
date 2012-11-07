<?php

class TSM_REGISTRATION_PROGRAM extends TSM_REGISTRATION{

  private $programId;
  private $info;
  private $programs;
  private $numStudentsEnrolled;

  public function __construct($programId = null){
		$tsm = TSM::getInstance();
		$this->tsm = $tsm;
		$this->db = $tsm->db;
		if(isset($programId)){
      $this->programId = $programId;
      $this->getInfo(); 
    }
  }
  
  public function getInfo(){
    $q = "SELECT * FROM tsm_reg_programs WHERE program_id = ".$this->programId;
    $r = $this->db->runQuery($q);
    while($a = mysql_fetch_assoc($r)){
      $this->info = $a;
    }
    
    return $this->info;
  }
  
  public function getDetails(){
    $this->numStudentsEnrolled = $this->getNumStudentsEnrolled();  
  }
  
  public function getNumStudentsEnrolled($programId = null){
    if($this->numStudentsEnrolled == null){
      if($programId == null){
        $programId = $this->programId;
      }
      $q = "SELECT COUNT(student_id) AS num_students FROM tsm_reg_student_program WHERE program_id = ".$programId;
      $r = $this->db->runQuery($q);
      while($a = mysql_fetch_assoc($r)){
        $this->numStudentsEnrolled = $a['num_students'];
      }
    }
    
    return $this->numStudentsEnrolled;
  }

}

?>