<?php
if(isset($saveQuickbooksStatus)){
	$currentCampus->saveCampus();
	$message = "Your Quickbooks status has been successfully saved.";
}
$campusInfo = $currentCampus->getInfo();

//$ItemService = new QuickBooks_IPP_Service_Item();
//$id = "{QB-459}";
//$allItems = $ItemService->findAll($quickbooks->Context,$quickbooks->creds['qb_realm']);

?>
