<?php
$feeTypes = $currentCampus->getFeeTypes();
if (isset($payment_plan_id)) {
  $paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($payment_plan_id);
  $planInfo = $paymentPlan->getInfo();
  $pageTitle = "Edit Payment Plan";
  $formAction = "savePaymentPlan";
} else {
  $pageTitle = "Add Payment Plan";
  $formAction = "createPaymentPlan";
  $planInfo = null;
}
?>