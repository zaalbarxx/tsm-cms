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
  header("Location: index.php?com=registration");
}

$paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($plan_to_process['payment_plan_id']);
$planInfo = $paymentPlan->getInfo();
$invoice = new TSM_REGISTRATION_INVOICE($invoice_id);
$firstInvoice = $invoice->getInfo();
$campusInfo = $currentCampus->getInfo();

if (isset($setupComplete)) {
  $family->completePaymentPlanSetup($plan_to_process['family_payment_plan_id']);
  header("Location: index.php?com=registration");
}
?>