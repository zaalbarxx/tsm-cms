<?php
if(!isset($action)){
  $action = null;
}

switch($action){
	case null:
		$students = $currentCampus->getStudents();
		
		$activeView = __TSM_ROOT__."admin/views/registration/student/student.view.php";
		break;
	case "viewStudent":
		require_once( __TSM_ROOT__."admin/controllers/registration/student/view.student.controller.php");
		$activeView = __TSM_ROOT__."admin/views/registration/student/view.student.view.php";
		break;
	case "addProgram":
		require_once( __TSM_ROOT__."admin/controllers/registration/student/addProgram.student.controller.php");
		$activeView = __TSM_ROOT__."admin/views/registration/student/addProgram.student.view.php";
		break;
	case "addCourse":
		require_once( __TSM_ROOT__."admin/controllers/registration/student/addCourse.student.controller.php");
		$activeView = __TSM_ROOT__."admin/views/registration/student/addCourse.student.view.php";
		break;
}



?>