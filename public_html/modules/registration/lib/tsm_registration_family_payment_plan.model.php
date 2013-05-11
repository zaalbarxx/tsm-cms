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

  public function getStatus(){
    $amountDue = $this->getAmountDue();
    if($this->info['setup_complete'] == 0){
      $status = "Pending Approval";
    } else if($this->info['setup_complete'] == 1 && $amountDue > 0){
      $status = "In Progress";
    } else if ($this->info['setup_complete'] == 1 && $amountDue == 0){
      $status = "Paid in Full";
    }

    return $status;
  }

  public function getAmountDue(){
    $total = $this->getTotal();
    $paid = $this->getAmountPaid();
    $due = $total - $paid;

    return $due;
  }

  public function getInvoices(){
    $q = "SELECT * FROM tsm_reg_families_invoices fi WHERE fi.family_payment_plan_id = '".$this->familyPaymentPlanId."'";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $invoices[$a['family_invoice_id']] = $a;
    }

    return $invoices;
  }

  public function getFeeTypes(){
    $feeTypes = unserialize($this->info['fee_types']);

    return $feeTypes;
  }

  public function getUnassignedApplicableFees(){
    $creditFeeId = $this->info['credit_fee_id'];
    $installmentFeeId = $this->info['installment_fee_id'];

    $q = "SELECT * FROM tsm_reg_families_fees f WHERE (";
    $i = 0;
    $feeTypes = $this->getFeeTypes();
    if(isset($feeTypes)){
      foreach($feeTypes as $fee_type_id){
        if($i != 0){
          $q .= " And ";
        }
        $q .= " fee_type_id = '".$fee_type_id."' ";
        $i++;
      }
      $q .= ") AND family_payment_plan_id IS NULL AND family_id = '".$this->info['family_id']."' AND fee_id <> '$creditFeeId' and fee_id <> '$installmentFeeId'";
      $r = $this->db->runQuery($q);
      $fees = null;
      while ($a = mysql_fetch_assoc($r)) {
        $fees[$a['family_fee_id']] = $a;
      }
    }

    return $fees;
  }

  public function getFees(){
    $creditFeeId = $this->info['credit_fee_id'];
    $installmentFeeId = $this->info['installment_fee_id'];
    //print_r($this->info);
    $q = "SELECT * FROM tsm_reg_families_fees WHERE family_payment_plan_id = '".$this->familyPaymentPlanId."' AND fee_id <> '$creditFeeId' and fee_id <> '$installmentFeeId'";
    $r = $this->db->runQuery($q);
    $fees = null;
    while ($a = mysql_fetch_assoc($r)) {
      $fees[$a['family_fee_id']] = $a;
    }

    return $fees;
  }

  public function setupComplete(){
    if($this->info['setup_complete'] == 1){
      return true;
    } else {
      return false;
    }
  }

  public function getTotal(){
    global $reg;

    if($this->setupComplete()){
      $fees = $this->getFees();
      $total = $reg->addFees($fees);
    } else {
      $fees = $this->getFees();
      $unassignedFees = $this->getUnassignedApplicableFees();
      $total = $reg->addFees($fees) + $reg->addFees($unassignedFees);
    }


    return $total;
  }

  public function getAmountPaid(){
    $amountPaid = 0;
    $invoices = $this->getInvoices();
    if(isset($invoices)){
      foreach($invoices as $invoice){
        $invoiceObject = new TSM_REGISTRATION_INVOICE($invoice['family_invoice_id']);
        $amountPaid = $amountPaid + $invoiceObject->getAmountPaid();
      }
    }

    return $amountPaid;
  }

  public function completeSetup(){
    $q = "UPDATE tsm_reg_families_payment_plans SET setup_complete = 1 WHERE family_payment_plan_id = '".$this->familyPaymentPlanId."'";
    $this->db->runQuery($q);

    return true;
  }

  public function addFees($feesToAdd){
    if(isset($feesToAdd)){
      foreach($feesToAdd as $family_fee_id){
        $feeObject = new TSM_REGISTRATION_FAMILY_FEE($family_fee_id);
        $feeObject->setPaymentPlan($this->familyPaymentPlanId);
      }
    }

    return true;
  }

  public function approve(){
    $this->completeSetup();

    return true;
  }

}

?>