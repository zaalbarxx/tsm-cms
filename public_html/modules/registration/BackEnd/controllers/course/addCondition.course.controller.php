<?php
$course = new TSM_REGISTRATION_COURSE($course_id);
$fee = new TSM_REGISTRATION_FEE($fee_id);

if (!isset($searchq)) {
  $searchq = null;
}

if (!isset($program_id)) {
  $program_id = null;
}

if (isset($addCondition)) {
  if ($course->addFeeCondition($addCondition, $fee_id, $program_id)) {
    die("1");
  } else {
    die("0");
  }
}


$feeInfo = $fee->getInfo();
$feeName = $feeInfo['name'];
$feeConditions = $currentCampus->getFeeConditions();
$pageTitle = "Add Condition to ".$feeName;
?>