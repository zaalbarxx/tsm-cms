<?php
$regPaymentPlans = $currentCampus->getPaymentPlans(2);
$tuitionPaymentPlans = $currentCampus->getPaymentPlans(1);

$tuitionTotal = $reg->addFees($family->getFees(1));
$registrationTotal = $reg->addFees($family->getFees(2));
?>