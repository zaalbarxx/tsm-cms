<?php
if (isset($savePaymentPlans)) {
  $family->savePaymentPlans();
  $family->moveToNextStep();
  header("Location: index.php?com=registration");
}

$regPaymentPlans = $currentCampus->getPaymentPlans(2);
$tuitionPaymentPlans = $currentCampus->getPaymentPlans(1);

$tuitionTotal = $reg->addFees($family->getFees(1));
$registrationTotal = $reg->addFees($family->getFees(2));
?>