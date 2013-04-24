<?php

class TSM_REGISTRATION_FAMILY_PAYMENT_PLAN extends TSM_REGISTRATION_CAMPUS {

  private $info;

  public function __construct($familyPaymentPlanId = null) {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    if (isset($familyPaymentPlanId)) {
      $this->familyPaymentPlanId = intval($familyPaymentPlanId);
      $this->getInfo();
    }
  }

  public function getInfo() {
    if ($this->info == null) {
      $q = "SELECT * FROM tsm_reg_families_payment_plans fpp, tsm_reg_fee_payment_plans feepp
      WHERE feepp.payment_plan_id = fpp.payment_plan_id
      AND fpp.family_payment_plan_id = ".$this->familyPaymentPlanId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function getNumInvoices(){
    $q = "SELECT COUNT(family_invoice_id) AS num_invoices FROM tsm_reg_families_invoices WHERE family_payment_plan_id = '".$this->familyPaymentPlanId."'";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $numInvoices = $a['num_invoices'];
    }

    return $numInvoices;
  }

  public function getLastInvoice(){
    $q = "SELECT * FROM tsm_reg_families_invoices WHERE family_payment_plan_id = '".$this->familyPaymentPlanId."' ORDER BY family_invoice_id DESC";
    $r = $this->db->runQuery($q);
    $lastInvocie = null;
    while ($a = mysql_fetch_assoc($r)) {
      $lastInvocie = $a;
    }

    return $lastInvocie;
  }

  public function getPaymentPlanTotal(){
    $q = "";
  }

}

?>