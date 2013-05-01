<?php
$course = new TSM_REGISTRATION_COURSE($course_id);
$courseInfo = $course->getInfo();
$courseStudents = $course->getEnrolledStudents();

if (isset($downloadCSV)) {
  $tsm->arrayToCSV($courseStudents, $courseInfo['name']." - Roster");
}


$pageTitle = $courseInfo['name']." Roster";
?>