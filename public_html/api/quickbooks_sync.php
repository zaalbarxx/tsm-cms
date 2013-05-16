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

//todo: verify that this is working correctly
//todo: make sure this is only syncing changed and new invoices and payments
//todo: make sure this is checking updated payments to see which invoices they are applied to and applying them to those invoices.
//if(isset($campusList)){
//  foreach($campusList as $campus){
    //$reg->setCurrentCampusId($campus['campus_id']);
    $reg->setCurrentCampusId(2);
    $currentCampus = new TSM_REGISTRATION_CAMPUS($campus['campus_id']);
    $reg->setSelectedSchoolYear($currentCampus->getCurrentSchoolYear());
    if($currentCampus->usesQuickbooks()){
      $quickbooks = new TSM_REGISTRATION_QUICKBOOKS();
      $invoiceService = new QuickBooks_IPP_Service_Invoice();

      //Check to see if any local invoices don't have their quickbooks external key
      $localInvoices = $currentCampus->getInvoices();
      $txnIds = null;
      $updateInvoices = null;
      if(isset($localInvoices)){
        foreach($localInvoices as $invoice){
          if(($invoice['quickbooks_external_key'] == "") and $invoice['quickbooks_invoice_id'] != ""){
            $txnIds[] = substr($invoice['quickbooks_invoice_id'],4,-1);
            $updateInvoices[$invoice['quickbooks_invoice_id']] = $invoice;
          }
        }
      }

      //If some invoices need their external key from QuickBooks, we go grab them and update the local record.
      if(isset($txnIds)){
        //build the query for the invoices that we need to update
        $query = "<TransactionIdSet>";
        foreach($txnIds as $txnId){
          $query .= "<Id>$txnId</Id>";
        }
        $query .= "</TransactionIdSet>";

        //get the invoices from quickbooks
        $quickbooksInvoices = $invoiceService->findAll($quickbooks->Context, $quickbooks->creds['qb_realm'], $query, 1, 999);
        foreach($quickbooksInvoices as $invoice){
          $quickbooksId = $invoice->getId();
          $invoiceId = $updateInvoices[$quickbooksId]['family_invoice_id'];
          $extKey = $invoice->getExternalKey();
          $header = $invoice->getHeader();
          $invoiceObject = new TSM_REGISTRATION_INVOICE($invoiceId);
          $extTxnIds[] = substr($extKey,4,-1);
          //update the external key for the invoice
          $invoiceObject->setQuickbooksExternalKey($extKey);
        }
      }

      //Once all the external keys are up to date locally, we need to re-grab the local invoices.
      $localInvoices = $currentCampus->getInvoices();

      $invoicesByExtKey = null;
      //Create an array of the invoices by quickbooks external key.
      if(isset($localInvoices)){
        foreach($localInvoices as $invoice){
          if($invoice['quickbooks_external_key'] != "" and $invoice['quickbooks_invoice_id'] != ""){
            $invoicesByExtKey[$invoice['quickbooks_external_key']] = $invoice;
          }
        }
      }

      //get all the local families and create an array to access them by quickbooks customer id
      $families = $currentCampus->getFamilies();
      $familyByQuickBooksId = null;
      if(isset($families)){
        foreach($families as $family){
          if($family['quickbooks_customer_id'] != ""){
            $familyByQuickBooksId[$family['quickbooks_customer_id']] = $family;
          }
        }
      }


      //Now we need to create payments in our system that are not already there.
      $paymentService = new QuickBooks_IPP_Service_Payment();
      $quickbooksPayments = $paymentService->findAll($quickbooks->Context, $quickbooks->creds['qb_realm'], null, 1, 999);
      if(isset($quickbooksPayments)){
        foreach($quickbooksPayments as $payment){
          $paymentId = $payment->getId();
          $found = false;
          $header = $payment->getHeader();
          $qbid = $header->getCustomerId();

          //if this customer is linked locally, sync the payments
          if(isset($familyByQuickBooksId[$qbid])){
            if(!isset($familyObjects[$qbid])){
              $familyObjects[$qbid] = $currentCampus->getFamilyByQBId($qbid);
              $localPayments[$qbid] = $familyObjects[$qbid]->getPayments();
              //$localInvoices[$qbid] = $family[$qbid]->getInvoices();
            }

            //check to see if this payment is in our system.
            if(isset($localPayments[$qbid])){
              foreach($localPayments[$qbid] as $localPayment){
                if($localPayment['quickbooks_payment_id'] == $paymentId){
                  $paymentObject = new TSM_REGISTRATION_PAYMENT($localPayment['family_payment_id']);
                  $found = true;
                }
              }
            }

            //if the payment was not found in our system, create it
            if($found == false){
              $amount = $header->getTotalAmt();
              $date = $header->getTxnDate();
              $params = Array("amount" => $amount,
              "date" => $date,
              "payment_type" => $header->getPaymentMethodName(),
              "reference_number" => $header->getDocNumber());
              $payment_id = $familyObjects[$qbid]->addPayment($params);
              $paymentObject = new TSM_REGISTRATION_PAYMENT($payment_id);
              $paymentObject->setQuickbooksId($paymentId);

              echo "Need to create payment $paymentId locally.<br />";
            }

            for($i = 0; $i < 100000; $i++){
              $line = $payment->getLine($i);
              if(is_object($line)){
                $extKey = $line->getTxnId();
                if(isset($invoicesByExtKey[$extKey])){
                  $invoice = new TSM_REGISTRATION_INVOICE($invoicesByExtKey[$extKey]['family_invoice_id']);
                  $invoicePayments = $invoice->getPayments();
                  $found = false;
                  if(isset($invoicePayments)){
                    foreach($invoicePayments as $invoicePayment){
                      if($invoicePayment['quickbooks_payment_id'] == $paymentId){
                        $found = true;
                      }
                    }
                  }

                  //if the payment is not assigned to this invoice, assign it.
                  if($found == false){
                    $paymentObject->assignToInvoice($invoicesByExtKey[$extKey]['family_invoice_id'],$line->getAmount());
                    $paymentInfo = $paymentObject->getInfo();
                    echo "Need to assign payment: $paymentId to invoice: $extKey<br />";
                  }

                }
              } else {
                break;
              }
            }
          }
        }
      }


      //Sync new payments from site to quickbooks

      if(isset($familyByQuickBooksId)){
        foreach($familyByQuickBooksId as $family){
          $qbid = $family['quickbooks_customer_id'];
          if(!isset($familyObjects[$qbid])){
            $familyObjects[$qbid] = $currentCampus->getFamilyByQBId($qbid);
            $localPayments[$qbid] = $familyObjects[$qbid]->getPayments();
            //$localInvoices[$qbid] = $family[$qbid]->getInvoices();
          }
          $payments = $familyObjects[$qbid]->getPayments();
          if(isset($payments)){
            foreach($payments as $payment){
              //if the payment is not already in quickbooks
              if($payment['quickbooks_payment_id'] == ""){
                $paymentObject = new TSM_REGISTRATION_PAYMENT($payment['family_payment_id']);
                $paymentObject->addToQuickbooks();
              }
            }
          }


        }
      }

    }
//  }
//}
$memUsage = memory_get_peak_usage(true)/1048576;
echo "Sync is complete: ".$memUsage."MB";