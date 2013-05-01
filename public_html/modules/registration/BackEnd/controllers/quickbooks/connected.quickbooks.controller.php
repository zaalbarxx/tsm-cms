<?php
if (isset($saveQuickbooksStatus)) {
  $currentCampus->saveCampus();
  $message = "Your Quickbooks status has been successfully saved.";
}
$query = null;
$service = new QuickBooks_IPP_Service_PaymentMethod();
$paymentMethods = $service->findAll($quickbooks->Context, $quickbooks->creds['qb_realm'],$query);
$service = new QuickBooks_IPP_Service_Account();
$quickbooksAccounts = $service->findAll($quickbooks->Context, $quickbooks->creds['qb_realm'],$query);
$campusInfo = $currentCampus->getInfo();
$service = new QuickBooks_IPP_Service_Class();
$quickbooksClasses = $service->findAll($quickbooks->Context, $quickbooks->creds['qb_realm'],$query);

//$ItemService = new QuickBooks_IPP_Service_Item();
//$id = "{QB-459}";
//$allItems = $ItemService->findAll($quickbooks->Context,$quickbooks->creds['qb_realm']);

?>
