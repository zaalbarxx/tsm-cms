<?php

class TSM_REGISTRATION_PROGRAM_FEE extends TSM_REGISTRATION {

  private $programFeeId;
  private $info;

  public function __construct($programFeeId = null) {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    if (isset($programFeeId)) {
      $this->programFeeId = intval($programFeeId);
      $this->getInfo();
    }
  }

  public function getInfo() {
    if ($this->info == null) {
      $q = "SELECT * FROM tsm_reg_program_fee WHERE program_fee_id = ".$this->programFeeId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function setQuickbooksClassId($qbClassId){
    $q = "UPDATE tsm_reg_program_fee SET quickbooks_class_id = '$qbClassId' WHERE program_fee_id = '".$this->programFeeId."'";
    $this->db->runQuery($q);

    return true;
  }

}

?>