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
      foreach ($fees as $fee) {
        $showFees = null;
        $feeObject = new TSM_REGISTRATION_FEE($fee['fee_id']);
        $conditions = $feeObject->getConditionsForProgram($program_id);
        $courseConditions = $feeObject->getConditionsForCourse($course['course_id'], $program_id);
        if ($conditions == null && $courseConditions == null) {
          $showFees[] = $fee;
        } else {
          $showFees = null;
        }
      }
      if (isset($showFees)) {
        $courseList[$course['course_id']]['tuition_total'] = $reg->addFees($showFees);
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