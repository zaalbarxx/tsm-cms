<?php

$reg->setSelectedSchoolYear(2013);


if (isset($campus_id)) {
  $currentCampus = new TSM_REGISTRATION_CAMPUS($campus_id);
}

if (!isset($action)) {
  if (isset($currentCampus)) {
    $action = "viewPrograms";
  } else {
    $action = null;
  }
}

switch ($action) {
  case null:
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/browse/chooseCampusAndYear.browse.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/browse/chooseCampusAndYear.browse.view.php";
    break;
  case "viewPrograms":
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/browse/viewPrograms.browse.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/browse/viewPrograms.browse.view.php";
    break;
  case "viewCourses":
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/browse/viewCourses.browse.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/browse/viewCourses.browse.view.php";
    break;
}
?>