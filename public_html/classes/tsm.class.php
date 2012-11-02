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

	//SQL injection protection function
	public function makeVarSafe( $value , $stripmetachar ){
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

		if(isset($com)){
		  if($this->website->adminPortal){
		    $prefix = 'admin/controllers/';
		  } else {
        $prefix = 'controllers/';
      }
		  
		
		  $q = "SELECT * FROM tsm_components WHERE component_name = '".$com."';";
		  $r = $this->db->runQuery($q);
		  if(mysql_num_rows($r) > 0){
		    $a = mysql_fetch_assoc($r);
        $com = $a["component_name"];
        return __TSM_ROOT__.$prefix.$com.'/main.controller.php';
      }

		} else {
        return __TSM_ROOT__.$prefix.'/registration/main.controller.php';
    }                                                           
	}

	public function getHeaderHTML(){
		return $this->headerHTML;
	}

}

?>