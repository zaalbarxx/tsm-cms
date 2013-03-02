<?php

class TSM_REGISTRATION_PAYMENT extends TSM_REGISTRATION_CAMPUS {

  private $info;

  public function __construct($paymentId = null) {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    if (isset($paymentId)) {
      $this->paymentId = intval($paymentId);
      $this->getInfo();
    }
  }

  public function getInfo() {
    if ($this->info == null) {
      $q = "SELECT * FROM tsm_reg_families_invoice_payments WHERE invoice_payment_id = ".$this->paymentId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function setQuickbooksId($id) {
    $q = "UPDATE tsm_reg_families_invoice_payments SET quickbooks_payment_id = '".$id."' WHERE invoice_payment_id = '".$this->paymentId."'";
    $this->db->runQuery($q);

    return true;
  }

}

?>