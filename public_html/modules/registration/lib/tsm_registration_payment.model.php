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
      $q = "SELECT * FROM tsm_reg_families_payments WHERE family_payment_id = ".$this->paymentId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function setQuickbooksId($id) {
    $q = "UPDATE tsm_reg_families_payments SET quickbooks_payment_id = '".$id."' WHERE family_payment_id = '".$this->paymentId."'";
    $this->db->runQuery($q);

    return true;
  }

  public function assignToInvoice($familyInvoiceId,$amount){
    $q = "INSERT INTO tsm_reg_families_payment_invoice (family_payment_id,family_invoice_id,amount) VALUES('".$this->paymentId."','$familyInvoiceId','$amount')";
    $this->db->runQuery($q);

    return true;
  }

  public function getLines(){
    $q = "SELECT * FROM tsm_reg_families_payment_invoice pi, tsm_reg_families_invoices fi
    WHERE fi.family_invoice_id = pi.family_invoice_id
    AND pi.family_payment_id = '".$this->paymentId."'
    AND fi.deleted_at IS NULL";
    $r = $this->db->runQuery($q);
    while($a = mysql_fetch_assoc($r)){
      $paymentLines[] = $a;
    }

    return $paymentLines;
  }

  public function addToQuickbooks(){
    $currentCampus = new TSM_REGISTRATION_CAMPUS($this->getCurrentCampusId());
    $campusInfo = $currentCampus->getInfo();

    $quickbooks = new TSM_REGISTRATION_QUICKBOOKS();
    $family = new TSM_REGISTRATION_FAMILY($this->info['family_id']);
    $familyInfo = $family->getInfo();

    $paymentObject = new QuickBooks_IPP_Object_Payment();
    $paymentHeader = new QuickBooks_IPP_Object_Header();
    $paymentHeader->setCustomerId($familyInfo['quickbooks_customer_id']);
    $paymentHeader->setTotalAmt($this->info['amount']);
    $paymentHeader->setDocNumber($this->info['reference_number']);
    $paymentHeader->setPaymentMethodId($campusInfo['qb_paypal_payment_method_id']);
    $txnDate = date('Y-m-d', strtotime($this->info['payment_time']));
    $paymentHeader->setTxnDate($txnDate);
    $paymentHeader->setNote($this->info['payment_description']);
    $paymentObject->addHeader($paymentHeader);
    $lines = $this->getLines();
    if(isset($lines)){
      foreach($lines as $localLine){
        $Line = new QuickBooks_IPP_Object_Line();
        $Line->setTxnId($localLine['quickbooks_external_key']);
        $Line->setAmount($localLine['amount']);
        $paymentObject->addLine($Line);
      }
    }
    $service = new QuickBooks_IPP_Service_Payment();
    $quickbooks_payment_id = $service->add($quickbooks->Context, $quickbooks->creds['qb_realm'], $paymentObject);
    $this->setQuickbooksId($quickbooks_payment_id);
  }

}

?>