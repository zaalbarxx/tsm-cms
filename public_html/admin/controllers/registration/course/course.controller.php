<?php
if(!isset($action)){
	$action = null;
}


switch($action){
	case null:
		$courseList = $currentCampus->getCourses();
		if($courseList){
			foreach($courseList as $course){
				$courseObject = new TSM_REGISTRATION_COURSE($course['course_id']);
				$courseList[$course['course_id']]['num_students'] = $courseObject->getNumStudentsEnrolled(); 
			}
		}
		$activeView = __TSM_ROOT__."admin/views/registration/course/courses.view.php";
		break;
    case "addFee":
      require_once(__TSM_ROOT__."admin/controllers/registration/course/addFee.course.controller.php");
      $activeView = __TSM_ROOT__."admin/views/registration/course/addFee.course.view.php";
      break;
    case "addRequirement":
      require_once(__TSM_ROOT__."admin/controllers/registration/course/addRequirement.course.controller.php");
      $activeView = __TSM_ROOT__."admin/views/registration/course/addRequirement.course.view.php";
      break;
    case "addPeriod":
      require_once(__TSM_ROOT__."admin/controllers/registration/course/addPeriod.course.controller.php");
      $activeView = __TSM_ROOT__."admin/views/registration/course/addPeriod.course.view.php";
      break;
    case "addCondition":
      require_once(__TSM_ROOT__."admin/controllers/registration/course/addCondition.course.controller.php");
      $activeView = __TSM_ROOT__."admin/views/registration/course/addCondition.course.view.php";
      break;
    case "viewCourse":
      require_once(__TSM_ROOT__."admin/controllers/registration/course/view.course.controller.php");
      $activeView = __TSM_ROOT__."admin/views/registration/course/view.course.view.php";
    break; 
	case "addEditCourse":
		require_once(__TSM_ROOT__."admin/controllers/registration/course/addEdit.course.controller.php");
		$activeView = __TSM_ROOT__."admin/views/registration/course/addEdit.course.view.php";
		break;
}	
	
?>