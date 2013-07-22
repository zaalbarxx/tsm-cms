<?php
$paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($paymentPlanId);
$paymentPlanInfo = $paymentPlan->getInfo();
$familyPaymentPlans = $paymentPlan->getFamilyPaymentPlans();
if(isset($familyPaymentPlans)){
	foreach($familyPaymentPlans as $family_payment_plan_id=>$familyPaymentPlan){
		$familyPaymentPlanObject = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($family_payment_plan_id);

		$familyPaymentPlans[$family_payment_plan_id]['status'] = $familyPaymentPlanObject->getStatus();
		$familyObject = new TSM_REGISTRATION_FAMILY($familyPaymentPlan['family_id']);
		$families[$familyPaymentPlan['family_id']] = $familyObject->getInfo();
		$families[$familyPaymentPlan['family_id']]['family_name'] = $familyObject->getFamilyName();
	}
}
?>