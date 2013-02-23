<?php
if (!isset($action)) {
  $action = null;
}


switch ($action) {
  case null:

    $activeView = __TSM_ROOT__."admin/views/registration/reports/reports.view.php";
    break;
  case "studentList":
    require_once(__TSM_ROOT__."admin/controllers/registration/reports/studentList.reports.controller.php");
    $activeView = __TSM_ROOT__."admin/views/registration/reports/studentList.reports.view.php";
    break;
  case "unenrolledStudents":
    require_once(__TSM_ROOT__."admin/controllers/registration/reports/unenrolledStudents.reports.controller.php");
    $activeView = __TSM_ROOT__."admin/views/registration/reports/unenrolledStudents.reports.view.php";
    break;
  case "unfinalizedFamilies":
    require_once(__TSM_ROOT__."admin/controllers/registration/reports/unfinalizedFamilies.reports.controller.php");
    $activeView = __TSM_ROOT__."admin/views/registration/reports/unfinalizedFamilies.reports.view.php";
    break;
  case "finalizedFamilies":
    require_once(__TSM_ROOT__."admin/controllers/registration/reports/finalizedFamilies.reports.controller.php");
    $activeView = __TSM_ROOT__."admin/views/registration/reports/finalizedFamilies.reports.view.php";
    break;
}

?>