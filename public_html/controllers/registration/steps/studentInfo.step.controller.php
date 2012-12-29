<?php
if(isset($addStudent)){
	if($currentCampus->studentExists($first_name,$birth_date)){
		
	} else {
		$student_id = $family->addStudent();
		if($student_id){
			$student = new TSM_REGISTRATION_STUDENT($student_id);
			$student->addToSchoolYear($currentCampus->getCurrentSchoolYear());
			$family->moveToNextStep();
			header('Location: index.php?com=registration');
		}
	}
}


$studentInfo = null;
$submitField = "addStudent";
$pageTitle = "Add A Student";
$headerMessage = "Please add a student by entering their information below.";

error_reporting(E_ALL ^ E_NOTICE);
//$familyInfo = $family->getInfo();

?>