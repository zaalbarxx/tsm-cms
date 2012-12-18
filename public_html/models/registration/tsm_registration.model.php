<?php

class TSM_REGISTRATION{

  private $currentCampusId;
  private $feeConditionTypes;
  private $requirementTypes;

  public function __construct(){
		$tsm = TSM::getInstance();
		$this->tsm = $tsm;
		$this->db = $tsm->db;
  }
  
  public function setCurrentCampusId($campus_id){
    echo "set campusId to: ".$campus_id;
    $_SESSION['reg']['currentCampusId'] = $campus_id;
    $this->currentCampusId = $_SESSION['reg']['currentCampusId'];
    
    return true;
  }
  
  public function getCurrentCampusId(){
    if(isset($_SESSION['reg']['currentCampusId'])){
      return $_SESSION['reg']['currentCampusId'];
    } else {
      return null;
    }
   
  }
  
  public function getSelectedSchoolYear(){
    return 2013;
  }
  
  public function getCampuses(){
    $q = "SELECT * FROM tsm_reg_campuses WHERE website_id = '".$_SESSION['website_id']."'";
    $r = $this->db->runQuery($q);
    $campuses = null;
    while($a = mysql_fetch_assoc($r)){
      $campuses[$a['campus_id']] = $a;
    }
    return $campuses;
  }

  public function createCampus(){
    if(isset($_POST['name']) && isset($_POST["website_id"])){
      if($this->db->insertRowFromPost("tsm_reg_campuses")){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
    
    }
  }
  
  public function getFeeConditionTypes(){
    $q = "SELECT * FROM tsm_reg_fee_condition_types";
    $r = $this->db->runQuery($q);
    while($a = mysql_fetch_assoc($r)){
      $this->feeConditionTypes[$a['fee_condition_type_id']] = $a;
    }
    
    return $this->feeConditionTypes;
  }
  
  public function getRequirementTypes(){
    $q = "SELECT * FROM tsm_reg_requirement_types";
    $r = $this->db->runQuery($q);
    while($a = mysql_fetch_assoc($r)){
      $this->requirementTypes[$a['requirement_type_id']] = $a;
    }
    
    return $this->requirementTypes;
  }

}

?>