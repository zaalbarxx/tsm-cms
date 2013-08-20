<?php
$invoice = new TSM_REGISTRATION_INVOICE($family_invoice_id);

$fees_temp = $invoice->getFees();

$fees = array();
$fee_total = 0;
foreach($fees_temp as $fee){
	$fees[] = array(
		'ref_no' => $fee['family_fee_id'],
		'description' =>$fee['description'],
		'ammount' =>$fee['amount']
		);
	$fee_total += $fee['amount'];
}
$invoice_id = $family_invoice_id;




