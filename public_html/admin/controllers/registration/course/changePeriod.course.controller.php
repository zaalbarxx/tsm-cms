<?php
$course = new TSM_REGISTRATION_COURSE($course_id);
$courseInfo = $course->getInfo();
$periods = $currentCampus->getPeriods();
$teachers = $currentCampus->getTeachers();

$pageTitle = "Change Period";
?>