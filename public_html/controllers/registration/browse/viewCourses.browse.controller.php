<?php
if (isset($program_id)) {
  $program = new TSM_REGISTRATION_PROGRAM($program_id);
  $programInfo = $program->getInfo();
  $courseList = $program->getCourses();
} else {
  $programInfo = null;
  $courseList = null;
}

$pageTitle = "Browse courses for ".$programInfo['name'];
?>