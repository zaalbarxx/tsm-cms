<?php
require_once(__TSM_ROOT__."includes/3rdparty/quickbooks/QuickBooks.php");

Class TSM_REGISTRATION_QUICKBOOKS extends TSM_REGISTRATION {

  public $token;
  public $oauth_consumer_key;
  public $oauth_consumer_secret;
  public $this_url;
  public $that_url;
  public $dsn;
  public $encryption_key;
  public $the_tenant;
  public $IPP;
  public $IntuitAnywhere;
  public $creds;
  public $Context;

  public function __construct() {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    /*
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    */
    $this->token = '407b2133bec1bb4e74bb2a0bb8cb695ac4d3';
    $this->oauth_consumer_key = 'qyprdQnp3HN97Sg8CFcGPWwK9scRM6';
    $this->oauth_consumer_secret = 'ptknTKS6ahlO2eJBtRGMxZSsGtPeFTubhzdCvNEu';

    $this->this_url = 'http://'.$_SERVER['SERVER_NAME'].'/admin/index.php?mod=registration&view=quickbooks&action=connect';
    $this->that_url = 'http://'.$_SERVER['SERVER_NAME'].'/admin/index.php?mod=registration&view=quickbooks&action=connected';
    $this->dsn = 'mysql://root:@localhost/takesixm_sandbox';
    $this->encryption_key = 'VgTtKpHDEmjsjbp2EsktwtQF3ecBjEFCf9CyNzaVjodzt4rKI0BCOK1VKUD818i';

    // The tenant that user is accessing within your own app
    $this->the_tenant = 1;

    if (!QuickBooks_Utilities::initialized($this->dsn)) {
      // Initialize creates the neccessary database schema for queueing up requests and logging
      QuickBooks_Utilities::initialize($this->dsn);
    }

    $this->IPP = new QuickBooks_IPP($this->dsn);

    $this->username = "tsm_reg_campuses:".$this->getCurrentCampusId();

    $this->IntuitAnywhere = new QuickBooks_IPP_IntuitAnywhere($this->dsn, $this->encryption_key, $this->oauth_consumer_key, $this->oauth_consumer_secret, $this->this_url, $this->that_url);
    $this->creds = $this->IntuitAnywhere->load($this->username, $this->the_tenant);

    $this->IPP->authMode(
      QuickBooks_IPP::AUTHMODE_OAUTH,
      $this->username,
      $this->creds);

    $this->Context = $this->IPP->context();
    $this->IPP->flavor($this->creds['qb_flavor']);

  }

  public function connect() {
    if ($this->IntuitAnywhere->handle($this->username, $this->the_tenant)) {
      // The user has been connected, and will be redirected to $that_url automatically.
    } else {
      die('Oh no, something bad happened: '.$this->IntuitAnywhere->errorNumber().': '.$this->IntuitAnywhere->errorMessage());
    }
  }

  public function createLineFromFee($fee,$invoiceTotal){
    global $currentCampus, $campusInfo;

    if (isset($fee['fee_id'])) {
      $feeObject = new TSM_REGISTRATION_FEE($fee['fee_id']);
      $feeInfo = $feeObject->getInfo();

      $Line = new QuickBooks_IPP_Object_Line();
      $Line->setItemId($feeInfo['quickbooks_item_id']);

      //we need to make the negative charge positive if this is a credit to their account.
      if ($invoiceTotal > 0) {
        $Line->setAmount($fee['amount']);
      } else {
        $Line->setAmount($fee['amount'] * -1);
      }

      $familyFee = new TSM_REGISTRATION_FAMILY_FEE($fee['family_fee_id']);
      $familyFeeInfo = $familyFee->getInfo();

      //todo:figure out why the paypal convenience fee is not getting assigned the correct class.
      if($familyFeeInfo['program_id'] != 0 || $familyFeeInfo['course_id'] == 0){
        if($familyFeeInfo['program_id'] == 0){
          $programString = " program_id IS NULL ";
        } else {
          $programString = " program_id = ".$familyFeeInfo['program_id']." ";
        }
        if($familyFeeInfo['course_id'] == 0){
          $courseString = "course_id IS NULL";
        } else {
          $courseString = "course_id = ".$familyFeeInfo['course_id']." ";
        }
        if($familyFeeInfo['course_id'] == 0 && $familyFeeInfo['program_id'] != 0){
          $q = "SELECT * FROM tsm_reg_program_fee WHERE $programString AND fee_id = '".$familyFeeInfo['fee_id']."'";
        } elseif($familyFeeInfo['course_id'] != 0) {
          $q = "SELECT * FROM tsm_reg_course_fee WHERE $programString AND $courseString AND fee_id = '".$familyFeeInfo['fee_id']."'";
        }
        if(isset($q)){
          $r = $this->db->runQuery($q);
          while($a = mysql_fetch_assoc($r)){
            $feeQbClassId = $a['quickbooks_class_id'];
          }
        } else {
          $feeQbClassId = null;
        }
        if($feeQbClassId != null){
          $Line->setClassId($feeQbClassId);
        }
      } else if($fee['fee_id'] == $campusInfo['paypal_convenience_fee_id']){
        if($campusInfo['paypal_convenience_fee_qb_class_id'] != ""){
          $Line->setClassId($campusInfo['paypal_convenience_fee_qb_class_id']);
        }
      }


      if($familyFeeInfo['student_id'] != 0){
        $student = new TSM_REGISTRATION_STUDENT($familyFeeInfo['student_id']);
        $studentInfo = $student->getInfo();
        $studentName = $studentInfo['first_name']." ".$studentInfo['last_name'].": ";
      } else {
        $studentName = null;
      }

      if($studentName != null){
        $description = $studentName.": ".$fee['name'];
      } else {
        $description = $fee['name'];
      }

      $Line->setDescription($description);
      $Line->setQty(1);
    } else {
      $Line = new QuickBooks_IPP_Object_Line();
      $Line->setAmount($fee['amount']);
      $Line->setDescription($fee['name']);
      $Line->setQty(1);
    }

    return $Line;
  }

}

/*
$token = '407b2133bec1bb4e74bb2a0bb8cb695ac4d3';
$oauth_consumer_key = 'qyprdQnp3HN97Sg8CFcGPWwK9scRM6';
$oauth_consumer_secret = 'ptknTKS6ahlO2eJBtRGMxZSsGtPeFTubhzdCvNEu';


$this_url = 'http://localhost/sandbox/admin/index.php?mod=registration&view=quickbooks&action=connect';
$that_url = 'http://localhost/sandbox/admin/index.php?mod=registration&view=quickbooks&action=connected';

$dsn = 'mysql://root:@localhost/takesixm_sandbox';
$encryption_key = 'VgTtKpHDEmjsjbp2EsktwtQF3ecBjEFCf9CyNzaVjodzt4rKI0BCOK1VKUD818i';

$the_tenant = 1;

$IPP = new QuickBooks_IPP($dsn);

$reg = new TSM_REGISTRATION();
$the_username = "tsm_reg_campuses:".$reg->getCurrentCampusId();
$reg = null;

$IntuitAnywhere = new QuickBooks_IPP_IntuitAnywhere($dsn, $encryption_key, $oauth_consumer_key, $oauth_consumer_secret);
$creds = $IntuitAnywhere->load($the_username, $the_tenant);

$IPP->authMode(
               QuickBooks_IPP::AUTHMODE_OAUTH,
               $the_username,
               $creds);

$Context = $IPP->context();
$IPP->flavor($creds['qb_flavor']);
*/
?>
