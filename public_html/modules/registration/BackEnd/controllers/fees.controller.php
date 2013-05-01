<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case null:
    $feesList = $currentCampus->getFees();
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/fees.view.php";
    break;
  case "addEditFee":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/addEdit.fees.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/addEdit.fees.view.php";
    break;
  case "quickbooksInfo":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/fee/quickbooksInfo.fee.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/fee/quickbooksInfo.fee.view.php";
    break;
  case "conditions":
    $conditionsList = $currentCampus->getFeeConditions();
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/conditions.fees.view.php";
    break;
  case "paymentPlans":
    $paymentPlans = $currentCampus->getPaymentPlans();
    foreach ($paymentPlans as $paymentPlan) {
      $paymentPlanObject = new TSM_REGISTRATION_PAYMENT_PLAN($paymentPlan['payment_plan_id']);
      $paymentPlans[$paymentPlan['payment_plan_id']]['num_families'] = $paymentPlanObject->getNumFamilies();
    }
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/paymentPlans.fees.view.php";
    break;
  case "addEditPaymentPlan":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/addEdit.paymentPlan.fees.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/addEdit.paymentPlan.fees.view.php";
    break;
  case "addEditCondition":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/addEditConditions.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/addEditCondition.fees.view.php";
    break;
  case "getConditionForm":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/conditionForm.fees.controller.php");
    break;
  case "addConditionToFees":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/addToFees.conditions.fees.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/addToFees.conditions.fees.view.php";
    break;
}

?>