<?php
$program = new TSM_REGISTRATION_PROGRAM($program_id);

if (!isset($searchq)) {
  $searchq = null;
}

if (isset($addRequirement)) {
  if ($program->addRequirement($addRequirement)) {
    die("1");
  } else {
    die("0");
  }
}

$programName = $program->getName();
$campusRequirements = $currentCampus->getRequirements($searchq);
$pageTitle = "Add Requirement to ".$programName;
?>
