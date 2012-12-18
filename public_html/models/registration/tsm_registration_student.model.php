<?php

class TSM_REGISTRATION_STUDENT extends TSM_REGISTRATION_CAMPUS{

  private $info;
  private $enrolledPrograms;

  public function __construct($studentId = null){
		$tsm = TSM::getInstance();
		$this->tsm = $tsm;
		$this->db = $tsm->db;
		if(isset($studentId)){
      $this->studentId = $studentId;
      $this->getInfo(); 
    }
  }
  
  public function getInfo(){
    if($this->info == null){
      $q = "SELECT * FROM tsm_reg_students WHERE student_id = ".$this->studentId;
      $r = $this->db->runQuery($q);
      while($a = mysql_fetch_assoc($r)){
        $this->info = $a;
      }
    }
    
    return $this->info;
  }
  
  public function getEnrolledPrograms(){
  	$q = "SELECT * FROM tsm_reg_student_program sp, tsm_reg_programs p WHERE p.program_id = sp.program_id AND sp.student_id = ".$this->studentId." AND p.school_year = ".$this->getSelectedSchoolYear()."";
  	$r = $this->db->runQuery($q);
		while($a = mysql_fetch_assoc($r)){
			$this->enrolledPrograms[$a['program_id']] = $a;
		}

		return $this->enrolledPrograms;
  }
  
  public function getEligiblePrograms(){
  	$campus = new TSM_REGISTRATION_CAMPUS($_SESSION['reg']['currentCampusId']);
  	$allPrograms = $campus->getPrograms();
  	return void;
  }
  
  public function getCoursesIn($program_id){
  	$q = "SELECT * FROM tsm_reg_student_course sc, tsm_reg_courses c, tsm_reg_periods p WHERE c.course_id = sc.course_id AND p.period_id = sc.period_id AND sc.program_id = '$program_id' AND sc.student_id = '".$this->studentId."' ORDER BY day, start_time";
  	$r = $this->db->runQuery($q);
  	$courses = null;
		while($a = mysql_fetch_assoc($r)){
			$courses[$a['course_id']] = $a;
		}
  	
		return $courses;
  }

}

?>