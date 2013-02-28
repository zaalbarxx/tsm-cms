<?php

if (isset($addStudent)) {
  if ($currentCampus->studentExists($first_name, $birth_date)) {
    $errorMessage = "This student is already registered at this campus for this year. Please contact <a href='mailto:support@artiosacademies.com'>support@artiosacademies.com</a>";
  } else {
    $student_id = $family->addStudent();
    if ($student_id) {
      $student = new TSM_REGISTRATION_STUDENT($student_id);
      $student->addToSchoolYear($currentCampus->getCurrentSchoolYear());
      $student->setFirstYear($first_year);
      $family->moveToNextStep();
      header('Location: index.php?com=registration');
    }
  }
} else if (isset($editStudent)) {
  $student = new TSM_REGISTRATION_STUDENT($student_id);
  $student->saveStudent();
  $student->setFirstYear($first_year);
  $family->moveToStep(3);
  header('Location: index.php?com=registration&student_id='.$student_id);
}

if (isset($backToReview)) {
  $family->moveToStep(4);
  header("Location: index.php?com=registration");
}

if (isset($student_id)) {
  $student = new TSM_REGISTRATION_STUDENT($student_id);
  $studentInfo = $student->getInfo();
  $submitField = "editStudent";
  $pageTitle = "Edit Student";
  $headerMessage = "Please edit the student by entering their information below.";
} else {
  $students = $family->getStudents($currentCampus->getCurrentSchoolYear());
  if (isset($students)) {
    $addingAdditional = 1;
  }
  $studentInfo = null;
  $submitField = "addStudent";
  $pageTitle = "Add A Student";
  $headerMessage = "Please add a student by entering their information below.";
}

$shirtSizes = $currentCampus->getShirtSizes();

error_reporting(E_ALL ^ E_NOTICE);
//$familyInfo = $family->getInfo();

?>