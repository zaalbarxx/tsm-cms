<?php

class TSM_REGISTRATION_PERIOD extends TSM_REGISTRATION_CAMPUS{

	private $periodId;
  private $info;

  public function __construct($periodId = null){
		$tsm = TSM::getInstance();
		$this->tsm = $tsm;
		$this->db = $tsm->db;
		if(isset($periodId)){
      $this->periodId = $periodId;
      $this->getInfo(); 
    }
  }
  
  public function getInfo(){
    if($this->info == null){
      $q = "SELECT * FROM tsm_reg_periods WHERE period_id = ".$this->periodId;
      $r = $this->db->runQuery($q);
      while($a = mysql_fetch_assoc($r)){
        $this->info = $a;
      }
    }
    
    return $this->info;
  }

}

?>