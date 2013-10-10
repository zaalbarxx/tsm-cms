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
}
?>