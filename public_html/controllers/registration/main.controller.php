<?php
require_once(__TSM_ROOT__."models/registration/main.model.php");

$reg = new Registration();

require_once($tsm->website->getTemplateHeader());
$view = null;
switch($view){
  case null:
    $campuses = $reg->getCampuses();
    require_once(__TSM_ROOT__."/views/registration/main.view.php");
    break;
  case "parentDetails":
    break;
  
}

require_once($tsm->website->getTemplateFooter());
?>