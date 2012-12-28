<?php
$program = new TSM_REGISTRATION_PROGRAM($program_id);
$programInfo = $program->getInfo();
$courses = $currentCampus->getCourses();

if(!isset($searchq)){
  $searchq = null;
}

if(isset($addCourse)){
  if($program->addCourse($addCourse)){
    die("1");  
  } else {
    die("0");
  }
}

$pageTitle = "Add Course to ".$programInfo['name'];
?>