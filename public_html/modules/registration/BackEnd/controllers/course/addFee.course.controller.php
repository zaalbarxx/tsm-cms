<?php
$course = new TSM_REGISTRATION_COURSE($course_id);

if (!isset($searchq)) {
  $searchq = null;
}

if (!isset($program_id)) {
  $program_id = null;
}

if (isset($addFee)) {
  if ($course->addFee($addFee, $program_id)) {
    die("1");
  } else {
    die("0");
  }
}

$courseName = $course->getName();
$campusFees = $currentCampus->getFees($searchq);
$pageTitle = "Add Fee to ".$courseName;
?>