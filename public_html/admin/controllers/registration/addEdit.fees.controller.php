<?php
if (isset($createFee)) {

}
if (isset($fee_id)) {
  $fee = new TSM_REGISTRATION_FEE($fee_id);
  $feeInfo = $fee->getInfo();
  $pageTitle = "Edit Fee";
  $formAction = "saveFee";
} else {
  $pageTitle = "Add Fee";
  $formAction = "createFee";
  $feeInfo = null;
}
$feeTypes = $reg->getFeeTypes();

if ($currentCampus->usesQuickbooks() == true) {
  $ItemService = new QuickBooks_IPP_Service_Item();
  //$id = "{QB-459}";
  $query = "
  <SortByColumn sortOrder=\"Ascending\">ItemName</SortByColumn>
";
  $quickbooksItems = $ItemService->findAll($quickbooks->Context, $quickbooks->creds['qb_realm'], $query, 1, 999);
}

?>