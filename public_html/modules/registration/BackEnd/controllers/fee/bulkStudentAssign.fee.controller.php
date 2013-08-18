<?php
$students = $currentCampus->getStudents();
if(isset($students)){
	foreach($students as $student){
		$studentObject = new TSM_REGISTRATION_STUDENT($student['student_id']);
		if($studentObject->assignedFee($fee_id,null,null)){
			unset($students[$student['student_id']]);
		}
	}
}
?>