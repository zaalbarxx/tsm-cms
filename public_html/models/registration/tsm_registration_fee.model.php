<?php

class TSM_REGISTRATION_FEE extends TSM_REGISTRATION_CAMPUS{

  private $info;

  public function __construct($feeId = null){
		$tsm = TSM::getInstance();
		$this->tsm = $tsm;
		$this->db = $tsm->db;
		if(isset($feeId)){
      $this->feeId = $feeId;
      $this->getInfo(); 
    }
  }
  
  public function getInfo(){
    if($this->info == null){
      $q = "SELECT * FROM tsm_reg_fees WHERE fee_id = ".$this->feeId;
      $r = $this->db->runQuery($q);
      while($a = mysql_fetch_assoc($r)){
        $this->info = $a;
      }
    }
    
    return $this->info;
  }

}

?>