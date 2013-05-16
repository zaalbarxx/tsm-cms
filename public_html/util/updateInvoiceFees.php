<?php
ini_set('max_execution_time', 0);
error_reporting(E_ALL ^ E_STRICT);
ini_set('display_errors', '1');
//REQUIRE THE CONFIG FILE
require_once('../tsm_config.php');
//REQUIRE THE CORE CLASSES
require_once(__TSM_ROOT__.'tsm_core.php');
//INSTANTIATE THE TSM CLASS
$tsm = TSM::getInstance();
//START SAFE GLOBAL VARIABLES
extract($tsm->makeArraySafe($_REQUEST), EXTR_OVERWRITE);
//INSTANTIATE THE DB CONNECTION
require_once(__TSM_ROOT__.'tsm_db_conn.php');

require_once(__TSM_ROOT__."models/registration/tsm_registration.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_campus.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_program.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_course.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_fee.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_family.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_invoice.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_payment.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_family_fee.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_student.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_teacher.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_requirement.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_period.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_fee_condition.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_payment_plan.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_quickbooks.model.php");

$campuses = Array(1, 2, 8, 9, 10);


foreach ($campuses as $campus_id) {

  //INSTANTIATE THE REGISRATION CLASS
  $reg = new TSM_REGISTRATION();
  $reg->setCurrentCampusId($campus_id);
  $reg->setSelectedSchoolYear(2013);

  $currentCampus = new TSM_REGISTRATION_CAMPUS($campus_id);
  $campusInfo = $currentCampus->getInfo();

  $q = "SELECT fif.*, feepp.payment_plan_id, fpp.family_payment_plan_id
  FROM tsm_reg_families_invoice_fees fif, tsm_reg_families_invoices famin,
  tsm_reg_families f, tsm_reg_families_payment_plans fpp,
  tsm_reg_fee_payment_plans feepp
  WHERE fif.family_fee_id = 0
  AND famin.family_invoice_id = fif.family_invoice_id
  AND fpp.family_payment_plan_id = famin.family_payment_plan_id
  AND fpp.payment_plan_id = feepp.payment_plan_id
  AND fif.family_id = f.family_id
  AND f.campus_id = $campus_id";
  $r = $tsm->db->runQuery($q);
  while ($a = mysql_fetch_assoc($r)) {
    $paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($a['payment_plan_id']);
    $paymentPlanInfo = $paymentPlan->getInfo();

    $family = new TSM_REGISTRATION_FAMILY($a['family_id']);
    if ($a['description'] == "Offset annual tuition to invoice according to payment plan selected.") {
      $name = $paymentPlanInfo['credit_fee_description'];
      $fee_id = $paymentPlanInfo['credit_fee_id'];
    } elseif (($a['description'] == "50% of Payment Plan Total") or ($a['description'] == "10% of Payment Plan Total")) {
      $name = $paymentPlanInfo['installment_fee_description'];
      $fee_id = $paymentPlanInfo['installment_fee_id'];
    } else {
      $name = null;
    }

    if ($name != null) {
      $fee = new TSM_REGISTRATION_FEE($fee_id);
      $feeInfo = $fee->getInfo();
      $fee_type_id = $feeInfo['fee_type_id'];
      $family_fee_id = $family->addFee($name, $a['amount'], $fee_id, $fee_type_id);

      $familyFee = new TSM_REGISTRATION_FAMILY_FEE($family_fee_id);
      $familyFee->setPaymentPlan($a['family_payment_plan_id']);

      $q = "UPDATE tsm_reg_families_invoice_fees SET family_fee_id = '$family_fee_id', description = '$name' WHERE family_invoice_fee_id = '".$a['family_invoice_fee_id']."'";
      $tsm->db->runQuery($q);
    }
  }

  $q = "SELECT * FROM tsm_reg_families_fees ff, tsm_reg_families f
  WHERE ff.name LIKE '%PayPal Convenience Fee%'
  AND (ff.fee_id IS NULL OR ff.fee_id = 0)
  AND ff.family_id = f.family_id
  AND f.campus_id = '$campus_id'";
  $r = $tsm->db->runQuery($q);

  $paypal_convenience_fee_id = $campusInfo['paypal_convenience_fee_id'];
  $paypalFee = new TSM_REGISTRATION_FEE($paypal_convenience_fee_id);
  $paypalFeeInfo = $paypalFee->getInfo();
  $paypal_fee_type_id = $paypalFeeInfo['fee_type_id'];

  while ($a = mysql_fetch_assoc($r)) {
    $q = "UPDATE tsm_reg_families_fees
    SET fee_id = $paypal_convenience_fee_id, fee_type_id = $paypal_fee_type_id
    WHERE family_fee_id = '".$a['family_fee_id']."'";
    //echo $q; die();
    $tsm->db->runQuery($q);
  }

}

?>