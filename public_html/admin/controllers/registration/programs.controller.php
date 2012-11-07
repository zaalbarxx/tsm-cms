<?php
  $campus = new TSM_REGISTRATION_CAMPUS($reg->getCurrentCampusId());
  if(!isset($action)){
    $action = null;
  }
  
  switch($action){
    case null:
      $programList = $campus->getPrograms();
      if($programList){
        foreach($programList as $program){
          $programObject = new TSM_REGISTRATION_PROGRAM($program['program_id']);
          $programList[$program['program_id']]['num_students'] = $programObject->getNumStudentsEnrolled(); 
        }
      }
      $activeView = __TSM_ROOT__."admin/views/registration/programs.view.php";
      break;
    case "addProgram":
      if(isset($createProgram)){
        if($campus->createProgram()){
          header('Location: index.php?com=registration&view=programs');
        }
      }
      $activeView = __TSM_ROOT__."admin/views/registration/addProgram.view.php";
      break;
    case "editProgram":
      $activeView = __TSM_ROOT__."admin/views/registration/editProgram.view.php";
      break;
    
  }
  
?>