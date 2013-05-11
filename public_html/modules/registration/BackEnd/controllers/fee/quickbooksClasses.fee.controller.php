<?php
$classService = new QuickBooks_IPP_Service_Class();
$qbClasses = $classService->findAll($quickbooks->Context,$quickbooks->creds['qb_realm']);
if(isset($qbClasses)){
  foreach($qbClasses as $class){
    $classes[$class->getId()] = $class->getName();
  }
  asort($classes);
}

if (isset($saveClasses)) {
  foreach ($_POST as $key => $value) {
    $addArray = explode("_", $key);
    if (stristr($key, "programFeeId")) {
      $programFeeId = explode(":", $key);
      $programFeeId = $programFeeId[1];
      $programFee = new TSM_REGISTRATION_PROGRAM_FEE($programFeeId);
      $programFee->setQuickbooksClassId($value);
    }
    if (stristr($key, "courseFeeId")) {
      $courseFeeId = explode(":", $key);
      $courseFeeId = $courseFeeId[1];
      $courseFee = new TSM_REGISTRATION_COURSE_FEE($courseFeeId);
      $courseFee->setQuickbooksClassId($value);
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
      $programs[$program['program_id']]['courses'][$course['course_id']]['courseOnlyFees'] = $courseObject->getFees(null, null);
    }
  }

}

$pageTitle = "Quickbooks Classes";
?>