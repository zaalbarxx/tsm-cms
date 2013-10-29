<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case null:
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/invoice/invoices.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/invoice/invoice.view.php";
    break;
  case "viewPDF":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/invoice/viewPDF.invoice.controller.php");
    //$activeView = __TSM_ROOT__."modules/registration/BackEnd/views/invoice/viewPDF.invoice.view.php";
    break;
  case "sendInvoices":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/invoice/sendInvoices.invoice.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/invoice/sendInvoices.invoice.view.php";
    break;
}


?>