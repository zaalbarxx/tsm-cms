<?php
$program = new TSM_REGISTRATION_PROGRAM($program_id);
$programInfo = $program->getInfo();
$programStudents = $program->getEnrolledStudents();

if (isset($downloadCSV)) {
  $tsm->arrayToCSV($programStudents, $programInfo['name']." - Roster");
}

$pageTitle = $programInfo['name']." Roster";
?>