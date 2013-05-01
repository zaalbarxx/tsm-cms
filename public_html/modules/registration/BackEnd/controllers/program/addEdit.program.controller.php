<?php
if (isset($createProgram)) {
  if ($currentCampus->createProgram()) {
    header('Location: index.php?com=registration&view=programs');
  }
}
if (isset($saveProgram)) {
  if ($currentCampus->saveProgram($program_id)) {
    header('Location: index.php?com=registration&view=programs');
  }
}
if (isset($program_id)) {
  $program = new TSM_REGISTRATION_PROGRAM($program_id);
  $programInfo = $program->getInfo();
  $pageTitle = "Edit Program";
  $submitField = "saveProgram";
} else {
  $pageTitle = "Add Program";
  $submitField = "createProgram";
  $programInfo = null;
}
?>