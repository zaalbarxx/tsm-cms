<?php
$currentCampus = new TSM_REGISTRATION_CAMPUS($reg->getCurrentCampusId());
switch ($ajax) {
  case "formSubmission":
    switch ($formAction) {
      case "saveFee":
        if ($currentCampus->saveFee($fee_id)) {
          $response = true;
          $redirect = "index.php?com=registration&view=fees";
        } else {
          $response = false;
        }
        break;
      case "createFee":
        if ($currentCampus->createFee()) {
          $response = true;
          $redirect = "index.php?com=registration&view=fees";
        } else {
          $response = false;
        }
        break;
      case "savePaymentPlan":
        if ($currentCampus->savePaymentPlan($payment_plan_id)) {
          $response = true;
          $redirect = "index.php?com=registration&view=fees&action=paymentPlans";
        } else {
          $response = false;
        }
        break;
      case "createPaymentPlan":
        if ($currentCampus->createPaymentPlan()) {
          $response = true;
          $redirect = "index.php?com=registration&view=fees&action=paymentPlans";
        } else {
          $response = false;
        }
        break;
    }
    if (isset($fb)) {
      echo $response;
    } else {
      echo $redirect;
    }
    break;
  case "deleteProgram":
    $program = new TSM_REGISTRATION_PROGRAM($programId);
    if ($program->delete()) {
      echo "1";
    } else {
      echo "0";
    }
    break;
  case "deleteCourse":
    $course = new TSM_REGISTRATION_COURSE($courseId);
    if ($course->delete()) {
      echo "1";
    } else {
      echo "0";
    }
    break;
  case "deleteFeeFromProgram":
    if (isset($program_id) && isset($fee_id)) {
      $program = new TSM_REGISTRATION_PROGRAM($program_id);
      $success = $program->deleteFee($fee_id);

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The fee was successfully deleted from this program. However, if any students have already been approved, this fee will still apply to their account.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The fee could not be removed.";
      }

      echo json_encode($response);
    }
    break;
  case "deleteFeeFromCourse":
    if (isset($course_id) && isset($course_fee_id)) {
      $course = new TSM_REGISTRATION_COURSE($course_id);
      $success = $course->deleteFee($course_fee_id);

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The fee was successfully deleted from this course. However, if any students have already been approved, this fee will still apply to their account.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The fee could not be removed.";
      }

      echo json_encode($response);
    }
    break;
  case "deleteFeeConditionFromProgram":
    if (isset($program_id) && isset($program_fee_condition_id)) {
      $program = new TSM_REGISTRATION_PROGRAM($program_id);
      $success = $program->deleteFeeCondition($program_fee_condition_id);

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The condition was successfully removed from the fee.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The condition could not be removed.";
      }

      echo json_encode($response);
    }
    break;
  case "deleteFeeConditionFromCourse":
    if (isset($course_id) && isset($course_fee_condition_id)) {
      $course = new TSM_REGISTRATION_COURSE($course_id);
      $success = $course->deleteFeeCondition($course_fee_condition_id);

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The condition was successfully removed from the fee.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The condition could not be removed.";
      }

      echo json_encode($response);
    }
    break;
  case "deletePeriodFromCourse":
    if (isset($course_id) && isset($course_period_id)) {
      $course = new TSM_REGISTRATION_COURSE($course_id);
      $success = $course->deletePeriod($course_period_id);

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The period was successfully removed from the course.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The period could not be removed.";
      }

      echo json_encode($response);
    }
    break;
  case "deleteFee":
    if ($currentCampus->deleteFee($fee_id)) {
      echo true;
    } else {
      echo false;
    }
    break;
  case "removeCourseFromProgram":
    $program = new TSM_REGISTRATION_PROGRAM($program_id);
    $success = $program->removeCourse($course_id);

    $response = Array("success" => false, "alertMessage" => null);

    if ($success == true) {
      $response["success"] = true;
      $response["alertMessage"] = "The course was successfully removed from the program.";
    } else {
      $response["success"] = false;
      $response["alertMessage"] = "The course could not be removed.";
    }

    echo json_encode($response);

    break;
  case "deleteRequirementFromProgram":
    $program = new TSM_REGISTRATION_PROGRAM($program_id);
    $success = $program->removeRequirement($requirement_id);

    $response = Array("success" => false, "alertMessage" => null);

    if ($success == true) {
      $response["success"] = true;
      $response["alertMessage"] = "The requirement was successfully removed from the program.";
    } else {
      $response["success"] = false;
      $response["alertMessage"] = "The requirement could not be removed.";
    }

    echo json_encode($response);
    break;
  case "deleteRequirementFromCourse":
    $course = new TSM_REGISTRATION_COURSE($course_id);
    $success = $course->removeRequirement($course_requirement_id);

    $response = Array("success" => false, "alertMessage" => null);

    if ($success == true) {
      $response["success"] = true;
      $response["alertMessage"] = "The requirement was successfully removed from the course.";
    } else {
      $response["success"] = false;
      $response["alertMessage"] = "The requirement could not be removed.";
    }

    echo json_encode($response);
    break;
  case "unenrollStudentFromCourse":
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
  case "unenrollStudentFromProgram":
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
  case "changePeriodInCourse":
    if (isset($course_period_id) && isset($new_period_id) && isset($new_teacher_id)) {
      $course = new TSM_REGISTRATION_COURSE($course_id);
      if ($course->changePeriod($course_period_id, $new_period_id, $new_teacher_id)) {
        die("1");
      } else {
        die("2");
      }
    }
    break;
  case "changeStudentPeriodForCourse":
    if (isset($course_period_id) && isset($student_id) && isset($program_id) && isset($course_id) && isset($new_course_period_id)) {
      $student = new TSM_REGISTRATION_STUDENT($student_id);
      if ($student->changePeriodForCourse($course_id, $program_id, $course_period_id, $new_course_period_id)) {
        die("1");
      } else {
        die("2");
      }
    }
    break;
  case "approveFamilyPaymentPlan":
    if (isset($family_payment_plan_id)) {
      $familyPaymentPlan = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($family_payment_plan_id);
      $success = $familyPaymentPlan->approve();

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The payment plan was successfully approved.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The payment plan could not be approved.";
      }

      echo json_encode($response);
    }
    break;
}
die();
?>