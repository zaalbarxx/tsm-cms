<?php

if (isset($addStudent)) {
  if ($currentCampus->studentExists($first_name, $birth_date)) {
    die("This student is already registered at this campus for this year. Please contact support@artiosacademies.com.");
  } else {
    $family = new TSM_REGISTRATION_FAMILY($family_id);
    $student_id = $family->addStudent();
    if ($student_id) {
      $student = new TSM_REGISTRATION_STUDENT($student_id);
      $student->addToSchoolYear($currentCampus->getCurrentSchoolYear());
      $student->setFirstYear($first_year);
      die("1");
    }
  }
} else if (isset($editStudent)) {
  $student = new TSM_REGISTRATION_STUDENT($student_id);
  $student->saveStudent();
  $student->setFirstYear($first_year);
  die("1");
}

if (isset($student_id)) {
  $student = new TSM_REGISTRATION_STUDENT($student_id);
  $studentInfo = $student->getInfo();
  $family_id = $studentInfo['family_id'];
  $submitField = "editStudent";
  $pageTitle = "Edit Student";
} else {
  $studentInfo = null;
  $submitField = "addStudent";
  $pageTitle = "Add A Student";
}

$shirtSizes = $currentCampus->getShirtSizes();

?>