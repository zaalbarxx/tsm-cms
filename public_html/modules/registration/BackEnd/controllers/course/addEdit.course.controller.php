<?php
if (isset($createCourse)) {
  if ($currentCampus->createCourse()) {
    header('Location: index.php?mod=registration&view=courses');
  }
}
if (isset($saveCourse)) {
  if ($currentCampus->saveCourse($course_id)) {
    header('Location: index.php?mod=registration&view=courses');
  }
}
if (isset($course_id)) {
  $course = new TSM_REGISTRATION_COURSE($course_id);
  $courseInfo = $course->getInfo();
  $pageTitle = "Edit Course";
  $submitField = "saveCourse";
} else {
  $pageTitle = "Add Course";
  $courseInfo = null;
  $submitField = "createCourse";
}
?>