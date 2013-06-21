<?php
$course = new TSM_REGISTRATION_COURSE($course_id);
$courseInfo = $course->getInfo();
$courseStudents = $course->getEnrolledStudents();
$periods = $course->getPeriods();
foreach($courseStudents as $id=>$student){
  $courseStudents[$id]['period'] = $reg->displayPeriod($periods[$student['course_period_id']]);
}

$periods = $course->getPeriods();
foreach($periods as $period){
  foreach($courseStudents as $student){
    if($student['course_period_id'] == $period['course_period_id']){
      $periods[$period['course_period_id']]['students'][] = $student;
    }
  }
  $periods[$period['course_period_id']]['students'];
}

if (isset($downloadCSV)) {
  $tsm->arrayToCSV($courseStudents, $courseInfo['name']." - Roster");
}


$pageTitle = $courseInfo['name']." Roster";
?>