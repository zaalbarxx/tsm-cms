<?php
if(!isset($action)){
  $action = null;
}

switch($action){
	case null:
		$families = $currentCampus->getFamilies();
		//foreach($families as $family){
			//$familyObject = new TSM_REGISTRATION_FAMILY($family['family_id']);
			//$families[$family['family_id']]['students'] = $familyObject->getStudents($reg->getSelectedSchoolYear());
			//$familyObject = null;
		//}
		
		$activeView = __TSM_ROOT__."admin/views/registration/family/family.view.php";
		break;
	case "viewFamily":
		require_once( __TSM_ROOT__."admin/controllers/registration/family/view.family.controller.php");
		$activeView = __TSM_ROOT__."admin/views/registration/family/view.family.view.php";
		break;
	case "addEditFamily":
		require_once( __TSM_ROOT__."admin/controllers/registration/family/addEdit.family.controller.php");
		$activeView = __TSM_ROOT__."admin/views/registration/family/addEdit.family.view.php";
		break;
}



?>