<?php
if (isset($program_id)) {
  $program = new TSM_REGISTRATION_PROGRAM($program_id);
  $programInfo = $program->getInfo();
  $courseList = $program->getCourses();
  $campusInfo = $currentCampus->getInfo();
  if (isset($courseList)) {
    foreach ($courseList as $course) {
      $courseObject = new TSM_REGISTRATION_COURSE($course['course_id']);
      $fees = $courseObject->getFees($program_id, $campusInfo['tuition_fee_type_id']);
      $courseFees = $courseObject->getFees(null, null);
      $displayTuition = 0;
      if(isset($fees)){
        foreach ($fees as $fee) {
          if ($fee['amount'] > $displayTuition) {
            $displayTuition = $fee['amount'];
          }
        }
      }
      if(isset($courseFees)){
        foreach ($courseFees as $fee) {
          if ($fee['amount'] > $displayTuition) {
            $displayTuition = $fee['amount'];
          }
        }
      }
      if ($displayTuition > 0) {
        $courseList[$course['course_id']]['tuition_total'] = $displayTuition;
      }
      $courseList[$course['course_id']]['periods'] = $courseObject->getPeriods();
    }
  }
} else {
  $programInfo = null;
  $courseList = null;
}

$pageTitle = "Browse courses for ".$programInfo['name'];
?>