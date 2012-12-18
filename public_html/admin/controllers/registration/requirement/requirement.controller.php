<?php
if(!isset($action)){
  $action = null;
}

switch($action){
  case null:
    $reqList = $currentCampus->getRequirements();
    $activeView = __TSM_ROOT__."admin/views/registration/requirement/requirement.view.php";
    break;
  case "addEditRequirement":
  	require_once(__TSM_ROOT__."admin/controllers/registration/requirement/addEdit.requirement.controller.php");
  	$activeView = __TSM_ROOT__."admin/views/registration/requirement/addEdit.requirement.view.php";
  	break;
  case "getRequirementForm":  
    require_once(__TSM_ROOT__."admin/controllers/registration/requirement/requirementForm.requirement.controller.php");
    break;
}
  
?>