<?php
$course = new TSM_REGISTRATION_COURSE($course_id);
$courseInfo = $course->getInfo();
$courseFees = $course->getFees($program_id);
$courseRequirements = $course->getRequirementsForProgram($program_id);
$coursePeriods = $course->getPeriods();
if ($courseFees) {
  foreach ($courseFees as $key => $fee) {
    $feeObject = new TSM_REGISTRATION_FEE($fee['fee_id']);
    $courseFees[$key]['conditions'] = $feeObject->getConditionsForCourse($course_id, $program_id);
  }
}
$pageTitle = $courseInfo['name'];
?>