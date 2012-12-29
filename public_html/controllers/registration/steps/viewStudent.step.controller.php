<?php
if(!isset($student_id)){
	$student_id = $family->getLatestStudent();
}
$student = new TSM_REGISTRATION_STUDENT($student_id);
$studentInfo = $student->getInfo();
$programs = $student->getEnrolledPrograms();
/*
echo "<pre>";
print_r($student->getFees());
echo "</pre>";
die();
*/
if($student->isApproved() == true){
	$studentStatus = "Approved";
} else {
	$studentStatus = "Unapproved";
}

if(isset($programs)){
	foreach($programs as $program){
		$programs[$program['program_id']]['tuition_total'] = $reg->addFees($student->getFeesForProgramAndCourses($program['program_id'],1));
		$programs[$program['program_id']]['registration_total'] = $reg->addFees($student->getFeesForProgramAndCourses($program['program_id'],2));
		$programs[$program['program_id']]['courses'] = $student->getCoursesIn($program['program_id']);
		if(isset($programs[$program['program_id']]['courses'])){
			foreach($programs[$program['program_id']]['courses'] as $course){
				$programs[$program['program_id']]['courses'][$course['course_id']]['tuition_amount'] = $reg->addFees($student->getFeesForCourse($course['course_id'],$program['program_id'],1));
				$programs[$program['program_id']]['courses'][$course['course_id']]['registration_amount'] = $reg->addFees($student->getFeesForCourse($course['course_id'],$program['program_id'],2));
			}
		}

	}

}

$tuitionTotal = $reg->addFees($student->getFees(1));
$registrationTotal = $reg->addFees($student->getFees(2));
$grandTotal = $reg->addFees($student->getFees(null));

$pageTitle = $studentInfo['last_name'].", ".$studentInfo['first_name'];
?>