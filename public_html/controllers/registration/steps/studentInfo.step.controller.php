<?php
if (isset($addStudent)) {
  if ($currentCampus->studentExists($first_name, $birth_date)) {

  } else {
    $student_id = $family->addStudent();
    if ($student_id) {
      $student = new TSM_REGISTRATION_STUDENT($student_id);
      $student->addToSchoolYear($currentCampus->getCurrentSchoolYear());
      $family->moveToNextStep();
      header('Location: index.php?com=registration');
    }
  }
} else if (isset($editStudent)) {
  $student = new TSM_REGISTRATION_STUDENT($student_id);
  $student->saveStudent();
  header('Location: index.php?com=registration&student_id='.$student_id);
}

if (isset($student_id)) {
  $student = new TSM_REGISTRATION_STUDENT($student_id);
  $studentInfo = $student->getInfo();
  $submitField = "editStudent";
  $pageTitle = "edit Student";
  $headerMessage = "Please edit the student by entering their information below.";
} else {
  $studentInfo = null;
  $submitField = "addStudent";
  $pageTitle = "Add A Student";
  $headerMessage = "Please add a student by entering their information below.";
}

$shirtSizes = $currentCampus->getShirtSizes();

error_reporting(E_ALL ^ E_NOTICE);
//$familyInfo = $family->getInfo();

?>