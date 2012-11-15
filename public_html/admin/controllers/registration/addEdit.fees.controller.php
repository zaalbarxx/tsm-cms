<?php
if(isset($createFee)){

}
if(isset($fee_id)){
    $fee = new TSM_REGISTRATION_FEE($fee_id);
    $feeInfo = $fee->getInfo();
    $pageTitle = "Edit Fee";
    $formAction = "saveFee";
} else {
    $pageTitle = "Add Fee";
    $formAction = "createFee";
    $feeInfo = null;
}
?>