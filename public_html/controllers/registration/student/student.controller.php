<?php
if(!isset($action)){
  $action = null;
}

switch($action){
	case null:
		$students = $family->getStudents($reg->getSelectedSchoolYear());
		foreach($students as $student){

		}
		
		$activeView = __TSM_ROOT__."views/registration/student/student.view.php";
		break;
	case "viewStudent":
		require_once( __TSM_ROOT__."controllers/registration/student/view.student.controller.php");
		$activeView = __TSM_ROOT__."views/registration/student/view.student.view.php";
		break;
	case "addEditStudent":
		require_once( __TSM_ROOT__."controllers/registration/student/addEdit.student.controller.php");
		$activeView = __TSM_ROOT__."views/registration/student/addEdit.student.view.php";
		break;
	case "addProgram":
		require_once( __TSM_ROOT__."controllers/registration/student/addProgram.student.controller.php");
		$activeView = __TSM_ROOT__."views/registration/student/addProgram.student.view.php";
		break;
	case "addCourse":
		require_once( __TSM_ROOT__."controllers/registration/student/addCourse.student.controller.php");
		$activeView = __TSM_ROOT__."views/registration/student/addCourse.student.view.php";
		break;
}



?>