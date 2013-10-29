<?php

class TSM_REGISTRATION_FAMILY extends TSM_REGISTRATION_CAMPUS {

  private $info;
  private $isLoggedIn;
  private $currentStep;
  private $students;
  private $schoolYearInfo;

  public function __construct($familyId = null) {
    global $logout;

    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    if (isset($familyId)) {
      if ($this->tsm->adminUser->isLoggedIn()) {
        $permission = true;
      } else {
        if ($familyId != $_SESSION['family']['id']) {
          $permission = false;
        } else {
          $permission = true;
        }
      }
      if ($permission == true) {
        $this->familyId = intval($familyId);
        $this->getInfo();
      } else {
        throw new Exception('TSM_REGISTRATION_FAMILY: no permission');
      }
    } else if (isset($_SESSION['family']['id'])) {
      $this->familyId = intval($_SESSION['family']['id']);
      $this->getInfo();
    }

    if ($logout == 1) {
      //unset($_SESSION['family']['id']);
      session_destroy();
      header("Location: index.php");
    }
  }

  public function getFamilyId() {
    return $this->info['family_id'];
  }

  public function getCurrentStep() {
    $this->currentStep = null;
    if ($this->isLoggedIn() == false) {
      $this->currentStep = 1;
    } else {
      $q = "SELECT current_step FROM tsm_reg_families_school_years WHERE family_id = '".$this->familyId."' AND school_year = '".$this->getSelectedSchoolYear()."'";
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->currentStep = $a['current_step'];
      }
    }

    if ($this->currentStep == null) {
      $this->currentStep = 1;
    }

    return $this->currentStep;
  }

  public function saveFamily() {
    //if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
    if ($this->db->updateRowFromPost("tsm_reg_families", $this->familyId)) {
      return true;
    } else {
      //THERE WAS AN ERROR INSERTING THE ROW
      die("uhoh");
    }
    // } else {
    //    die("not all fields required.");
    //}
  }

  public function registerFamily() {
    if (isset($_POST['father_first']) && isset($_POST['father_last']) && isset($_POST["website_id"]) && isset($_POST['school_year'])) {
      if (isset($_POST['password'])) {
        $_POST['password'] = $this->tsm->createPassword($_POST['password']);
      }
      $family_id = $this->db->insertRowFromPost("tsm_reg_families");
      if ($family_id) {
        return $family_id;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      }
    } else {
      die("not all fields required.");
    }
  }

  public function addStudent() {
    $student_id = $this->db->insertRowFromPost("tsm_reg_students");
    if ($student_id) {
      return $student_id;
    } else {
      //THERE WAS AN ERROR INSERTING THE ROW
      die("uhoh");
    }
  }

  public function moveToStep($step) {
    $q = "UPDATE tsm_reg_families_school_years SET current_step = '$step' WHERE family_id = '".$this->familyId."' AND school_year = '".$this->getSelectedSchoolYear()."'";
    $this->db->runQuery($q);

    return true;
  }

  public function moveToNextStep() {
    $nextStep = $this->getCurrentStep() + 1;
    $this->moveToStep($nextStep);

    return true;
  }

  public function addToSchoolYear($school_year) {
    $q = "SELECT family_id FROM tsm_reg_families_school_years WHERE family_id = '".$this->familyId."' AND school_year = '".$school_year."'";
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) == 0) {
      $q = "INSERT INTO tsm_reg_families_school_years (family_id,current_step,school_year) VALUES('".$this->familyId."','1','".$school_year."')";
      $this->db->runQuery($q);
      return true;
    }
  }

  public function getCampusId() {
    return $this->info['campus_id'];
  }

  public function login($email, $password, $campus_id) {
    $q = "SELECT * FROM tsm_reg_families WHERE primary_email = '$email' AND campus_id = '".$campus_id."' AND website_id = '".$_SESSION['website_id']."'";
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) > 0) {
      $a = mysql_fetch_assoc($r);
      if (TSM::getInstance()->checkPassword($a['password'], $password)) {
        $_SESSION['family']['id'] = $a['family_id'];
        $campus = new TSM_REGISTRATION_CAMPUS($campus_id);
        $this->setSelectedSchoolYear($campus->getCurrentSchoolYear());
        header("location: index.php");
        $success = 1;
      } else {
        $success = 0;
      }
    } else {
      $success = 0;
    }

    return $success;
  }

  public function getLatestStudent() {
    $q = "SELECT s.student_id FROM tsm_reg_students s, tsm_reg_students_school_years sy WHERE sy.student_id = s.student_id AND sy.school_year = '".$this->getSelectedSchoolYear()."' AND s.family_id = '".$this->familyId."' ORDER BY sy.registration_time DESC LIMIT 1";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $student_id = $a['student_id'];
    }

    return $student_id;
  }

  public function inSchoolYear($school_year) {
    $q = "SELECT * FROM tsm_reg_families_school_years WHERE family_id = ".$this->familyId." AND school_year = '".$school_year."'";
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) == 0) {
      return false;
    } else {
      return true;
    }
  }

  public function isLoggedIn() {
    if (isset($_SESSION['family']['id'])) {
      $this->isLoggedIn = true;
    } else {
      $this->isLoggedIn = false;
    }

    return $this->isLoggedIn;
  }

  public function getInfo($force=false) {
    if ($this->info == null || $force==true) {
      $q = "SELECT * FROM tsm_reg_families WHERE family_id = ".$this->familyId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function getSchoolYearInfo($school_year = null) {
    if ($school_year != null) {
      $q = "SELECT * FROM tsm_reg_families_school_years fsy WHERE fsy.family_id = '".$this->familyId."' AND fsy.school_year = '".$school_year."'";
    } else {
      $q = "SELECT * FROM tsm_reg_families_school_years fsy WHERE fsy.family_id = '".$this->familyId."' AND fsy.school_year = '".$this->getSelectedSchoolYear()."'";
    }
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $this->schoolYearInfo = $a;
    }

    return $this->schoolYearInfo;
  }

  public function getStudents($school_year = null) {
    if($school_year == null){
      $school_year = $this->getSelectedSchoolYear();
    }

    $q = "SELECT * FROM tsm_reg_students s, tsm_reg_students_school_years ssy WHERE ssy.student_id = s.student_id AND ssy.school_year = '".$school_year."' AND s.family_id = ".$this->familyId." ORDER BY s.last_name";
    $r = $this->db->runQuery($q);
    $this->students = null;
    while ($a = mysql_fetch_assoc($r)) {
      $this->students[$a['student_id']] = $a;
    }

    return $this->students;
  }

  public function addPayment($params) {
    $amount = $params['amount'];
    $paymentTime = $params['date'];
    $paymentType = $params['payment_type'];
    $reference_number = $params['reference_number'];

    $q = "INSERT INTO tsm_reg_families_payments (family_id,amount,payment_time,payment_type,reference_number)
    VALUES('".$this->familyId."','$amount','$paymentTime','$paymentType','$reference_number')";
    $this->db->runQuery($q);
    $id = mysql_insert_id($this->db->conn);

    return $id;
  }

  public function getPayments() {
    $q = "SELECT * FROM tsm_reg_families_payments WHERE family_id = '".$this->familyId."'";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $payments[$a['family_payment_id']] = $a;
    }

    return $payments;
  }

  public function getPaymentPlans($payment_plan_type_id = null) {
    $q = "SELECT pp.*, fpp.payment_plan_type_id, fpp.name, fpp.immediate_invoice_percentage, fpp.fee_type_id AS payment_plan_fee_type_id,
    fpp.installment_fee_id, fpp.installment_fee_description, fpp.credit_fee_id, fpp.credit_fee_description, fpp.invoice_and_credit
    FROM tsm_reg_families_payment_plans pp, tsm_reg_fee_payment_plans fpp
    WHERE fpp.payment_plan_id = pp.payment_plan_id
    AND pp.family_id = '".$this->familyId."'
    AND pp.school_year = '".$this->getSelectedSchoolYear()."'";
    if (isset($payment_plan_type_id)) {
      $q .= " AND fpp.payment_plan_type_id = '$payment_plan_type_id'";
    }

    $r = $this->db->runQuery($q);
    $paymentPlans = Array();
    while ($a = mysql_fetch_assoc($r)) {
      $paymentPlans[$a['family_payment_plan_id']] = $a;
      $paymentPlans[$a['family_payment_plan_id']]['fee_types'] = unserialize($a['fee_types']);
      //$paymentPlans[$a['family_payment_plan_id']]['setup_complete'] = $a['setup_complete'];
    }

    return $paymentPlans;
  }

  public function completePaymentPlanSetup($family_payment_plan_id) {
    $q = "UPDATE tsm_reg_families_payment_plans SET setup_complete = 1 WHERE family_payment_plan_id = '$family_payment_plan_id' AND family_id = '".$this->familyId."'";
    $this->db->runQuery($q);

    return true;
  }

  public function deletePaymentPlans() {
    $q = "DELETE FROM tsm_reg_families_payment_plans WHERE family_id = '".$this->familyId."' AND school_year = '".$this->getSelectedSchoolYear()."'";
    $this->db->runQuery($q);

    return true;
  }

  public function acceptDisclaimer($family_payment_plan_id) {
    $q = "UPDATE tsm_reg_families_payment_plans SET accept_disclaimer = '1' WHERE family_payment_plan_id = '".$family_payment_plan_id."'";
    $this->db->runQuery($q);
  }

  public function savePaymentPlans() {
    if ($this->deletePaymentPlans()) {
      $paymentPlans = null;
      //print_r($_POST);
      foreach ($_POST as $key => $value) {
        if ($value != "") {
          if (strstr($key, 'payment_plan_id_for_fee_type_id')) {
            $payment_plan_id = $value;
            if (!isset($paymentPlans[$payment_plan_id])) {
              $paymentPlans[$payment_plan_id] = Array();
            }
            $array = explode(":", $key);
            $fee_type_id = $array[1];
            array_push($paymentPlans[$payment_plan_id], $fee_type_id);


            //$family_payment_plan_id = $this->db->insertRowFromPost("tsm_reg_families_payment_plans");
          }
        } else {
          $error = true;
          break;
        }
      }

      foreach ($paymentPlans as $payment_plan_id => $feeTypes) {
        $paymentPlans[$payment_plan_id] = serialize($feeTypes);
        $q = "INSERT INTO tsm_reg_families_payment_plans (family_id,payment_plan_id,fee_types,school_year)
        VALUES ('".$this->familyId."','$payment_plan_id','".$paymentPlans[$payment_plan_id]."','".$this->getSelectedSchoolYear()."')";
        $this->db->runQuery($q);
      }
    }

    if (!isset($error)) {
      return true;
    } else {
      return false;
    }

  }

  public function addFee($name, $amount, $fee_id = null, $fee_type_id = null) {
    //todo: there needs to be some logic in here that checks to see if the family is already on a payment plan for this school year that supports this fee_type_id. If so, we need to give the admin the option to put this fee on an existing payment plan or add it to a new one.
    $q = "INSERT INTO tsm_reg_families_fees (family_id,name,amount,fee_id,fee_type_id,school_year) VALUES('".$this->familyId."','$name','$amount','$fee_id','$fee_type_id','".$this->getSelectedSchoolYear()."')";
    $this->db->runQuery($q);
    $id = mysql_insert_id($this->db->conn);

    $q = "INSERT INTO tsm_reg_families_fee_log (family_id,add_remove,fee_id,amount,fee_name) VALUES('".$this->info['family_id']."',1,$fee_id,'$amount','$name')";
    $this->db->runQuery($q);

    return $id;
  }

  public function getInvoices($displayed = null,$includeDeleted = false) {
    $q = "SELECT * FROM tsm_reg_families_invoices fi, tsm_reg_families_payment_plans fpp, tsm_reg_fee_payment_plans pp
    WHERE fi.family_payment_plan_id = fpp.family_payment_plan_id
    AND pp.payment_plan_id = fpp.payment_plan_id
    AND fi.family_id = '".$this->familyId."'";
    if ($displayed) {
      $q .= " AND fi.displayed = '$displayed'";
    }
	  if($includeDeleted == false){
		  $q .= " AND fi.deleted_at IS NULL ";
	  }
    $r = $this->db->runQuery($q);
    $returnInvoices = null;
    while ($a = mysql_fetch_assoc($r)) {
      $returnInvoices[$a['family_invoice_id']] = $a;
    }

    $q = "SELECT * FROM tsm_reg_families_invoices WHERE family_id = '".$this->familyId."' AND family_payment_plan_id IS NULL ";
	  if($includeDeleted == false){
		  $q .= " AND deleted_at IS NULL ";
	  }
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $returnInvoices[$a['family_invoice_id']] = $a;
    }

    return $returnInvoices;
  }

  public function getUnSyncedInvoices(){
    if($this->inQuickbooks()){
	    $returnInvoices = $this->getInvoices();
	    if(isset($returnInvoices)){
		    foreach($returnInvoices as $invoice){
			    if(!$invoice['quickbooks_invoice_id'] == ''){
				    unset($returnInvoices[$invoice['family_invoice_id']]);
			    }
		    }
	    }
    } else {
      $returnInvoices = null;
    }

    return $returnInvoices;
  }

  public function getGivenName(){
    if ($this->info['father_first'] != "" && $this->info['father_first'] != "deceased"  && $this->info['mother_first'] != "") {
      $givenName = $this->info['father_first']." & ".$this->info['mother_first'];
    } elseif ($this->info['father_first'] == "" || $this->info['father_first'] == "deceased") {
      $givenName = $this->info['mother_first'];
    } elseif ($this->info['mother_first'] == "") {
      $givenName = $this->info['father_first'];
    }

    return $givenName;
  }

  public function getFamilyName(){

    if ($this->info['father_last'] != "" && $this->info['father_last'] != "deceased" && $this->info['mother_last'] != "") {
      $familyName = $this->info['father_last'];
    } elseif ($this->info['father_last'] == "" || $this->info['father_last'] == "deceased") {
      $familyName = $this->info['mother_last'];
    } elseif ($this->info['mother_last'] == "") {
      $familyName = $this->info['father_last'];
    }

    return $familyName;
  }

  public function getDisplayName(){
    return $this->getGivenName()." ".$this->getFamilyName();
  }

  public function createQuickbooksInfo() {
    $this->updateQuickbooksInfo(true);
  }

  public function updateQuickbooksInfo($create = false) {
    global $quickbooks;

    $father_first = $this->info['father_first'];
    $father_last = $this->info['father_last'];
    $mother_first = $this->info['mother_first'];
    $mother_last = $this->info['mother_last'];

    $service = new QuickBooks_IPP_Service_Customer();
    if ($create == false) {
      $customer = $service->findById($quickbooks->Context, $quickbooks->creds['qb_realm'], $this->info['quickbooks_customer_id']);
    } elseif ($create == true) {
      $customer = new QuickBooks_IPP_Object_Customer();
    }


    if ($father_first != "" && $mother_first != "") {
      $givenName = $father_first." & ".$mother_first;
    } elseif ($father_first == "") {
      $givenName = $mother_first;
    } elseif ($mother_first == "") {
      $givenName = $father_first;
    }

    if ($father_last != "" && $mother_last != "") {
      $familyName = $father_last;
    } elseif ($father_last == "") {
      $familyName = $mother_last;
    } elseif ($mother_last == "") {
      $familyName = $father_last;
    }

    $customer->setGivenName($givenName);
    $customer->setFamilyName($familyName);
    $customer->setName($familyName.", ".$givenName);
    $customer->setShowAs($familyName.", ".$givenName);


    if ($create == true) {
      $address = new QuickBooks_IPP_Object_Address();
      $address->setTag("Billing");
    } else {
      $address = $customer->getAddress();
    }
    $address->setLine1($givenName." ".$familyName);
    $address->setLine2($this->info['address']);
    $address->setCity($this->info['city']);
    $address->setCountrySubDivisionCode($this->info['state']);
    $address->setPostalCode($this->info['zip']);
    $customer->setAddress($address);

    $customer->remove("Phone");

    $phoneArray = Array("primary_phone" => $this->info['primary_phone'], "father_cell" => $this->info['father_cell'], "mother_cell" => $this->info['mother_cell'], "seconday_phone" => $this->info['secondary_phone']);
    $i = 1;
    foreach ($phoneArray as $key => $number) {
      if ($number != "") {
        $phone = new QuickBooks_IPP_Object_Phone();
        $phone->setFreeFormNumber($number);
        switch ($i) {
          case 1:
            $phone->setDefault(1);
            $phone->setTag("Business");
            break;
          case 2:
            $phone->setTag("Home");
            break;
          case 3:
            $phone->setTag("Mobile");
            break;
          case 4:
            $phone->setTag("Pager");
            break;
        }
        $customer->addPhone($phone);
        $i++;
      }
    }
    $customer->remove("Email");


    $emailArray = Array("primary_email" => $this->info['primary_email'], "secondary_email" => $this->info['secondary_email']);
    $i = 1;
    foreach ($emailArray as $key => $email) {
      if ($email != "") {
        $email = new QuickBooks_IPP_Object_Email();
        $email->setAddress($this->info['primary_email']);
        switch ($i) {
          case 1:
            $email->setTag("Business");
            break;
          case 2:
            $email->setTag("Home");
            break;
        }
        $customer->addEmail($email);
        $i++;
      }
    }

    if ($create == false) {
      $service->update($quickbooks->Context, $quickbooks->creds['qb_realm'], $customer->getId(), $customer);
    } elseif ($create == true) {
      $quickbooks_customer_id = $service->add($quickbooks->Context, $quickbooks->creds['qb_realm'], $customer);
      //$customer = $service->findById($quickbooks->Context, $quickbooks->creds['qb_realm'], $quickbooks_customer_id);
      //print_r($customer);die();
      //$extKey = $customer->getExternalKey();

      if (!$quickbooks_customer_id) {
        die("THERE WAS A PROBLEM! EXITING!".$service->lastResponse());
      }
      $this->setQuickbooksCustomerId($quickbooks_customer_id);
    }


    return true;
  }

  public function getInvoicesByPaymentPlan($family_payment_plan_id) {
    $q = "SELECT * FROM tsm_reg_families_invoices
    WHERE family_payment_plan_id = '".$family_payment_plan_id."'
    AND family_id = '".$this->familyId."'
    AND deleted_at IS NULL
    ORDER BY family_invoice_id ASC";
    $r = $this->db->runQuery($q);
    $returnInvoices = null;
    while ($a = mysql_fetch_assoc($r)) {
      $returnInvoices[] = $a;
    }

    return $returnInvoices;
  }

  public function inQuickbooks() {
    $inQuickbooks = $this->getQuickbooksCustomerId();
    if (isset($inQuickbooks)) {
      $inQuickbooks = true;
    } else {
      $inQuickbooks = false;
    }

    return $inQuickbooks;
  }

  public function setQuickbooksCustomerId($quickbooks_customer_id) {
    $q = "UPDATE tsm_reg_families SET quickbooks_customer_id = '$quickbooks_customer_id' WHERE family_id = '".$this->familyId."'";
    $this->db->runQuery($q);
    $this->info['quickbooks_customer_id'] = $quickbooks_customer_id;

    return true;
  }

  public function getQuickbooksCustomerId() {
    $q = "SELECT quickbooks_customer_id FROM tsm_reg_families WHERE family_id = '".$this->familyId."'";
    $r = $this->db->runQuery($q);
    $quickbooks_customer_id = null;
    while ($a = mysql_fetch_assoc($r)) {
      $quickbooks_customer_id = $a['quickbooks_customer_id'];
    }

    return $quickbooks_customer_id;
  }

  public function createInvoice($family_payment_plan_id = null, $invoice_description = null, $due_date = null, $invoiceDate = null) {
    if ($due_date == null) {
      $due_date = date("Y-m-d");
      $due_date = new DateTime($due_date);
      $due_date = $due_date->add(date_interval_create_from_date_string('1 month'));
      $due_date = date_format($due_date, 'Y-m-d');
    }
    if($family_payment_plan_id == null){
      $family_payment_plan_id = "NULL";
    }


    $q = "INSERT INTO tsm_reg_families_invoices (family_id,family_payment_plan_id,invoice_description,due_date)
    VALUES('".$this->familyId."',$family_payment_plan_id,'$invoice_description','$due_date')";
    $this->db->runQuery($q);
    $invoice_id = mysql_insert_id($this->db->conn);

    //If the campus uses quickbooks, we have to create the invoice in quickbooks as well.
    $campus = new TSM_REGISTRATION_CAMPUS($this->getCurrentCampusId());
    $campusInfo = $campus->getInfo();
    $invoice = new TSM_REGISTRATION_INVOICE($invoice_id);
    $invoice->setDocNumber($campusInfo['invoice_prefix'].$invoice_id);
	  if($invoiceDate != null){
			$invoice->setInvoiceDate($invoiceDate);
	  }

    return $invoice_id;
  }

  public function createInvoiceFromFees($fees, $description, $family_payment_plan_id = "NULL", $due_date = null) {
    global $currentCampus;
	  $doNotCreate = false;
	  foreach($fees as $fee){
		  $feeObject = new TSM_REGISTRATION_FAMILY_FEE($fee['family_fee_id']);
		  if($feeObject->isInvoiced()){
			  $doNotCreate = true;
		  }
	  }

	  if($doNotCreate == true){
		  return false;
	  }

    $invoice_id = $this->createInvoice($family_payment_plan_id, $description,$due_date);
    $invoice = new TSM_REGISTRATION_INVOICE($invoice_id);

    foreach ($fees as $fee) {
      $params = Array("family_fee_id" => $fee['family_fee_id'], "description" => $fee['name'], "amount" => $fee['amount']);
      $invoice->addFee($params);
    }

    $invoice->updateTotal();

    if ($currentCampus->usesQuickbooks() && $this->inQuickbooks()) {
      $invoice->addToQuickbooks();
    }

    return $invoice;
  }

  public function recordFee($fee) {

  }

  public function sendRegistrationConfirmation() {
    $campus = new TSM_REGISTRATION_CAMPUS($this->info['campus_id']);
    $campusInfo = $campus->getInfo();
    $subject = $campusInfo['name']." Registration Confirmation";

    $headers = "From: noreply@artiosacademies.com\r\n";
    //$headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $message = $campusInfo['registration_confirmation_email'];
    /*
    $message = "
    <h3>Registration Confirmation</h3>
    <p>You have successfully registered for ".$campusInfo['name']."!</p>
    <p>You can view your registration summary anytime by logging in to the registration portal</p>
    <p style='text-align: center'><a href='http://sandbox.takesixmedia.com/' target='_blank'>View Summary</a></p>
    <br /><br />
    ";
*/
    mail($this->info['primary_email'], $subject, $message, $headers);
  }

  public function getLooseFees() {
    $q = "SELECT * FROM tsm_reg_families_fees WHERE family_id = '".$this->familyId."' AND family_payment_plan_id IS NULL";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $familyFee = new TSM_REGISTRATION_FAMILY_FEE($a['family_fee_id']);
      if (!$familyFee->isInvoiced()) {
        $returnFees[] = $a;
      }
    }

    return $returnFees;
  }

  public function getUninvoicedFees(){
    $q = "SELECT * FROM tsm_reg_families_fees WHERE family_id = '".$this->familyId."'";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $familyFee = new TSM_REGISTRATION_FAMILY_FEE($a['family_fee_id']);
      if (!$familyFee->isInvoiced()) {
        $returnFees[] = $a;
      }
    }

    return $returnFees;
  }

  public function getFees($fee_type_id = null) {
    $students = $this->getStudents($this->getSelectedSchoolYear());
    $returnFees = null;
    if (isset($students)) {
      foreach ($students as $student) {
        $studentObject = new TSM_REGISTRATION_STUDENT($student['student_id']);
        $fees = $studentObject->getFees($fee_type_id);
        if (isset($fees)) {
          foreach ($fees as $fee) {
            $fee['student_id'] = $student['student_id'];
            $returnFees[] = $fee;
          }
        }
      }
    }

    return $returnFees;
  }

  public function getFeesByFeeId($fee_id){
    $q = "SELECT * FROM tsm_reg_families_fees WHERE family_id = ".$this->familyId." AND fee_id = '$fee_id'";
    $r = $this->db->runQuery($q);
    while($a = mysql_fetch_assoc($r)){
      $fees[$a['family_fee_id']] = $a;
    }

    return $fees;
  }

  public function getFeesNeedingReview(){
    $q = "SELECT * FROM tsm_reg_families_fees WHERE family_id = ".$this->familyId." AND to_review = '1'";
    $r = $this->db->runQuery($q);
    $feesNeedingReview = null;
    while($a = mysql_fetch_assoc($r)){
      $feesNeedingReview[] = $a;
    }

    return $feesNeedingReview;
  }

  public function handleFees($handleFees){
    foreach($handleFees as $family_fee_id=>$handleInfo){
      if($handleInfo['handleMethod'] == 1){

        //echo $family_fee_id.": removing from invoices and family";
        $familyFee = new TSM_REGISTRATION_FAMILY_FEE($family_fee_id);
        $familyFeeInfo = $familyFee->getInfo();
        if($familyFee->isInvoiced()){
          $invoice_id = $familyFee->getInvoiceId();
          if(isset($invoice_id)){
            //echo "the fee is on a payment plan";
	          if(isset($familyFeeInfo['family_payment_plan_id'])){
	            $familyPaymentPlan = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($familyFeeInfo['family_payment_plan_id']);
	            $originalInvoiceId = $familyPaymentPlan->getOriginalInvoiceId();
		          $familyPaymentPlanInfo = $familyPaymentPlan->getInfo();
	          } else {
		          $originalInvoiceId = 0;
	          }


	          //if($familyPaymentPlanInfo['invoice_and_credit'] == 0 || !($familyPaymentPlan->getAmountInvoiced() >= $familyPaymentPlan->getTotal())){
		        //if($familyPaymentPlanInfo['invoice_and_credit'] == 0){
              $familyInvoice = new TSM_REGISTRATION_INVOICE($invoice_id);
              $familyInvoice->removeFee($family_fee_id);
              $familyInvoice->updateTotal();

              if($invoice_id == $originalInvoiceId){
	              $newTotal = $familyInvoice->getTotal();
                $credit_invoice_id = $familyPaymentPlan->getCreditInvoiceId();
                if($credit_invoice_id){
                  $creditInvoice = new TSM_REGISTRATION_INVOICE($credit_invoice_id);
                  $creditFeeId = $creditInvoice->getFirstFamilyFeeId();
                  $credtFee = new TSM_REGISTRATION_FAMILY_FEE($creditFeeId);
                  $newTotal = $newTotal*-1;
                  $credtFee->updateAmount($newTotal);
                  $creditInvoice->updateFeeAmount($creditFeeId,$newTotal);
                  $creditInvoice->updateTotal();
                }
              }

              $familyFee->setPaymentPlan("NULL");
              $familyFee->setToReview(false);
              $familyFee->delete();
            //}
          }
        } else if($familyFee->isOnPaymentPlan()){
          $familyFee->setPaymentPlan("NULL");
          $familyFee->setToReview(false);
          $familyFee->delete();
        }

      } else if($handleInfo['handleMethod'] == 2){
        //echo $family_fee_id.": nonrefundable";
        $familyFee = new TSM_REGISTRATION_FAMILY_FEE($family_fee_id);
        $familyFee->setRemovable(false);
        $familyFee->setToReview(false);
      }


    }

    return true;
  }

  public function getFeesInReview(){
    $q = "SELECT * FROM tsm_reg_families_fees WHERE family_id = ".$this->familyId." AND to_review = 1";
    $r = $this->db->runQuery($q);
    $feeInReview = null;
    while($a = mysql_fetch_assoc($r)){
      $feeInReview[] = $a;
    }

    return $feeInReview;
  }

  public function deactivateFamily($students_list = null){
    $std = '';
    if($students_list == null){
      $students_list  = $this->getStudents();
    }
    if(!empty($students_list)){
      foreach($students_list as $student){
        $studentObject = new TSM_REGISTRATION_STUDENT($student['student_id']);
        $studentObject->processFees();
        $std.=$student['student_id'].',';
      }
      $std = substr_replace($std,'',-1);
      $q = 'UPDATE tsm_reg_students SET active=0 WHERE student_id IN('.$std.')';
      $r = $this->db->runQuery($q);
    }

    $q = 'UPDATE tsm_reg_families SET active=0 WHERE family_id = '.$this->familyId;
    $r = $this->db->runQuery($q);
    return true;
  }

  public function resetPassword($campus_id,$email){
    $q = 'SELECT * FROM tsm_reg_families WHERE 
          primary_email="'.$email.'" AND 
          campus_id='.$campus_id.' AND 
          active=1 LIMIT 1';
    $result = $this->db->runQuery($q);
    if(mysql_num_rows($result)==1){
      $row = mysql_fetch_assoc($result);
      $token = md5(uniqid());

      $mailer = $this->setupEmail();

      $content ="
              <h3>Password Reset</h3>
              <p>To change your password, please click <a href='".$_SERVER['HTTP_HOST']."/index.php?mod=registration&view=family&action=resetPassword&token=".$token."&email=".$email."'>here</a></p>
              ";
      $content_plain="
              Password Reset \n
              To change your password, please open this link ".$_SERVER['HTTP_HOST']."/index.php?mod=registration&view=family&action=resetPassword&token=".$token."&email=".$email;
      
      $content=str_replace('\"','"',$content);
      // Create a message
      $message = Swift_Message::newInstance('Reset Password')
        ->setFrom(array('noreply@artiosacademies.com' => 'Artios Academies'))
        ->setTo(array($email))
        ->setBody($content,'text/html')
        ->addPart($content_plain,'text/plain');

      $result = $mailer->send($message);
      if($result == 1){
        //save data in database if mail was successfully sent 
        $family_id = $row['family_id'];

        $date = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s').' + 1 day'));

        $q = 'UPDATE tsm_reg_families SET 
        password_reset_token="'.$token.'",
        password_reset_expire="'.$date.'" 
        WHERE family_id='.$family_id;
        $this->db->runQuery($q);
        return true;
      }
      else{
        return false;
      }

    }
    else{
      return false;
    }
  }

  public function checkResetToken($email,$token){
    $q = 'SELECT password_reset_expire FROM tsm_reg_families WHERE primary_email="'.$email.'" 
          AND password_reset_token="'.$token.'" LIMIT 1';
    $res = $this->db->runQuery($q);
    if(mysql_num_rows($res)==1){
      $time = mysql_fetch_assoc($res);
      $time = strtotime($time['password_reset_expire']);
      $now = time();
      if($time > $now){
        return true;
      }
    }
    return false;
  }
  private function setupEmail(){
    require_once __TSM_ROOT__.'includes/3rdparty/swift/lib/swift_required.php';

    $transport = Swift_SmtpTransport::newInstance('66.147.244.176', 25)
      ->setUsername('noreply@takesixmedia.com')
      ->setPassword('LTOZ7]OLz~wB');
      $mailer = Swift_Mailer::newInstance($transport);
      return $mailer;
  }

  public function changePassword($email,$password,$token){
    $password = $this->tsm->createPassword($password);
    $exists = 'SELECT * FROM tsm_reg_families WHERE primary_email="'.$email.'" AND password_reset_token="'.$token.'" LIMIT 1';
    $exists = $this->db->runQuery($exists);
    if(mysql_num_rows($exists)==0) return false;

    $q = 'UPDATE tsm_reg_families SET password="'.$password.'" WHERE primary_email="'.$email.'" AND password_reset_token="'.$token.'" LIMIT 1';
    $res = $this->db->runQuery($q);

    //clear token and date, just in case
    $q = 'UPDATE tsm_reg_families SET password_reset_token="" AND password_reset_expire="0000-00-00 00:00:00"WHERE primary_email="'.$email.'" AND password_reset_token="'.$token.'" LIMIT 1';
    $this->db->runQuery($q);
    return true;
  }

  public function recentPayments(){
    $q = 'SELECT family_payment_id,payment_description,reference_number,quickbooks_payment_id,payment_type,amount,payment_time FROM tsm_reg_families_payments WHERE family_id='.$this->familyId.' ORDER BY payment_time DESC LIMIT 10';
    $res = $this->db->runQuery($q);
    $results = array();
    while($r = mysql_fetch_assoc($res)){
      $results[] = $r;
    }

    foreach($results as $key=>$result){
      $p = new TSM_REGISTRATION_PAYMENT($result['family_payment_id']);
      $results[$key]['invoices'] = $p->getInvoices();
    }
    return $results;
  }
 } 

?>