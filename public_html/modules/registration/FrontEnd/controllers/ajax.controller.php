<?php
$currentCampus = new TSM_REGISTRATION_CAMPUS($reg->getCurrentCampusId());
switch ($ajax) {
  case "unenrollFromCourse":
    if (isset($course_id) && isset($student_id) && isset($program_id)) {

      $student = new TSM_REGISTRATION_STUDENT($student_id);
      $success = $student->unenrollFromCourse($course_id, $program_id);

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The student has been successfully unenrolled from this course.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The student could not be unenrolled.";
      }

      echo json_encode($response);
    }
    break;
  case "unenrollFromProgram":
    if (isset($student_id) && isset($program_id)) {

      $student = new TSM_REGISTRATION_STUDENT($student_id);
      $success = $student->unenrollFromProgram($program_id);

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The student has been successfully unenrolled from this program.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The student could not be unenrolled from this program. Please make sure they are not enrolled in any courses.";
      }

      echo json_encode($response);
    }
    break;
  case "addPayPalFeeToInvoice":
    if (isset($family_invoice_id)) {
      $invoice = new TSM_REGISTRATION_INVOICE($family_invoice_id);
      $invoice->addPayPalFee();
      $newTotal = null;
      $newTotal = $invoice->getTotal();

      $response = Array("success" => false, "alertMessage" => null, "newTotal" => null);

      if ($newTotal) {
        $response["success"] = true;
        $response["alertMessage"] = null;
        $response["newTotal"] = $newTotal;
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The student could not be unenrolled from this program. Please make sure they are not enrolled in any courses.";
      }
      echo json_encode($response);

    }
    break;
}
die();

?>