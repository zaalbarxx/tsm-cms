<?php
$program = new TSM_REGISTRATION_PROGRAM($program_id);
$programInfo = $program->getInfo();
$programFees = $program->getFees();
$programRequirements = $program->getRequirements();
if ($programFees) {
  foreach ($programFees as $key => $fee) {
    $feeObject = new TSM_REGISTRATION_FEE($fee['fee_id']);
    $programFees[$key]['conditions'] = $feeObject->getConditionsForProgram($program_id);
  }
}

if (isset($removeCourses)) {
  if ($program->removeCourses(true)) {
    die("1");
  } else {
    die("0");
  }
}


$programCourses = $program->getCourses();

$pageTitle = $programInfo['name'];
?>