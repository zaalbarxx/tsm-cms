<?php
$student = new TSM_REGISTRATION_STUDENT($student_id);
$studentInfo = $student->getInfo();
$program = new TSM_REGISTRATION_PROGRAM($program_id);
$programInfo = $program->getInfo();
$eligibleCourses = $student->getEligibleCoursesForProgram($program_id);
if(isset($eligibleCourses)){
	foreach($eligibleCourses as $course){
		$courseObject = new TSM_REGISTRATION_COURSE($course['course_id']);
		$eligibleCourses[$course['course_id']]['periods'] = $courseObject->getPeriods();
	}
}

if(!isset($searchq)){
  $searchq = null;
}

if(isset($enrollInCourse)){
  if($student->enrollInCourse($enrollInCourse,$program_id,$course_period_id)){
    die("1");  
  } else {
    die("0");
  }
}

$pageTitle = "Add Course for ".$studentInfo['first_name']." in ".$programInfo['name'];
?>