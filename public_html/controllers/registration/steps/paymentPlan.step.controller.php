<?php
if (isset($savePaymentPlans)) {
  if ($family->savePaymentPlans()) {
    $family->moveToNextStep();
    header("Location: index.php?com=registration");
  } else {
    $errorMessage = "There was a problem adding your payment plans. Please make sure you have selected a payment plan for each fee type.";
  }


}

if (isset($backToReview)) {
  $family->moveToStep(4);
  header("Location: index.php?com=registration");
}

$feeTypes = $currentCampus->getFeeTypes();
if (isset($feeTypes)) {
  foreach ($feeTypes as $feeType) {
    $feeTypes[$feeType['fee_type_id']]['payment_plans'] = $currentCampus->getPaymentPlans($feeType['fee_type_id']);

    $feeTypes[$feeType['fee_type_id']]['total_amount'] = $reg->addFees($family->getFees($feeType['fee_type_id']));
  }
}
?>