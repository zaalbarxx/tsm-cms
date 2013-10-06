<?php

if(isset($student_id)){

	$student = new TSM_REGISTRATION_STUDENT($student_id);
	$familyInfo = $family->getInfo();
	if(isset($nickname) && count($_POST)==4){
		if($student->editInfo($_POST,$familyInfo['family_id'])){
			header('Location:http://schoolsystem.dev/index.php?mod=registration&view=student&action=viewStudent&student_id='.$student_id);
		}
		else{
			$error = 'error';
		}
	}

	$studentInfo = $student->getInfo(); 
}
else{
	header('Location:http://schoolsystem.dev/index.php?mod=registration&view=student');
}