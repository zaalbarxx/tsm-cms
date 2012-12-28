<?php

class TSM{

	private $headerHTML;
	private $adminHeaderHTML;
	protected static $_instance;
  public $db;
  private $rootPath;
  
  protected function __construct(){}
  protected function __clone(){}

	public static function getInstance(){
		if (!self::$_instance)
		{
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

  public function intToDay($int){
  	switch($int){
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
  
  public function intToHour($int){
  	switch($int){
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
	public function makeVarSafe( $value , $stripmetachar = 1 ){
			if($stripmetachar == 1){
				if(is_array($value) == false){
					$value = htmlentities($value, ENT_QUOTES);
				}
			}
			if(get_magic_quotes_gpc()){
						$value = stripslashes( $value );
			} else {
						$value = addslashes( $value );
			}
			return $value;
	}

	public function makeArraySafe($array){
		$requestarray = array();
		foreach($array as $requestkey=>$requestvalue){
			$requestvalue = self::makeVarSafe($requestvalue,1);
			$requestarray[$requestkey] = $requestvalue;
		}

		return $requestarray;
	}

	public function getComponent(){
		global $com;
		
	  if($this->website->adminPortal){
	    $prefix = 'admin/controllers/'; 
			if(isset($com)){
				$q = "SELECT * FROM tsm_components WHERE component_name = '".$com."';";
				$r = $this->db->runQuery($q);
				if(mysql_num_rows($r) > 0){
					$a = mysql_fetch_assoc($r);
					$com = $a["component_name"];
					return __TSM_ROOT__.$prefix.$com.'/main.controller.php';
				}
	
			} else {
					return __TSM_ROOT__.$prefix.'/welcome/main.controller.php';
			}  
	  } else {
      $prefix = 'controllers/';
      return __TSM_ROOT__.$prefix.'/registration/main.controller.php';
    }
                                                         
	}

  public function createPassword($password){
  	$randSalt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
  	$randSalt2 = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
  	$salt = '$5$'.substr(sha1($randSalt.sha1($randSalt.$password.$randSalt2).$randSalt2),3,22);
  	$password = crypt($password,$salt);
  
  	return $password;
  }
  
  function isStrongPassword($pwd){
  	if (preg_match("#.*^(?=.{8,100})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $pwd)){
  		$isStrongPassword = true;
  	} else {
  		$isStrongPassword = false;
  	}
  
  	return $isStrongPassword;
  }
  
  function checkPassword($passwordHash,$passwordToCheck){
  	if(strpos($passwordHash,'$5$') === false){
  		$salt = sha1("aUyh:B>G-+\,n<EOWklsO".md5("zV6ivBrm1ZJ".$passwordToCheck));
  		$salt2 = sha1("w^e[p0CJL7Q".md5("YdQ}VCp2".$salt));
  		$hash = sha1($salt2.sha1($salt.$passwordToCheck.$salt2).$salt);
  		if ($hash == $passwordHash){
  			$checkPassword = true;
  		} else {
  			$checkPassword = false;
  		}
  	} else {
  		$hash = crypt($passwordToCheck,$passwordHash);
  		//die($hash."<br />".$passwordHash);
  		if ($hash == $passwordHash){
  			$checkPassword = true;
  		} else {
  			$checkPassword = false;
  		}
  	}
  
  	return $checkPassword;
  }

  public function intToMonth($number = null){
  	switch($number){
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
  
	public function getAdminHeaderHTML(){
	  $this->adminHeaderHTML = "
    <script src=\"//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js\" type=\"text/javascript\"></script>
    <link rel=\"stylesheet\" href=\"../includes/fancybox/jquery.fancybox.css?v=2.1.3\" type=\"text/css\" media=\"screen\" />
    <script type=\"text/javascript\" src=\"../includes/fancybox/jquery.fancybox.pack.js?v=2.1.3\"></script>";
    if(isset($_GET['fb'])){
      $this->adminHeaderHTML .= "<link href=\"templates/admin/css/custom.css.php?fb=1\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />";
    } else {
      $this->adminHeaderHTML .= "<link href=\"templates/admin/css/custom.css.php\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />";
    }
    $this->adminHeaderHTML .= "
    <script type=\"text/javascript\" src=\"../includes/jquery.tooltip/jquery.tooltip.min.js\"></script>
    <link rel=\"stylesheet\" href=\"../includes/jquery.tooltip/jquery.tooltip.css\" type=\"text/css\" media=\"screen\" />
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
	
	public function getHeaderHTML(){
	  $this->headerHTML = "
    <script src=\"//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js\" type=\"text/javascript\"></script>
    <link rel=\"stylesheet\" href=\"includes/fancybox/jquery.fancybox.css?v=2.1.3\" type=\"text/css\" media=\"screen\" />
    <script type=\"text/javascript\" src=\"includes/fancybox/jquery.fancybox.pack.js?v=2.1.3\"></script>";
    if(isset($_GET['fb'])){
      $this->headerHTML .= "<link href=\"templates/".$this->website->getTemplateId()."/css/custom.css.php?fb=1\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />";
    } else {
      $this->headerHTML .= "<link href=\"templates/".$this->website->getTemplateId()."/css/custom.css.php\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />";
    }
    $this->headerHTML .= "
    <script type=\"text/javascript\" src=\"includes/jquery.tooltip/jquery.tooltip.min.js\"></script>
    <link rel=\"stylesheet\" href=\"includes/jquery.tooltip/jquery.tooltip.css\" type=\"text/css\" media=\"screen\" />
    ";
		$this->headerHTML .= "<script type=\"text/javascript\">
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
	
		return $this->headerHTML;
	}

}

?>