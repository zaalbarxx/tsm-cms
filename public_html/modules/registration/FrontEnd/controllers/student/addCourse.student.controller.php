<?php
if (!isset($student_id)) {
  $student_id = $family->getLatestStudent();
}
$student = new TSM_REGISTRATION_STUDENT($student_id);
$studentInfo = $student->getInfo();
if (!isset($program_id)) {
  $program_id = $student->getLatestProgram();
}
$program = new TSM_REGISTRATION_PROGRAM($program_id);
$programInfo = $program->getInfo();
$eligibleCourses = $student->getEligibleCoursesForProgram($program_id);
if (isset($eligibleCourses)) {
  foreach ($eligibleCourses as $course) {
    if ($student->inCourse($course['course_id'])) {
      unset($eligibleCourses[$course['course_id']]);
    } else {
      $courseObject = new TSM_REGISTRATION_COURSE($course['course_id']);
      $eligibleCourses[$course['course_id']]['periods'] = $courseObject->getPeriods();
    }
  }
}

if (!isset($searchq)) {
  $searchq = null;
}

$student->setUseRecordedFees(false);

if (isset($enrollInCourse)) {
  if ($student->enrollInCourse($enrollInCourse, $program_id, $course_period_id)) {
    die("1");
  } else {
    die("0");
  }
}

$pageTitle = "Enroll ".$studentInfo['first_name']." in courses for ".$programInfo['name'];
?>