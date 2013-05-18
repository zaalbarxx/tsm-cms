<?php
$family = new TSM_REGISTRATION_FAMILY($family_id);
$familyInfo = $family->getInfo();
$familyInfo['school_year_info'] = $family->getSchoolYearInfo();
$students = $family->getStudents($reg->getSelectedSchoolYear());
if (isset($students)) {
  foreach ($students as $student) {
    $studentObject = new TSM_REGISTRATION_STUDENT($student['student_id']);
    $students[$student['student_id']]['age'] = $studentObject->getAge();
    $students[$student['student_id']]['tuition_total'] = $reg->addFees($studentObject->getFees($campusInfo['tuition_fee_type_id']));
    $students[$student['student_id']]['registration_total'] = $reg->addFees($studentObject->getFees($campusInfo['registration_fee_type_id']));
  }
}
$invoices = $family->getInvoices();
$paymentPlans = $family->getPaymentPlans();
if (isset($invoices)) {
  foreach ($invoices as $invoice) {
    $invoiceObject = new TSM_REGISTRATION_INVOICE($invoice['family_invoice_id']);
    $invoices[$invoice['family_invoice_id']]['amountPaid'] = number_format($invoiceObject->getAmountPaid(), 2, '.', ',');
    $invoices[$invoice['family_invoice_id']]['amountDue'] = number_format($invoiceObject->getAmountDue(), 2, '.', ',');
  }
}

if(isset($paymentPlans)){
  foreach($paymentPlans as $paymentPlan){

    $paymentPlanObject = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($paymentPlan['family_payment_plan_id']);
    $paymentPlans[$paymentPlan['family_payment_plan_id']]['status'] = $paymentPlanObject->getStatus();
    $paymentPlans[$paymentPlan['family_payment_plan_id']]['amountDue'] = number_format($paymentPlanObject->getAmountDue(), 2, '.', ',');
    $paymentPlans[$paymentPlan['family_payment_plan_id']]['amountPaid'] = number_format($paymentPlanObject->getAmountPaid(), 2, '.', ',');
    $paymentPlans[$paymentPlan['family_payment_plan_id']]['totalAmount'] = number_format($paymentPlanObject->getTotal(), 2, '.', ',');
    $paymentPlans[$paymentPlan['family_payment_plan_id']]['amountInvoiced'] = number_format($paymentPlanObject->getAmountInvoiced(), 2, '.', ',');
    if($paymentPlanObject->getUnassignedApplicableFees()){
      $paymentPlans[$paymentPlan['family_payment_plan_id']]['moreFeesAvailible'] = true;
    } else {
      $paymentPlans[$paymentPlan['family_payment_plan_id']]['moreFeesAvailible'] = false;
    }
    foreach($paymentPlans[$paymentPlan['family_payment_plan_id']]['fee_types'] as $feeType){
      $paymentPlans[$paymentPlan['family_payment_plan_id']]['fee_type_names'] .= $currentCampus->getFeeTypeName($feeType).", ";
    }
    $paymentPlans[$paymentPlan['family_payment_plan_id']]['fee_type_names'] = substr_replace($paymentPlans[$paymentPlan['family_payment_plan_id']]['fee_type_names'] ,"",-2);
  }
}
$looseFees = $family->getLooseFees();
//print_r($paymentPlans);die();


if (isset($loginAs)) {
  $reg->loginAs($familyInfo['family_id']);
}

$pageTitle = $familyInfo['father_last'];
?>