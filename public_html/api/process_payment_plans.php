<?php
error_reporting(E_ALL ^ E_STRICT);
ini_set("display_errors", "1");
ini_set('memory_limit', '256M');
set_time_limit(0);

session_start();
//REQUIRE THE CONFIG FILE
require_once('../tsm_config.php');

//REQUIRE THE CORE CLASSES
require_once(__TSM_ROOT__.'tsm_core.php');

//INSTANTIATE THE TSM CLASS
$tsm = TSM::getInstance();
//START SAFE GLOBAL VARIABLES
extract($tsm->makeArraySafe($_REQUEST), EXTR_OVERWRITE);

//INSTANTIATE THE DB CONNECTION
require_once(__TSM_ROOT__.'tsm_db_conn.php');

//INSTANTIATE THE ADMIN USER CLASS
$tsm->adminUser = new AdminUser();

//INSTANTIATE THE WEBSITE CLASS AND START THE SITE
$tsm->website = new Website();
$tsm->website->start();

require_once(__TSM_ROOT__."models/registration/tsm_registration.model.php");

$reg = new TSM_REGISTRATION();
$campusList = $reg->getCampuses();


//if(isset($campusList)){
//  foreach($campusList as $campus){
//    $reg->setCurrentCampusId($campus['campus_id']);
    $reg->setCurrentCampusId(2);
    $currentCampus = new TSM_REGISTRATION_CAMPUS(2);
    $reg->setSelectedSchoolYear($currentCampus->getCurrentSchoolYear());

    $paymentPlans = $currentCampus->getPaymentPlans();
    if(isset($paymentPlans)){
      foreach($paymentPlans as $paymentPlan){
        switch($paymentPlan['payment_plan_type_id']){
          case 2:
            if($paymentPlan['payment_plan_id'] == 57){
              $startBilling = strtotime($paymentPlan['start_date']);
              $today = time();
              //if we're past the start date, continue
              if($today > $startBilling){
                $startDate = new DateTime($paymentPlan['start_date']);

                $paymentPlanObject = new TSM_REGISTRATION_PAYMENT_PLAN($paymentPlan['payment_plan_id']);
                $familyPaymentPlans = $paymentPlanObject->getFamilyPaymentPlans();
                if(isset($familyPaymentPlans)){
                  foreach($familyPaymentPlans as $familyPaymentPlan){
                    $familyPaymentPlanObject = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($familyPaymentPlan['family_payment_plan_id']);
                    $numInvoices = $familyPaymentPlanObject->getNumInvoices();
                    $lastInvoice = $familyPaymentPlanObject->getLastInvoice();
                    $lastInvoiceDate = $lastInvoice['invoice_time'];

                    if($numInvoices < $paymentPlan['num_invoices']){
                      echo "need to create next invoice";
                    }


                    //stop here so we only affect one family as we're developing
                    die();
                  }
                }

                //print_r($familyPaymentPlans);

                echo "Time to start";
              }

              //print_r($paymentPlan);

            }
            break;
        }
      }
    }


//  }
//}