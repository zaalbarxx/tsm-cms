<?php
if(!isset($student_id)){
	$student_id = $family->getLatestStudent();
}
$student = new TSM_REGISTRATION_STUDENT($student_id);
$studentInfo = $student->getInfo();
$student->setUseRecordedFees(false);
$eligiblePrograms = $student->getEligiblePrograms();

if(!isset($searchq)){
  $searchq = null;
}

if(isset($enrollInProgram)){
  if($student->enrollInProgram($enrollInProgram)){
  	die("1");
  } else {
  	die("0");
  }
}

$pageTitle = "Enroll ".$studentInfo['first_name']." in a Program";
?>