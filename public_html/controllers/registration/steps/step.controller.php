<?php

switch($family->getCurrentStep()) {
	case 1:
		require_once(__TSM_ROOT__."controllers/registration/steps/familyInfo.step.controller.php");
		$activeView = __TSM_ROOT__."views/registration/steps/familyInfo.step.view.php";  
		break;
		
	case 2:
		require_once(__TSM_ROOT__."controllers/registration/steps/studentInfo.step.controller.php");
		$activeView = __TSM_ROOT__."views/registration/steps/studentInfo.step.view.php";
		break;
}
?>