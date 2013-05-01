<?php
require_once(__TSM_ROOT__."modules/registration/registration.php");

//INSTANTIATE THE REGISRATION CLASS
$reg = new TSM_REGISTRATION();
$campusList = $reg->getCampuses();
if (!isset($view)) {
  $view = null;
}

if (isset($ajax)) {
  require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/ajax.controller.php");
}

if (isset($createCampus)) {
  if ($reg->createCampus()) {
    header('Location: '.$_SERVER["REQUEST_URI"]);
  }
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


if ($campusList == NULL) {
  $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/createCampus.view.php";
} else if (!$reg->getCurrentCampusId()) {
  $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/selectCurrentCampus.view.php";
} else if (!$reg->getSelectedSchoolYear()) {
  $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/selectSchoolYear.view.php";
} else {
  $currentCampus = new TSM_REGISTRATION_CAMPUS($reg->getCurrentCampusId());
  $campusInfo = $currentCampus->getInfo();
  $quickbooks = new TSM_REGISTRATION_QUICKBOOKS();
  switch ($view) {
    case null:
      require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/dashboard.controller.php");
      break;
    case "family":
      require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/family/family.controller.php");
      break;
    case "student":
      require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/student/student.controller.php");
      break;
    case "teacher":
      require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/teacher/teacher.controller.php");
      break;
    case "programs":
      require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/program/programs.controller.php");
      break;
    case "courses":
      require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/course/course.controller.php");
      break;
    case "fees":
      require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/fees.controller.php");
      break;
    case "requirements":
      require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/requirement/requirement.controller.php");
      break;
    case "periods":
      require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/period/period.controller.php");
      break;
    case "quickbooks":
      require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/quickbooks/quickbooks.controller.php");
      break;
    case "reports":
      require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/reports/reports.controller.php");
      break;
    case "invoice":
      require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/invoice/invoice.controller.php");
      break;

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