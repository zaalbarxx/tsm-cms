<?php
$family = new TSM_REGISTRATION_FAMILY($family_id);
if (isset($registerFamily)) {
  if ($family->registerFamily()) {
    header('Location: index.php?mod=registration&view=family');
  }
}
if (isset($saveFamily)) {
  if ($family->saveFamily($family_id)) {
    header('Location: index.php?mod=registration&view=family&action=viewFamily&family_id='.$family_id);
  }
}
if(isset($deactivateFamily)){
  $students = $family->getStudents();
  foreach($students as $s){
    $student = new TSM_REGISTRATION_STUDENT($s['student_id']);
    $programs = $student->getStudentPrograms();
    $courses = $student->getStudentCourses();
    foreach($courses as $course){
      $student->unenrollFromCourse($course['course_id'],$course['program_id']);
    }
    foreach($programs as $program){
      $student->unenrollFromProgram($program['program_id']);
    }
  }
  $family->deactivateFamily($students);
  header('Location:index.php?mod=registration&view=family');
}

if (isset($family_id)) {
  $family = new TSM_REGISTRATION_FAMILY($family_id);
  $familyInfo = $family->getInfo();
  $pageTitle = "Edit Family";
  $submitField = "saveFamily";
} else {
  $pageTitle = "Add Family";
  $submitField = "registerFamily";
  $programInfo = null;
}

/*
if ($currentCampus->usesQuickbooks() == true) {
  $CustomerService = new QuickBooks_IPP_Service_Customer();
  $query = '<FirstLastInside>'.$familyInfo['father_last'].'</FirstLastInside>';
  $quickbooksCustomers = $CustomerService->findAll($quickbooks->Context, $quickbooks->creds['qb_realm'], $query, 1, 999);
  if ($quickbooksCustomers == null) {
    $query = '<FirstLastInside>'.$familyInfo['mother_last'].'</FirstLastInside>';
    $quickbooksCustomers = $CustomerService->findAll($quickbooks->Context, $quickbooks->creds['qb_realm'], $query, 1, 999);
  }
}
*/
?>