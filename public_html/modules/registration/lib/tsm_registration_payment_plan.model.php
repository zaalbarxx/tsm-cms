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

  public function getInvoiceEmail(){
    return html_entity_decode($this->info['invoice_email']);
  }

  public function getInvoiceEmailSubject(){
    return $this->info['invoice_email_subject'];
  }

	public function getRequiredNumInvoiceToDate(){
		$d1 = new DateTime($this->info['start_date']);
		$d2 = new DateTime();
		$d3 = $d1->diff($d2);
		$months = ($d3->y*12)+$d3->m;
		if($d3->d > 0){
			$months++;
		}

		$numInvoicesNeeded = $months / $this->info['invoice_frequency'];
		$numInvoicesNeeded = ceil($numInvoicesNeeded);
		$totalNumInvoicesNeeded = $this->info['num_invoices'];
		if($this->info['payment_plan_type_id'] == 4){
			$totalNumInvoicesNeeded++;
			$numInvoicesNeeded++;
		}
		if($numInvoicesNeeded > $totalNumInvoicesNeeded){
			$numInvoicesNeeded = $totalNumInvoicesNeeded;
		}

		return $numInvoicesNeeded;
	}

  public function getInvoices(){
    $q = "SELECT * FROM tsm_reg_families_invoices fi, tsm_reg_families_payment_plans fpp, tsm_reg_families f
    WHERE fpp.family_payment_plan_id = fi.family_payment_plan_id
    AND fi.family_id = f.family_id
    AND fpp.payment_plan_id = '".$this->info['payment_plan_id']."'
    AND fi.displayed = 1";
    $r = $this->db->runQuery($q);
    while($a = mysql_fetch_assoc($r)){
      $invoices[$a['family_invoice_id']] = $a;
    }

    return $invoices;
  }

  public function getFamilyPaymentPlans(){
    $q = "SELECT * FROM tsm_reg_families f, tsm_reg_families_payment_plans fpp
    WHERE f.family_id = fpp.family_id
    AND fpp.payment_plan_id = '".$this->paymentPlanId."'";
    $r = $this->db->runQuery($q);
    while($a = mysql_fetch_assoc($r)){
      $familyPaymentPlans[$a['family_payment_plan_id']] = $a;
    }

    return $familyPaymentPlans;
  }

}

?>