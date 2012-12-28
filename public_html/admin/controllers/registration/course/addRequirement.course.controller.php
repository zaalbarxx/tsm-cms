<?php
$course = new TSM_REGISTRATION_COURSE($course_id);

if(!isset($searchq)){
  $searchq = null;
}

if(!isset($program_id)){
  $program_id = null;
}


if(isset($addRequirement)){
  if($course->addRequirement($addRequirement,$program_id)){
    die("1");  
  } else {
    die("0");
  }
}

$courseName = $course->getName();
$campusRequirements = $currentCampus->getRequirements($searchq);
$pageTitle = "Add Requirement to ".$courseName;
?>
