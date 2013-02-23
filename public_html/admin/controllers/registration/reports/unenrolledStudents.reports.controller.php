<?php
$students = $currentCampus->getStudents();
if (isset($students)) {
  foreach ($students as $student) {
    $studentObject = new TSM_REGISTRATION_STUDENT($student['student_id']);
    $programs = $studentObject->getEnrolledPrograms();
    if ($programs != null) {
      unset($students[$student['student_id']]);
    }
  }
}
?>