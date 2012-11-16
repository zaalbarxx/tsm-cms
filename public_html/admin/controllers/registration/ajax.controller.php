<?php
$currentCampus = new TSM_REGISTRATION_CAMPUS($reg->getCurrentCampusId());
switch($ajax){
  case "formSubmission":
    switch($formAction){
      case "saveFee":
        if($currentCampus->saveFee($fee_id)){
            $response = true;
            $redirect = "index.php?com=registration&view=fees";
        } else {
          $response = false;
        }
        break;
      case "addFee":
        if($currentCampus->createFee()){
            $response = true;
            $redirect = "index.php?com=registration&view=fees";
        } else {
          $response = false;
        }
        break;
    }
    if(isset($fb)){
      echo $response;
    } else {
      echo $redirect;
    }
    break;
  case "deleteFeeConditionFromProgram":
    if(isset($program_id) && isset($program_fee_condition_id)){
      $program = new TSM_REGISTRATION_PROGRAM($program_id);
      if($program->deleteFeeCondition($program_fee_condition_id)){
        echo true;
      } else {
        echo false;
      }
    }
    break;
  case "deleteFee":
    if($currentCampus->deleteFee($fee_id)){
      echo true;
    } else {
      echo false; 
    }
    break;
}
die();
?>