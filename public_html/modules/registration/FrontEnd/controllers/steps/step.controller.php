<?php

if ($family->getCurrentStep() != 1) {
  if (isset($addAnotherStudent)) {
    $family->moveToStep(2);
    header("Location: index.php?com=registration&addingAdditional=1");
  }
  if (isset($addAnotherProgram)) {
    $family->moveToStep(3);
    header("Location: index.php?com=registration");
  }
  if (isset($reviewRegistration)) {
    $family->moveToStep(4);
    header("Location: index.php?com=registration");
  }
  if (isset($reviseStudent)) {
    $family->moveToStep(3);
    header("Location: index.php?com=registration&student_id=".$student_id);
  }
  if (isset($choosePaymentPlan)) {
    $family->moveToStep(5);
    header("Location: index.php?com=registration");
  }
  if (isset($editFamilyInfo)) {
    $family->moveToStep(1);
    header("Location: index.php?com=registration&backToReview=1");
  }
}

switch ($family->getCurrentStep()) {
  case 1:
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/steps/familyInfo.step.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/steps/familyInfo.step.view.php";
    break;
  case 2:
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/steps/studentInfo.step.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/steps/studentInfo.step.view.php";
    break;
  case 3:
    if (isset($action)) {
      switch ($action) {
        case "addProgram":
          require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/student/addProgram.student.controller.php");
          $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/student/addProgram.student.view.php";
          break;
        case "addCourse":
          require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/student/addCourse.student.controller.php");
          $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/student/addCourse.student.view.php";
          break;
        case "editStudent":
          require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/steps/studentInfo.step.controller.php");
          $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/steps/studentInfo.step.view.php";
          break;
      }
    } else {
      require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/steps/viewStudent.step.controller.php");
      $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/steps/viewStudent.step.view.php";
    }
    break;
  case 4:
    if (isset($action)) {
      switch ($action) {
        case "editStudentInfo":
          $family->moveToStep(2);
          header("Location: index.php?".$_SERVER['QUERY_STRING']);
          break;
      }
    }
    require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/steps/reviewRegistration.step.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/steps/reviewRegistration.step.view.php";
    break;
  case 5:
    if (isset($action)) {
      switch ($action) {
        case "viewAvailablePaymentPlans":
          require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/steps/view.paymentPlan.step.controller.php");
          $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/steps/view.paymentPlan.step.view.php";
          break;
      }

    } else {
      require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/steps/paymentPlan.step.controller.php");
      $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/steps/paymentPlan.step.view.php";
    }
    break;
  case 6:

    if (isset($action)) {
      switch ($action) {
        case "payByMail":
          require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/steps/payByMail.step.controller.php");
          $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/steps/payByMail.step.view.php";
          break;
        case "payOnline":
          require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/steps/payOnline.step.controller.php");
          $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/steps/payOnline.step.view.php";
          break;
      }
    } else {
      require_once(__TSM_ROOT__."modules/registration/FrontEnd/controllers/steps/setupPaymentPlans.step.controller.php");
      $activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/steps/setupPaymentPlans.step.view.php";
    }
    break;
}
?>