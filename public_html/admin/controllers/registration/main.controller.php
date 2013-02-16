<?php
require_once(__TSM_ROOT__."models/registration/tsm_registration.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_campus.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_program.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_course.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_fee.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_family.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_invoice.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_family_fee.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_student.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_teacher.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_requirement.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_period.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_fee_condition.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_payment_plan.model.php");
require_once(__TSM_ROOT__."models/registration/tsm_registration_quickbooks.model.php");

//INSTANTIATE THE REGISRATION CLASS
$reg = new TSM_REGISTRATION();
$campusList = $reg->getCampuses();
if (!isset($view)) {
  $view = null;
}

if (isset($ajax)) {
  require_once(__TSM_ROOT__."admin/controllers/registration/ajax.controller.php");
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
  $activeView = __TSM_ROOT__."admin/views/registration/createCampus.view.php";
} else if (!$reg->getCurrentCampusId()) {
  $activeView = __TSM_ROOT__."admin/views/registration/selectCurrentCampus.view.php";
} else if (!$reg->getSelectedSchoolYear()) {
  $activeView = __TSM_ROOT__."admin/views/registration/selectSchoolYear.view.php";
} else {
  $currentCampus = new TSM_REGISTRATION_CAMPUS($reg->getCurrentCampusId());
  $campusInfo = $currentCampus->getInfo();
  $quickbooks = new TSM_REGISTRATION_QUICKBOOKS();
  switch ($view) {
    case null:
      require_once(__TSM_ROOT__."admin/controllers/registration/dashboard.controller.php");
      break;
    case "family":
      require_once(__TSM_ROOT__."admin/controllers/registration/family/family.controller.php");
      break;
    case "student":
      require_once(__TSM_ROOT__."admin/controllers/registration/student/student.controller.php");
      break;
    case "teacher":
      require_once(__TSM_ROOT__."admin/controllers/registration/teacher/teacher.controller.php");
      break;
    case "programs":
      require_once(__TSM_ROOT__."admin/controllers/registration/program/programs.controller.php");
      break;
    case "courses":
      require_once(__TSM_ROOT__."admin/controllers/registration/course/course.controller.php");
      break;
    case "fees":
      require_once(__TSM_ROOT__."admin/controllers/registration/fees.controller.php");
      break;
    case "requirements":
      require_once(__TSM_ROOT__."admin/controllers/registration/requirement/requirement.controller.php");
      break;
    case "periods":
      require_once(__TSM_ROOT__."admin/controllers/registration/period/period.controller.php");
      break;
    case "quickbooks":
      require_once(__TSM_ROOT__."admin/controllers/registration/quickbooks/quickbooks.controller.php");
      break;
    case "reports":
      require_once(__TSM_ROOT__."admin/controllers/registration/reports/reports.controller.php");
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