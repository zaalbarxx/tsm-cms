<?php

class TSM {

  private $headerHTML;
  private $adminHeaderHTML;
  protected static $_instance;
  public $db;
  private $rootPath;

  protected function __construct() {
  }

  protected function __clone() {
  }

  public static function getInstance() {
    if (!self::$_instance) {
      self::$_instance = new TSM();
    }

    return self::$_instance;
  }

  public function stringEndsWith($string, $test) {
    $strlen = strlen($string);
    $testlen = strlen($test);
    if ($testlen > $strlen) return false;
    return substr_compare($string, $test, -$testlen) === 0;
  }

  public function intToDay($int) {
    switch ($int) {
      case 1:
        $day = "Sun";
        break;
      case 2:
        $day = "Mon";
        break;
      case 3:
        $day = "Tue";
        break;
      case 4:
        $day = "Wed";
        break;
      case 5:
        $day = "Thu";
        break;
      case 6:
        $day = "Fri";
        break;
      case 7:
        $day = "Sat";
        break;
    }

    return $day;
  }

  public function arrayToCSV($array, $filename) {
    $rowCount = 0;
    $csv = "";
    $filename = str_replace(",","",$filename);
    foreach ($array as $row) {
      if ($rowCount == 0) {
        foreach ($row as $key => $value) {
          if ($key != 'password') {
            $csv .= $key.",";
          }
        }
      }
      if ($rowCount == 0) {
        $csv = substr_replace($csv, "", -1);
        $csv .= "\r\n";
      }
      foreach ($row as $key => $value) {
        if ($key != 'password') {
          $csv .= $value.",";
        }
      }
      $csv = substr_replace($csv, "", -1);
      $csv .= "\r\n";
      $rowCount++;
    }
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename=".$filename.".csv");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $csv;
    die();
  }

  public function getColumnsFor($tableName) {
    $q = "SHOW columns FROM $tableName;";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $columns[] = $a;
    }

    return $columns;
  }

  public function intToHour($int) {
    switch ($int) {
      case 0:
        $hour = "12am";
        break;
      case 1:
        $hour = "1am";
        break;
      case 2:
        $hour = "2am";
        break;
      case 3:
        $hour = "3am";
        break;
      case 4:
        $hour = "4am";
        break;
      case 5:
        $hour = "5am";
        break;
      case 6:
        $hour = "6am";
        break;
      case 7:
        $hour = "7am";
        break;
      case 8:
        $hour = "8am";
        break;
      case 9:
        $hour = "9am";
        break;
      case 10:
        $hour = "10am";
        break;
      case 11:
        $hour = "11am";
        break;
      case 12:
        $hour = "12pm";
        break;
      case 13:
        $hour = "1pm";
        break;
      case 14:
        $hour = "2pm";
        break;
      case 15:
        $hour = "3pm";
        break;
      case 16:
        $hour = "4pm";
        break;
      case 17:
        $hour = "5pm";
        break;
      case 18:
        $hour = "6pm";
        break;
      case 19:
        $hour = "7pm";
        break;
      case 20:
        $hour = "8pm";
        break;
      case 21:
        $hour = "9pm";
        break;
      case 22:
        $hour = "10pm";
        break;
      case 23:
        $hour = "11pm";
        break;
    }

    return $hour;
  }

  //SQL injection protection function
  public function makeVarSafe($value, $stripmetachar = 1) {

    if ($stripmetachar == 1) {
      if (is_array($value) == false) {
        $value = htmlentities($value);
      }
    }

    if (get_magic_quotes_gpc()) {
      $value = stripslashes($value);
    } else {
      if (is_string($value)) {
        $value = addslashes($value);
      }
    }

    return $value;
  }

  public function makeArraySafe($array) {
    $requestarray = array();
    foreach ($array as $requestkey => $requestvalue) {
      $requestvalue = self::makeVarSafe($requestvalue, 1);
      $requestarray[$requestkey] = $requestvalue;
    }

    return $requestarray;
  }

  public function getComponent() {
    global $com;

    if ($this->website->adminPortal) {
      $prefix = 'admin/controllers/';
      if (isset($com)) {
        $q = "SELECT * FROM tsm_components WHERE component_name = '".$com."';";
        $r = $this->db->runQuery($q);
        if (mysql_num_rows($r) > 0) {
          $a = mysql_fetch_assoc($r);
          $com = $a["component_name"];
          return __TSM_ROOT__.$prefix.$com.'/main.controller.php';
        }

      } else {
        return __TSM_ROOT__.$prefix.'/welcome/main.controller.php';
      }
    } else {
      $prefix = 'controllers/';
      return __TSM_ROOT__.$prefix.'/home/main.controller.php';
    }

  }

  public function createPassword($password) {
    $randSalt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
    $randSalt2 = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
    $salt = '$5$'.substr(sha1($randSalt.sha1($randSalt.$password.$randSalt2).$randSalt2), 3, 22);
    $password = crypt($password, $salt);

    return $password;
  }

  function isStrongPassword($pwd) {
    if (preg_match("#.*^(?=.{8,100})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $pwd)) {
      $isStrongPassword = true;
    } else {
      $isStrongPassword = false;
    }

    return $isStrongPassword;
  }

  function checkPassword($passwordHash, $passwordToCheck) {
    if (strpos($passwordHash, '$5$') === false) {
      $salt = sha1("aUyh:B>G-+\,n<EOWklsO".md5("zV6ivBrm1ZJ".$passwordToCheck));
      $salt2 = sha1("w^e[p0CJL7Q".md5("YdQ}VCp2".$salt));
      $hash = sha1($salt2.sha1($salt.$passwordToCheck.$salt2).$salt);
      if ($hash == $passwordHash) {
        $checkPassword = true;
      } else {
        $checkPassword = false;
      }
    } else {
      $hash = crypt($passwordToCheck, $passwordHash);
      //die($hash."<br />".$passwordHash);
      if ($hash == $passwordHash) {
        $checkPassword = true;
      } else {
        $checkPassword = false;
      }
    }

    return $checkPassword;
  }

  public function intToMonth($number = null) {
    switch ($number) {
      case 1:
        $month = "January";
        break;
      case 2:
        $month = "February";
        break;
      case 3:
        $month = "March";
        break;
      case 4:
        $month = "April";
        break;
      case 5:
        $month = "May";
        break;
      case 6:
        $month = "June";
        break;
      case 7:
        $month = "July";
        break;
      case 8:
        $month = "August";
        break;
      case 9:
        $month = "September";
        break;
      case 10:
        $month = "October";
        break;
      case 11:
        $month = "November";
        break;
      case 12:
        $month = "December";
        break;

    }

    return $month;
  }

  public function formatPhone($phone = '', $convert = true, $trim = true) {
    // If we have not entered a phone number just return empty
    if (empty($phone)) {
      return '';
    }

    // Strip out any extra characters that we do not need only keep letters and numbers
    $phone = preg_replace("/[^0-9A-Za-z]/", "", $phone);

    // Do we want to convert phone numbers with letters to their number equivalent?
    // Samples are: 1-800-TERMINIX, 1-800-FLOWERS, 1-800-Petmeds
    if ($convert == true) {
      $replace = array('2' => array('a', 'b', 'c'),
        '3' => array('d', 'e', 'f'),
        '4' => array('g', 'h', 'i'),
        '5' => array('j', 'k', 'l'),
        '6' => array('m', 'n', 'o'),
        '7' => array('p', 'q', 'r', 's'),
        '8' => array('t', 'u', 'v'),
        '9' => array('w', 'x', 'y', 'z'));

      // Replace each letter with a number
      // Notice this is case insensitive with the str_ireplace instead of str_replace
      foreach ($replace as $digit => $letters) {
        $phone = str_ireplace($letters, $digit, $phone);
      }
    }

    // If we have a number longer than 11 digits cut the string down to only 11
    // This is also only ran if we want to limit only to 11 characters
    if ($trim == true && strlen($phone) > 11) {
      $phone = substr($phone, 0, 11);
    }

    // Perform phone number formatting here
    if (strlen($phone) == 7) {
      return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1-$2", $phone);
    } elseif (strlen($phone) == 10) {
      return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "($1) $2-$3", $phone);
    } elseif (strlen($phone) == 11) {
      return preg_replace("/([0-9a-zA-Z]{1})([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1($2) $3-$4", $phone);
    }

    // Return original phone if not 7, 10 or 11 digits long
    return $phone;
  }

  public function verifyEmail($email) {
    $isValid = true;
    $atIndex = strrpos($email, "@");
    if (is_bool($atIndex) && !$atIndex) {
      $isValid = false;
    } else {
      $domain = substr($email, $atIndex + 1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64) {
        // local part length exceeded
        $isValid = false;
      } else if ($domainLen < 1 || $domainLen > 255) {
        // domain part length exceeded
        $isValid = false;
      } else if ($local[0] == '.' || $local[$localLen - 1] == '.') {
        // local part starts or ends with '.'
        $isValid = false;
      } else if (preg_match('/\\.\\./', $local)) {
        // local part has two consecutive dots
        $isValid = false;
      } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
        // character not valid in domain part
        $isValid = false;
      } else if (preg_match('/\\.\\./', $domain)) {
        // domain part has two consecutive dots
        $isValid = false;
      } else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local))) {
        // character not valid in local part unless
        // local part is quoted
        if (!preg_match('/^"(\\\\"|[^"])+"$/',
          str_replace("\\\\", "", $local))
        ) {
          $isValid = false;
        }
      }
      if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
        // domain not found in DNS
        $isValid = false;
      }
    }
    return $isValid;
  }

  public function getAdminHeaderHTML() {
    $this->adminHeaderHTML = "
    <!--[if lt IE 9]>
        <script src=\"../includes/jquery-1.5.1.min.js\" type=\"text/javascript\"></script>
    <![endif]-->
    <!--[if (gte IE 9) | (!IE)]><!-->
        <script src=\"../includes/jquery-1.8.3.min.js\" type=\"text/javascript\"></script>
    <!--<![endif]-->
    <link rel=\"stylesheet\" href=\"../includes/fancybox/jquery.fancybox.css?v=2.1.3\" type=\"text/css\" media=\"screen\" />
    <link href=\"../includes/bootstrap/css/bootstrap.min.css\" rel=\"stylesheet\" media=\"screen\">
    <script type=\"text/javascript\" src=\"../includes/fancybox/jquery.fancybox.pack.js?v=2.1.3\"></script>
    <script type=\"text/javascript\" src=\"../includes/jquery.validate.min.js\"></script>
    <script type=\"text/javascript\" src=\"../includes/bootstrap/js/bootstrap.min.js\"></script>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <link href=\"../includes/bootstrap/css/bootstrap-responsive.css\" rel=\"stylesheet\">
    <script type=\"text/javascript\" src=\"../includes/jquery.maskedinput.js\"></script>";
    if (isset($_GET['fb'])) {
      $this->adminHeaderHTML .= "<link href=\"templates/admin/css/custom.css.php?fb=1\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />";
    } else {
      $this->adminHeaderHTML .= "<link href=\"templates/admin/css/custom.css.php\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />";
    }
    $this->adminHeaderHTML .= "
    <script type=\"text/javascript\" src=\"../includes/jquery.tooltip/jquery.tooltip.min.js\"></script>
    <link rel=\"stylesheet\" href=\"../includes/jquery.tooltip/jquery.tooltip.css\" type=\"text/css\" media=\"screen\" />
    <script type=\"text/javascript\" src=\"../includes/jquery_implementation.js\"></script>
    ";
    $this->adminHeaderHTML .= "<script type=\"text/javascript\">
		$(document).ready( function(){
		  $(\".fb\").attr('href', function() { return $(this).attr('href') + '&fb=1'; }).fancybox({
    	  'width'          : 985,
    	  'height'          : '85%',
    	  'padding'       : 5,
        'autoSize'    : false,
        'leftRatio' : .51,
    		'helpers': {
          title: null
        },
    		'type'				: 'iframe'
    	});
    	$(\".tooltip\").tooltip();
    });
		</script>
    ";

    return $this->adminHeaderHTML;
  }

  public function getHeaderHTML() {
    $this->headerHTML = "
    <!--[if lt IE 9]>
        <script src=\"includes/jquery-1.5.1.min.js\" type=\"text/javascript\"></script>
    <![endif]-->
    <!--[if (gte IE 9) | (!IE)]><!-->
        <script src=\"includes/jquery-1.8.3.min.js\" type=\"text/javascript\"></script>
    <!--<![endif]-->
    <link rel=\"stylesheet\" href=\"includes/fancybox/jquery.fancybox.css?v=2.1.3\" type=\"text/css\" media=\"screen\" />
    <script type=\"text/javascript\" src=\"includes/fancybox/jquery.fancybox.pack.js?v=2.1.3\"></script>
    <script type=\"text/javascript\" src=\"includes/jquery.validate.min.js\"></script>
    <script type=\"text/javascript\" src=\"includes/jquery.maskedinput.js\"></script>";
    if (isset($_GET['fb'])) {
      $this->headerHTML .= "<link href=\"templates/".$this->website->getTemplateId()."/css/custom.css.php?fb=1\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />";
    } else {
      $this->headerHTML .= "<link href=\"templates/".$this->website->getTemplateId()."/css/custom.css.php\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />";
    }
    $this->headerHTML .= "
    <script type=\"text/javascript\" src=\"includes/jquery.tooltip/jquery.tooltip.min.js\"></script>
    <link rel=\"stylesheet\" href=\"includes/jquery.tooltip/jquery.tooltip.css\" type=\"text/css\" media=\"screen\" />
    <script type=\"text/javascript\" src=\"includes/jquery_implementation.js\"></script>
    ";
    $this->headerHTML .= "<script type=\"text/javascript\">
		$(document).ready( function(){
		  $(\".fb\").attr('href', function() {
		  if($(this).hasClass(\"noext\")){
		    return $(this).attr('href');
		  } else {
		    return $(this).attr('href') + '&fb=1';
		  }
		  }).fancybox({
    	  'width'          : 785,
    	  'height'          : '85%',
    	  'padding'       : 5,
        'autoSize'    : false,
        'leftRatio' : .51,
    		'helpers': {
          title: null
        },
    		'type'				: 'iframe'
    	});
    	$(\".tooltip\").tooltip();
    });
		</script>
    <!--[if IE 7]>
      <script type=\"text/javascript\">
        //window.location = window.location + \"?noIE7\";
      </script>
    <![endif]-->
    ";

    return $this->headerHTML;
  }

  public function logRequest() {

    if (substr($_SERVER['REQUEST_URI'], 0, 5) == "/club" or substr($_SERVER['REQUEST_URI'], 0, 10) == "/scva/club" or substr($_SERVER['REQUEST_URI'], 0, 6) == "/admin" or substr($_SERVER['REQUEST_URI'], 0, 11) == "/scva/admin") {
      $viewingAdminOrClub = 1;
    }

    $postArray = Array();
    foreach ($_POST as $key => $value) {
      $postArray[$key] = $this->makeVarSafe($_POST[$key], 1);
    }

    $sessionArray = Array();
    if ($_SESSION) {
      foreach ($_SESSION as $key => $value) {
        $sessionArray[$key] = $this->makeVarSafe($_SESSION[$key], 1);
      }
    }
    $getArray = Array();
    foreach ($_GET as $key => $value) {
      $getArray[$key] = $this->makeVarSafe($_GET[$key], 1);
    }
    $cookieArray = Array();
    foreach ($_COOKIE as $key => $value) {
      $cookieArray[$key] = $this->makeVarSafe($_COOKIE[$key], 1);
    }
    $postArray = serialize($postArray);
    $sessionArray = serialize($sessionArray);
    $getArray = serialize($getArray);
    $cookieArray = serialize($cookieArray);
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $userAgent = $this->makeVarSafe($_SERVER['HTTP_USER_AGENT'], 1);
    $curPath = $this->makeVarSafe($_SERVER['REQUEST_URI'], 1);
    $q = "INSERT INTO system_requests (ip_address, current_path, user_agent, get_request, post_request, session_request, cookie_request)
	VALUES('$ipAddress','$curPath','$userAgent','$getArray','$postArray','$sessionArray','$cookieArray')";
    $this->db->runQuery($q);
    //mysql_query($q) or die(mysql_error().$q);
  }

}

?>