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
    $reg->setCurrentCampusId(2);
    $currentCampus = new TSM_REGISTRATION_CAMPUS(2);
    $reg->setSelectedSchoolYear($currentCampus->getCurrentSchoolYear());

    $paymentPlans = $currentCampus->getPaymentPlans();
    if(isset($paymentPlans)){
      foreach($paymentPlans as $paymentPlan){
        switch($paymentPlan['payment_plan_type_id']){
          case 2:
            if($paymentPlan['payment_plan_id'] == 64){
              $startBilling = strtotime($paymentPlan['start_date']);
              $installmentFee = new TSM_REGISTRATION_FEE($paymentPlan['installment_fee_id']);
              $installmentFee = $installmentFee->getInfo();
              $today = date("Y-m-d");
              $today = strtotime($today);
              //if we're past the start date, continue

              if($today > $startBilling){
                $startDate = new DateTime($paymentPlan['start_date']);

                $paymentPlanObject = new TSM_REGISTRATION_PAYMENT_PLAN($paymentPlan['payment_plan_id']);
                $familyPaymentPlans = $paymentPlanObject->getFamilyPaymentPlans();
                if(isset($familyPaymentPlans)){
                  foreach($familyPaymentPlans as $familyPaymentPlan){

                    $familyPaymentPlanObject = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($familyPaymentPlan['family_payment_plan_id']);
                    if($familyPaymentPlanObject->setupComplete()){
                      print_r($familyPaymentPlan);
                      echo "\r\n";
                      print_r($paymentPlan);
                      echo "\r\n";
                      $numInvoices = $familyPaymentPlanObject->getNumInvoices();


                      if($numInvoices < $paymentPlan['num_invoices']){
                        $family = new TSM_REGISTRATION_FAMILY($familyPaymentPlan['family_id']);
                        $totalInvoiced = $familyPaymentPlanObject->getAmountInvoiced();
                        $totalAmount = $familyPaymentPlanObject->getTotal();
                        $totalRemaining = $totalAmount - $totalInvoiced;
                        $numInvoicesRemaining = $paymentPlan['num_invoices'] - $numInvoices;
                        $invoiceTotal = $totalRemaining / $numInvoicesRemaining;
                        $invoiceNumber = $numInvoices+1;
                        //echo "Plan Total: ".$totalAmount." Total Invoiced: ".$totalInvoiced." Total This Invoice: ".$invoiceTotal."\r\n";
                        $lastInvoice = $familyPaymentPlanObject->getLastInvoice();
                        $invoiceNow = false;
                        if(isset($lastInvoice)){
                          $lastInvoiceDate = new DateTime($lastInvoice['invoice_time']);
                          $nextInvoiceDate = $lastInvoiceDate->add(date_interval_create_from_date_string('1 month'));
                          $nextInvoiceDate = date_format($nextInvoiceDate,'Y-m-d');
                          $nextInvoiceDate = strtotime($nextInvoiceDate);

                          if($today >= $nextInvoiceDate){
                            $invoiceNow = true;
                          }
                        } else {
                          $invoiceNow = true;

                        }

                        if($invoiceNow){
                          $installmentFeeId = $family->addFee($paymentPlan['installment_description'],$invoiceTotal,$installmentFee['fee_id'],$installmentFee['fee_type_id']);
                          $familyFee = new TSM_REGISTRATION_FAMILY_FEE($installmentFeeId);
                          $familyFee->setPaymentPlan($familyPaymentPlan['family_payment_plan_id']);
                          $invoiceId = $family->createInvoice($familyPaymentPlan['family_payment_plan_id'],$paymentPlan['name']." - Invoice #".$invoiceNumber);

                          $familyInvoice = new TSM_REGISTRATION_INVOICE($invoiceId);
                          $params = Array("family_fee_id"=>$installmentFeeId,"description"=>$paymentPlan['installment_description'],"amount"=>$invoiceTotal);
                          $familyInvoice->addFee($params);
                          $familyInvoice->updateTotal();
                        }

                      }
                      //stop here so we only affect one family as we're developing
                      die("did one family: ".$numInvoices);
                    }




                  }
                }
              }

              //print_r($paymentPlan);

            }
            break;
        }
      }
    }


//  }
//}