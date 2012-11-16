<?php
$requirement = new TSM_REGISTRATION_REQUIREMENT($requirement_id);

if(!isset($searchq)){
  $searchq = null;
}

if(isset($addCondition)){
  if($program->addFeeCondition($addCondition,$requirement_id)){
    die("1");  
  } else {
    die("0");
  }
}


$requirementInfo = $requirement->getInfo(); 
$requirementName = $requirementInfo['name'];
$pageTitle = "Add Requirement";
?>