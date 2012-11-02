<?php
require_once(__TSM_ROOT__."models/registration/main.model.php");

$reg = new Registration();
$view = null;
switch($view){
  case null:
    $campuses = $reg->getCampuses();
    $activeView = __TSM_ROOT__."admin/views/registration/main.view.php";
    break;
  case "parentDetails":
    break;
  
}

//CALL THE APPROPRIATE VIEW
require_once($tsm->website->getTemplateHeader());
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
require_once($activeView);
require_once($tsm->website->getTemplateFooter());
?>