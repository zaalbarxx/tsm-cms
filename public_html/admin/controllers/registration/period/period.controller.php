<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case null:
    $periods = $currentCampus->getPeriods();
    $activeView = __TSM_ROOT__."admin/views/registration/period/period.view.php";
    break;
  case "addEditPeriod":
    require_once(__TSM_ROOT__."admin/controllers/registration/period/addEdit.period.controller.php");
    $activeView = __TSM_ROOT__."admin/views/registration/period/addEdit.period.view.php";
    break;
}

?>