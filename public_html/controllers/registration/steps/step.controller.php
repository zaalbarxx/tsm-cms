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
    require_once(__TSM_ROOT__."controllers/registration/steps/familyInfo.step.controller.php");
    $activeView = __TSM_ROOT__."views/registration/steps/familyInfo.step.view.php";
    break;
  case 2:
    require_once(__TSM_ROOT__."controllers/registration/steps/studentInfo.step.controller.php");
    $activeView = __TSM_ROOT__."views/registration/steps/studentInfo.step.view.php";
    break;
  case 3:
    if (isset($action)) {
      switch ($action) {
        case "addProgram":
          require_once(__TSM_ROOT__."controllers/registration/student/addProgram.student.controller.php");
          $activeView = __TSM_ROOT__."views/registration/student/addProgram.student.view.php";
          break;
        case "addCourse":
          require_once(__TSM_ROOT__."controllers/registration/student/addCourse.student.controller.php");
          $activeView = __TSM_ROOT__."views/registration/student/addCourse.student.view.php";
          break;
        case "editStudent":
          require_once(__TSM_ROOT__."controllers/registration/steps/studentInfo.step.controller.php");
          $activeView = __TSM_ROOT__."views/registration/steps/studentInfo.step.view.php";
          break;
      }
    } else {
      require_once(__TSM_ROOT__."controllers/registration/steps/viewStudent.step.controller.php");
      $activeView = __TSM_ROOT__."views/registration/steps/viewStudent.step.view.php";
    }
    break;
  case 4:
    if (isset($action)) {
      switch ($action) {
        case "editStudent":
          $family->moveToStep(2);
          header("Location: index.php?".$_SERVER['QUERY_STRING']);
          break;
      }
    }
    require_once(__TSM_ROOT__."controllers/registration/steps/reviewRegistration.step.controller.php");
    $activeView = __TSM_ROOT__."views/registration/steps/reviewRegistration.step.view.php";
    break;
  case 5:
    if (isset($action)) {
      switch ($action) {
        case "viewAvailablePaymentPlans":
          require_once(__TSM_ROOT__."controllers/registration/steps/view.paymentPlan.step.controller.php");
          $activeView = __TSM_ROOT__."views/registration/steps/view.paymentPlan.step.view.php";
          break;
      }

    } else {
      require_once(__TSM_ROOT__."controllers/registration/steps/paymentPlan.step.controller.php");
      $activeView = __TSM_ROOT__."views/registration/steps/paymentPlan.step.view.php";
    }
    break;
  case 6:

    if (isset($action)) {
      switch ($action) {
        case "payByMail":
          require_once(__TSM_ROOT__."controllers/registration/steps/payByMail.step.controller.php");
          $activeView = __TSM_ROOT__."views/registration/steps/payByMail.step.view.php";
          break;
        case "payOnline":
          require_once(__TSM_ROOT__."controllers/registration/steps/payOnline.step.controller.php");
          $activeView = __TSM_ROOT__."views/registration/steps/payOnline.step.view.php";
          break;
      }
    } else {
      require_once(__TSM_ROOT__."controllers/registration/steps/setupPaymentPlans.step.controller.php");
      $activeView = __TSM_ROOT__."views/registration/steps/setupPaymentPlans.step.view.php";
    }
    break;
}
?>