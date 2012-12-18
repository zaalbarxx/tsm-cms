<?php
$student = new TSM_REGISTRATION_STUDENT($student_id);
$studentInfo = $student->getInfo();
$eligiblePrograms = $student->getEligiblePrograms();

if(!isset($searchq)){
  $searchq = null;
}

if(isset($addProgram)){
  if($program->addProgram($addProgram)){
    die("1");  
  } else {
    die("0");
  }
}

$pageTitle = "Add Program to ".$studentInfo['first_name'];
?>