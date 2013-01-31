<?php
$program = new TSM_REGISTRATION_PROGRAM($program_id);

if (!isset($searchq)) {
  $searchq = null;
}

if (isset($addFee)) {
  if ($program->addFee($addFee)) {
    die("1");
  } else {
    die("0");
  }
}

$programName = $program->getName();
$campusFees = $currentCampus->getFees($searchq);
$pageTitle = "Add Fee to ".$programName;
?>