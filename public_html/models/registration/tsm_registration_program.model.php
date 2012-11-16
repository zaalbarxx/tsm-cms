<?php

class TSM_REGISTRATION_PROGRAM extends TSM_REGISTRATION{

  private $programId;
  private $info;
  private $programs;
  private $numStudentsEnrolled;
  private $fees;
  private $requirements;

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
    if($this->info == null){
      $q = "SELECT * FROM tsm_reg_programs WHERE program_id = ".$this->programId;
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
  
  public function getRequirements(){
    if($this->requirements == null){
      $q = "SELECT * FROM tsm_reg_program_requirements pr, tsm_reg_requirements r WHERE r.requirement_id = pr.requirement_id AND pr.program_id = ".$this->programId."";
      $r = $this->db->runQuery($q);
      while($a = mysql_fetch_assoc($r)){
        $this->requirements[$a['program_requirement_id']] = $a;
      }
    }
    
    return $this->requirements;
  }
  
  public function getFees(){
    if($this->fees == null){
      $q = "SELECT * FROM tsm_reg_program_fee pf, tsm_reg_fees f WHERE f.fee_id = pf.fee_id AND pf.program_id = ".$this->programId."";
      $r = $this->db->runQuery($q);
      while($a = mysql_fetch_assoc($r)){
        $this->fees[$a['program_fee_id']] = $a;
      }
    }
    
    return $this->fees;
  }
  
  public function getFeeConditions($feeId){
    $q = "SELECT * FROM tsm_reg_program_fee_condition pfc, tsm_reg_fee_conditions fc 
    WHERE pfc.fee_condition_id = fc.fee_condition_id 
    AND pfc.program_id = ".$this->programId." AND pfc.fee_id = ".$feeId;
    $r = $this->db->runQuery($q);
    $conditions = null;
    while($a = mysql_fetch_assoc($r)){
      $conditions[$a['program_fee_condition_id']] = $a;
    }
  
    return $conditions;
  }
  
  public function deleteFeeCondition($programFeeConditionId){
    $q = "DELETE FROM tsm_reg_program_fee_condition WHERE program_fee_condition_id = $programFeeConditionId AND program_id = ".$this->programId;
    $r = $this->db->runQuery($q);
    
    return true;
  }
  
  public function addFee($feeId){
    //Check to see if the fee has already been added to the program
    $q = "SELECT * FROM tsm_reg_program_fee WHERE fee_id = ".$feeId." AND program_id = ".$this->programId;
    $r = $this->db->runQuery($q);
    if(mysql_num_rows($r) == 0){
      $q = "INSERT INTO tsm_reg_program_fee (program_id,fee_id) VALUES ('".$this->programId."','$feeId')";;
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
  
  public function addRequirement($requirementId){
    //Check to see if the fee has already been added to the program
    $q = "SELECT * FROM tsm_reg_program_requirements WHERE requirement_id = ".$requirementId." AND program_id = ".$this->programId;
    $r = $this->db->runQuery($q);
    if(mysql_num_rows($r) == 0){
      $q = "INSERT INTO tsm_reg_program_requirements (program_id,requirement_id) VALUES ('".$this->programId."','$requirementId')";;
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
  
  public function addFeeCondition($feeConditionId,$feeId){
    //Check to see if the fee has already been added to the program
    $q = "SELECT * FROM tsm_reg_program_fee_condition WHERE fee_id = ".$feeId." AND fee_condition_id = ".$feeConditionId." AND program_id = ".$this->programId;
    $r = $this->db->runQuery($q);
    if(mysql_num_rows($r) == 0){
      $q = "INSERT INTO tsm_reg_program_fee_condition (program_id,fee_id,fee_condition_id) VALUES ('".$this->programId."','$feeId','$feeConditionId')";;
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
  
  public function deleteFee($feeId){
  
  }

}

?>