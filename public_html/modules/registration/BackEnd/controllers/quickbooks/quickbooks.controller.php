<?php
if (isset($action)) {
  switch ($action) {
    case "connect":
      require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/quickbooks/connect.quickbooks.controller.php");
      break;
    case "connected":
      require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/quickbooks/connected.quickbooks.controller.php");
      $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/quickbooks/connected.quickbooks.view.php";
      break;
  }
} else {
  if ($quickbooks->creds == null) {
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/quickbooks/quickbooks.view.php";
  } else {
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/quickbooks/connected.quickbooks.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/quickbooks/connected.quickbooks.view.php";
  }
}



?>
