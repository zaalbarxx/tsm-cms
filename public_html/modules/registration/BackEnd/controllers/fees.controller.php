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
  case "quickbooksClasses":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/fee/quickbooksClasses.fee.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/fee/quickbooksClasses.fee.view.php";
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
	    $familyPaymentPlans = $paymentPlanObject->getFamilyPaymentPlans();
	    if($paymentPlan['payment_plan_type_id'] == 2 or $paymentPlan['payment_plan_type_id'] == 4){
		    $amount = 0;
		    $pendingAmount = 0;
		    foreach($familyPaymentPlans as $familyPaymentPlan){
			    $familyPaymentPlanObject = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($familyPaymentPlan['family_payment_plan_id']);
			    if($familyPaymentPlanObject->getStatus() == "In Progress"){
				    $amount = $amount + $familyPaymentPlanObject->getNextInstallmentAmount();
			    } else if($familyPaymentPlanObject->getStatus() == "Pending Approval"){
				    $pendingAmount = $pendingAmount + $familyPaymentPlanObject->getNextInstallmentAmount();
			    }

		    }
		    $paymentPlans[$paymentPlan['payment_plan_id']]['next_installment_amount'] = $amount;
		    $paymentPlans[$paymentPlan['payment_plan_id']]['pending_next_installment_amount'] = $pendingAmount;
	    } else {
		    $amount = 0;

		    if(isset($familyPaymentPlans)){
			    foreach($familyPaymentPlans as $familyPaymentPlan){
				    $familyPaymentPlanObject = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($familyPaymentPlan['family_payment_plan_id']);
					  $amount = $amount + $familyPaymentPlanObject->getTotal();
			    }
		    }
		    $paymentPlans[$paymentPlan['payment_plan_id']]['next_installment_amount'] = $amount;
	    }
    }
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/paymentPlans.fees.view.php";
    break;
  case "addEditPaymentPlan":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/addEdit.paymentPlan.fees.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/addEdit.paymentPlan.fees.view.php";
    break;
  case "sendPaymentPlanInvoices":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/fee/sendInvoices.paymentPlan.fee.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/fee/sendInvoices.paymentPlan.fee.view.php";
    break;
	case "viewFamilies":
		require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/fee/viewFamilies.paymentPlan.fee.controller.php");
		$activeView = __TSM_ROOT__."modules/registration/BackEnd/views/fee/viewFamilies.paymentPlan.fee.view.php";
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
  case "bulkStudentAssign":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/fee/bulkStudentAssign.fee.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/fee/bulkStudentAssign.fee.view.php";
    break;
  case "bulkFeeInvoice":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/fee/bulkFeeInvoice.fee.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/fee/bulkFeeInvoice.fee.view.php";
    break;
}

?>