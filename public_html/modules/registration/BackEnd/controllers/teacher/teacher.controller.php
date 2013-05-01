<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case null:
    $teachers = $currentCampus->getTeachers();

    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/teacher/teacher.view.php";
    break;
  case "viewTeacher":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/teacher/view.teacher.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/teacher/view.teacher.view.php";
    break;
  case "addEditTeacher":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/teacher/addEdit.teacher.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/teacher/addEdit.teacher.view.php";
    break;
}



?>