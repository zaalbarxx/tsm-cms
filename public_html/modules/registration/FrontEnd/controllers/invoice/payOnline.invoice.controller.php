<?php
$familyInfo = $family->getInfo();
$invoice = new TSM_REGISTRATION_INVOICE($family_invoice_id);
$firstInvoice = $invoice->getInfo();
$campusInfo = $currentCampus->getInfo();


if (isset($setupComplete)) {
  $family->completePaymentPlanSetup($plan_to_process['family_payment_plan_id']);
}

$notify_url = urlencode("http://".$_SERVER['HTTP_HOST']."/api/paypal_ipn.php");
$return_url = urlencode("http://".$_SERVER['HTTP_HOST']."/index.php?com=registration&setupComplete=1");
$cancel_url = urlencode("http://".$_SERVER['HTTP_HOST']."/index.php?com=registration");
?>