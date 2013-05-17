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

require_once(__TSM_ROOT__."modules/registration/lib/tsm_registration.model.php");

$reg = new TSM_REGISTRATION();
$campusList = $reg->getCampuses();


//if(isset($campusList)){
//  foreach($campusList as $campus){
//    $reg->setCurrentCampusId($campus['campus_id']);
    $reg->setCurrentCampusId(1);
    $currentCampus = new TSM_REGISTRATION_CAMPUS(1);
    if($currentCampus->usesQuickbooks()){
      $quickbooks = new TSM_REGISTRATION_QUICKBOOKS();
    }
    $reg->setSelectedSchoolYear($currentCampus->getCurrentSchoolYear());

    $paymentPlans = $currentCampus->getPaymentPlans();
    if(isset($paymentPlans)){
      foreach($paymentPlans as $paymentPlan){
        switch($paymentPlan['payment_plan_type_id']){
          case 1:
            //invoice immediately
            break;
          case 2:
            //get the time when we should begin billing this payment plan
            $startBilling = strtotime($paymentPlan['start_date']);
            $today = date("Y-m-d");
            $today = strtotime($today);

            //if we're past the start date, continue
            if($today > $startBilling){
              $startDate = new DateTime($paymentPlan['start_date']);

              $paymentPlanObject = new TSM_REGISTRATION_PAYMENT_PLAN($paymentPlan['payment_plan_id']);
              $familyPaymentPlans = $paymentPlanObject->getFamilyPaymentPlans();
              if(isset($familyPaymentPlans)){
                //LOOP THROUGH EACH OF THE FAMILIES
                foreach($familyPaymentPlans as $familyPaymentPlan){

                  $familyPaymentPlanObject = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($familyPaymentPlan['family_payment_plan_id']);
                  //IF THE PAYMENT PLAN HAS COMPLETED SETUP
                  if($familyPaymentPlanObject->setupComplete()){
                    $family = new TSM_REGISTRATION_FAMILY($familyPaymentPlan['family_id']);

                    //GET THE NUMBER OF INVOICES IN THIS PAYMENT PLAN
                    $numInvoices = $familyPaymentPlanObject->getNumInvoices();
                    //CHECK TO SEE IF THE PP NEEDS TO BE INVOICED AND CREDITED
                    if($paymentPlan['invoice_and_credit'] == 1 && $numInvoices == 0){
                      $familyPaymentPlanObject->invoiceAndCredit();
                    }

                    if($paymentPlan['invoice_and_credit'] == 1 && $numInvoices > 0){
                      $numInvoices = $numInvoices - 2;
                    }

                    //CHECK TO SEE IF WE HAVE REACHED THE FULL NUMBER OF INVOICES FOR THIS PP
                    if($numInvoices < $paymentPlan['num_invoices']){
                      $lastInvoice = $familyPaymentPlanObject->getLastInvoice();

                      //GET THE NEXT INVOICE DATE FOR THIS PP
                      if(isset($lastInvoice)){
                        $lastInvoiceDate = new DateTime($lastInvoice['invoice_time']);
                        $nextInvoiceDate = $lastInvoiceDate->add(date_interval_create_from_date_string('1 month'));
                        $nextInvoiceDate = date_format($nextInvoiceDate,'Y-m-d');
                        $nextInvoiceDate = strtotime($nextInvoiceDate);

                        //IF WE'RE PAST THE NEXT INVOICE THIS INSTALLMENT
                        if($today >= $nextInvoiceDate){
                          $invoice = $familyPaymentPlanObject->invoiceInstallment();
                          $invoice->emailInvoice("jlane@veritasproductions.net",$paymentPlanObject->getInvoiceEmail(),$paymentPlanObject->getInvoiceEmailSubject());
                        }
                      } else {
                        $invoice = $familyPaymentPlanObject->invoiceInstallment();
                        $invoice->emailInvoice("jlane@veritasproductions.net",$paymentPlanObject->getInvoiceEmail(),$paymentPlanObject->getInvoiceEmailSubject());
                      }
                    }
                  }
                }
              }
            }
            break;
          case 3:
            //invoice in full on a specific date

            break;
          case 4:
            //get the time when we should begin billing this payment plan
            $startBilling = strtotime($paymentPlan['start_date']);
            $today = date("Y-m-d");
            $today = strtotime($today);

            //if we're past the start date, continue
            if($today > $startBilling){
              $startDate = new DateTime($paymentPlan['start_date']);

              $paymentPlanObject = new TSM_REGISTRATION_PAYMENT_PLAN($paymentPlan['payment_plan_id']);
              $familyPaymentPlans = $paymentPlanObject->getFamilyPaymentPlans();
              if(isset($familyPaymentPlans)){
                //LOOP THROUGH EACH OF THE FAMILIES
                foreach($familyPaymentPlans as $familyPaymentPlan){

                  $familyPaymentPlanObject = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($familyPaymentPlan['family_payment_plan_id']);
                  //IF THE PAYMENT PLAN HAS COMPLETED SETUP
                  if($familyPaymentPlanObject->setupComplete()){
                    $family = new TSM_REGISTRATION_FAMILY($familyPaymentPlan['family_id']);

                    //GET THE NUMBER OF INVOICES IN THIS PAYMENT PLAN
                    $numInvoices = $familyPaymentPlanObject->getNumInvoices();
                    //CHECK TO SEE IF THE PP NEEDS TO BE INVOICED AND CREDITED
                    if($paymentPlan['invoice_and_credit'] == 1 && $numInvoices == 0){
                      $familyPaymentPlanObject->invoiceAndCredit();
                    }

                    if($paymentPlan['invoice_and_credit'] == 1 && $numInvoices > 0){
                      $numInvoices = $numInvoices - 2;
                    }

                    //IF NO INVOICES, INVOICE THE FIRST PERCENTAGE
                    if($numInvoices == 0) {
                      //invoice the first percentage here.
                      $invoice = $familyPaymentPlanObject->invoicePercentage();
                      $invoice->emailInvoice("jlane@veritasproductions.net",$paymentPlanObject->getInvoiceEmail(),$paymentPlanObject->getInvoiceEmailSubject());
                    }
                    //CHECK TO SEE IF WE HAVE REACHED THE FULL NUMBER OF INVOICES FOR THIS PP
                    else if($numInvoices < ($paymentPlan['num_invoices'] + 1)){
                      $lastInvoice = $familyPaymentPlanObject->getLastInvoice();

                      //GET THE NEXT INVOICE DATE FOR THIS PP
                      if(isset($lastInvoice)){
                        $lastInvoiceDate = new DateTime($lastInvoice['invoice_time']);
                        $nextInvoiceDate = $lastInvoiceDate->add(date_interval_create_from_date_string('1 month'));
                        $nextInvoiceDate = date_format($nextInvoiceDate,'Y-m-d');
                        $nextInvoiceDate = strtotime($nextInvoiceDate);

                        //IF WE'RE PAST THE NEXT INVOICE THIS INSTALLMENT
                        if($today >= $nextInvoiceDate){
                          //die('invoicing next invoice');
                          $invoice = $familyPaymentPlanObject->invoiceInstallment();
                          $invoice->emailInvoice("jlane@veritasproductions.net",$paymentPlanObject->getInvoiceEmail(),$paymentPlanObject->getInvoiceEmailSubject());
                        }
                      } else {
                        $invoice = $familyPaymentPlanObject->invoiceInstallment();
                        $invoice->emailInvoice("jlane@veritasproductions.net",$paymentPlanObject->getInvoiceEmail(),$paymentPlanObject->getInvoiceEmailSubject());
                      }
                    }
                  }
                }
              }
            }
            break;
        }
      }
    }


//  }
//}