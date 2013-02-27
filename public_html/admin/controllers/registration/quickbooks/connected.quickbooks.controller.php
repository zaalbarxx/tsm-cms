<?php
if (isset($saveQuickbooksStatus)) {
  $currentCampus->saveCampus();
  $message = "Your Quickbooks status has been successfully saved.";
}

$service = new QuickBooks_IPP_Service_PaymentMethod();
$paymentMethods = $service->findAll($quickbooks->Context, $quickbooks->creds['qb_realm']);
$campusInfo = $currentCampus->getInfo();

//$ItemService = new QuickBooks_IPP_Service_Item();
//$id = "{QB-459}";
//$allItems = $ItemService->findAll($quickbooks->Context,$quickbooks->creds['qb_realm']);

?>
