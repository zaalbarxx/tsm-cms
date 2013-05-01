<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case null:
    break;
  case "payOnline":
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/invoice/payOnline.invoice.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/invoice/payOnline.invoice.view.php";
    break;
}
?>