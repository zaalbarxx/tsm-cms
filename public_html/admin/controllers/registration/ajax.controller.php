<?php
switch($ajax){
  case "deleteFeeConditionFromProgram":
    if(isset($program_id) && isset($fee_condition_id)){
      $program = new TSM_REGISTRATION_PROGRAM($program_id);
      if($program->deleteFeeCondition($fee_condition_id)){
        echo true;
      } else {
        echo false;
      }
    }
    break;
}
die();
?>