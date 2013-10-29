<?php
$families = $currentCampus->getFamilies();
foreach($families as $family){
  $familyObject = new TSM_REGISTRATION_FAMILY($family['family_id']);
  $families[$family['family_id']]['invoices'] = $familyObject->getInvoices(1);
  if(isset($families[$family['family_id']]['invoices'])){
    foreach($families[$family['family_id']]['invoices'] as $invoice){
      $invoiceObject = new TSM_REGISTRATION_INVOICE($invoice['family_invoice_id']);
      $families[$family['family_id']]['invoices'][$invoice['family_invoice_id']]['times_sent'] = $invoiceObject->getTimesSent();
      $families[$family['family_id']]['invoices'][$invoice['family_invoice_id']]['amount_paid'] = $invoiceObject->getAmountPaid();
      if($families[$family['family_id']]['invoices'][$invoice['family_invoice_id']]['times_sent'] > 0){
        unset($families[$family['family_id']]['invoices'][$invoice['family_invoice_id']]);
      }
    }
  }

  if(count($families[$family['family_id']]['invoices']) == 0){
    unset($families[$family['family_id']]);
  }
}
?>