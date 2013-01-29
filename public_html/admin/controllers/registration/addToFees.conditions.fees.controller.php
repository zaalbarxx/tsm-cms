<?php
$condition = new TSM_REGISTRATION_FEE_CONDITION($fee_condition_id);
$conditionInfo = $condition->getInfo();

if (isset($addToFees)) {
  foreach ($_POST as $key => $value) {
    $addArray = explode("_", $key);
    if (stristr($addArray[0], "programId")) {
      $programId = explode(":", $addArray[0]);
      $programId = $programId[1];
      $feeId = explode(":", $addArray[1]);
      $feeId = $feeId[1];
      $program = new TSM_REGISTRATION_PROGRAM($programId);
      $program->addFeeCondition($fee_condition_id, $feeId);
      //echo "Adding ".$fee_condition_id." to Fee ".$feeId." and Program ".$programId."...<br />";
    }
    if (stristr($addArray[0], "courseId")) {
      $courseId = explode(":", $addArray[0]);
      $courseId = $courseId[1];
      $programId = explode(":", $addArray[1]);
      $programId = $programId[1];
      $feeId = explode(":", $addArray[2]);
      $feeId = $feeId[1];
      $course = new TSM_REGISTRATION_COURSE($courseId);
      if ($programId == "null") {
        $course->addFeeCondition($fee_condition_id, $feeId, null);
      } else {
        $course->addFeeCondition($fee_condition_id, $feeId, $programId);
      }
      //echo "Adding ".$fee_condition_id." to Fee ".$feeId." and Program ".$programId."...<br />";
    }
  }
  die("1");
}

$programs = $currentCampus->getPrograms();
foreach ($programs as $program) {
  $programObject = new TSM_REGISTRATION_PROGRAM($program['program_id']);
  $programs[$program['program_id']]['fees'] = $programObject->getFees();
  $programs[$program['program_id']]['courses'] = $programObject->getCourses();
  if (isset($programs[$program['program_id']]['courses'])) {
    foreach ($programs[$program['program_id']]['courses'] as $course) {
      $courseObject = new TSM_REGISTRATION_COURSE($course['course_id']);
      $programs[$program['program_id']]['courses'][$course['course_id']]['fees'] = $courseObject->getFees($program['program_id']);
    }
  }

}

$pageTitle = "Add ".$conditionInfo['name']." To Fees";
?>