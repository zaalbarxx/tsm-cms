<?php
if (isset($createTeacher)) {
  if ($add_type == 1) {
    $teacher = new TSM_REGISTRATION_TEACHER($addTeacher);
    if ($teacher->addToSchoolYear($reg->getSelectedSchoolYear())) {
      header('Location: index.php?com=registration&view=teacher');
    } else {
      $errorMessage = "Could not add teacher to school year. They may already be added.";
    }
  } elseif ($add_type == 2) {
    $teacher_id = $currentCampus->createTeacher();
    $teacher = new TSM_REGISTRATION_TEACHER($teacher_id);
    $teacher->addToSchoolYear($reg->getSelectedSchoolYear());
    header('Location: index.php?com=registration&view=teacher');
  }

} elseif (isset($saveTeacher)) {
  $currentCampus->saveTeacher($teacher_id);
  header('Location: index.php?com=registration&view=teacher');
}

if (isset($teacher_id)) {
  if ($teacher_id == "") {
    unset($teacher_id);
  }
}

if (isset($teacher_id)) {
  $teacher = new TSM_REGISTRATION_TEACHER($teacher_id);
  $teacherInfo = $teacher->getInfo();
  $pageTitle = "Edit Teacher";
  $formAction = "saveTeacher";
} else {
  $pageTitle = "Add Teacher";
  $formAction = "createTeacher";
  $teachers = $currentCampus->getTeachers(Array('showAll' => 1));
  $teacherInfo = null;
}

?>