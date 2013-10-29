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

$originalCampusId = $reg->getCurrentCampusId();

if(isset($campusList)){
  foreach($campusList as $campus){
	  if($campus['auto_invoicing_enabled'] == 1){
		//if($campus['campus_id'] == 2){
		  echo "<h2>Processing ".$campus['name']."</h2>";
	    $reg->setCurrentCampusId($campus['campus_id']);
	    //$reg->setCurrentCampusId(1);
	    $currentCampus = new TSM_REGISTRATION_CAMPUS($campus['campus_id']);
			$campusInfo = $currentCampus->getInfo();
	    if($currentCampus->usesQuickbooks()){
	      $quickbooks = new TSM_REGISTRATION_QUICKBOOKS();
	    }
	    $reg->setSelectedSchoolYear($currentCampus->getCurrentSchoolYear());

	    $paymentPlans = $currentCampus->getPaymentPlans();
	    if(isset($paymentPlans)){
	      foreach($paymentPlans as $paymentPlan){
		      echo "<b>Processing ".$campusInfo['name']." payment plan: ".$paymentPlan['name'].": ".$paymentPlan['payment_plan_id']."</b><br />";


	        switch($paymentPlan['payment_plan_type_id']){
	          case 1:
	            //invoice immediately
							//do nothing

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
		                  echo "---Processing Family: ".$familyPaymentPlan['family_id']." and payment plan: ".$familyPaymentPlan['family_payment_plan_id']."<br />";
	                    $family = new TSM_REGISTRATION_FAMILY($familyPaymentPlan['family_id']);

	                    //GET THE NUMBER OF INVOICES IN THIS PAYMENT PLAN
	                    $numInvoices = $familyPaymentPlanObject->getNumInvoices();
	                    //CHECK TO SEE IF THE PP NEEDS TO BE INVOICED AND CREDITED
	                    if($paymentPlan['invoice_and_credit'] == 1 && $numInvoices == 0){
		                    echo "Invoice and credit...<br />";
		                    if(isset($invoiceNow)){
	                        $familyPaymentPlanObject->invoiceAndCredit();
		                    }
	                    }

	                    if($paymentPlan['invoice_and_credit'] == 1 && $numInvoices > 0){
	                      $numInvoices = $numInvoices - 2;
	                    }

	                    //CHECK TO SEE IF WE HAVE REACHED THE FULL NUMBER OF INVOICES FOR THIS PP
		                  $reqInvoices = $paymentPlanObject->getRequiredNumInvoiceToDate();
		                  for($numInvoices;$numInvoices < $reqInvoices; $numInvoices++){
			                  $lastInvoice = $familyPaymentPlanObject->getLastInvoice();

			                  //GET THE NEXT INVOICE DATE FOR THIS PP
			                  if(isset($lastInvoice)){
				                  $invoiceDay = Date("d",strtotime($paymentPlan['start_date']));
				                  $lastInvoiceDate = new DateTime($lastInvoice['invoice_time']);
				                  echo "------Last invoice time: ".date_format($lastInvoiceDate,'Y-m-d')."<br />";
				                  $nextInvoiceDate = $lastInvoiceDate->add(date_interval_create_from_date_string($paymentPlan['invoice_frequency'].' month'));
				                  $nextInvoiceDate = date_format($nextInvoiceDate,'Y-m-'.$invoiceDay);
				                  echo "------Next invoice time: ".$nextInvoiceDate."<br />";
			                  } else {
				                  $nextInvoiceDate = $paymentPlan['start_date'];
				                  //$invoice->emailInvoice("jlane@veritasproductions.net",$paymentPlanObject->getInvoiceEmail(),$paymentPlanObject->getInvoiceEmailSubject());
			                  }
			                  echo "--------Creating invoice on: ".$nextInvoiceDate." - $".$familyPaymentPlanObject->getNextInstallmentAmount()."<br />";
			                  if(isset($invoiceNow)){
				                  $invoice = $familyPaymentPlanObject->invoiceInstallment(null,$nextInvoiceDate);
			                  }
		                  }
		                  echo "<br />";
	                  }
	                }
	              }
	            }
	            break;
	          case 3:
	            //invoice in full on a specific date

		          //get the time when we should begin billing this payment plan
		          $startBilling = strtotime($paymentPlan['start_date']);
		          $today = date("Y-m-d");
		          $today = strtotime($today);

		          //if we're past the start date, continue
		          if($today > $startBilling){
			          $paymentPlanObject = new TSM_REGISTRATION_PAYMENT_PLAN($paymentPlan['payment_plan_id']);
			          $familyPaymentPlans = $paymentPlanObject->getFamilyPaymentPlans();
			          if(isset($familyPaymentPlans)){
				          //LOOP THROUGH EACH OF THE FAMILIES
				          foreach($familyPaymentPlans as $familyPaymentPlan){
					          $familyPaymentPlanObject = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($familyPaymentPlan['family_payment_plan_id']);
					          //print_r($familyPaymentPlanObject->getInfo());
					          //IF THE PAYMENT PLAN HAS COMPLETED SETUP
					          if($familyPaymentPlanObject->setupComplete()){
						          echo "---Processing Family: ".$familyPaymentPlan['family_id']." and payment plan: ".$familyPaymentPlan['family_payment_plan_id']."<br />";
						          $family = new TSM_REGISTRATION_FAMILY($familyPaymentPlan['family_id']);

						          //GET THE NUMBER OF INVOICES IN THIS PAYMENT PLAN
						          $numInvoices = $familyPaymentPlanObject->getNumInvoices();
						          //die($numInvoices);
						          if(!$numInvoices > 0){
							          //they have not yet been invoice. Invoicing now.
							          //print_r($family->getInfo());

							          echo "Invoicing...<br />";
							          if(isset($invoiceNow)){
								          $familyPaymentPlanObject->invoiceFull("2013-08-01");
							          }
						          }
						          echo "<br />";
					          }
				          }
			          }


		          }
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
		                  echo "---Processing Family: ".$familyPaymentPlan['family_id']." and payment plan: ".$familyPaymentPlan['family_payment_plan_id']."<br />";
	                    $family = new TSM_REGISTRATION_FAMILY($familyPaymentPlan['family_id']);

	                    //GET THE NUMBER OF INVOICES IN THIS PAYMENT PLAN
	                    $numInvoices = $familyPaymentPlanObject->getNumInvoices();
	                    //CHECK TO SEE IF THE PP NEEDS TO BE INVOICED AND CREDITED
	                    if($paymentPlan['invoice_and_credit'] == 1 && $numInvoices == 0){
		                    if(isset($invoiceNow)){
	                        $familyPaymentPlanObject->invoiceAndCredit();
		                    }
	                    }

	                    if($paymentPlan['invoice_and_credit'] == 1 && $numInvoices > 0){
	                      $numInvoices = $numInvoices - 2;
	                    }

	                    //IF NO INVOICES, INVOICE THE FIRST PERCENTAGE
	                    if($numInvoices == 0) {
	                      //invoice the first percentage here.
		                    echo "Invoicing...<br />";
		                    if(isset($invoiceNow)){
	                        $invoice = $familyPaymentPlanObject->invoicePercentage();
		                    }
	                      //$invoice->emailInvoice("jlane@veritasproductions.net",$paymentPlanObject->getInvoiceEmail(),$paymentPlanObject->getInvoiceEmailSubject());
	                    }

	                    //CHECK TO SEE IF WE HAVE REACHED THE FULL NUMBER OF INVOICES FOR THIS PP
		                  $reqInvoices = $paymentPlanObject->getRequiredNumInvoiceToDate();
		                  for($numInvoices;$numInvoices < $reqInvoices; $numInvoices++){
			                  $lastInvoice = $familyPaymentPlanObject->getLastInvoice();

			                  //GET THE NEXT INVOICE DATE FOR THIS PP
			                  if(isset($lastInvoice)){
				                  $invoiceDay = Date("d",strtotime($paymentPlan['start_date']));
				                  $lastInvoiceDate = new DateTime($lastInvoice['invoice_time']);
				                  echo "------Last invoice time: ".date_format($lastInvoiceDate,'Y-m-d')."<br />";
				                  $nextInvoiceDate = $lastInvoiceDate->add(date_interval_create_from_date_string($paymentPlan['invoice_frequency'].' month'));
				                  $nextInvoiceDate = date_format($nextInvoiceDate,'Y-m-'.$invoiceDay);
				                  echo "------Next invoice time: ".$nextInvoiceDate."<br />";
			                  } else {
				                  $nextInvoiceDate = $paymentPlan['start_date'];
				                  //$invoice->emailInvoice("jlane@veritasproductions.net",$paymentPlanObject->getInvoiceEmail(),$paymentPlanObject->getInvoiceEmailSubject());
			                  }
			                  echo "--------Creating invoice on: ".$nextInvoiceDate."<br />";
			                  if(isset($invoiceNow)){
				                  $invoice = $familyPaymentPlanObject->invoiceInstallment(null,$nextInvoiceDate);
			                  }
		                  }
		                  echo "<br />";
	                  }
	                }
	              }
	            }
	            break;
	        }
	      }
	    }

	  }
  }
}

$reg->setCurrentCampusId($originalCampusId);
$memUsage = memory_get_peak_usage(true)/1048576;
echo "Proccessing is complete: ".$memUsage."MB";