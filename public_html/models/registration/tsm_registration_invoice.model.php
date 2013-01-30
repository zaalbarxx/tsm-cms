<?php

class TSM_REGISTRATION_INVOICE extends TSM_REGISTRATION_CAMPUS {

  private $info;

  public function __construct($invoiceId = null) {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    if (isset($invoiceId)) {
      $this->invoiceId = intval($invoiceId);
      $this->getInfo();
    }
  }

  public function getInfo() {
    if ($this->info == null) {
      $q = "SELECT * FROM tsm_reg_families_invoices WHERE family_invoice_id = ".$this->invoiceId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function containsFee($family_fee_id) {
    $q = "SELECT * FROM tsm_reg_families_invoice_fees WHERE family_invoice_id = '".$this->invoiceId."' AND family_fee_id = '".$family_fee_id."'";
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) == 0) {
      return false;
    } else {
      return true;
    }
  }

  public function addFee($family_fee_id) {
    if ($this->containsFee($family_fee_id) == false) {
      $q = "INSERT INTO tsm_reg_families_invoice_fees (family_id,family_fee_id,family_invoice_id) VALUES('".$this->info['family_id']."','$family_fee_id','".$this->invoiceId."')";
      $this->db->runQuery($q);

      return true;
    } else {
      return false;
    }
  }

  public function getFees() {
    $q = "SELECT * FROM tsm_reg_families_fees ff, tsm_reg_families_invoice_fees invf WHERE invf.family_fee_id = ff.family_fee_id AND invf.family_invoice_id = '".$this->invoiceId."'";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $returnFees[] = $a;
    }

    return $returnFees;
  }

  public function addToQuickbooks() {
    global $quickbooks;

    if (isset($this->info['quickbooks_invoice_id'])) {
      $doNotProcess = 1;
    }

    $fees = $this->getFees();

    $quickbooksInvoice = new QuickBooks_IPP_Object_Invoice();
    $invoiceHeader = new QuickBooks_IPP_Object_Header();
    $invoiceHeader->setCustomerId("{QB-988}");
    $quickbooksInvoice->addHeader($invoiceHeader);

    foreach ($fees as $fee) {
      $feeObject = new TSM_REGISTRATION_FEE($fee['fee_id']);
      $feeInfo = $feeObject->getInfo();

      if (!isset($feeInfo['quickbooks_item_id'])) {
        $doNotProcess = true;
      }


    }

    if (!isset($doNotProcess)) {
      foreach ($fees as $fee) {
        $feeObject = new TSM_REGISTRATION_FEE($fee['fee_id']);
        $feeInfo = $feeObject->getInfo();

        $Line = new QuickBooks_IPP_Object_Line();
        $Line->setItemId($feeInfo['quickbooks_item_id']);
        $Line->setQty(1);
        $quickbooksInvoice->addLine($Line);
      }

      $service = new QuickBooks_IPP_Service_Invoice();
      $quickbooks_id = $service->add($quickbooks->Context, $quickbooks->creds['qb_realm'], $quickbooksInvoice);

      $this->setQuickbooksId($quickbooks_id);

      return true;
    } else {
      return false;
    }
  }

  public function setQuickbooksId($id) {
    $q = "UPDATE tsm_reg_families_invoices SET quickbooks_invoice_id = '".$id."' WHERE family_invoice_id = '".$this->invoiceId."'";
    $this->db->runQuery($q);

    return true;
  }

  public function updateTotal() {
    $q = "UPDATE tsm_reg_families_invoices SET amount = '".$this->addFees($this->getFees())."' WHERE family_invoice_id = '".$this->invoiceId."'";
    $this->db->runQuery($q);

    return true;
  }

}

?>