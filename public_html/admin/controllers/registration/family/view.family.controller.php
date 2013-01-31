<?php
$family = new TSM_REGISTRATION_FAMILY($family_id);
$familyInfo = $family->getInfo();
$students = $family->getStudents($reg->getSelectedSchoolYear());
if (isset($students)) {
  foreach ($students as $student) {
    $studentObject = new TSM_REGISTRATION_STUDENT($student['student_id']);
    $students[$student['student_id']]['tuition_total'] = $reg->addFees($studentObject->getFees(1));
    $students[$student['student_id']]['registration_total'] = $reg->addFees($studentObject->getFees(2));
  }
}
//$family->getFees(1);
$pageTitle = $familyInfo['father_last'];
?>