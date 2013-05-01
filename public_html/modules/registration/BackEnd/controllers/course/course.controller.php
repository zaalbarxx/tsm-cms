<?php
if (!isset($action)) {
  $action = null;
}


switch ($action) {
  case null:
    $courseList = $currentCampus->getCourses();
    if ($courseList) {
      foreach ($courseList as $course) {
        $courseObject = new TSM_REGISTRATION_COURSE($course['course_id']);
        $courseList[$course['course_id']]['num_students'] = $courseObject->getNumStudentsEnrolled();
      }
    }
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/course/courses.view.php";
    break;
  case "addFee":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/course/addFee.course.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/course/addFee.course.view.php";
    break;
  case "addRequirement":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/course/addRequirement.course.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/course/addRequirement.course.view.php";
    break;
  case "addPeriod":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/course/addPeriod.course.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/course/addPeriod.course.view.php";
    break;
  case "addCondition":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/course/addCondition.course.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/course/addCondition.course.view.php";
    break;
  case "viewCourse":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/course/view.course.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/course/view.course.view.php";
    break;
  case "viewRoster":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/course/roster.course.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/course/roster.course.view.php";
    break;
  case "addEditCourse":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/course/addEdit.course.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/course/addEdit.course.view.php";
    break;
  case "changePeriodInCourse":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/course/changePeriod.course.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/course/changePeriod.course.view.php";
    break;
}

?>