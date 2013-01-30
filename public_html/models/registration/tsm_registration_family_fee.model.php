<?php

class TSM_REGISTRATION_FAMILY_FEE extends TSM_REGISTRATION_CAMPUS {

  private $info;

  public function __construct($familyFeeId = null) {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    if (isset($familyFeeId)) {
      $this->familyFeeId = intval($familyFeeId);
      $this->getInfo();
    }
  }

  public function getInfo() {
    if ($this->info == null) {
      $q = "SELECT * FROM tsm_reg_families_fees WHERE family_fee_id = ".$this->familyFeeId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function isInvoiced() {
    $q = "SELECT * FROM tsm_reg_families_invoice_fees WHERE family_fee_id = '".$this->familyFeeId."'";
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function delete() {
    if ($this->isInvoiced() == false) {
      $q = "DELETE FROM tsm_reg_families_fees WHERE family_fee_id = '".$this->familyFeeId."'";
      $this->db->runQuery($q);

      return true;
    } else {
      return false;
    }
  }

}

?>