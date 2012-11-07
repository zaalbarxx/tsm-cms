<?php
require_once(__TSM_ROOT__."models/registration/tsm_registration.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_campus.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_program.model.php");

//INSTANTIATE THE REGISRATION CLASS
$reg = new TSM_REGISTRATION();
$campusList = $reg->getCampuses();
if(!isset($view)){
  $view = null;
}

if(isset($createCampus)){
  if($reg->createCampus()){
    header('Location: '.$_SERVER["REQUEST_URI"]);
  }
}
if(isset($setCurrentCampusId)){
  if($reg->setCurrentCampusId($setCurrentCampusId)){
    header('Location: '.$_SERVER["REQUEST_URI"]);
  }
}



if($campusList == NULL){
  $activeView = __TSM_ROOT__."admin/views/registration/createCampus.view.php";  
} else if(!$reg->getCurrentCampusId()){
  $activeView = __TSM_ROOT__."admin/views/registration/selectCurrentCampus.view.php";
} else {
  switch($view){
    case null:
      require_once(__TSM_ROOT__."admin/controllers/registration/dashboard.controller.php");
      break;
    case "family":
      require_once(__TSM_ROOT__."admin/controllers/registration/family.controller.php");
      break;
    case "programs":
      require_once(__TSM_ROOT__."admin/controllers/registration/programs.controller.php");    
      break;
    
  }
}

//CALL THE APPROPRIATE VIEW
require_once($tsm->website->getTemplateHeader());
require_once($activeView);
require_once($tsm->website->getTemplateFooter());
?>