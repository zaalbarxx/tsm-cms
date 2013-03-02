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

  public function getPayPalFee() {
    $q = "SELECT * FROM tsm_reg_families_fees ff, tsm_reg_families_invoice_fees fif
    WHERE fif.family_fee_id = ff.family_fee_id
    AND fif.family_invoice_id = '".$this->invoiceId."'
    AND ff.name = 'PayPal Convenience Fee'";
    $r = $this->db->runQuery($q);
    $fee = null;
    while ($a = mysql_fetch_assoc($r)) {
      $fee = $a;
    }

    return $fee;
  }

  public function addPayPalFee() {
    $payPalFee = $this->getPayPalFee();
    if (!$payPalFee) {
      $total = $this->getTotal();
      $campus = new TSM_REGISTRATION_CAMPUS($this->getCurrentCampusId());
      $campusInfo = $campus->getInfo();
      $paypal_fee_id = $campusInfo['paypal_convenience_fee_id'];
      $paypalFee = new TSM_REGISTRATION_FEE($paypal_fee_id);
      $paypalFeeInfo = $paypalFee->getInfo();

      $paypalFeeAmount = $total * .03;
      $family_id = $this->info['family_id'];
      $family = new TSM_REGISTRATION_FAMILY($family_id);
      $family_fee_id = $family->addFee($paypalFeeInfo['name'], $paypalFeeAmount, $paypal_fee_id, $paypalFeeInfo['fee_type_id']);
      /* WE SHOULDN'T SET THE PAYMENT PLAN ID FOR A PAYPAL FEE BECAUSE IT COULD THROW OFF THE CALCUALTED TOTAL FOR THE PAYMENT PLAN
      $familyFee = new TSM_REGISTRATION_FAMILY_FEE($family_fee_id);
      $familyFee->setPaymentPlan($this->info['family_payment_plan_id']);
      */
      $params = Array("family_fee_id" => $family_fee_id, "description" => $paypalFeeInfo['name'], "amount" => $paypalFeeAmount);
      $this->addFee($params);
      $this->updateTotal();
      $return = true;
    } else {
      $return = true;
    }
    return $return;

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

  public function addFee($options = Array("family_fee_id" => null, "description" => "", "amount" => 0)) {
    if (isset($options['family_fee_id'])) {
      $family_fee_id = $options['family_fee_id'];
    } else {
      $family_fee_id = null;
    }
    if (isset($options['description'])) {
      $description = $options['description'];
    } else {
      $description = null;
    }
    if (isset($options['amount'])) {
      $amount = $options['amount'];
    } else {
      $amount = null;
    }


    if ($this->containsFee($family_fee_id) == false) {
      $q = "INSERT INTO tsm_reg_families_invoice_fees (family_id,description,amount,family_fee_id,family_invoice_id)
      VALUES('".$this->info['family_id']."','".$description."','".$amount."','$family_fee_id','".$this->invoiceId."')";
      $this->db->runQuery($q);

      return true;
    } else {
      return false;
    }
  }

  public function getPayments() {
    $q = "SELECT * FROM tsm_reg_families_invoice_payments WHERE family_invoice_id = '".$this->invoiceId."'";
    $r = $this->db->runQuery($q);
    $payments = null;
    while ($a = mysql_fetch_assoc($r)) {
      $payments[$a['invoice_payment_id']] = $a;
    }

    return $payments;
  }

  public function getFees() {
    //$q = "SELECT invf.*, ff.fee_id, ff.name FROM tsm_reg_families_invoice_fees invf, tsm_reg_families_fees ff WHERE ff.family_fee_id = invf.family_fee_id AND invf.family_invoice_id = '".$this->invoiceId."'";
    $q = "SELECT invf.*, ff.fee_id, ff.name FROM tsm_reg_families_invoice_fees invf, tsm_reg_families_fees ff WHERE ff.family_fee_id = invf.family_fee_id AND invf.family_invoice_id = '".$this->invoiceId."'";

    $r = $this->db->runQuery($q);
    $returnFees = null;
    while ($a = mysql_fetch_assoc($r)) {
      $returnFees[] = $a;
    }

    return $returnFees;
  }

  public function addToQuickbooks() {
    global $quickbooks;

    $campus = new TSM_REGISTRATION_CAMPUS($this->getCurrentCampusId());
    $campusInfo = $campus->getInfo();

    $doNotProcess = false;
    $family = new TSM_REGISTRATION_FAMILY($this->info['family_id']);
    $quickbooks_customer_id = $family->getQuickbooksCustomerId();
    $invoiceTotal = $this->getTotal();

    if ($this->info['quickbooks_invoice_id'] != "") {
      $doNotProcess = true;
    }

    $fees = $this->getFees();

    $invoiceHeader = new QuickBooks_IPP_Object_Header();
    $invoiceHeader->setCustomerId($quickbooks_customer_id);

    if ($invoiceTotal > 0) {
      $quickbooksInvoice = new QuickBooks_IPP_Object_Invoice();
      $quickbooksInvoice->addHeader($invoiceHeader);
    } elseif ($invoiceTotal < 0) {
      $quickbooksInvoice = new QuickBooks_IPP_Object_CreditMemo();
      $creditMemoTotal = $invoiceTotal * -1;
      $invoiceHeader->setTotalAmt($creditMemoTotal);
      $invoiceHeader->setARAccountName("Accounts Receivable");
      $quickbooksInvoice->addHeader($invoiceHeader);
    }

    /*
    if(isset($fees)){
      foreach ($fees as $fee) {
        $feeObject = new TSM_REGISTRATION_FEE($fee['fee_id']);
        if (isset($fee['fee_id'])) {
          $feeInfo = $feeObject->getInfo();
        }


        if (!isset($feeInfo['quickbooks_item_id'])) {
          $doNotProcess = true;
        }


      }
    }
    */

    if (!$doNotProcess) {
      if (isset($fees)) {
        foreach ($fees as $fee) {
          if (isset($fee['fee_id'])) {
            $feeObject = new TSM_REGISTRATION_FEE($fee['fee_id']);
            $feeInfo = $feeObject->getInfo();

            $Line = new QuickBooks_IPP_Object_Line();
            $Line->setItemId($feeInfo['quickbooks_item_id']);

            //we need to make the negative charge positive if this is a credit to their account.
            if ($invoiceTotal > 0) {
              $Line->setAmount($fee['amount']);
            } else {
              $Line->setAmount($fee['amount'] * -1);
            }

            $Line->setDescription($fee['name']);
            $Line->setQty(1);
            $quickbooksInvoice->addLine($Line);
          } else {
            $Line = new QuickBooks_IPP_Object_Line();
            $Line->setAmount($fee['amount']);
            $Line->setDescription($fee['name']);
            $Line->setQty(1);
            $quickbooksInvoice->addLine($Line);
          }
        }
      }

      if ($invoiceTotal > 0) {
        $service = new QuickBooks_IPP_Service_Invoice();
      } elseif ($invoiceTotal < 0) {

        /*
        $Line = new QuickBooks_IPP_Object_Line();
        $Line->setAmount($creditMemoTotal);
        $Line->setDesc("Tuition Installment");
        $Line->setItemId("{QB-398}");
        $Line->setQty(1);
        $quickbooksInvoice->addLine($Line);
        */

        $service = new QuickBooks_IPP_Service_CreditMemo();
      }

      $quickbooks_id = $service->add($quickbooks->Context, $quickbooks->creds['qb_realm'], $quickbooksInvoice);
      if ($quickbooks_id == null) {
        die($service->lastResponse()."<br /><br />".$service->lastRequest());
      }
      echo "Setting Quickbooks ID: ".$quickbooks_id."...";
      $this->setQuickbooksId($quickbooks_id);
      echo "set!";
      $invoice = $service->findById($quickbooks->Context, $quickbooks->creds['qb_realm'], $quickbooks_id);

      $payments = $this->getPayments();
      if (isset($payments)) {
        $txnId = $invoice->getExternalKey();
        foreach ($payments as $payment) {
          $paymentObject = new QuickBooks_IPP_Object_Payment();
          $paymentHeader = new QuickBooks_IPP_Object_Header();
          $paymentHeader->setCustomerId($quickbooks_customer_id);
          $paymentHeader->setTotalAmt($payment['amount']);
          $paymentHeader->setDocNumber($payment['paypal_transaction_id']);
          $paymentHeader->setPaymentMethodId($campusInfo['qb_paypal_payment_method_id']);
          $paymentObject->addHeader($paymentHeader);
          $Line = new QuickBooks_IPP_Object_Line();
          $Line->setTxnId($txnId);
          $Line->setAmount($payment['amount']);
          $paymentObject->addLine($Line);
          $service = new QuickBooks_IPP_Service_Payment();
          $quickbooks_payment_id = $service->add($quickbooks->Context, $quickbooks->creds['qb_realm'], $paymentObject);
          //todo: create payment object and add the quickbooks_payment_id to the payment

        }
      }

      return true;
    } else {
      die("doNotProcess");
      return false;
    }
  }

  public function setQuickbooksId($id) {
    $q = "UPDATE tsm_reg_families_invoices SET quickbooks_invoice_id = '".$id."' WHERE family_invoice_id = '".$this->invoiceId."'";
    $this->db->runQuery($q);

    return true;
  }

  public function getTotal() {
    $q = "SELECT amount FROM tsm_reg_families_invoices WHERE family_invoice_id = '".$this->invoiceId."'";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $total = $a['amount'];
    }

    return $total;
  }

  public function getAmountPaid() {
    $q = "SELECT * FROM tsm_reg_families_invoice_payments WHERE family_invoice_id = '".$this->invoiceId."'";
    $r = $this->db->runQuery($q);
    $amountPaid = 0;
    while ($a = mysql_fetch_assoc($r)) {
      $amountPaid = $amountPaid + $a['amount'];
    }

    return $amountPaid;
  }

  public function getAmountDue() {
    $q = "SELECT * FROM tsm_reg_families_invoice_payments WHERE family_invoice_id = '".$this->invoiceId."'";
    $r = $this->db->runQuery($q);
    $amountDue = $this->getTotal();
    while ($a = mysql_fetch_assoc($r)) {
      $amountDue = $amountDue - $a['amount'];
    }

    return $amountDue;
  }

  public function updateTotal() {
    $q = "UPDATE tsm_reg_families_invoices SET amount = '".$this->addFees($this->getFees())."' WHERE family_invoice_id = '".$this->invoiceId."'";
    $this->db->runQuery($q);

    return true;
  }

}

?>