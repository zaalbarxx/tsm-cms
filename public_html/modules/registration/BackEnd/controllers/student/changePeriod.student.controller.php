<?php
$course = new TSM_REGISTRATION_COURSE($course_id);
$courseInfo = $course->getInfo();
$periods = $course->getPeriods();

$pageTitle = "Change Period";
?>