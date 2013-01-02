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
	$family->moveToStep(0);
	header("Location: index.php?com=registration");
}

$paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($plan_to_process);
$planInfo = $paymentPlan->getInfo();
$planFeeTypes = $paymentPlans[$plan_to_process];
$students = $family->getStudents($family->getSelectedSchoolYear());
foreach($students as $student){
	$studentObject = new TSM_REGISTRATION_STUDENT($student['student_id']);
	$studentInfo = $studentObject->getInfo();
	$students[$student['student_id']]['studentInfo'] = $studentInfo;
	foreach($planFeeTypes as $fee_type_id=>$array){
		$students[$student['student_id']]['planFeeTypes'][$fee_type_id] = $studentObject->getFees($fee_type_id);
		$students[$student['student_id']]['planFeeTotals'][$fee_type_id] = $reg->addFees($students[$student['student_id']]['planFeeTypes'][$fee_type_id]);
		foreach($students[$student['student_id']]['planFeeTypes'][$fee_type_id] as $key=>$fee){
			if(isset($fee['program_id'])){
				$program = new TSM_REGISTRATION_PROGRAM($fee['program_id']);
				$program = $program->getInfo();
				$students[$student['student_id']]['planFeeTypes'][$fee_type_id][$key]['program_name'] = $program['name'];
			}
			
			if(isset($fee['course_id'])){
				$course = new TSM_REGISTRATION_COURSE($fee['course_id']);
				$course = $course->getInfo();
				$students[$student['student_id']]['planFeeTypes'][$fee_type_id][$key]['course_name'] = $course['name'];
			}
			
		}
	}
}
$paymentPlanTotal = 0;
foreach($planFeeTypes as $fee_type_id=>$value){
	$paymentPlanTotal = $paymentPlanTotal + $reg->addFees($family->getFees($fee_type_id));
}

$invoices = $family->getInvoicesByPaymentPlan($plan_to_process);
if($invoices == null){
	$invoice_id = $family->createInvoice($plan_to_process);
	$invoice = new TSM_REGISTRATION_INVOICE($invoice_id);
	foreach($planFeeTypes as $fee_type_id=>$array){
		$familyFees = $family->getFees($fee_type_id);
		foreach($familyFees as $fee){
			$invoice->addFee($fee['family_fee_id']);
		}
	}
	$invoice->updateTotal();
} else {
	$invoice_id = $invoices[0]['family_invoice_id'];
}
?>