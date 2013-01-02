<?php
$paymentPlans = $family->getPaymentPlans(1);
$plan_to_process = null;
foreach($paymentPlans as $payment_plan_id=>$fee_types){
	foreach($fee_types as $fee_type_id=>$setup_complete){
		if($setup_complete == 0 && $plan_to_process == null){
			$plan_to_process = $payment_plan_id;
		}
	}
}

if($plan_to_process == null){
	$family->moveToStep(7);
	header("Location: index.php?com=registration");
}

$paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($plan_to_process);
$planInfo = $paymentPlan->getInfo();
$planFeeTypes = $paymentPlans[$plan_to_process];

if(isset($setupComplete)){
	$family->completePaymentPlanSetup($plan_to_process);
}
?>