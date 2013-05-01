<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case null:
    $reqList = $currentCampus->getRequirements();
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/requirement/requirement.view.php";
    break;
  case "addEditRequirement":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/requirement/addEdit.requirement.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/requirement/addEdit.requirement.view.php";
    break;
  case "getRequirementForm":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/requirement/requirementForm.requirement.controller.php");
    break;
}

?>