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
    $q = "SELECT * FROM tsm_reg_families_invoice_fees WHERE family_fee_id = '".$this->familyFeeId."' AND soft_delete=FALSE";
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function getInvoiceId(){
    $q = "SELECT * FROM tsm_reg_families_invoice_fees WHERE family_fee_id = '".$this->familyFeeId."'";
    $r = $this->db->runQuery($q);
    while($a = mysql_fetch_assoc($r)){
      $invoice_id = $a['family_invoice_id'];
    }

    return $invoice_id;
  }

  public function setPaymentPlan($family_payment_plan_id) {
    //if ($this->getPaymentPlan() == null) {
      $q = "UPDATE tsm_reg_families_fees SET family_payment_plan_id = ".$family_payment_plan_id." WHERE family_fee_id = '".$this->familyFeeId."'";
      $this->db->runQuery($q);
      $this->info['family_payment_plan_id'] = "";

      return true;
    //} else {
    //  return false;
    //}

  }

  public function getPaymentPlan() {
    return $this->info['family_payment_plan_id'];
  }

  public function isOnPaymentPlan(){
    if($this->getPaymentPlan() != ""){
      return true;
    } else {
      return false;
    }
  }

  public function isRemovable(){
    if($this->info['removable'] == true){
      return true;
    } else {
      return false;
    }
  }

  public function setRemovable($set){
    $q = "UPDATE tsm_reg_families_fees SET removable = '$set' WHERE family_fee_id = '".$this->familyFeeId."'";
    $this->db->runQuery($q);
    $this->info['removable'] = $set;

    return true;
  }

  public function setToReview($set){
    $q = "UPDATE tsm_reg_families_fees SET to_review = '$set' WHERE family_fee_id = '".$this->familyFeeId."'";
    $this->db->runQuery($q);
    $this->info['to_review'] = $set;


    return true;
  }

  public function getIsUnderReview(){
    return $this->info['to_review'];
  }

  public function updateAmount($amount){
    $q = "UPDATE tsm_reg_families_fees SET amount = '$amount' WHERE family_fee_id = '".$this->familyFeeId."'";
    $this->db->runQuery($q);

    return true;
  }

  public function delete() {
    if ($this->isInvoiced() == false && $this->isOnPaymentPlan() == false && $this->isRemovable() == true && $this->getIsUnderReview() == false) {
      $q = "DELETE FROM tsm_reg_families_fees WHERE family_fee_id = '".$this->familyFeeId."'";
      $this->db->runQuery($q);

      $q = "INSERT INTO tsm_reg_families_fee_log (family_id,student_id,family_fee_id,fee_id,program_id,course_id,amount,fee_name) VALUES('".$this->info['family_id']."','".$this->info['fee_id']."','".$this->info['family_fee_id']."','".$this->info['fee_id']."','".$this->info['program_id']."','".$this->info['course_id']."','".$this->info['amount']."','".$this->info['name']."')";
      $this->db->runQuery($q);

      return true;
    } else {
      return false;
    }
  }

}

?>