<?php
$programs = $currentCampus->getPrograms();
if (isset($programs)) {
  foreach ($programs as $program) {
    $programObject = new TSM_REGISTRATION_PROGRAM($program['program_id']);
    $programs[$program['program_id']]['courses'] = $programObject->getCourses();
  }
}
$studentColumns = $tsm->getColumnsFor("tsm_reg_students");
?>