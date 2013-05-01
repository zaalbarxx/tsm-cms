<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case "viewPDF":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/invoice/viewPDF.invoice.controller.php");
    //$activeView = __TSM_ROOT__."modules/registration/BackEnd/views/invoice/viewPDF.invoice.view.php";
    break;
}


?>