<?php

$paymentPlan = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($familyPaymentPlanId);
$total = $paymentPlan->getTotal();
$fees = $paymentPlan->getFees();
foreach($fees as $fee){
  if($fee['student_id'] != ""){
    $students[$fee['student_id']]['fees'][$fee['family_fee_id']] = $fee;
    if(!isset($students[$fee['student_id']]['object'])){
      $students[$fee['student_id']]['object'] = new TSM_REGISTRATION_STUDENT($fee['student_id']);
      $students[$fee['student_id']]['info'] = $students[$fee['student_id']]['object']->getInfo();
    }
  }
}