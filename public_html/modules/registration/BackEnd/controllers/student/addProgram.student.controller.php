<?php
$student = new TSM_REGISTRATION_STUDENT($student_id);
$studentInfo = $student->getInfo();
$eligiblePrograms = $student->getEligiblePrograms();

if (!isset($searchq)) {
  $searchq = null;
}

$student->setUseRecordedFees(false);

if (isset($enrollInProgram)) {
  if ($student->enrollInProgram($enrollInProgram)) {
    die("1");
  } else {
    die("0");
  }
}

$pageTitle = "Add ".$studentInfo['first_name']." to Program";
?>