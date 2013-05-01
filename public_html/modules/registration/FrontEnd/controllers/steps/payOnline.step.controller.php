<?php
$immediatePlans = $family->getPaymentPlans(1);
$partNowPartLaterPlans = $family->getPaymentPlans(4);
$paymentPlans = array_merge($immediatePlans, $partNowPartLaterPlans);
$plan_to_process = null;
foreach ($paymentPlans as $family_payment_plan_id => $familyPaymentPlan) {
  if ($familyPaymentPlan['setup_complete'] == 0 && $plan_to_process == null) {
    $plan_to_process = $familyPaymentPlan;
  }
}

if ($plan_to_process == null) {
  $family->moveToStep(0);
  header("Location: index.php?mod=registration");
}
$familyInfo = $family->getInfo();
$paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($plan_to_process['payment_plan_id']);
$planInfo = $paymentPlan->getInfo();
$planFeeTypes = $plan_to_process['fee_types'];
$invoices = $family->getInvoicesByPaymentPlan($plan_to_process['family_payment_plan_id']);
if ($plan_to_process['payment_plan_type_id'] == 1) {
  $firstInvoice = $invoices[0];
} else {
  $firstInvoice = $invoices[2];
}
$campusInfo = $currentCampus->getInfo();


if (isset($setupComplete)) {
  $family->completePaymentPlanSetup($plan_to_process['family_payment_plan_id']);
}

$notify_url = urlencode("http://".$_SERVER['HTTP_HOST']."/api/paypal_ipn.php");
$return_url = urlencode("http://".$_SERVER['HTTP_HOST']."/index.php?mod=registration&setupComplete=1");
$cancel_url = urlencode("http://".$_SERVER['HTTP_HOST']."/index.php?mod=registration");
?>