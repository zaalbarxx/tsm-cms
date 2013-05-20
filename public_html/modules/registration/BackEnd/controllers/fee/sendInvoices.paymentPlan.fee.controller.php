<?php
$paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($payment_plan_id);
$emailSubject = $paymentPlan->getInvoiceEmailSubject();
$emailContents = $paymentPlan->getInvoiceEmail();
$invoices = $paymentPlan->getInvoices();
if(isset($invoices)){
  foreach($invoices as $invoice){
    $invoiceObject = new TSM_REGISTRATION_INVOICE($invoice['family_invoice_id']);
    if($invoiceObject->getAmountDue() > 0){
      $invoiceObjects[$invoice['family_invoice_id']] = $invoiceObject;
      $invoiceInfos[$invoice['family_invoice_id']] = $invoiceObject->getInfo();
      if(!isset($familyObjects[$invoice['family_id']])){
        $familyObjects[$invoice['family_id']] = new TSM_REGISTRATION_FAMILY($invoice['family_id']);
      }
    }
  }
}
?>