<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case null:
    $programList = $currentCampus->getPrograms(true);
    if ($programList) {
      foreach ($programList as $program) {
        $programObject = new TSM_REGISTRATION_PROGRAM($program['program_id']);
        $programList[$program['program_id']]['num_students'] = $programObject->getNumStudentsEnrolled();
      }
    }
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/program/programs.view.php";
    break;
  case "addFee":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/program/addFee.program.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/program/addFee.program.view.php";
    break;
  case "addRequirement":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/program/addRequirement.program.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/program/addRequirement.program.view.php";
    break;
  case "addCondition":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/program/addCondition.program.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/program/addCondition.program.view.php";
    break;
  case "addCourse":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/program/addCourse.program.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/program/addCourse.program.view.php";
    break;
  case "viewProgram":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/program/view.program.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/program/view.program.view.php";
    break;
  case "viewRoster":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/program/roster.program.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/program/roster.program.view.php";
    break;
  case "viewCourse":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/program/view.course.program.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/program/view.course.program.view.php";
    break;
  case "addEditProgram":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/program/addEdit.program.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/program/addEdit.program.view.php";
    break;
}

?>