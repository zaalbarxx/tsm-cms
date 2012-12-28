<?php

class TSM_REGISTRATION_FAMILY extends TSM_REGISTRATION_CAMPUS{

  private $info;
  private $isLoggedIn;

  public function __construct($familyId = null){
		$tsm = TSM::getInstance();
		$this->tsm = $tsm;
		$this->db = $tsm->db;
		if(isset($familyId)){
      $this->familyId = $familyId;
      $this->getInfo(); 
    } else if(isset($_SESSION['family']['id'])){
    	$this->familyId = $_SESSION['family']['id'];
      $this->getInfo(); 
    }
  }

  public function login($email,$password,$campus_id){
    $q = "SELECT * FROM tsm_reg_families WHERE primary_email = '$email' AND campus_id = '".$campus_id."' AND website_id = '".$_SESSION['website_id']."'";
    $r = $this->db->runQuery($q);
    if(mysql_num_rows($r) > 0){
      $a = mysql_fetch_assoc($r);
      if(TSM::getInstance()->checkPassword($a['password'],$password)){
        $_SESSION['family']['id'] = $a['family_id'];
        header("location: index.php");
        $success = 1;
      } else {
        $success = 0;
      }
    } else {
      $success = 0;
    }

    return $success;
  }
  
  public function isLoggedIn(){
    if(isset($_SESSION['family']['id'])){
      $this->isLoggedIn = true;  
    } else {
      $this->isLoggedIn = false;
    }
    
    return $this->isLoggedIn;
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
  
  public function getFees($fee_type_id = null){
  	$students = $this->getStudents($this->getSelectedSchoolYear());
  	if(isset($students)){
  		foreach($students as $student){
  			$studentObject = new TSM_REGISTRATION_STUDENT($student['student_id']);
  			$fees = $studentObject->getFees($fee_type_id);
  		}
  	}
  }

}

?>