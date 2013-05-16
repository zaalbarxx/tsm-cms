<?php

$paymentPlan = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($familyPaymentPlanId);
$total = 0;
$fees = $paymentPlan->getUnassignedApplicableFees();
foreach($fees as $fee){
  if($fee['student_id'] != ""){
    $students[$fee['student_id']]['fees'][$fee['family_fee_id']] = $fee;
    $total = $total + $fee['amount'];
    if(!isset($students[$fee['student_id']]['object'])){
      $students[$fee['student_id']]['object'] = new TSM_REGISTRATION_STUDENT($fee['student_id']);
      $students[$fee['student_id']]['info'] = $students[$fee['student_id']]['object']->getInfo();
    }
  }
}