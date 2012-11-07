<?php

class TSM_REGISTRATION{

  private $currentCampusId;

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

}

?>