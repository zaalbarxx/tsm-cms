<?php
require_once(__TSM_ROOT__."modules/registration/registration.php");

//INSTANTIATE THE REGISRATION CLASS
$reg = new TSM_REGISTRATION();
$reg->family = new TSM_REGISTRATION_FAMILY();
$family = $reg->family;

if (!isset($view)) {
  $view = null;
}

if (isset($ajax)) {
  require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/ajax.controller.php");
}

if (isset($setCurrentCampusId)) {
  if ($reg->setCurrentCampusId($setCurrentCampusId)) {
    header('Location: '.$_SERVER["REQUEST_URI"]);
  }
}

if (isset($setSelectedSchoolYear)) {
  if ($reg->setSelectedSchoolYear($setSelectedSchoolYear)) {
    header('Location: '.$_SERVER["REQUEST_URI"]);
  }
}

if (isset($browseOfferings)) {
  require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/browse/browse.controller.php");
} else if ($reg->family->isLoggedIn() == false) {
  if (isset($login)) {
    if (!$reg->family->login($email, $password, $campus_id)) {
      $error = "Incorrect e-mail address and password.";
    }
  }
  $campusList = $reg->getCampuses(true);
  if (isset($registerNow)) {
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/steps/step.controller.php");
  } else {
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/login.view.php";
  }
} else {
  $reg->setCurrentCampusId($family->getCampusId());
  $currentCampus = new TSM_REGISTRATION_CAMPUS($family->getCampusId());
  $campusInfo = $currentCampus->getInfo();
  $quickbooks = new TSM_REGISTRATION_QUICKBOOKS();
  //if the family has not completed the registration process, send them to the first step.
  if ($family->getCurrentStep() != 0) {
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/steps/step.controller.php");
  } else {
    switch ($view) {
      case null:
        require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/student/student.controller.php");
        //$activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/dashboard.view.php";
        //require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/dashboard.controller.php");
        break;
      case "family":
        require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/family/family.controller.php");
        break;
      case "student":
        require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/student/student.controller.php");
        break;
      case "programs":
        require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/program/programs.controller.php");
        break;
      case "courses":
        require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/course/course.controller.php");
        break;
      case "fees":
        require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/fees.controller.php");
        break;
      case "requirements":
        require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/requirement/requirement.controller.php");
        break;
      case "periods":
        require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/period/period.controller.php");
        break;
      case "invoice":
        require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/invoice/invoice.controller.php");
        break;

    }
  }
}

//CALL THE APPROPRIATE VIEW
require_once($tsm->website->getTemplateHeader());
if (isset($activeView)) {
  require_once($activeView);
} else {
  echo "<p style='text-align: center;'>This command has not yet been implemented. <a href='javascript:history.go(-1)'>Back</a><p>";
}
require_once($tsm->website->getTemplateFooter());
?>