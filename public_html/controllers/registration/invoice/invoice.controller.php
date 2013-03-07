<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case null:
    break;
  case "payOnline":
    require_once(__TSM_ROOT__."controllers/registration/invoice/payOnline.invoice.controller.php");
    $activeView = __TSM_ROOT__."views/registration/invoice/payOnline.invoice.view.php";
    break;
}
?>