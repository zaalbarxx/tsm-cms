<?php
$paymentPlans = $family->getPaymentPlans(1);
$plan_to_process = null;
foreach ($paymentPlans as $family_payment_plan_id => $familyPaymentPlan) {
  if ($familyPaymentPlan['setup_complete'] == 0 && $plan_to_process == null) {
    $plan_to_process = $familyPaymentPlan;
  }
}

if ($plan_to_process == null) {
  $family->moveToStep(0);
  header("Location: index.php?com=registration");
}
$familyInfo = $family->getInfo();
$paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($plan_to_process['payment_plan_id']);
$planInfo = $paymentPlan->getInfo();
$planFeeTypes = $plan_to_process['fee_types'];
$invoices = $family->getInvoicesByPaymentPlan($plan_to_process['family_payment_plan_id']);
$firstInvoice = $invoices[0];
$campusInfo = $currentCampus->getInfo();


if (isset($setupComplete)) {
  $family->completePaymentPlanSetup($plan_to_process['family_payment_plan_id']);
}

$notify_url = urlencode("http://".$_SERVER['HTTP_HOST']."/api/paypal_ipn.php");
$return_url = urlencode("http://".$_SERVER['HTTP_HOST']."/index.php?com=registration&setupComplete=1");
$cancel_url = urlencode("http://".$_SERVER['HTTP_HOST']."/index.php?com=registration");
?>