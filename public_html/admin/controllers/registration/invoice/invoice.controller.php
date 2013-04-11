<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case "viewPDF":
    require_once(__TSM_ROOT__."admin/controllers/registration/invoice/viewPDF.invoice.controller.php");
    //$activeView = __TSM_ROOT__."admin/views/registration/invoice/viewPDF.invoice.view.php";
    break;
}


?>