<?php
if(isset($createFee)){
  if($currentCampus->createFee()){
    header('Location: index.php?com=registration&view=fees');
  }
}
if(isset($saveFee)){
  if($currentCampus->saveFee($fee_id)){
    header('Location: index.php?com=registration&view=fees');
  }
}
if(isset($fee_id)){
    $fee = new TSM_REGISTRATION_FEE($fee_id);
    $feeInfo = $fee->getInfo();
    $pageTitle = "Edit Program";
    $submitField = "saveFee";
} else {
    $pageTitle = "Add Program";
    $submitField = "createFee";
    $feeInfo = null;
}
?>