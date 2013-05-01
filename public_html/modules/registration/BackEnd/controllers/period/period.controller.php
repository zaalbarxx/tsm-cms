<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case null:
    $periods = $currentCampus->getPeriods();
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/period/period.view.php";
    break;
  case "addEditPeriod":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/period/addEdit.period.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/period/addEdit.period.view.php";
    break;
}

?>