<?php
if(isset($fee_condition_id)){
  $condition = $currentCampus->getFeeCondition($fee_condition_id);
  $submitField = "saveCondition";
} else {
  $condition = null;
  $submitField = "createCondition";
}
if(isset($createCondition)){
  if($currentCampus->createFeeCondition()){
    header('Location: index.php?com=registration&view=fees&action=conditions');
  }
} else if(isset($saveCondition)){
  if($currentCampus->saveFeeCondition($fee_condition_id)){
    header('Location: index.php?com=registration&view=fees&action=conditions');
  } else {
    die();
  }
}
$pageTitle = "Add Condition";
$feeConditionTypes = $reg->getFeeConditionTypes();
?>