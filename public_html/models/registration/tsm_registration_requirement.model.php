<?php

class TSM_REGISTRATION_REQUIREMENT extends TSM_REGISTRATION_CAMPUS{

	private $requirementId;
  private $info;

  public function __construct($requirementId = null){
		$tsm = TSM::getInstance();
		$this->tsm = $tsm;
		$this->db = $tsm->db;
		if(isset($requirementId)){
      $this->requirementId = $requirementId;
      $this->getInfo(); 
    }
  }
  
  public function getInfo(){
    if($this->info == null){
      $q = "SELECT * FROM tsm_reg_requirements WHERE requirement_id = ".$this->requirementId;
      $r = $this->db->runQuery($q);
      while($a = mysql_fetch_assoc($r)){
        $this->info = $a;
      }
    }
    
    return $this->info;
  }

}

?>