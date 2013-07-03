<?php

class TSM_REGISTRATION_INVOICE extends TSM_REGISTRATION_CAMPUS {

  private $info;

  public function __construct($invoiceId = null) {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    if (isset($invoiceId)) {
      $this->invoiceId = intval($invoiceId);
      $this->getInfo();
    }
  }

  public function getInfo() {
    if ($this->info == null) {
      $q = "SELECT * FROM tsm_reg_families_invoices WHERE family_invoice_id = ".$this->invoiceId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function getTimesSent(){
    $q = "SELECT COUNT(family_invoice_id) AS times_sent FROM tsm_reg_families_invoice_email WHERE family_invoice_id = '".$this->invoiceId."'";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $timesSent = $a['times_sent'];
    }

    return $timesSent;
  }

  public function updateFeeAmount($family_fee_id,$amount){
    $q = "UPDATE tsm_reg_families_invoice_fees SET amount = '$amount' WHERE family_fee_id = $family_fee_id AND family_invoice_id = '".$this->invoiceId."'";
    $this->db->runQuery($q);

    return true;
  }

  public function getFirstFamilyFeeId(){
    $q = "SELECT * FROM tsm_reg_families_invoice_fees WHERE family_invoice_id = '".$this->invoiceId."' ORDER BY family_invoice_fee_id ASC LIMIT 1";
    $r = $this->db->runQuery($q);
    while($a = mysql_fetch_assoc($r)){
      $family_fee_id = $a['family_fee_id'];
    }

    return $family_fee_id;
  }

  public function emailInvoice($sendTo, $contents, $subject){
    global $currentCampus;

    $family = new TSM_REGISTRATION_FAMILY($this->info['family_id']);
    $currentCampusInfo = $currentCampus->getInfo();

    $invoicePdf = $this->generatePDF(true);

    $file = $invoicePdf;
    $from_name = $currentCampusInfo['name'];
    $from_mail = $currentCampusInfo['invoice_email_address'];
    $filename = "Invoice ".$this->info['doc_number'].".pdf";
    $invoiceNo = $this->info['doc_number'];
    $contents = str_replace("{{invoiceNo}}",$invoiceNo,$contents);
    $subject = str_replace("{{invoiceNo}}",$invoiceNo,$subject);
    $contents = str_replace("{{name}}",$family->getDisplayName(),$contents);
    $subject = str_replace("{{name}}",$family->getDisplayName(),$subject);
    $contents = str_replace("{{amount}}",$this->info['amount'],$contents);
    $subject = str_replace("{{amount}}",$this->info['amount'],$subject);
    /*
    if($currentCampus->usesQuickbooks() && $family->inQuickbooks()){
      $contents = $contents.'
      <br />
      <b>Intuit Payment Network</b>
      <p>To pay via Intuit Payment Network, just click the button below.
      <b>Important: </b>Be sure to specify Invoice Number: <b>'.$this->info['doc_number'].'</b> on the following page to ensure that your payment is applied to the correct invoice.
      If a warning is displayed after you click "Pay Online", simply click "Okay" or "Continue".</p>
      <form method="post" target="_payByIpnWindow"
            action="https://ipn.intuit.com/payNow/start" id="payByIpnForm">
          <input type="hidden" name="eId" value="5152baca5e802cda"/> <input type="hidden" name="uuId"
                                                                            value="8a89fc3b-5f4b-49be-809e-8fc3a1ff0f32"/>
          <!--<input type="image" id="payByIpnImg" style="background-color:transparent;border:0 none !important;"
                 src="https://ipn.intuit.com/images/payButton/btn_PayNow_BLU_LG.png"
                 alt="Make payments for less with Intuit Payment Network."/>-->
                 <input style="padding: 10px;" type="submit" value="Pay Online" />
      </form>
      <br /><br />
      ';
    }*/

    require_once __TSM_ROOT__.'includes/3rdparty/swift/lib/swift_required.php';

    $transport = Swift_SmtpTransport::newInstance('66.147.244.176', 25)
      ->setUsername('noreply@takesixmedia.com')
      ->setPassword('LTOZ7]OLz~wB')
    ;

/*
    $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
      ->setUsername('billing@artiosacademies.com')
      ->setPassword('5646lane')
    ;
*/
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a message
    $message = Swift_Message::newInstance($subject)
      ->setContentType('text/html')
      ->setFrom(array($from_mail => $from_name))
      ->setTo(array($sendTo))
      ->setBody($contents)
      ->attach(Swift_Attachment::newInstance($file, $filename, 'application/pdf'));
    ;

    // Send the message
    $result = $mailer->send($message);
    //$is_sent = @mail($sendTo, $subject, "", $header);
    if($result == 1){
      $q = "INSERT INTO tsm_reg_families_invoice_email (family_invoice_id,family_id,email_subject,email_contents,sent_to) VALUES('".$this->invoiceId."','".$this->info['family_id']."','$subject','".htmlentities($contents)."','$sendTo')";
      $this->db->runQuery($q);
    }

    return $result;
  }

  public function markAsSent(){
    $q = "INSERT INTO tsm_reg_families_invoice_email (family_invoice_id,family_id,email_subject) VALUES('".$this->invoiceId."','".$this->info['family_id']."','Marked as Sent')";
    $this->db->runQuery($q);
  }

  public function generatePDF($forEmail = false) {
    $family = new TSM_REGISTRATION_FAMILY($this->info['family_id']);
    $familyInfo = $family->getInfo();

    $students = $family->getStudents($this->getSelectedSchoolYear());

    $campus = new TSM_REGISTRATION_CAMPUS($familyInfo['campus_id']);
    $campusInfo = $campus->getInfo();
    if($campusInfo['payment_address2'] != ""){
      $paymentLine2 = "<br />".$campusInfo['payment_address2'];
    } else {
      $paymentLine2 = "";
    }

    $invoiceNum = $this->info['doc_number'];

    $familyName = $family->getDisplayName();


    $mpdf = new mPDF('win-1252', 'A4', '', '', 20, 15, 48, 25, 10, 10);
    $mpdf->useOnlyCoreFonts = true; // false is default
    $mpdf->SetProtection(array('print'));
    $mpdf->SetTitle($familyInfo['father_last']." - Invoice");
    $mpdf->SetAuthor($campusInfo['name']);
    if ($this->getPayments()) {
      $mpdf->SetWatermarkText("Paid");
      $mpdf->showWatermarkText = true;
      $mpdf->watermark_font = 'DejaVuSansCondensed';
      $mpdf->watermarkTextAlpha = 0.1;
    }
    $mpdf->SetDisplayMode('fullpage');

    $html = '
    <html>
    <head>
    <style>
    body {font-family: sans-serif;
        font-size: 10pt;
    }
    p {    margin: 0pt;
    }
    td { vertical-align: top; }
    .items td {
        border-left: 0.1mm solid #000000;
        border-right: 0.1mm solid #000000;
    }
    table thead td { background-color: #f5f6e0;
        text-align: center;
        border: 0.1mm solid #000000;
    }
    .items td.blanktotal {
        background-color: #FFFFFF;
        border: 0mm none #000000;
        border-top: 0.1mm solid #000000;
        border-right: 0.1mm solid #000000;
    }
    .items td.totals {
        text-align: right;
        border: 0.1mm solid #000000;
    }
    </style>
    </head>
    <body>

    <!--mpdf
    <htmlpageheader name="myheader">

    <table width="100%"><tr>
    <td width="33%" valign=top style="color: #522d1d;"><br /><span style="font-weight: bold; font-size: 14pt; float: right; color: #8f9332;">'.$campusInfo['name'].'</span><br />'.$campusInfo['payment_address'].$paymentLine2.'<br />'.$campusInfo['payment_city'].', '.$campusInfo['payment_state'].' '.$campusInfo['payment_zip'].'</td>
    <td width="33%" align=center valign=top><img src="/files/1/artios_logo_invoice.png" style="width: 125px;" /></td>
    <td width="33%" style="text-align: right;" valign=top><br /><div style="margin-top: 20px;">Invoice No.<br /><span style="font-weight: bold; font-size: 12pt;">'.$invoiceNum.'</span></div></td>
    </tr></table>
    </htmlpageheader>

    <htmlpagefooter name="myfooter">
    <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
    Page {PAGENO} of {nb}
    </div>
    </htmlpagefooter>

    <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
    <sethtmlpagefooter name="myfooter" value="on" />
    mpdf-->

    <div style="text-align: right; margin-top: -50px;">
    <table width="400" align=right>
    <tr><td></td><td></td></tr>
    <tr><td align=right>Invoice Date: </td><td width=100 align=right>'.date('M j, Y', strtotime($this->info['invoice_time'])).'</td></tr>
    <tr><td align=right>Payment Due: </td><td width=100 align=right>'.date("M j, Y",strtotime($this->info['due_date'])).'</td></tr>
    </table>
    <br /><br />

    <table width="100%" style="font-family: serif;" cellpadding="10">
    <tr>
    <td width="40%" style="border: 0.1mm solid #888888;">
    <span style="font-size: 7pt; color: #555555; font-family: sans;">BILL TO:</span>
    <br /><br />'.$familyName.'
    <br />'.$familyInfo['address'].'
    <br />'.$familyInfo['city'].', '.$familyInfo['state'].' '.$familyInfo['zip'].'
    </td>
    <td width="15%">&nbsp;</td>
    <td width="45%" style="border: 0mm solid #888888;"></td>
    </tr>
    </table>
    <br /><br />


    <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8">
    <thead>
    <tr>
    <td width="15%">REF. NO.</td>
    <td width="55%" colspan=2>DESCRIPTION</td>
    <!--<td width="15%">UNIT PRICE</td>-->
    <td width="15%">AMOUNT</td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->';

    foreach ($this->getFees() as $fee) {
      $familyFee = new TSM_REGISTRATION_FAMILY_FEE($fee['family_fee_id']);
      $familyFee = $familyFee->getInfo();
      if($familyFee['student_id'] != 0){
        $description = $students[$familyFee['student_id']]['first_name']." ".$students[$familyFee['student_id']]['last_name'].": ".$fee['description'];
      } else {
        $description = $fee['description'];
      }
      $html .= '
    <tr>
    <td align="center">'.$fee['family_fee_id'].'</td>
    <td style="border-right: #fff;">'.$description.'</td>
    <td align="right" style="border-left: 0px;"></td>
    <td align="right">$'.number_format($fee['amount'], 2, '.', ',').'</td>
    </tr>';
    }


    $html .= '

    <!-- END ITEMS HERE -->
    <tr>
    <td class="blanktotal" colspan="2" rowspan="6"></td>
    <td class="totals"><b>TOTAL:</b></td>
    <td class="totals"><b>$'.number_format($this->getTotal(), 2, '.', ',').'</b></td>
    </tr>
    <tr>
    <td class="totals">Amount Paid:</td>
    <td class="totals">$'.number_format($this->getAmountPaid(), 2, '.', ',').'</td>
    </tr>
    <tr>
    <td class="totals"><b>Balance due:</b></td>
    <td class="totals"><b>$'.number_format($this->getAmountDue(), 2, '.', ',').'</b></td>
    </tr>
    </tbody>
    </table>
    <br /><br />
    <div style="text-align: right; font-style: italic;">Note: '.$this->info['invoice_description'].'</div>
    </body>
    </html>
    ';

    $mpdf->WriteHTML($html);

    if($forEmail == false){
      $mpdf->Output();
      exit;
    } else{
      $content = $mpdf->Output('','S');
      return $content;
    }
  }

  public function getPayPalFee() {
    $q = "SELECT * FROM tsm_reg_families_fees ff, tsm_reg_families_invoice_fees fif
    WHERE fif.family_fee_id = ff.family_fee_id
    AND fif.family_invoice_id = '".$this->invoiceId."'
    AND ff.name = 'PayPal Convenience Fee'";
    $r = $this->db->runQuery($q);
    $fee = null;
    while ($a = mysql_fetch_assoc($r)) {
      $fee = $a;
    }

    return $fee;
  }

  public function addPayPalFee() {
    $payPalFee = $this->getPayPalFee();
    if (!$payPalFee) {
      $total = $this->getTotal();
      $campus = new TSM_REGISTRATION_CAMPUS($this->getCurrentCampusId());
      $campusInfo = $campus->getInfo();
      $paypal_fee_id = $campusInfo['paypal_convenience_fee_id'];
      $paypalFee = new TSM_REGISTRATION_FEE($paypal_fee_id);
      $paypalFeeInfo = $paypalFee->getInfo();

      $paypalFeeAmount = $total * .03;
      $family_id = $this->info['family_id'];
      $family = new TSM_REGISTRATION_FAMILY($family_id);
      $family_fee_id = $family->addFee($paypalFeeInfo['name'], $paypalFeeAmount, $paypal_fee_id, $paypalFeeInfo['fee_type_id']);
      /* WE SHOULDN'T SET THE PAYMENT PLAN ID FOR A PAYPAL FEE BECAUSE IT COULD THROW OFF THE CALCUALTED TOTAL FOR THE PAYMENT PLAN
      $familyFee = new TSM_REGISTRATION_FAMILY_FEE($family_fee_id);
      $familyFee->setPaymentPlan($this->info['family_payment_plan_id']);
      */
      $params = Array("family_fee_id" => $family_fee_id, "description" => $paypalFeeInfo['name'], "amount" => $paypalFeeAmount);
      $this->addFee($params);
      $this->updateTotal();
      $return = true;
    } else {
      $return = true;
    }
    return $return;

  }

  public function containsFee($family_fee_id) {
    $q = "SELECT * FROM tsm_reg_families_invoice_fees WHERE family_invoice_id = '".$this->invoiceId."' AND family_fee_id = '".$family_fee_id."'";
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) == 0) {
      return false;
    } else {
      return true;
    }
  }

  public function addFee($options = Array("family_fee_id" => null, "description" => "", "amount" => 0)) {
    if (isset($options['family_fee_id'])) {
      $family_fee_id = $options['family_fee_id'];
    } else {
      $family_fee_id = null;
    }
    if (isset($options['description'])) {
      $description = $options['description'];
    } else {
      $description = null;
    }
    if (isset($options['amount'])) {
      $amount = $options['amount'];
    } else {
      $amount = null;
    }

    if ($this->containsFee($family_fee_id) == false) {
      $q = "INSERT INTO tsm_reg_families_invoice_fees (family_id,description,amount,family_fee_id,family_invoice_id)
      VALUES('".$this->info['family_id']."','".$description."','".$amount."','$family_fee_id','".$this->invoiceId."')";
      $this->db->runQuery($q);

      $q = "INSERT INTO tsm_reg_families_invoice_fee_log (add_remove,family_fee_id,family_invoice_id) VALUES(1,$family_fee_id,".$this->info['family_invoice_id'].")";
      $this->db->runQuery($q);

      return true;
    } else {
      return false;
    }
  }

  public function removeFee($family_fee_id){
    if(isset($this->info['family_invoice_id'])){
      $q = "DELETE FROM tsm_reg_families_invoice_fees WHERE family_fee_id = '$family_fee_id' AND family_invoice_id = '".$this->info['family_invoice_id']."'";
      $this->db->runQuery($q);

      $q = "INSERT INTO tsm_reg_families_invoice_fee_log (add_remove,family_fee_id,family_invoice_id) VALUES(0,$family_fee_id,".$this->info['family_invoice_id'].")";
      $this->db->runQuery($q);

      return true;
    } else {
      return false;
    }
  }

  public function getPayments() {
    $q = "SELECT * FROM tsm_reg_families_payment_invoice fpi, tsm_reg_families_payments fp
    WHERE fp.family_payment_id = fpi.family_payment_id AND fpi.family_invoice_id = '".$this->invoiceId."'";
    $r = $this->db->runQuery($q);
    $payments = null;
    while ($a = mysql_fetch_assoc($r)) {
      $payments[$a['family_payment_id']] = $a;
    }

    return $payments;
  }

  public function getFees() {
    //$q = "SELECT invf.*, ff.fee_id, ff.name FROM tsm_reg_families_invoice_fees invf, tsm_reg_families_fees ff WHERE ff.family_fee_id = invf.family_fee_id AND invf.family_invoice_id = '".$this->invoiceId."'";
    $q = "SELECT invf.*, ff.fee_id, ff.name FROM tsm_reg_families_invoice_fees invf, tsm_reg_families_fees ff WHERE ff.family_fee_id = invf.family_fee_id AND invf.family_invoice_id = '".$this->invoiceId."'";

    $r = $this->db->runQuery($q);
    $returnFees = null;
    while ($a = mysql_fetch_assoc($r)) {
      $returnFees[] = $a;
    }

    return $returnFees;
  }

  public function addToQuickbooks() {
    global $quickbooks;

    $campus = new TSM_REGISTRATION_CAMPUS($this->getCurrentCampusId());
    $campusInfo = $campus->getInfo();

    $doNotProcess = false;
    $family = new TSM_REGISTRATION_FAMILY($this->info['family_id']);
    $quickbooks_customer_id = $family->getQuickbooksCustomerId();
    $invoiceTotal = $this->getTotal();

    if ($this->info['quickbooks_invoice_id'] != "") {
      $doNotProcess = true;
    }

    if($this->info['family_payment_plan_id'] != ""){
      $familyPaymentPlan = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($this->info['family_payment_plan_id']);
      $paymentPlanInfo = $familyPaymentPlan->getInfo();
      $paymentPlan = new TSM_REGISTRATION_PAYMENT_PLAN($paymentPlanInfo['payment_plan_id']);
      $paymentPlanInfo = $paymentPlan->getInfo();
    }

    $fees = $this->getFees();

    $invoiceHeader = new QuickBooks_IPP_Object_Header();
    $invoiceHeader->setCustomerId($quickbooks_customer_id);
    $txnDate = date('Y-m-d', strtotime($this->info['invoice_time']));
    $invoiceHeader->setTxnDate($txnDate);
    $invoiceHeader->setNote($this->info['invoice_description']);
    $invoiceHeader->setDocNumber($this->info['doc_number']);

    if ($invoiceTotal > 0) {
      if(isset($paymentPlanInfo['qb_invoice_class_id'])){
        if($paymentPlanInfo['qb_invoice_class_id'] != ""){
          $invoiceHeader->setClassId($paymentPlanInfo['qb_invoice_class_id']);
        }
      }
      $invoiceHeader->setDueDate($this->info['due_date']);
      $quickbooksInvoice = new QuickBooks_IPP_Object_Invoice();
      $quickbooksInvoice->addHeader($invoiceHeader);
    } elseif ($invoiceTotal < 0) {
      if(isset($paymentPlanInfo['qb_credit_class_id'])){
        if($paymentPlanInfo['qb_credit_class_id'] != ""){
          $invoiceHeader->setClassId($paymentPlanInfo['qb_credit_class_id']);
        }
      }
      $quickbooksInvoice = new QuickBooks_IPP_Object_CreditMemo();
      $creditMemoTotal = $invoiceTotal * -1;
      //$invoiceHeader->setTotalAmt($creditMemoTotal);
      $invoiceHeader->setARAccountName("Accounts Receivable");
      //todo: need to set the account to whatever account the campus is set to.
      $quickbooksInvoice->addHeader($invoiceHeader);
    }

    if (!$doNotProcess) {
      if (isset($fees)) {
        foreach ($fees as $fee) {
          $quickbooksInvoice->add($quickbooks->createLineFromFee($fee,$invoiceTotal));
        }
      }

      if ($invoiceTotal > 0) {
        $service = new QuickBooks_IPP_Service_Invoice();
      } elseif ($invoiceTotal < 0) {
        $service = new QuickBooks_IPP_Service_CreditMemo();
      }

      $quickbooks_id = $service->add($quickbooks->Context, $quickbooks->creds['qb_realm'], $quickbooksInvoice);
      if ($quickbooks_id == null) {
        die($service->lastResponse()."<br /><br />".$service->lastRequest());
      }
      $this->setQuickbooksId($quickbooks_id);
      $invoice = $service->findById($quickbooks->Context, $quickbooks->creds['qb_realm'], $quickbooks_id);
      $extKey = $invoice->getExternalKey();
      $this->setQuickbooksExternalKey($extKey);

      $this->updateLastQBSync();

      return true;
    } else {
      die("doNotProcess");
      return false;
    }
  }

  public function updateLastQBSync(){
    $q = "UPDATE tsm_reg_families_invoices SET last_qb_sync = '".date("Y-m-d H:i:s",time())."' WHERE family_invoice_id = '".$this->invoiceId."'";
    $this->db->runQuery($q);

    return true;
  }

  public function hide() {
    $q = "UPDATE tsm_reg_families_invoices SET displayed = false WHERE family_invoice_id = '".$this->invoiceId."'";
    $this->db->runQuery($q);

    return true;
  }

  public function setInvoiceAndCredit($value) {
    $q = "UPDATE tsm_reg_families_invoices SET invoice_and_credit = $value WHERE family_invoice_id = '".$this->invoiceId."'";
    $this->db->runQuery($q);

    return true;
  }

  public function setQuickbooksId($id) {
    $q = "UPDATE tsm_reg_families_invoices SET quickbooks_invoice_id = '".$id."' WHERE family_invoice_id = '".$this->invoiceId."'";
    $this->db->runQuery($q);

    return true;
  }

  public function setQuickbooksExternalKey($key){
    $q = "UPDATE tsm_reg_families_invoices SET quickbooks_external_key = '".$key."' WHERE family_invoice_id = '".$this->invoiceId."'";
    $this->db->runQuery($q);

    return true;
  }

  public function setDocNumber($num){
    $q = "UPDATE tsm_reg_families_invoices SET doc_number = '".$num."' WHERE family_invoice_id = '".$this->invoiceId."'";
    $this->db->runQuery($q);

    return true;
  }

  public function getTotal() {
    $q = "SELECT amount FROM tsm_reg_families_invoices WHERE family_invoice_id = '".$this->invoiceId."'";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $total = $a['amount'];
    }

    return $total;
  }

  public function getAmountPaid() {
    $q = "SELECT fpi.amount FROM tsm_reg_families_payments fp, tsm_reg_families_payment_invoice fpi
    WHERE fpi.family_payment_id = fp.family_payment_id
    AND fpi.family_invoice_id = '".$this->invoiceId."'";
    $r = $this->db->runQuery($q);
    $amountPaid = 0;
    bcscale(2);
    while ($a = mysql_fetch_assoc($r)) {
      $amountPaid = bcadd($amountPaid,$a['amount']);
    }

    return $amountPaid;
  }

  public function getAmountDue() {
    $q = "SELECT fpi.amount FROM tsm_reg_families_payments fp, tsm_reg_families_payment_invoice fpi
    WHERE fpi.family_payment_id = fp.family_payment_id
    AND fpi.family_invoice_id = '".$this->invoiceId."'";
    $r = $this->db->runQuery($q);
    $amountDue = $this->getTotal();
    bcscale(2);
    while ($a = mysql_fetch_assoc($r)) {
      $amountDue = bcsub($amountDue,$a['amount']);
    }

    return $amountDue;
  }

  public function updateTotal() {
    $q = "UPDATE tsm_reg_families_invoices SET amount = '".$this->addFees($this->getFees())."', last_updated = '".date("Y-m-d H:i:s",time())."' WHERE family_invoice_id = '".$this->invoiceId."'";
    $this->db->runQuery($q);

    return true;
  }

}

?>