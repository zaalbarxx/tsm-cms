<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case null:
    $programList = $currentCampus->getPrograms();
    if ($programList) {
      foreach ($programList as $program) {
        $programObject = new TSM_REGISTRATION_PROGRAM($program['program_id']);
        $programList[$program['program_id']]['num_students'] = $programObject->getNumStudentsEnrolled();
      }
    }
    $activeView = __TSM_ROOT__."admin/views/registration/program/programs.view.php";
    break;
  case "addFee":
    require_once(__TSM_ROOT__."admin/controllers/registration/program/addFee.program.controller.php");
    $activeView = __TSM_ROOT__."admin/views/registration/program/addFee.program.view.php";
    break;
  case "addRequirement":
    require_once(__TSM_ROOT__."admin/controllers/registration/program/addRequirement.program.controller.php");
    $activeView = __TSM_ROOT__."admin/views/registration/program/addRequirement.program.view.php";
    break;
  case "addCondition":
    require_once(__TSM_ROOT__."admin/controllers/registration/program/addCondition.program.controller.php");
    $activeView = __TSM_ROOT__."admin/views/registration/program/addCondition.program.view.php";
    break;
  case "addCourse":
    require_once(__TSM_ROOT__."admin/controllers/registration/program/addCourse.program.controller.php");
    $activeView = __TSM_ROOT__."admin/views/registration/program/addCourse.program.view.php";
    break;
  case "viewProgram":
    require_once(__TSM_ROOT__."admin/controllers/registration/program/view.program.controller.php");
    $activeView = __TSM_ROOT__."admin/views/registration/program/view.program.view.php";
    break;
  case "viewCourse":
    require_once(__TSM_ROOT__."admin/controllers/registration/program/view.course.program.controller.php");
    $activeView = __TSM_ROOT__."admin/views/registration/program/view.course.program.view.php";
    break;
  case "addEditProgram":
    require_once(__TSM_ROOT__."admin/controllers/registration/program/addEdit.program.controller.php");
    $activeView = __TSM_ROOT__."admin/views/registration/program/addEdit.program.view.php";
    break;
}

?>