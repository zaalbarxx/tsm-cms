<?php
$family = new TSM_REGISTRATION_FAMILY($family_id);
$familyInfo = $family->getInfo();
$students = $family->getStudents($reg->getSelectedSchoolYear());
$pageTitle = $familyInfo['father_last'];
?>