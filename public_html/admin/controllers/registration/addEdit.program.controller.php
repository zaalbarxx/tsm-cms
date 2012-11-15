<?php
if(isset($createProgram)){
  if($currentCampus->createProgram()){
    header('Location: index.php?com=registration&view=programs');
  }
}
if(isset($saveProgram)){
  if($currentCampus->saveProgram($program_id)){
    header('Location: index.php?com=registration&view=programs');
  }
}
switch($action){
  case "addProgram":
    $pageTitle = "Add Program";
    $submitField = "createProgram";
    $programInfo = null;
    break;
  case "editProgram":
    $program = new TSM_REGISTRATION_PROGRAM($program_id);
    $programInfo = $program->getInfo();
    $pageTitle = "Edit Program";
    $submitField = "saveProgram";
    break;
}
?>