<?php
error_reporting(E_ALL);

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
// The majority of the following code is a direct copy of the example code specified on the Paypal site.

// Paypal POSTs HTML FORM variables to this page
// we must post all the variables back to paypal exactly unchanged and add an extra parameter cmd with value _notify-validate

// initialise a variable with the requried cmd parameter
$req = 'cmd=_notify-validate';

// go through each of the POSTed vars and add them to the variable
foreach ($_POST as $key => $value) {
  $value = urlencode(stripslashes($value));
  $req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: ".strlen($req)."\r\n\r\n";

// In a live application send it back to www.paypal.com
// but during development you will want to uswe the paypal sandbox

// comment out one of the following lines

//$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);
$fp = fsockopen('www.paypal.com', 80, $errno, $errstr, 30);

// or use port 443 for an SSL connection
//$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

if (!$fp) {
  // HTTP ERROR
} else {
  fputs($fp, $header.$req);

  //ENABLE TESTING
  //$test = 0;
  //END ENABLE TESTING 

  while (!feof($fp)) {
    $res = fgets($fp, 1024);

    echo $res."<br />";
    if (strcmp($res, "VERIFIED") == 0) {

      //ENABLE TEST
      //if($test == 0){
      //$test++;
      //END ENABLE TESTING

      // assign posted variables to local variables
      // the actual variables POSTed will vary depending on your application.
      // there are a huge number of possible variables that can be used. See the paypal documentation.

      // the ones shown here are what is needed for a simple purchase
      // a "custom" variable is available for you to pass whatever you want in it. 
      // if you have many complex variables to pass it is possible to use session variables to pass them.

      $item_name = $_POST['item_name'];
      $item_number = $_POST['item_number'];
      $item_colour = $_POST['custom'];
      $payment_status = $_POST['payment_status'];
      $payment_amount = $_POST['mc_gross']; //full amount of payment. payment_gross in US
      $payment_currency = $_POST['mc_currency'];
      $txn_id = $_POST['txn_id']; //unique transaction id
      $receiver_email = $_POST['receiver_email'];
      $payer_email = $_POST['payer_email'];
      $custom = $_POST['custom'];
      $customarray = explode("-", $custom);
      $family_id = $customarray[0];
      $invoice_num = $customarray[1];
      $school_year = $customarray[2];
      $last_name = $_POST['last_name'];
      $first_name = $_POST['first_name'];
      $payment_date = $_POST['payment_date'];

      // use the above params to look up what the price of "item_name" should be.

      //LOOK UP THE CAMPUS PAYMENT INFORMATION
      if ($parents_id != null) {
        $piq = "SELECT c.payment_email, c.campuses_name  
        FROM tsm_com_registration_campuses c, tsm_com_registration_parents p 
        WHERE p.parents_id = $parents_id 
        AND p.campuses_id = c.campuses_id";
        $pir = mysql_query($piq) or die(mysql_error());
        while ($pia = mysql_fetch_assoc($pir)) {
          $campus_email = $pia['payment_email'];
          $campuses_name = $pia['campuses_name'];
        }
      } else {
        //SEND THIS E-MAIL IF THERE IS NO PARENT ID AND THE SUBJECT IS APPLICATION
        if (stristr($item_name, 'application')) {
          $mail_To = "jlane@veritasproductions.net";
          $mail_Subject = "PayPal - IPN SUCCESSFUL (No Parent ID)";
          $mail_Body = "Transaction ID: $txn_id\n
          Payer Name: $first_name $last_name\n
          Payer Email: $payer_email\n
          Amount Paid: $payment_amount\n
          Item Name: $item_name\n";
          mail($mail_To, $mail_Subject, $mail_Body);
        }
      }

      // the next part is also very important from a security point of view
      // you must check at the least the following...

      if (($payment_status == 'Completed') && //payment_status = Completed
        ($receiver_email == $campus_email) && // receiver_email is same as your account email
        ($family_id != null) && //and the parents_id is not blank
        ($payment_currency == "USD")
      ) { // and its the correct currency

        // everything is ok
        // you will probably want to do some processing here such as logging the purchase in a database etc

        //check to make sure the transacation hasn't already been logged
        $checkq = "SELECT family_invoice_payment_id FROM tsm_reg_families_invoice_payments WHERE paypal_transaction_id = '$txn_id'";
        $checkr = $tsm->db->runQuery($checkq);
        if (mysql_num_rows($checkr) == 0) {
          $log_payment_q = "INSERT INTO tsm_com_registration_payments (parents_id, method, payment_type, date, item_name, paypal_transaction_id, paypal_payer_email, payment_amount, school_year) 
          VALUES ('$parents_id', '1', '$payment_type', '$payment_date', '$item_name', '$txn_id', '$payer_email', '$payment_amount', '$school_year')";
          mysql_query($log_payment_q) or die(mysql_error());
          $logged = 1;

        } else {
          echo "This transaction has already been processed.";
          $logged = 0;
        }

        $mail_To = "jlane@veritasproductions.net";
        $mail_Subject = "PayPal - IPN SUCCESSFUL";
        $mail_Body = "Transaction ID: $txn_id\n
        Payer Name: $first_name $last_name\n
        Payer Email: $payer_email\n
        Family ID: $family_id\n
        Logged?: $logged\n
        Amount Paid: $payment_amount\n
        Item Name: $item_name\n
        Payment Type: $payment_type\n";
        mail($mail_To, $mail_Subject, $mail_Body);

      } else if ($parents_id != null) {
        //
        // paypal replied with something other than completed or one of the security checks failed.
        // you might want to do some extra processing here
        //

        //
        // we will send an email to say that something went wrong
        $mail_To = "jlane@veritasproductions.net";
        $mail_Subject = "PayPal IPN status not completed or security check fail";
        //
        //you can put whatever debug info you want in the email
        //
        $mail_Body = "Something wrong. \n\n
        The transaction ID number is: $txn_id \n\n 
        Payment status = $payment_status \n\n 
        Payment amount = $payment_amount\n\n
        Currency Type: $payment_currency\n\n
        Custom Field: $custom\n\n
        Parent ID: $parents_id\n\n
        School Year: $school_year\n\n
        Campus E-mail: $campus_email\n\n
        Receiver E-mail: $receiver_email";
        mail($mail_To, $mail_Subject, $mail_Body);

      }
    } else if (strcmp($res, "INVALID") == 0) {
      //
      // Paypal didnt like what we sent. If you start getting these after system was working ok in the past, check if Paypal has altered its IPN format
      //
      $mail_To = "jlane@veritasproductions.net";
      $mail_Subject = "PayPal - Invalid IPN ";
      $mail_Body = "We have had an INVALID response. \n\n
      The transaction ID number is: $txn_id \n\n
      Username: $username\n\n
      Custom Field: $custom";
      mail($mail_To, $mail_Subject, $mail_Body);
    }
  } //end of while
  fclose($fp);
}
?>

