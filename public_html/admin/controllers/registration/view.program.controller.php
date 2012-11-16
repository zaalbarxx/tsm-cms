<?php
$program = new TSM_REGISTRATION_PROGRAM($program_id);
$programInfo = $program->getInfo();
$programFees = $program->getFees();
$programRequirements = $program->getRequirements();
if($programFees){
	foreach($programFees as $fee){
		$programFees[$fee['program_fee_id']]['conditions'] = $program->getFeeConditions($fee['fee_id']);
	}
}
$pageTitle = $programInfo['name'];
?>