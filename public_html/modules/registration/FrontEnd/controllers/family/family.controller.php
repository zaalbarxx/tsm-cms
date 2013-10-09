<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case null:
    header('index.php?mod=registration');
    break;
  case "editInfo":
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/family/editInfo.family.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/family/editInfo.family.view.php";
    break;
  case "resetPassword":
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/family/resetPassword.family.view.php";
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/family/resetPassword.family.controller.php");
    break;
  case "recentPayments":
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/family/recentPayments.family.view.php";
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/family/recentPayments.family.controller.php");
}
?>