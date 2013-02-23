<?php
$family = new TSM_REGISTRATION_FAMILY($family_id);
$familyInfo = $family->getInfo();
$students = $family->getStudents($reg->getSelectedSchoolYear());
if (isset($students)) {
  foreach ($students as $student) {
    $studentObject = new TSM_REGISTRATION_STUDENT($student['student_id']);
    $students[$student['student_id']]['tuition_total'] = $reg->addFees($studentObject->getFees($campusInfo['tuition_fee_type_id']));
    $students[$student['student_id']]['registration_total'] = $reg->addFees($studentObject->getFees($campusInfo['registration_fee_type_id']));
  }
}
$invoices = $family->getInvoices();
if (isset($invoices)) {
  foreach ($invoices as $invoice) {
    $invoiceObject = new TSM_REGISTRATION_INVOICE($invoice['family_invoice_id']);
    $invoices[$invoice['family_invoice_id']]['amountPaid'] = $invoiceObject->getAmountPaid();
    $invoices[$invoice['family_invoice_id']]['amountDue'] = $invoiceObject->getAmountDue();
  }
}

$pageTitle = $familyInfo['father_last'];
?>