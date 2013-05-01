<?php
if (!isset($action)) {
  $action = null;
}


switch ($action) {
  case null:

    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/reports/reports.view.php";
    break;
  case "studentList":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/reports/studentList.reports.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/reports/studentList.reports.view.php";
    break;
  case "unenrolledStudents":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/reports/unenrolledStudents.reports.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/reports/unenrolledStudents.reports.view.php";
    break;
  case "unfinalizedFamilies":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/reports/unfinalizedFamilies.reports.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/reports/unfinalizedFamilies.reports.view.php";
    break;
  case "finalizedFamilies":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/reports/finalizedFamilies.reports.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/reports/finalizedFamilies.reports.view.php";
    break;
  case "totalRevenue":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/reports/totalRevenue.reports.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/reports/totalRevenue.reports.view.php";
    break;
}

?>