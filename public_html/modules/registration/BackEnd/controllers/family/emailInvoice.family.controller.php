<?php
$invoice = new TSM_REGISTRATION_INVOICE($family_invoice_id);
$invoiceInfo = $invoice->getInfo();
$family = new TSM_REGISTRATION_FAMILY($invoiceInfo['family_id']);
$familyInfo = $family->getInfo();
if($invoiceInfo['family_payment_plan_id'] != ""){
  $familyPaymentPlan = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($invoiceInfo['family_payment_plan_id']);
  $familyPaymentPlanInfo = $familyPaymentPlan->getInfo();
  $paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($familyPaymentPlanInfo['payment_plan_id']);
  $paymentPlanInfo = $paymentPlan->getInfo();

  $emailContents = $paymentPlanInfo['invoice_email'];
  if(!isset($emailContents)){
    $emailContents = "{{name}},<br /><br />";
  }
  $emailSubject = $paymentPlanInfo['invoice_email_subject'];
} else {
  $emailContents = "";
  $emailSubject = "";
}
?>