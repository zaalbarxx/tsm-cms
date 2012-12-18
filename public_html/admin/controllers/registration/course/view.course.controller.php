<?php
$course = new TSM_REGISTRATION_COURSE($course_id);
$courseInfo = $course->getInfo();
$courseFees = $course->getFees();
$courseRequirements = $course->getRequirements();
if($courseFees){
	foreach($courseFees as $fee){
		$courseFees[$fee['course_fee_id']]['conditions'] = $course->getFeeConditions($fee['fee_id']);
	}
}
$pageTitle = $courseInfo['name'];
?>