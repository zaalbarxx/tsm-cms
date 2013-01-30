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

$regPaymentPlans = $currentCampus->getPaymentPlans(2);
$tuitionPaymentPlans = $currentCampus->getPaymentPlans(1);

$tuitionTotal = $reg->addFees($family->getFees(1));
$registrationTotal = $reg->addFees($family->getFees(2));
?>