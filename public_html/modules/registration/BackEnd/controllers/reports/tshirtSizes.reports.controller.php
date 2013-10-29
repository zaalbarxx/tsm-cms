<?php

$students = $currentCampus->getStudents();
foreach($students as $student){
	$studentObject = new TSM_REGISTRATION_STUDENT($student['student_id']);
	if(!$studentObject->inAProgram()){
		unset($students[$student['student_id']]);
	} else {
		$tshirts[$studentObject->getShirtSize()]['size'] = $studentObject->getShirtSize();
		$tshirts[$studentObject->getShirtSize()]['count'] = $tshirts[$studentObject->getShirtSize()]['count'] + 1;
	}
}
$tsm->arrayToCSV($tshirts, $campusInfo['name']." - T-Shirt Sizes");
