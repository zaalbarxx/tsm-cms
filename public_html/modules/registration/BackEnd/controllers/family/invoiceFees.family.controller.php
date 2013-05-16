<?php
$family = new TSM_REGISTRATION_FAMILY($family_id);
$total = 0;
$fees = $family->getLooseFees();
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