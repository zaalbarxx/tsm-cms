<?php

class TSM{

	private $headerHTML;
	protected static $_instance;
  public static $db;
  private static $rootPath;
  
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
	  } else {
      $prefix = 'controllers/';
    }
    
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
  		if ($hash == $passwordHash){
  			$checkPassword = true;
  		} else {
  			$checkPassword = false;
  		}
  	}
  
  	return $checkPassword;
  }

	public function getAdminHeaderHTML(){
	  $this->headerHTML = "
    <script src=\"//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js\" type=\"text/javascript\"></script>
    <link rel=\"stylesheet\" href=\"../includes/fancybox/jquery.fancybox.css?v=2.1.3\" type=\"text/css\" media=\"screen\" />
    <script type=\"text/javascript\" src=\"../includes/fancybox/jquery.fancybox.pack.js?v=2.1.3\"></script>";
    if(isset($_GET['fb'])){
      $this->headerHTML .= "<link href=\"templates/admin/css/custom.css.php?fb=1\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />";
    } else {
      $this->headerHTML .= "<link href=\"templates/admin/css/custom.css.php\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />";
    }
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
    	})
    });
		</script>
    ";
	
		return $this->headerHTML;
	}

}

?>