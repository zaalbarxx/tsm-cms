<?php
error_reporting(E_ALL ^ E_STRICT);
ini_set("display_errors", "1");
ini_set('memory_limit', '256M');
set_time_limit(0);

function rand_char($length) {
	$random = md5(uniqid(rand(), true));
	return $random;
}

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

//todo: verify that this is working correctly
//todo: make sure this is only syncing changed and new invoices and payments
//todo: make sure this is checking updated payments to see which invoices they are applied to and applying them to those invoices.
if(isset($campusList)){
  foreach($campusList as $campus){
    $reg->setCurrentCampusId($campus['campus_id']);
    //$reg->setCurrentCampusId(2);
    $currentCampus = new TSM_REGISTRATION_CAMPUS($campus['campus_id']);
    $reg->setSelectedSchoolYear($currentCampus->getCurrentSchoolYear());
    if($currentCampus->usesQuickbooks()){
      $quickbooks = new TSM_REGISTRATION_QUICKBOOKS();
      $invoiceService = new QuickBooks_IPP_Service_Invoice();

      //first, we need to get all the deleted invoices and delete them from quickbooks
      /*
      $deletedInvoices = $currentCampus->getInvoices(null,true);
      if(isset($deletedInvoices)){
        foreach($deletedInvoices as $key=>$i){
          if($i['quickbooks_invoice_id'] != ""){
            //echo $i['quickbooks_invoice_id']."<br />";
          } else {
            //todo:check if invoice is really gone from QB, then delete it here
            unset($deletedInvoices[$key]);
          }
        }

        foreach($deletedInvoices as $i){
          //process deletion
          echo "Deleting invoice: ".$i['doc_number']."...";
          $invoice = new TSM_REGISTRATION_INVOICE($i['family_invoice_id']);
          if($invoice->isCreditMemo()){
            $delType = "CreditMemo";
            $invoiceService = new QuickBooks_IPP_Service_CreditMemo();
          } else {
            $delType = "Invoice";
            $invoiceService = new QuickBooks_IPP_Service_Invoice();
          }

          $qbInvoice = $invoiceService->findById($quickbooks->Context, $quickbooks->creds['qb_realm'],$i['quickbooks_invoice_id']);
          //found the object, now delete it
          if(is_object($qbInvoice)){
            $syncToken = $qbInvoice->getSyncToken();
            $parse = QuickBooks_IPP_IDS::parseIDType($i['quickbooks_invoice_id']);
            //$id = $qbInvoice->getId();
            $xml = '<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>
                  <Del RequestId="'.rand_char(32).'" xmlns="http://www.intuit.com/sb/cdm/v2">
                     <Object xsi:type="'.$delType.'"
                     xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                        <Id idDomain="'.$parse[0].'">'.$parse[1].'</Id>
                     </Object>
                  </Del>';
            //echo $xml;die();
            $IPP = $quickbooks->Context->IPP();
            $var = $IPP->IDS($quickbooks->Context, $quickbooks->creds['qb_realm'], $delType, QuickBooks_IPP_IDS::OPTYPE_QUERY, $xml);
            if($var == true){
              echo "SUCCESS!<br />";
            } else {
              echo "FAILED<br />";
              echo $IPP->lastResponse();
            }
          }
        }
      }
      */

      //Check to see if any local invoices don't have their quickbooks external key
      $localInvoices = $currentCampus->getInvoices();
      $txnIds = null;
      $updateInvoices = null;
      if(isset($localInvoices)){
        foreach($localInvoices as $invoice){
          if($invoice['quickbooks_invoice_id'] != ""){
            if(($invoice['quickbooks_external_key'] == "")){
              $txnIds[] = substr($invoice['quickbooks_invoice_id'],4,-1);
              $updateInvoices[$invoice['quickbooks_invoice_id']] = $invoice;
            }

            //update invoices that were updated after the last time they were synced.
            if(strtotime($invoice['last_qb_sync']) < strtotime($invoice['last_updated'])){
              $updateInv[$invoice['quickbooks_invoice_id']] = $invoice;

            }
          }
        }
      }
			echo "Got to 1<br />";
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
        if(isset($quickbooksInvoices)){
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

	      $creditMemoService = new QuickBooks_IPP_Service_CreditMemo();
	      $quickbooksCreditMemos = $creditMemoService->findAll($quickbooks->Context, $quickbooks->creds['qb_realm'], $query, 1, 999);
	      if(isset($quickbooksCreditMemos)){
		      foreach($quickbooksCreditMemos as $invoice){
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
      }
	    //die();
	    echo "Got to 2<br />";

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

	    /*
	    $invoiceService = new QuickBooks_IPP_Service_CreditMemo();
	    $erroredInvoices = $invoiceService->findAll($quickbooks->Context, $quickbooks->creds['qb_realm'], null, 1, 999);
	    foreach($erroredInvoices as $qbInvoice){
		    //var_dump($qbInvoice);die();
		    $extKey = $qbInvoice->getExternalKey();
		    $localInvoice = $invoicesByExtKey[$extKey];
		    if($localInvoice){

			    $invoiceObject = new TSM_REGISTRATION_INVOICE($localInvoice['family_invoice_id']);
			    $total = $invoiceObject->getTotal();
			    if($localInvoice['credit_memo'] == 0 or $total >= 0){
				    echo "skipping...<br />";
				    continue;
			    }
			    $header = $qbInvoice->getHeader();
			    $header->remove("TotalAmt");
			    //$header->setTotalAmt($invoiceObject->getTotal());

			    $qbInvoice->remove("Header");
			    $qbInvoice->add($header);



			    $qbInvoice->remove("Line");
			    $fees = $invoiceObject->getFees();
			    if(isset($fees)){
				    foreach($fees as $fee){
					    $qbInvoice->add($quickbooks->createLineFromFee($fee,$total));
				    }
			    }
					//print_r($qbInvoice);
          //die();
			    echo "updating: ".$localInvoice['family_invoice_id']." amount: ".$total."<br />";

			    $success = $invoiceService->update($quickbooks->Context, $quickbooks->creds['qb_realm'],$id,$qbInvoice);
			    if($success == false){
				    echo "FAILED (".$invoiceService->errorText().")!<br />";
			    } else {
				    $invoiceObject->updateLastQBSync();
				    echo "SUCCESS!<br />";
			    }

		    }
	    }
	    die();
			*/


      if(isset($updateInv)){
        foreach($updateInv as $invoice){

          $invoiceObject = new TSM_REGISTRATION_INVOICE($invoice['family_invoice_id']);
          $total = $invoiceObject->getTotal();
	        $isCreditMemo = false;
	        if($invoice['credit_memo'] == 1){
		        $isCreditMemo = true;
		        //continue;
	        }
	        if($isCreditMemo == true & $total >= 0){
		        echo "Updating ".$invoice['invoice_description']." credit memo: ".$invoice['family_invoice_id']." to amount: ".$invoice['amount']."...INCORRECT AMOUNT<br />";
	          continue;
	        } else if($isCreditMemo == false & $total <= 0){
		        echo "Updating ".$invoice['invoice_description']." invoice: ".$invoice['family_invoice_id']." to amount: ".$invoice['amount']."...INCORRECT AMOUNT<br />";
		        continue;
	        }

          if($isCreditMemo == false){
	          echo "Updating ".$invoice['invoice_description']." invoice: ".$invoice['family_invoice_id']." to amount: ".$invoice['amount']."...";
            $invoiceService = new QuickBooks_IPP_Service_Invoice();
          } else {
	          echo "Updating ".$invoice['invoice_description']." credit memo: ".$invoice['family_invoice_id']." to amount: ".$invoice['amount']."...";
            $invoiceService = new QuickBooks_IPP_Service_CreditMemo();
          }
          $fees = $invoiceObject->getFees();
          $qbInvoice = $invoiceService->findById($quickbooks->Context, $quickbooks->creds['qb_realm'],$invoice['quickbooks_invoice_id']);

	        if(is_object($qbInvoice)){
		        //echo $invoiceService->lastResponse()."\r\n\r\n\r\n";
		        //print_r($qbInvoice);

		        $header = $qbInvoice->getHeader();
		        $header->remove("TotalAmt");
		        //$header->setTotalAmt($invoiceObject->getTotal());

		        $qbInvoice->remove("Header");
		        $qbInvoice->add($header);



		        $qbInvoice->remove("Line");
		        if(isset($fees)){
			        foreach($fees as $fee){
				        $qbInvoice->add($quickbooks->createLineFromFee($fee,$total));
			        }
		        }

		        $success = $invoiceService->update($quickbooks->Context, $quickbooks->creds['qb_realm'],$id,$qbInvoice);
		        if($success == false){
			        echo "FAILED (".$invoiceService->errorText().")!<br />";
		        } else {
							$invoiceObject->updateLastQBSync();
			        echo "SUCCESS!<br />";
		        }
	        } else {
		        echo "FAILED: ".$invoice['quickbooks_invoice_id']." - ".rand_char(32)." (no object)!<br />";
	        }
	        //die();


          //echo $invoiceService->lastRequest()."\r\n\r\n\r\n";

          //echo $invoiceService->lastResponse()."\r\n\r\n\r\n";
          //print_r($qbInvoice);
          //die();
          //print_r($invoice);
        }
      }
	    echo "Got to 3<br />";

      //die();

	    echo "Got to 4<br />";

      //get all the local families and create an array to access them by quickbooks customer id
      $families = $currentCampus->getFamilies();
      $familyByQuickBooksId = null;
      $unsyncedInvoices = Array();
      if(isset($families)){
        foreach($families as $family){
          if($family['quickbooks_customer_id'] != ""){
            $familyByQuickBooksId[$family['quickbooks_customer_id']] = $family;
          }

          //load in unsynced invoices
          $familyObject = new TSM_REGISTRATION_FAMILY($family['family_id']);
          $familyUnsyncedInvoices = $familyObject->getUnSyncedInvoices();
          if(is_array($familyUnsyncedInvoices)){
            $unsyncedInvoices = array_merge($unsyncedInvoices,$familyUnsyncedInvoices);
          }
        }
      }
	    echo "Got to 5<br />";

      //sync unsynced invoices to QB
      if (isset($unsyncedInvoices)){
        foreach($unsyncedInvoices as $invoice){
          $invoiceObject = new TSM_REGISTRATION_INVOICE($invoice['family_invoice_id']);
          $invoiceObject->addToQuickbooks();
        }
      }
	    echo "Got to 6<br />";



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
              "payment_type" => mysql_escape_string($header->getPaymentMethodName()),
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
	    echo "Got to 7<br />";

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
	    echo "Got to 8<br />";

    }
  }
}
$reg->setCurrentCampusId($originalCampusId);
$memUsage = memory_get_peak_usage(true)/1048576;
echo "Sync is complete: ".$memUsage."MB";