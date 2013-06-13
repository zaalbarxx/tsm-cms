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
    $q = "SELECT COUNT(family_invoice_id) AS num_invoices
    FROM tsm_reg_families_invoices
    WHERE family_payment_plan_id = '".$this->familyPaymentPlanId."'";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $numInvoices = $a['num_invoices'];
    }

    return $numInvoices;
  }

  public function getLastInvoice(){
    $q = "SELECT * FROM tsm_reg_families_invoices
    WHERE family_payment_plan_id = '".$this->familyPaymentPlanId."'
    AND invoice_and_credit = 0
    ORDER BY family_invoice_id DESC LIMIT 1";
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

  public function getOriginalInvoiceId(){
    $paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($this->info['payment_plan_id']);
    $paymentPlanInfo = $paymentPlan->getInfo();

    if($paymentPlanInfo['invoice_and_credit'] == 1){
      $q = "SELECT * FROM tsm_reg_families_invoices WHERE family_payment_plan_id = '".$this->familyPaymentPlanId."' AND invoice_and_credit = 1 AND amount > 0";
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $invoice_id = $a['family_invoice_id'];
      }
    } else {
      $invoice_id = false;
    }

    return $invoice_id;
  }

  public function getCreditInvoiceId(){
    if($this->info['invoice_and_credit'] == 1){
      $q = "SELECT * FROM tsm_reg_families_invoices WHERE family_payment_plan_id = '".$this->familyPaymentPlanId."' AND invoice_and_credit = 1 AND amount < 0";
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $invoice_id = $a['family_invoice_id'];
      }

      return $invoice_id;
    } else {
      return false;
    }
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
        $familyFee = new TSM_REGISTRATION_FAMILY_FEE($a['family_fee_id']);
        if(!$familyFee->isInvoiced()){
          $fees[$a['family_fee_id']] = $a;
        }
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

  public function getAmountInvoiced(){
    global $reg;

    $campus = new TSM_REGISTRATION_CAMPUS($this->getCurrentCampusId());
    $campusInfo = $campus->getInfo();

    $invoices = $this->getInvoices();
    if(isset($invoices)){
      foreach($invoices as $invoice){
        $invoiceObject = new TSM_REGISTRATION_INVOICE($invoice['family_invoice_id']);
        $fees = $invoiceObject->getFees();
        if(isset($fees)){
          foreach($fees as $fee){
            if($fee['fee_id'] != $campusInfo['paypal_convenience_fee_id']){
              $paymentPlanFees[] = $fee;
            }
          }
        }
      }
    }
    if(isset($paymentPlanFees)){
      $total = $reg->addFees($paymentPlanFees);
    } else {
      $total = 0;
    }

    return $total;
  }

  public function getAmountPaid(){
    $campus = new TSM_REGISTRATION_CAMPUS($this->getCurrentCampusId());
    $campusInfo = $campus->getInfo();

    $amountPaid = 0;
    $invoices = $this->getInvoices();
    if(isset($invoices)){
      foreach($invoices as $invoice){
        $invoiceObject = new TSM_REGISTRATION_INVOICE($invoice['family_invoice_id']);
        $invoiceFees = $invoiceObject->getFees();
        $amtToSubtract = 0;
        if(isset($invoiceFees)){
          foreach($invoiceFees as $fee){
            if($fee['fee_id'] == $campusInfo['paypal_convenience_fee_id']){
              $amtToSubtract = $amtToSubtract + $fee['amount'];
            }
          }
        }
        $invoiceAmtPaid = $invoiceObject->getAmountPaid();
        if($invoiceAmtPaid > 0){
          $invoiceAmtPaid = $invoiceObject->getAmountPaid() - $amtToSubtract;
        }
        $amountPaid = $amountPaid + $invoiceAmtPaid;
      }
    }

    return $amountPaid;
  }

  public function invoicePercentage(){
    $percentage = $this->info['immediate_invoice_percentage'];
    $percentage = $percentage / 100;
    $paymentPlanTotal = $this->getTotal();
    $invoiceAmount = $paymentPlanTotal * $percentage;
    $invoice = $this->invoiceInstallment($invoiceAmount);

    return $invoice;
  }

  public function invoiceInstallment($invoiceAmount = null){
    $family = new TSM_REGISTRATION_FAMILY($this->info['family_id']);
    $familyInfo = $family->getInfo();
    $paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($this->info['payment_plan_id']);
    $paymentPlan = $paymentPlan->getInfo();
    $installmentFee = new TSM_REGISTRATION_FEE($paymentPlan['installment_fee_id']);
    $installmentFee = $installmentFee->getInfo();

    $numInvoices = $this->getNumInvoices();
    if($this->info['invoice_and_credit'] == 1){
      $numInvoices = $numInvoices - 2;
    }

    //if we're invoicing a percentage up front and then invoicing installments, we need to modify the number of invoices to be +1;
    if($paymentPlan['payment_plan_type_id'] == 4){
      $paymentPlan['num_invoices']++;
    }

    $totalInvoiced = $this->getAmountInvoiced();
    $totalAmount = $this->getTotal();
    $totalRemaining = $totalAmount - $totalInvoiced;
    $numInvoicesRemaining = $paymentPlan['num_invoices'] - $numInvoices;
    if($invoiceAmount == null){
      $invoiceTotal = $totalRemaining / $numInvoicesRemaining;
    } else {
      $invoiceTotal = $invoiceAmount;
    }
    $invoiceNumber = $numInvoices+1;
    $installmentFeeId = $family->addFee($paymentPlan['installment_fee_description'],$invoiceTotal,$installmentFee['fee_id'],$installmentFee['fee_type_id']);
    $familyFee = new TSM_REGISTRATION_FAMILY_FEE($installmentFeeId);
    $familyFee->setPaymentPlan($this->familyPaymentPlanId);


    //SET DUE DATE TO BE THE 1ST OF NEXT MONTH
    $dueDate = date("Y-m-d");
    $dueDate = new DateTime($dueDate);
    $dueDate = $dueDate->add(date_interval_create_from_date_string('1 month'));
    $dueDate = date_format($dueDate,'Y-m-1');

    $invoiceId = $family->createInvoice($this->familyPaymentPlanId,$paymentPlan['installment_invoice_description']." - (".$invoiceNumber." of ".$paymentPlan['num_invoices'].")",$dueDate);

    $familyInvoice = new TSM_REGISTRATION_INVOICE($invoiceId);
    $params = Array("family_fee_id"=>$installmentFeeId,"description"=>$paymentPlan['installment_fee_description'],"amount"=>$invoiceTotal);
    $familyInvoice->addFee($params);
    $familyInvoice->updateTotal();

    $currentCampus = new TSM_REGISTRATION_CAMPUS($familyInfo['campus_id']);
    if($currentCampus->usesQuickbooks() && $family->inQuickbooks()){
      $familyInvoice->addToQuickbooks();
    }

    return $familyInvoice;
  }

  public function invoiceAndCredit(){
    $family = new TSM_REGISTRATION_FAMILY($this->info['family_id']);
    $familyInfo = $family->getInfo();
    $paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($this->info['payment_plan_id']);
    $paymentPlanInfo = $paymentPlan->getInfo();

    $invoiceFull = $this->invoiceFull();
    $planTotal = $this->getTotal();

    $creditFee = new TSM_REGISTRATION_FEE($paymentPlanInfo['credit_fee_id']);
    $creditFeeInfo = $creditFee->getInfo();
    $creditFeeAmount = -$planTotal;

    //Credit intial invoice back to account so we can bill in installments.
    $credit_invoice_id = $family->createInvoice($this->familyPaymentPlanId,$paymentPlanInfo['credit_invoice_description']);
    $family_fee_id = $family->addFee($paymentPlanInfo['credit_fee_description'], $creditFeeAmount, $paymentPlanInfo['credit_fee_id'], $creditFeeInfo['fee_type_id']);
    $familyFee = new TSM_REGISTRATION_FAMILY_FEE($family_fee_id);
    $familyFee->setPaymentPlan($this->familyPaymentPlanId);
    $invoiceCredit = new TSM_REGISTRATION_INVOICE($credit_invoice_id);
    $invoiceCredit->addFee(Array("family_fee_id" => $family_fee_id, "description" => $paymentPlanInfo['credit_fee_description'], "amount" => $creditFeeAmount));
    $invoiceCredit->updateTotal();
    $invoiceCredit->hide();
    $invoiceCredit->setInvoiceAndCredit(true);

    $currentCampus = new TSM_REGISTRATION_CAMPUS($familyInfo['campus_id']);
    if($currentCampus->usesQuickbooks() && $family->inQuickbooks()){
      $invoiceCredit->addToQuickbooks();
    }
    $return = Array("invoice_full"=>$invoiceFull,"invoice_credit"=>$invoiceCredit);

    return $return;
  }

  public function invoiceSpecificFees($feesToInvoice,$description = null,$dueDate = null){
    $family = new TSM_REGISTRATION_FAMILY($this->info['family_id']);
    $familyInfo = $family->getInfo();
    $paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($this->info['payment_plan_id']);
    $paymentPlanInfo = $paymentPlan->getInfo();
    if($description == null){
      $description = $paymentPlanInfo['name'];
    }

    $invoice_id = $family->createInvoice($this->familyPaymentPlanId,$description);
    $invoice = new TSM_REGISTRATION_INVOICE($invoice_id);

    if(isset($feesToInvoice)){
      foreach ($feesToInvoice as $family_fee_id) {
        $familyFee = new TSM_REGISTRATION_FAMILY_FEE($family_fee_id);
        $familyFee->setPaymentPlan($this->familyPaymentPlanId);
        //$feeObject = new TSM_REGISTRATION_FEE($fee['fee_id']);
        $familyFeeInfo = $familyFee->getInfo();
        $invoice->addFee(Array("family_fee_id" => $family_fee_id, "description" => $familyFeeInfo['name'], "amount" => $familyFeeInfo['amount']));
      }
    }
    $invoice->updateTotal();

    $currentCampus = new TSM_REGISTRATION_CAMPUS($familyInfo['campus_id']);
    if($currentCampus->usesQuickbooks() && $family->inQuickbooks()){
      $invoice->addToQuickbooks();
    }

    return $invoice;
  }

  public function invoiceFull(){
    $family = new TSM_REGISTRATION_FAMILY($this->info['family_id']);
    $familyInfo = $family->getInfo();
    $paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($this->info['payment_plan_id']);
    $paymentPlanInfo = $paymentPlan->getInfo();

    $invoice_id = $family->createInvoice($this->familyPaymentPlanId,$paymentPlanInfo['full_invoice_description']);
    $invoice = new TSM_REGISTRATION_INVOICE($invoice_id);


    $fees = $this->getFees();
    if(isset($fees)){
      foreach ($fees as $fee) {
        $familyFee = new TSM_REGISTRATION_FAMILY_FEE($fee['family_fee_id']);
        $familyFee->setPaymentPlan($this->familyPaymentPlanId);
        //$feeObject = new TSM_REGISTRATION_FEE($fee['fee_id']);
        $familyFeeInfo = $familyFee->getInfo();
        $invoice->addFee(Array("family_fee_id" => $fee['family_fee_id'], "description" => $familyFeeInfo['name'], "amount" => $familyFeeInfo['amount']));
      }
    }
    $invoice->updateTotal();
    if($paymentPlanInfo['invoice_and_credit'] == 1){
      $invoice->hide();
      $invoice->setInvoiceAndCredit(true);
    }

    $currentCampus = new TSM_REGISTRATION_CAMPUS($familyInfo['campus_id']);
    if($currentCampus->usesQuickbooks() && $family->inQuickbooks()){
      $invoice->addToQuickbooks();
    }

    return $invoice;
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
    //todo: need to see if we're supposed to invoice then credit this invoice and handle that somehow
    $this->completeSetup();

    return true;
  }

}

?>