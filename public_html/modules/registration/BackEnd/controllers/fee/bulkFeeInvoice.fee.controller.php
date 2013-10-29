<?php
$families = $currentCampus->getFamilies();
foreach($families as $family){
  $familyObject = new TSM_REGISTRATION_FAMILY($family['family_id']);
  if($familyObject->getInvoices() != null){
    $families[$family['family_id']]['finalized'] = " - Finalized";
  }
  //if($familyObject)
  $families[$family['family_id']]['fees'] = $familyObject->getFeesByFeeId($fee_id);
  if(isset($families[$family['family_id']]['fees'])){
    foreach($families[$family['family_id']]['fees'] as $key=>$fee){
      $feeObject = new TSM_REGISTRATION_FAMILY_FEE($fee['family_fee_id']);
      if($feeObject->isInvoiced() || $feeObject->isOnPaymentPlan()){
        unset($families[$family['family_id']]['fees'][$key]);
      }
    }
  }
  if(count($families[$family['family_id']]['fees']) == 0){
    unset($families[$family['family_id']]);
  } else {
    $families[$family['family_id']]['students'] = $familyObject->getStudents();
  }
}

?>