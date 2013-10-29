<?php
$totalTuition = $currentCampus->getTotalExpectedRevenue($campusInfo['tuition_fee_type_id']);
$totalRegistration = $currentCampus->getTotalExpectedRevenue($campusInfo['registration_fee_type_id']);

/*
$paymentPlans = $currentCampus->getPaymentPlans();
$totalFinalizedRevenue = 0;
foreach($paymentPlans as $paymentPlan){
	$paymentPlanObject = new TSM_REGISTRATION_PAYMENT_PLAN($paymentPlan['payment_plan_id']);
	$familyPaymentPlans = $paymentPlanObject->getFamilyPaymentPlans();
	if(isset($familyPaymentPlans)){
		foreach($familyPaymentPlans as $familyPaymentPlan){
			$familyPaymentPlanObject = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($familyPaymentPlan['family_payment_plan_id']);
			if($familyPaymentPlanObject->getStatus() == "In Progress" or $familyPaymentPlanObject->getStatus() == "Paid in Full"){
				$totalFinalizedRevenue = $totalFinalizedRevenue + $familyPaymentPlanObject->getTotal();
			}
		}
	}
}
*/
$totalFinalizedRevenue = $currentCampus->getFinalizedRevenue();

?>