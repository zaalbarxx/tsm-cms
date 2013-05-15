<?php
$family = new TSM_REGISTRATION_FAMILY($family_id);
$familyInfo = $family->getInfo();


if (isset($linkToQuickbooks)) {
  if (isset($createNewCustomer)) {
    //todo: figure out how to link a family when they haven't been synced with quickbooks yet
    //$family->createQuickbooksInfo();
  } else {
    $family->setQuickbooksCustomerId($linkToQuickbooks);
    $family->updateQuickbooksInfo();
  }

  if ($family->inQuickbooks()) {
    $invoices = $family->getInvoices();
    if (isset($invoices)) {
      foreach ($invoices as $invoice) {
        $invoiceObject = new TSM_REGISTRATION_INVOICE($invoice['family_invoice_id']);
        $invoiceObject->addToQuickbooks();
      }
    }
    $payments = $family->getPayments();
    if (isset($payments)) {
      foreach ($payments as $payment) {
        $paymentObject = new TSM_REGISTRATION_PAYMENT($payment['family_payment_id']);
        $paymentObject->addToQuickbooks();
      }
    }
  }
  die("1");
}

if ($currentCampus->usesQuickbooks() == true) {
  $CustomerService = new QuickBooks_IPP_Service_Customer();
  $query = '<FirstLastInside>'.$familyInfo['father_last'].'</FirstLastInside>';
  $quickbooksCustomers = $CustomerService->findAll($quickbooks->Context, $quickbooks->creds['qb_realm'], $query, 1, 999);
  if ($quickbooksCustomers == null) {
    $query = '<FirstLastInside>'.$familyInfo['mother_last'].'</FirstLastInside>';
    $quickbooksCustomers = $CustomerService->findAll($quickbooks->Context, $quickbooks->creds['qb_realm'], $query, 1, 999);
  }
}
?>