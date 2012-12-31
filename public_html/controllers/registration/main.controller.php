<?php
require_once(__TSM_ROOT__."models/registration/tsm_registration.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_campus.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_program.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_course.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_fee.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_family.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_student.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_requirement.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_period.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_fee_condition.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_payment_plan.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_invoice.model.php");



//INSTANTIATE THE REGISRATION CLASS
$reg = new TSM_REGISTRATION();
$reg->family = new TSM_REGISTRATION_FAMILY();
$family = $reg->family;

if(!isset($view)){
  $view = null;
}

if(isset($ajax)){
  require_once(__TSM_ROOT__."controllers/registration/ajax.controller.php");
}

if(isset($setCurrentCampusId)){
  if($reg->setCurrentCampusId($setCurrentCampusId)){
    header('Location: '.$_SERVER["REQUEST_URI"]);
  }
}

if(isset($setSelectedSchoolYear)){
  if($reg->setSelectedSchoolYear($setSelectedSchoolYear)){
    header('Location: '.$_SERVER["REQUEST_URI"]);
  }
}

if($reg->family->isLoggedIn() == false){
	if(isset($login)){
		if(!$reg->family->login($email,$password,$campus_id)){
			$error = "Incorrect e-mail address and password.";
		}
	}
	$campusList = $reg->getCampuses();
	if(isset($registerNow)){
		require_once(__TSM_ROOT__."controllers/registration/steps/step.controller.php");
	} else {
		$activeView = __TSM_ROOT__."views/registration/login.view.php";  
  }
} else {
  $currentCampus = new TSM_REGISTRATION_CAMPUS($family->getCampusId());
  //if the family has not completed the registration process, send them to the first step.
  if($family->getCurrentStep() != 0){
  	require_once(__TSM_ROOT__."controllers/registration/steps/step.controller.php");
  } else {
		switch($view){
			case null:
				$activeView = __TSM_ROOT__."views/registration/dashboard.view.php";  
				//require_once(__TSM_ROOT__."controllers/registration/dashboard.controller.php");
				break;
			case "family":
				require_once(__TSM_ROOT__."controllers/registration/family/family.controller.php");
				break;
			case "student":
				require_once(__TSM_ROOT__."controllers/registration/student/student.controller.php");
				break;
			case "programs":
				require_once(__TSM_ROOT__."controllers/registration/program/programs.controller.php");    
				break;
			case "courses":
				require_once(__TSM_ROOT__."controllers/registration/course/course.controller.php");    
				break;
			case "fees":
				require_once(__TSM_ROOT__."controllers/registration/fees.controller.php"); 
				break;
			case "requirements":
				require_once(__TSM_ROOT__."controllers/registration/requirement/requirement.controller.php"); 
				break;
			case "periods":
				require_once(__TSM_ROOT__."controllers/registration/period/period.controller.php"); 
				break;
			
		}
  }
}

//CALL THE APPROPRIATE VIEW
require_once($tsm->website->getTemplateHeader());
if(isset($activeView)){
	require_once($activeView);	
} else {
	echo "<p style='text-align: center;'>This command has not yet been implemented. <a href='javascript:history.go(-1)'>Back</a><p>";
}
require_once($tsm->website->getTemplateFooter());
?>