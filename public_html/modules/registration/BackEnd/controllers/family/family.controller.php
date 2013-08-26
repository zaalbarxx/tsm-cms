<?php
if (!isset($action)) {
  $action = null;
}

switch ($action) {
  case null:
    $families = $currentCampus->getFamilies();
    if (isset($families)) {
      foreach ($families as $family) {
        $familyObject = new TSM_REGISTRATION_FAMILY($family['family_id']);
        $feesInReview = $familyObject->getFeesInReview();
        $families[$family['family_id']]['family_name'] = $familyObject->getFamilyName();
        $families[$family['family_id']]['status'] = null;
        $families[$family['family_id']]['feesInReview'] = $feesInReview;
        $paymentPlans = $familyObject->getPaymentPlans();
        $families[$family['family_id']]['hasLooseFees'] = false;
        if(isset($paymentPlans)){
          foreach($paymentPlans as $paymentPlan){
            $paymentPlanObject = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($paymentPlan['family_payment_plan_id']);
            if($paymentPlanObject->setupComplete() == true && $paymentPlanObject->getUnassignedApplicableFees()){
              $families[$family['family_id']]['hasLooseFees'] = true;
            }
          }
        }
        switch ($family['current_step']) {
          case 0:
            $families[$family['family_id']]['status'] = " - Finalized";
            break;
          case 6:
            $families[$family['family_id']]['status'] = " - Finalized";
            break;
        }
      }
    }

    if (isset($downloadCSV)) {
      $tsm->arrayToCSV($families, $campusInfo['name']." - Families");
    }
    $numFamilies = count($families);
    //foreach($families as $family){
    //$familyObject = new TSM_REGISTRATION_FAMILY($family['family_id']);
    //$families[$family['family_id']]['students'] = $familyObject->getStudents($reg->getSelectedSchoolYear());
    //$familyObject = null;
    //}

    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/family/family.view.php";
    break;
  case "viewFamily":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/family/view.family.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/family/view.family.view.php";
    break;
  case "addEditFamily":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/family/addEdit.family.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/family/addEdit.family.view.php";
    break;
  case "resetPassword":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/family/resetPassword.family.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/family/resetPassword.family.view.php";
    break;
  case "linkToQuickbooks":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/family/linkToQuickbooks.family.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/family/linkToQuickbooks.family.view.php";
    break;
  case "approvePaymentPlan":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/family/approvePaymentPlan.family.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/family/approvePaymentPlan.family.view.php";
    break;
  case "addFeesToPaymentPlan":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/family/addFeesToPaymentPlan.family.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/family/addFeesToPaymentPlan.family.view.php";
    break;
  case "invoiceFeesToPaymentPlan":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/family/invoiceFeesToPaymentPlan.family.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/family/invoiceFeesToPaymentPlan.family.view.php";
    break;
  case "invoiceFees":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/family/invoiceFees.family.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/family/invoiceFees.family.view.php";
    break;
  case "emailInvoice":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/family/emailInvoice.family.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/family/emailInvoice.family.view.php";
    break;
  case "editInvoice":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/family/editInvoice.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/family/editInvoice.view.php";
  case "changePaymentPlan":
    require_once(__TSM_ROOT__."modules/registration/BackEnd/controllers/family/changePaymentPlan.controller.php");
    $activeView = __TSM_ROOT__."modules/registration/BackEnd/views/family/family.view.php";
    break;
}



?>