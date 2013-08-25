<?php
	$student = new TSM_REGISTRATION_STUDENT($student_id);
	if(isset($_POST['registration_date'])){
		$student->updateProgramRegistrationDate($student_program_id,$registration_date);
		header('Location:/admin/index.php?mod=registration&view=student&action=viewStudent&student_id='.$student_id);
	}
	else{
		$student_program = $student->getProgramById($student_program_id);
		$pageTitle = 'Edit registration date';
	}
