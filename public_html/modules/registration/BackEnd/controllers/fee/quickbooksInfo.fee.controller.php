<?php
if ($currentCampus->usesQuickbooks() == true) {
  if (isset($saveAll)) {

    foreach ($_POST as $key => $value) {

      if (stristr($key, 'quickbooks_item_id')) {
        $array = explode(":", $key);
        $fee_id = $array[1];
        $fee = new TSM_REGISTRATION_FEE($fee_id);
        $fee->setQuickBooksItemId($value);
      }
    }
  }

  $ItemService = new QuickBooks_IPP_Service_Item();
  $query = "
  <SortByColumn sortOrder=\"Ascending\">ItemName</SortByColumn>
";
  $quickbooksItems = $ItemService->findAll($quickbooks->Context, $quickbooks->creds['qb_realm'], $query, 1, 999);
  $quickbooksItems2 = null;
  foreach ($quickbooksItems as $item) {
    if ($item->get("Active") == "true") {
      $unitPrice = $item->getUnitPrice();
      if (isset($unitPrice)) {
        $price = $unitPrice->getAmount();
      }
      $id = $item->getId();
      $name = $item->getName();
      $quickbooksItems2[$id]['id'] = $id;
      $quickbooksItems2[$id]['price'] = $price;
      $quickbooksItems2[$id]['name'] = $name;
    }
  }
  $fees = $currentCampus->getFees();
  $pageTitle = "Edit Quickbooks Info";
} else {
  die("not available");
}
?>