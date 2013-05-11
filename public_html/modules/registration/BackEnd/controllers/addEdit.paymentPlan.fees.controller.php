<?php
if($currentCampus->usesQuickbooks()){
  $classService = new QuickBooks_IPP_Service_Class();
  $qbClasses = $classService->findAll($quickbooks->Context,$quickbooks->creds['qb_realm']);
  if(isset($qbClasses)){
    foreach($qbClasses as $class){
      $classes[$class->getId()] = $class->getName();
    }
    asort($classes);
  }
}


$feeTypes = $currentCampus->getFeeTypes();
$fees = $currentCampus->getFees();
if (isset($payment_plan_id)) {
  $paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($payment_plan_id);
  $planInfo = $paymentPlan->getInfo();
  $pageTitle = "Edit Payment Plan";
  $formAction = "savePaymentPlan";
} else {
  $pageTitle = "Add Payment Plan";
  $formAction = "createPaymentPlan";
  $planInfo = null;
}
?>