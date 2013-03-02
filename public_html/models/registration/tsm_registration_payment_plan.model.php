<?php

class TSM_REGISTRATION_PAYMENT_PLAN extends TSM_REGISTRATION_CAMPUS {

  private $info;

  public function __construct($paymentPlanId = null) {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    if (isset($paymentPlanId)) {
      $this->paymentPlanId = intval($paymentPlanId);
      $this->getInfo();
    }
  }

  public function getInfo() {
    if ($this->info == null) {
      $q = "SELECT * FROM tsm_reg_fee_payment_plans WHERE payment_plan_id = ".$this->paymentPlanId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function getNumFamilies() {
    $q = "SELECT COUNT(family_id) AS num_families FROM tsm_reg_families_payment_plans WHERE payment_plan_id = '".$this->paymentPlanId."'";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $numFamiles = $a['num_families'];
    }

    return $numFamiles;
  }

}

?>