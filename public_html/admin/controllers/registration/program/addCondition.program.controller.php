<?php
$program = new TSM_REGISTRATION_PROGRAM($program_id);
$fee = new TSM_REGISTRATION_FEE($fee_id);

if(!isset($searchq)){
  $searchq = null;
}

if(isset($addCondition)){
  if($program->addFeeCondition($addCondition,$fee_id)){
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