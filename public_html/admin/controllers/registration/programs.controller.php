<?php
  if(!isset($action)){
    $action = null;
  }
  
  switch($action){
    case null:
      $programList = $currentCampus->getPrograms();
      if($programList){
        foreach($programList as $program){
          $programObject = new TSM_REGISTRATION_PROGRAM($program['program_id']);
          $programList[$program['program_id']]['num_students'] = $programObject->getNumStudentsEnrolled(); 
        }
      }
      $activeView = __TSM_ROOT__."admin/views/registration/programs.view.php";
      break;
    case "addFee":
      require_once(__TSM_ROOT__."admin/controllers/registration/addFee.program.controller.php");
      $activeView = __TSM_ROOT__."admin/views/registration/addFee.program.view.php";
      break;
    case "addRequirement":
      require_once(__TSM_ROOT__."admin/controllers/registration/addRequirement.program.controller.php");
      $activeView = __TSM_ROOT__."admin/views/registration/addRequirement.program.view.php";
      break;
    case "addCondition":
      require_once(__TSM_ROOT__."admin/controllers/registration/addCondition.program.controller.php");
      $activeView = __TSM_ROOT__."admin/views/registration/addCondition.program.view.php";
      break;
    case "viewProgram":
      require_once(__TSM_ROOT__."admin/controllers/registration/view.program.controller.php");
      $activeView = __TSM_ROOT__."admin/views/registration/view.program.view.php";
    break; 
    case "addEditProgram":
      require_once(__TSM_ROOT__."admin/controllers/registration/addEdit.program.controller.php");
      $activeView = __TSM_ROOT__."admin/views/registration/addEdit.program.view.php";
      break;
  }
  
?>