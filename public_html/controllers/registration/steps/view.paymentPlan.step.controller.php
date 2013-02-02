<?php
$pageTitle = "Payment Plan Information";
if (isset($fee_type_id)) {
  $paymentPlans = $currentCampus->getPaymentPlans($fee_type_id);
}
?>