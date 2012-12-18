<?php

class TSM_REGISTRATION_FAMILY extends TSM_REGISTRATION_CAMPUS{

  private $info;

  public function __construct($familyId = null){
		$tsm = TSM::getInstance();
		$this->tsm = $tsm;
		$this->db = $tsm->db;
		if(isset($familyId)){
      $this->familyId = $familyId;
      $this->getInfo(); 
    }
  }
  
  public function getInfo(){
    if($this->info == null){
      $q = "SELECT * FROM tsm_reg_families WHERE family_id = ".$this->familyId;
      $r = $this->db->runQuery($q);
      while($a = mysql_fetch_assoc($r)){
        $this->info = $a;
      }
    }
    
    return $this->info;
  }
  
  public function getStudents($school_year = null){
    $q = "SELECT * FROM tsm_reg_students s, tsm_reg_students_school_years ssy WHERE ssy.student_id = s.student_id AND ssy.school_year = '".$school_year."' AND s.family_id = ".$this->familyId." ORDER BY s.last_name";
    $r = $this->db->runQuery($q);
    $this->students = null;
    while($a = mysql_fetch_assoc($r)){
      $this->students[$a['student_id']] = $a;
    }
    
    return $this->students;
  }

}

?>