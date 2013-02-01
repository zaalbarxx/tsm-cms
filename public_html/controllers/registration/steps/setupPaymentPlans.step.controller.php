<?php
//GET PAYMENT PLANS THAT ARE SET TO BILL IMMEDIATELY
$paymentPlans = $family->getPaymentPlans(1);
$familyInfo = $family->getInfo();
$plan_to_process = null;
foreach ($paymentPlans as $family_payment_plan_id => $familyPaymentPlan) {
  if ($familyPaymentPlan['setup_complete'] == 0 && $plan_to_process == null) {
    $plan_to_process = $familyPaymentPlan;
  }
}

if ($plan_to_process == null) {
  $family->moveToStep(0);
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
$paymentPlanTotal = 0;
foreach ($planFeeTypes as $fee_type_id) {
  $paymentPlanTotal = $paymentPlanTotal + $reg->addFees($family->getFees($fee_type_id));
}

$invoices = $family->getInvoicesByPaymentPlan($plan_to_process['family_payment_plan_id']);


if ($invoices == null) {
  $invoice_id = $family->createInvoice($plan_to_process['family_payment_plan_id']);
  $invoice = new TSM_REGISTRATION_INVOICE($invoice_id);

  foreach ($planFeeTypes as $fee_type_id) {
    $familyFees = $family->getFees($fee_type_id);

    foreach ($familyFees as $fee) {
      $familyFee = new TSM_REGISTRATION_FAMILY_FEE($fee['family_fee_id']);
      $familyFee->setPaymentPlan($plan_to_process['family_payment_plan_id']);
      $feeObject = new TSM_REGISTRATION_FEE($fee['fee_id']);
      $feeInfo = $feeObject->getInfo();
      $invoice->addFee($fee['family_fee_id']);
    }
  }
  $invoice->updateTotal();

  if (isset($familyInfo['quickbooks_customer_id']) && $currentCampus->usesQuickbooks()) {
    //$invoice->addToQuickbooks();
  }
} else {
  $invoice_id = $invoices[0]['family_invoice_id'];
  //$invoice = new TSM_REGISTRATION_INVOICE($invoice_id);
  //$invoiceInfo = $invoice->getInfo();
  //$invoiceService = new QuickBooks_IPP_Service_Invoice();
  //$qbInvoice = $invoiceService->findById($quickbooks->Context,$quickbooks->creds['qb_realm'],$invoiceInfo['quickbooks_invoice_id']);
  //echo $invoiceService->lastResponse();

  //die();
}
?>