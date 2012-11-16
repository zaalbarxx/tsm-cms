<?php
if(!isset($action)){
  $action = null;
}

switch($action){
  case null:
    $reqList = $currentCampus->getRequirements();
    $activeView = __TSM_ROOT__."admin/views/registration/requirements.view.php";
    break;
  case "addEditRequirement":
  	require_once(__TSM_ROOT__."admin/controllers/registration/addEdit.requirements.controller.php");
  	$activeView = __TSM_ROOT__."admin/views/registration/addEdit.requirements.view.php";
  	break;
}
  
?>