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
}

?>