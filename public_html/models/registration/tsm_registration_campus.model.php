<?php

class TSM_REGISTRATION_CAMPUS extends TSM_REGISTRATION{

  private $campusId;
  private $info;
  private $programs;
  private $fees;
  private $feeConditions;
  private $requirements;

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
    $q = "SELECT * FROM tsm_reg_campuses WHERE campus_id = ".$this->campusId." ORDER BY name";
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
    $q = "SELECT * FROM tsm_reg_programs WHERE campus_id = ".$this->campusId." AND school_year = '".$this->info['current_school_year']."' ORDER BY name";
    $r = $this->db->runQuery($q);
    $this->programs = null;
    while($a = mysql_fetch_assoc($r)){
      $this->programs[$a['program_id']] = $a;
    }
    
    return $this->programs;
  }
  
  public function getRequirements($searchq = null){
    $q = "SELECT * FROM tsm_reg_requirements WHERE campus_id = ".$this->campusId." AND school_year = '".$this->info['current_school_year']."'";
    if($searchq != null){
      $q .= "AND name LIKE '%$searchq%'";
    }
    $q .= " ORDER BY name";
    $r = $this->db->runQuery($q);
    $this->requirements = null;
    while($a = mysql_fetch_assoc($r)){
      $this->requirements[$a['requirement_id']] = $a;
    }
    
    return $this->requirements;
  }
  
  public function deleteFee($feeId = null){
    return true;
  }
  
  public function getFees($searchq = null){
    $q = "SELECT * FROM tsm_reg_fees WHERE campus_id = ".$this->campusId." AND school_year = '".$this->info['current_school_year']."'";
    if($searchq != null){
      $q .= "AND name LIKE '%$searchq%'";
    }
    $q .= " ORDER BY name";
    $r = $this->db->runQuery($q);
    $this->fees = null;
    while($a = mysql_fetch_assoc($r)){
      $this->fees[$a['fee_id']] = $a;
    }
    
    return $this->fees;
  }
  
  public function getFeeConditions(){
    $q = "SELECT * FROM tsm_reg_fee_conditions WHERE campus_id = ".$this->campusId." AND school_year = '".$this->info['current_school_year']."'";
    $q .= " ORDER BY name";
    $r = $this->db->runQuery($q);
    $this->feeConditions = null;
    while($a = mysql_fetch_assoc($r)){
      $this->feeConditions[$a['fee_condition_id']] = $a;
    }
    
    return $this->feeConditions;
  }
  
  public function getFeeCondition($fee_condition_id){
    $q = "SELECT * FROM tsm_reg_fee_conditions WHERE campus_id = ".$this->campusId." AND fee_condition_id = '".$fee_condition_id."'";
    $r = $this->db->runQuery($q);
    $condition = null;
    $condition = mysql_fetch_assoc($r);
    
    return $condition;
  }

  public function createFee(){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->insertRowFromPost("tsm_reg_fees")){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
      die(print_r($_POST));
    }
  }
  
   public function saveFee($feeId){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->updateRowFromPost("tsm_reg_fees",$feeId)){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
      die(print_r($_POST));
    }
  }
  
  public function createFeeCondition(){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->insertRowFromPost("tsm_reg_fee_conditions")){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
      die(print_r($_POST));
    }
  }
  
   public function saveFeeCondition($feeConditionId){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->updateRowFromPost("tsm_reg_fee_conditions",$feeConditionId)){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
      die(print_r($_POST));
    }
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
      die("not all fields required.");
    }
  }

   public function saveProgram($programId){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->updateRowFromPost("tsm_reg_programs",$programId)){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
        die("not all fields required.");
    }
  }

}

?>