<?php
$student = new TSM_REGISTRATION_STUDENT($student_id);
$studentInfo = $student->getInfo();
$programs = $student->getEnrolledPrograms();

if ($student->isApproved() == true) {
  $studentStatus = "Approved";
} else {
  $studentStatus = "Unapproved";
}

if (isset($programs)) {
  foreach ($programs as $program) {
    $programs[$program['program_id']]['tuition_total'] = $reg->addFees($student->getFeesForProgramAndCourses($program['program_id'], $campusInfo['tuition_fee_type_id']));
    $programs[$program['program_id']]['registration_total'] = $reg->addFees($student->getFeesForProgramAndCourses($program['program_id'], $campusInfo['registration_fee_type_id']));
    $programs[$program['program_id']]['courses'] = $student->getCoursesIn($program['program_id']);
    if (isset($programs[$program['program_id']]['courses'])) {
      foreach ($programs[$program['program_id']]['courses'] as $course) {
        $programs[$program['program_id']]['courses'][$course['course_id']]['tuition_amount'] = $reg->addFees($student->getFeesForCourse($course['course_id'], $program['program_id'], $campusInfo['tuition_fee_type_id']));
        $programs[$program['program_id']]['courses'][$course['course_id']]['registration_amount'] = $reg->addFees($student->getFeesForCourse($course['course_id'], $program['program_id'], $campusInfo['registration_fee_type_id']));
      }
    }

  }

}

$tuitionTotal = $reg->addFees($student->getFees($campusInfo['tuition_fee_type_id']));
$registrationTotal = $reg->addFees($student->getFees($campusInfo['registration_fee_type_id']));
$grandTotal = $reg->addFees($student->getFees(null));

$pageTitle = $studentInfo['last_name'].", ".$studentInfo['first_name'];
?>