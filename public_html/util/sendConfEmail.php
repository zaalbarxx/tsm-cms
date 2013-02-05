<?php
ini_set('max_execution_time', 0);
//REQUIRE THE CONFIG FILE
require_once('tsm_config.php');
//REQUIRE THE CORE CLASSES
require_once(__TSM_ROOT__.'tsm_core.php');
//INSTANTIATE THE TSM CLASS
$tsm = TSM::getInstance();
//START SAFE GLOBAL VARIABLES
extract($tsm->makeArraySafe($_REQUEST), EXTR_OVERWRITE);
//INSTANTIATE THE DB CONNECTION
require_once(__TSM_ROOT__.'tsm_db_conn.php');


$q = "SELECT * FROM tsm_reg_campuses WHERE campus_id = '$campus_id'";
$r = $tsm->db->runQuery($q);
while ($a = mysql_fetch_assoc($r)) {
  $campusInfo = $a;
}
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
mail($send_to, $subject, $message, $headers);

?>