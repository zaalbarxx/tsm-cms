<?php
$student = new TSM_REGISTRATION_STUDENT($student_id);
$studentInfo = $student->getInfo();
$programs = $student->getEnrolledPrograms();
if(isset($programs)){
	foreach($programs as $program){
		$programs[$program['program_id']]['courses'] = $student->getCoursesIn($program['program_id']);
	}
}
$pageTitle = $studentInfo['last_name'].", ".$studentInfo['first_name'];
?>