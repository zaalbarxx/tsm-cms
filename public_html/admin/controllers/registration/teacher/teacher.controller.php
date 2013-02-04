<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case null:
    $teachers = $currentCampus->getTeachers();

    $activeView = __TSM_ROOT__."admin/views/registration/teacher/teacher.view.php";
    break;
  case "viewTeacher":
    require_once(__TSM_ROOT__."admin/controllers/registration/teacher/view.teacher.controller.php");
    $activeView = __TSM_ROOT__."admin/views/registration/teacher/view.teacher.view.php";
    break;
  case "addEditTeacher":
    require_once(__TSM_ROOT__."admin/controllers/registration/teacher/addEdit.teacher.controller.php");
    $activeView = __TSM_ROOT__."admin/views/registration/teacher/addEdit.teacher.view.php";
    break;
}



?>