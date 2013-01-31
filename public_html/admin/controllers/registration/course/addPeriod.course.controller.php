<?php
$course = new TSM_REGISTRATION_COURSE($course_id);
$courseInfo = $course->getInfo();
$periods = $currentCampus->getPeriods();
$teachers = $currentCampus->getTeachers();

if (!isset($searchq)) {
  $searchq = null;
}

if (isset($addPeriod)) {
  if ($course->addPeriod($addPeriod, $teacher_id)) {
    die("1");
  } else {
    die("0");
  }
}

$pageTitle = "Add Period to ".$courseInfo['name'];
?>