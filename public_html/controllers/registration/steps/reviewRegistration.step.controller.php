<?php
$students = $family->getStudents($reg->getSelectedSchoolYear());
foreach ($students as $student) {
  $student = new TSM_REGISTRATION_STUDENT($student['student_id']);
  $studentInfo = $student->getInfo();
  $students[$studentInfo['student_id']]['programs'] = $student->getEnrolledPrograms();

  if ($student->isApproved() == true) {
    $studentStatus = "Approved";
  } else {
    $studentStatus = "Unapproved";
  }

  if (isset($students[$studentInfo['student_id']]['programs'])) {
    foreach ($students[$studentInfo['student_id']]['programs'] as $program) {
      $students[$studentInfo['student_id']]['programs'][$program['program_id']]['tuition_total'] = $reg->addFees($student->getFeesForProgramAndCourses($program['program_id'], 1));
      $students[$studentInfo['student_id']]['programs'][$program['program_id']]['registration_total'] = $reg->addFees($student->getFeesForProgramAndCourses($program['program_id'], 2));
      $students[$studentInfo['student_id']]['programs'][$program['program_id']]['courses'] = $student->getCoursesIn($program['program_id']);
      if (isset($students[$studentInfo['student_id']]['programs'][$program['program_id']]['courses'])) {
        foreach ($students[$studentInfo['student_id']]['programs'][$program['program_id']]['courses'] as $course) {
          $students[$studentInfo['student_id']]['programs'][$program['program_id']]['courses'][$course['course_id']]['tuition_amount'] = $reg->addFees($student->getFeesForCourse($course['course_id'], $program['program_id'], 1));
          $students[$studentInfo['student_id']]['programs'][$program['program_id']]['courses'][$course['course_id']]['registration_amount'] = $reg->addFees($student->getFeesForCourse($course['course_id'], $program['program_id'], 2));
        }
      }

    }

  }

  $students[$studentInfo['student_id']]['tuitionTotal'] = $reg->addFees($student->getFees(1));
  $students[$studentInfo['student_id']]['registrationTotal'] = $reg->addFees($student->getFees(2));
  $students[$studentInfo['student_id']]['studentTotal'] = $reg->addFees($student->getFees(null));

}
//print_r($students);die();

$pageTitle = $studentInfo['last_name'].", ".$studentInfo['first_name'];
?>