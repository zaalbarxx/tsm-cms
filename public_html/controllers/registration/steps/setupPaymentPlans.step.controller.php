<?php
//GET PAYMENT PLANS THAT ARE SET TO BILL IMMEDIATELY
$immediatePlans = $family->getPaymentPlans(1);
$partNowPartLaterPlans = $family->getPaymentPlans(4);
$paymentPlans = array_merge($immediatePlans, $partNowPartLaterPlans);
$familyInfo = $family->getInfo();
$plan_to_process = null;
foreach ($paymentPlans as $family_payment_plan_id => $familyPaymentPlan) {
  if ($familyPaymentPlan['setup_complete'] == 0 && $plan_to_process == null) {
    $plan_to_process = $familyPaymentPlan;
  }
}

if ($plan_to_process == null) {
  $family->moveToStep(0);
  $family->sendRegistrationConfirmation();
  header("Location: index.php?com=registration");
}

$paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($plan_to_process['payment_plan_id']);
$planInfo = $paymentPlan->getInfo();
$planFeeTypes = $plan_to_process['fee_types'];
$students = $family->getStudents($family->getSelectedSchoolYear());
foreach ($students as $student) {
  $studentObject = new TSM_REGISTRATION_STUDENT($student['student_id']);
  $studentInfo = $studentObject->getInfo();
  $students[$student['student_id']]['studentInfo'] = $studentInfo;
  foreach ($planFeeTypes as $fee_type_id) {
    $students[$student['student_id']]['planFeeTypes'][$fee_type_id] = $studentObject->getFees($fee_type_id);
    $students[$student['student_id']]['planFeeTotals'][$fee_type_id] = $reg->addFees($students[$student['student_id']]['planFeeTypes'][$fee_type_id]);
    if (isset($students[$student['student_id']]['planFeeTypes'][$fee_type_id])) {
      foreach ($students[$student['student_id']]['planFeeTypes'][$fee_type_id] as $key => $fee) {
        if (isset($fee['program_id'])) {
          $program = new TSM_REGISTRATION_PROGRAM($fee['program_id']);
          $program = $program->getInfo();
          $students[$student['student_id']]['planFeeTypes'][$fee_type_id][$key]['program_name'] = $program['name'];
        }

        if (isset($fee['course_id'])) {
          $course = new TSM_REGISTRATION_COURSE($fee['course_id']);
          $course = $course->getInfo();
          $students[$student['student_id']]['planFeeTypes'][$fee_type_id][$key]['course_name'] = $course['name'];
        }

      }
    }
  }
}
//$paymentPlanTotal = 0;
$allFees = Array();
foreach ($planFeeTypes as $fee_type_id) {
  $allFees = array_merge($allFees, $family->getFees($fee_type_id));
  //$paymentPlanTotal = $paymentPlanTotal + $reg->addFees($family->getFees($fee_type_id));
}
$paymentPlanTotal = $reg->addFees($allFees);

$invoices = $family->getInvoicesByPaymentPlan($plan_to_process['family_payment_plan_id']);

if (isset($acceptDisclaimer)) {
  $family->acceptDisclaimer($plan_to_process['family_payment_plan_id']);
}


if ($invoices == null) {

  $invoice_id = $family->createInvoice($plan_to_process['family_payment_plan_id']);
  $invoice = new TSM_REGISTRATION_INVOICE($invoice_id);

  foreach ($planFeeTypes as $fee_type_id) {
    $familyFees = $family->getFees($fee_type_id);

    foreach ($familyFees as $fee) {
      $familyFee = new TSM_REGISTRATION_FAMILY_FEE($fee['family_fee_id']);
      $familyFee->setPaymentPlan($plan_to_process['family_payment_plan_id']);
      $feeObject = new TSM_REGISTRATION_FEE($fee['fee_id']);
      $familyFeeInfo = $familyFee->getInfo();
      $invoice->addFee(Array("family_fee_id" => $fee['family_fee_id'], "description" => $familyFeeInfo['name'], "amount" => $familyFeeInfo['amount']));
    }
  }
  $invoice->updateTotal();
  $planTotal = $invoice->getTotal();

  if (isset($familyInfo['quickbooks_customer_id']) && $currentCampus->usesQuickbooks()) {
    //$invoice->addToQuickbooks();
  }

  $dueToday = $planTotal;

  if ($plan_to_process['payment_plan_type_id'] == 4) {
    $installmentFee = new TSM_REGISTRATION_FEE($plan_to_process['installment_fee_id']);
    $installmentFeeInfo = $installmentFee->getInfo();
    $percentage = $plan_to_process['immediate_invoice_percentage'] / 100;
    $installmentFeeAmount = $planTotal * $percentage;

    $creditFee = new TSM_REGISTRATION_FEE($plan_to_process['credit_fee_id']);
    $creditFeeInfo = $creditFee->getInfo();
    $creditFeeAmount = -$planTotal;

    //Credit intial invoice back to account so we can bill in installments.
    $invoice_id = $family->createInvoice($plan_to_process['family_payment_plan_id']);
    $family_fee_id = $family->addFee($plan_to_process['credit_description'], $creditFeeAmount, $plan_to_process['credit_fee_id'], $creditFeeInfo['fee_type_id']);
    $familyFee = new TSM_REGISTRATION_FAMILY_FEE($family_fee_id);
    $familyFee->setPaymentPlan($plan_to_process['family_payment_plan_id']);
    $invoice = new TSM_REGISTRATION_INVOICE($invoice_id);
    $invoice->addFee(Array("family_fee_id" => $family_fee_id, "description" => $plan_to_process['credit_description'], "amount" => $creditFeeAmount));
    $invoice->updateTotal();

    //Invoice first installment
    $invoice_id = $family->createInvoice($plan_to_process['family_payment_plan_id']);
    $family_fee_id = $family->addFee($plan_to_process['installment_description'], $installmentFeeAmount, $plan_to_process['installment_fee_id'], $installmentFeeInfo['fee_type_id']);
    $familyFee = new TSM_REGISTRATION_FAMILY_FEE($family_fee_id);
    $familyFee->setPaymentPlan($plan_to_process['family_payment_plan_id']);
    $invoice = new TSM_REGISTRATION_INVOICE($invoice_id);
    $invoice->addFee(Array("family_fee_id" => $family_fee_id, "description" => $plan_to_process['installment_description'], "amount" => $installmentFeeAmount));
    $invoice->updateTotal();

    $dueToday = $installmentFeeAmount;
  }
} else {
  if ($plan_to_process['payment_plan_type_id'] == 1) {
    $invoice_id = $invoices[0]['family_invoice_id'];
  } else {
    $invoice_id = $invoices[2]['family_invoice_id'];
  }
  $invoice = new TSM_REGISTRATION_INVOICE($invoice_id);
  $dueToday = $invoice->getTotal();
}
?>