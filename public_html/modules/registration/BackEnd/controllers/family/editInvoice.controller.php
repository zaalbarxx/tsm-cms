<?php
$invoice = new TSM_REGISTRATION_INVOICE($family_invoice_id);

if(isset($editTime)){
	$invoice_date = $_POST['invoice_date'];
	$due_date = $_POST['due_date'];
	$invoice->updateInvoiceAndDueDate($invoice_date,$due_date);
	header('Location: /admin/index.php?mod=registration&view=family&action=editInvoice&family_invoice_id='.$family_invoice_id);
}
else{
	$invoice_info = $invoice->getInfo();
	$invoice_info = array('invoice_date'=>$invoice_info['invoice_time'],'due_date'=>$invoice_info['due_date']);
	$fees_temp = $invoice->getFees();
	$fees = array();
	$fee_total = 0;
	if(count($fees_temp)>0){
		foreach($fees_temp as $fee){
		$fees[] = array(
			'ref_no' => $fee['family_fee_id'],
			'description' =>$fee['description'],
			'ammount' =>$fee['amount']
			);
		$fee_total += $fee['amount'];
		}
	}

	$invoice_id = $family_invoice_id;
}





