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
    case "addProgram" or "editProgram":
      if(isset($createProgram)){
        if($campus->createProgram()){
          header('Location: index.php?com=registration&view=programs');
        }
      }
      if(isset($saveProgram)){
        if($campus->saveProgram($program_id)){
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
      $activeView = __TSM_ROOT__."admin/views/registration/addEditProgram.view.php";
      break;
    case "editProgram":
      $activeView = __TSM_ROOT__."admin/views/registration/editProgram.view.php";
      break;
    
  }
  
?>