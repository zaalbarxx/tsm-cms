<?php
if (isset($family_id) && !isset($family)) {
  $family = new TSM_REGISTRATION_FAMILY($family_id);
}

if (isset($addStudent)) {
  $student_id = $family->addStudent();
  if ($student_id) {
    $student = new TSM_REGISTRATION_STUDENT($student_id);
    $student->addToSchoolYear($currentCampus->getCurrentSchoolYear());
    header('Location: index.php?com=registration&view=student');
  }
}


if (isset($student_id)) {
  $student = new TSM_REGISTRATION_STUDENT($student_id);
  $studentInfo = $student->getInfo();
  $pageTitle = "Edit Student";
  $submitField = "saveStudent";
  if (isset($saveStudent)) {
    if ($student->saveStudent($student_id)) {
      header('Location: index.php?com=registration&view=student');
    }
  }
} else {
  $pageTitle = "Add Student";
  $submitField = "addStudent";
  $studentInfo = null;
}
?>