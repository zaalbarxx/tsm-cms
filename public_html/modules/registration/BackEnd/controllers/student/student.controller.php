<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case null:
    $students = $currentCampus->getStudents();
    $numStudents = count($students);

    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/student/student.view.php";
    break;
  case "viewStudent":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/student/view.student.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/student/view.student.view.php";
    break;
  case "addProgram":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/student/addProgram.student.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/student/addProgram.student.view.php";
    break;
  case "addCourse":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/student/addCourse.student.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/student/addCourse.student.view.php";
    break;
  case "changeStudentPeriodForCourse":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/student/changePeriod.student.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/student/changePeriod.student.view.php";
    break;
  case "addEditStudent":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/student/addEdit.student.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/student/addEdit.student.view.php";
    break;
}



?>