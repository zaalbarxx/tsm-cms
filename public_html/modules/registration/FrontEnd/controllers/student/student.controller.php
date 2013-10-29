<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case null:
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/student/students.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/student/students.view.php";
    break;
  case "viewStudent":
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/student/view.student.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/student/view.student.view.php";
    break;
  case "addEditStudent":
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/student/addEdit.student.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/student/addEdit.student.view.php";
    break;
  case "addProgram":
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/student/addProgram.student.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/student/addProgram.student.view.php";
    break;
  case "addCourse":
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/student/addCourse.student.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/student/addCourse.student.view.php";
    break;
    case "editInfo":
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/student/editInfo.student.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/student/editInfo.student.view.php";
}



?>