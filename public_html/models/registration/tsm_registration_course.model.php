<?php
class TSM_REGISTRATION_COURSE extends TSM_REGISTRATION{

  private $courseId;
  private $info;
  private $courses;
  private $numStudentsEnrolled;
  private $fees;
  private $requirements;
	
	public function __construct($courseId = null){
		$tsm = TSM::getInstance();
		$this->tsm = $tsm;
		$this->db = $tsm->db;
		if(isset($courseId)){
      $this->courseId = $courseId;
      $this->getInfo(); 
    }
  }

  public function getInfo(){
    if($this->info == null){
      $q = "SELECT * FROM tsm_reg_courses WHERE course_id = ".$this->courseId;
      $r = $this->db->runQuery($q);
      while($a = mysql_fetch_assoc($r)){
        $this->info = $a;
      }
    }
    
    return $this->info;
  }
  
  public function getName(){
    if($this->info == null){
      $this->getInfo();
    }
    
    $this->name = $this->info['name'];
    
    return $this->name;
  }
  
  public function addFee($feeId){
    //Check to see if the fee has already been added to the program
    $q = "SELECT * FROM tsm_reg_course_fee WHERE fee_id = ".$feeId." AND course_id = ".$this->courseId;
    $r = $this->db->runQuery($q);
    if(mysql_num_rows($r) == 0){
      $q = "INSERT INTO tsm_reg_course_fee (course_id,fee_id) VALUES ('".$this->courseId."','$feeId')";;
      if($this->db->runQuery($q)){
        $feeAdded = true;
      } else {
        $feeAdded = false;
      }
    } else {
      $feeAdded = false;
    }
    
    return $feeAdded;
  }
  
  public function getFees(){
    if($this->fees == null){
      $q = "SELECT * FROM tsm_reg_course_fee cf, tsm_reg_fees f WHERE f.fee_id = cf.fee_id AND cf.course_id = ".$this->courseId."";
      $r = $this->db->runQuery($q);
      while($a = mysql_fetch_assoc($r)){
        $this->fees[$a['course_fee_id']] = $a;
      }
    }
    
    return $this->fees;
  }
  
  public function addFeeCondition($feeConditionId,$feeId){
    //Check to see if the fee has already been added to the program
    $q = "SELECT * FROM tsm_reg_course_fee_condition WHERE fee_id = ".$feeId." AND fee_condition_id = ".$feeConditionId." AND course_id = ".$this->courseId;
    $r = $this->db->runQuery($q);
    if(mysql_num_rows($r) == 0){
      $q = "INSERT INTO tsm_reg_course_fee_condition (course_id,fee_id,fee_condition_id) VALUES ('".$this->courseId."','$feeId','$feeConditionId')";;
      if($this->db->runQuery($q)){
        $feeAdded = true;
      } else {
        $feeAdded = false;
      }
    } else {
      $feeAdded = false;
    }
    
    return $feeAdded;
  }  

  public function getFeeConditions($feeId){
    $q = "SELECT * FROM tsm_reg_course_fee_condition cfc, tsm_reg_fee_conditions fc 
    WHERE cfc.fee_condition_id = fc.fee_condition_id 
    AND cfc.course_id = ".$this->courseId." AND cfc.fee_id = ".$feeId;
    $r = $this->db->runQuery($q);
    $conditions = null;
    while($a = mysql_fetch_assoc($r)){
      $conditions[$a['course_fee_condition_id']] = $a;
    }
  
    return $conditions;
  }
  
  public function deleteFeeCondition($courseFeeConditionId){
    $q = "DELETE FROM tsm_reg_course_fee_condition WHERE course_fee_condition_id = $courseFeeConditionId AND course_id = ".$this->courseId;
    $r = $this->db->runQuery($q);
    
    return true;
  }
  
  public function addRequirement($requirementId){
    //Check to see if the fee has already been added to the course
    $q = "SELECT * FROM tsm_reg_course_requirements WHERE requirement_id = ".$requirementId." AND course_id = ".$this->courseId;
    $r = $this->db->runQuery($q);
    if(mysql_num_rows($r) == 0){
      $q = "INSERT INTO tsm_reg_course_requirements (course_id,requirement_id) VALUES ('".$this->courseId."','$requirementId')";;
      if($this->db->runQuery($q)){
        $requirementAdded = true;
      } else {
        $requirementAdded = false;
      }
    } else {
      $requirementAdded = false;
    }
    
    return $requirementAdded;
  }
  
  public function removeRequirement($requirementId){
  		$q = "DELETE FROM tsm_reg_course_requirements WHERE requirement_id = ".$requirementId." AND course_id = ".$this->courseId;
  		$r = $this->db->runQuery($q);
  		
  		return true;
  }
  
  public function getRequirements(){
    if($this->requirements == null){
      $q = "SELECT * FROM tsm_reg_course_requirements cr, tsm_reg_requirements r WHERE r.requirement_id = cr.requirement_id AND cr.course_id = ".$this->courseId."";
      $r = $this->db->runQuery($q);
      while($a = mysql_fetch_assoc($r)){
        $this->requirements[$a['course_requirement_id']] = $a;
      }
    }
    
    return $this->requirements;
  }
  
  public function getNumStudentsEnrolled($courseId = null){
    if($this->numStudentsEnrolled == null){
      if($courseId == null){
        $courseId = $this->courseId;
      }
      $q = "SELECT COUNT(student_id) AS num_students FROM tsm_reg_student_course WHERE course_id = ".$courseId;
      $r = $this->db->runQuery($q);
      while($a = mysql_fetch_assoc($r)){
        $this->numStudentsEnrolled = $a['num_students'];
      }
    }
    
    return $this->numStudentsEnrolled;
  }
  
}
?>